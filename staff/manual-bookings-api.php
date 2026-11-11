<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');

function respond(int $status, array $body): void
{
    http_response_code($status);
    echo json_encode($body, JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}

function textField(array $data, string $key, int $max, bool $required = true): string
{
    $value = is_string($data[$key] ?? null) ? trim($data[$key]) : '';
    if (($required && $value === '') || strlen($value) > $max) {
        respond(422, ['error' => 'Check the ' . str_replace('_', ' ', $key) . ' field.']);
    }
    return $value;
}

function localSlot(string $value): string
{
    $slot = DateTimeImmutable::createFromFormat('!Y-m-d\TH:i', $value, new DateTimeZone('Asia/Kolkata'));
    if (!$slot || $slot->format('Y-m-d\TH:i') !== $value || $slot <= new DateTimeImmutable()) {
        respond(422, ['error' => 'Choose a future service time (IST).']);
    }
    return $slot->format('Y-m-d H:i:s');
}

$method = $_SERVER['REQUEST_METHOD'];
if (!in_array($method, ['GET', 'POST'], true)) {
    header('Allow: GET, POST');
    respond(405, ['error' => 'Method not allowed.']);
}

if (!preg_match('/^Bearer (\S+)$/', $_SERVER['HTTP_AUTHORIZATION'] ?? '', $authorization)) {
    respond(401, ['error' => 'Sign in with your staff account.']);
}

try {
    require_once __DIR__ . '/../includes/firebase.php';
    $token = firebaseAuth()->verifyIdToken($authorization[1], true);
} catch (Throwable $error) {
    respond(401, ['error' => 'Staff session could not be verified. Sign in again.']);
}

$claims = $token->claims();
if ($claims->get('customerCare', false) !== true) {
    respond(403, ['error' => 'Your account does not have customer-care access.']);
}
$staff = $claims->get('sub');

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    require __DIR__ . '/../includes/db.php';
    $conn->set_charset('utf8mb4');
    if ($method === 'GET') {
        $day = textField($_GET, 'day', 10);
        $parsedDay = DateTimeImmutable::createFromFormat('!Y-m-d', $day, new DateTimeZone('Asia/Kolkata'));
        if (!$parsedDay || $parsedDay->format('Y-m-d') !== $day) {
            respond(422, ['error' => 'Choose a valid date.']);
        }
        $phone = textField($_GET, 'phone', 10, false);
        if ($phone !== '' && !preg_match('/^[6-9][0-9]{9}$/D', $phone)) {
            respond(422, ['error' => 'Enter a 10-digit mobile number.']);
        }
        $columns = 'id, customer_name, phone, area, address, service, plan, starts_at, source, total_paise, notes, partner, status, version';
        if ($phone === '') {
            $nextDay = $parsedDay->modify('+1 day')->format('Y-m-d');
            $query = $conn->prepare("SELECT $columns FROM cn_manual_bookings WHERE starts_at >= ? AND starts_at < ? ORDER BY starts_at, id LIMIT 101");
            $query->execute([$day, $nextDay]);
        } else {
            $query = $conn->prepare("SELECT $columns FROM cn_manual_bookings WHERE phone = ? ORDER BY starts_at DESC, id LIMIT 101");
            $query->execute([$phone]);
        }
        $rows = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        respond(200, ['bookings' => array_slice($rows, 0, 100), 'truncated' => count($rows) > 100]);
    }

    if (strtolower(trim(explode(';', $_SERVER['CONTENT_TYPE'] ?? '')[0])) !== 'application/json') {
        respond(415, ['error' => 'Expected JSON.']);
    }
    $raw = file_get_contents('php://input', false, null, 0, 8193);
    if ($raw === false || strlen($raw) > 8192) {
        respond(413, ['error' => 'The request is too large.']);
    }
    $data = json_decode($raw, true);
    if (!is_array($data)) {
        respond(400, ['error' => 'Invalid request.']);
    }
    $id = textField($data, 'id', 32);
    if (!preg_match('/^[0-9a-f]{32}$/D', $id)) {
        respond(422, ['error' => 'Invalid booking ID.']);
    }

    if (($data['action'] ?? null) === 'create') {
        $requestHash = hash('sha256', $raw);
        $existing = $conn->prepare('SELECT created_by, request_hash FROM cn_manual_bookings WHERE id = ?');
        $existing->execute([$id]);
        $row = $existing->get_result()->fetch_assoc();
        if ($row) {
            if ($row['created_by'] === $staff && $row['request_hash'] === $requestHash) {
                respond(200, ['reference' => 'CN-M-' . $id]);
            }
            respond(409, ['error' => 'A booking with this reference was already saved. Check the queue before retrying.']);
        }
        $phone = textField($data, 'phone', 10);
        $source = textField($data, 'source', 20);
        $total = textField($data, 'total', 9);
        if (!preg_match('/^[6-9][0-9]{9}$/D', $phone)) {
            respond(422, ['error' => 'Enter a valid 10-digit Indian mobile number.']);
        }
        if (!in_array($source, ['Call', 'WhatsApp', 'Website callback'], true)
            || !preg_match('/^[0-9]{1,6}(?:\.[0-9]{1,2})?$/D', $total)) {
            respond(422, ['error' => 'Check the source and final quoted amount.']);
        }
        [$rupees, $paise] = array_pad(explode('.', $total, 2), 2, '');
        $values = [
            $id, $requestHash, textField($data, 'customer_name', 100), $phone,
            textField($data, 'area', 120), textField($data, 'address', 500),
            textField($data, 'service', 100), textField($data, 'plan', 120),
            localSlot(textField($data, 'starts_at', 16)), $source,
            (int)$rupees * 100 + (int)str_pad($paise, 2, '0'),
            textField($data, 'notes', 500, false), $staff, $staff,
        ];
        $insert = $conn->prepare('INSERT INTO cn_manual_bookings
            (id, request_hash, customer_name, phone, area, address, service, plan, starts_at, source, total_paise, notes, created_by, updated_by)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        try {
            $insert->execute($values);
        } catch (mysqli_sql_exception $error) {
            if ($error->getCode() !== 1062) {
                throw $error;
            }
            $existing->execute([$id]);
            $row = $existing->get_result()->fetch_assoc();
            if (!$row || $row['created_by'] !== $staff || $row['request_hash'] !== $requestHash) {
                respond(409, ['error' => 'A booking with this reference was already saved. Check the queue before retrying.']);
            }
        }
        respond(201, ['reference' => 'CN-M-' . $id]);
    }

    if (($data['action'] ?? null) !== 'update') {
        respond(422, ['error' => 'Unknown booking action.']);
    }
    $version = filter_var($data['version'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $read = $conn->prepare('SELECT status, starts_at, partner FROM cn_manual_bookings WHERE id = ? AND version = ?');
    $read->execute([$id, $version]);
    $current = $read->get_result()->fetch_assoc();
    if (!$current) {
        respond(409, ['error' => 'Booking changed. Reload the list and try again.']);
    }

    $status = $current['status'];
    $slot = $current['starts_at'];
    $partner = $current['partner'];
    $next = textField($data, 'next', 20);
    $allowed = [
        'pending' => ['confirmed', 'reschedule', 'cancelled'],
        'confirmed' => ['assigned', 'reschedule', 'cancelled'],
        'assigned' => ['completed', 'reschedule', 'cancelled'],
        'completed' => [],
        'cancelled' => [],
    ];
    if (!in_array($next, $allowed[$status], true)) {
        respond(409, ['error' => 'This action is unavailable for the booking status.']);
    }
    if ($next === 'reschedule') {
        $slot = localSlot(textField($data, 'starts_at', 16));
        $partner = '';
        $next = 'pending';
    } elseif ($next === 'confirmed') {
        if (($data['availability_checked'] ?? false) !== true) {
            respond(422, ['error' => 'Check availability before confirming.']);
        }
        localSlot(str_replace(' ', 'T', substr($slot, 0, 16)));
    } elseif ($next === 'assigned') {
        $partner = textField($data, 'partner', 120);
    }

    $update = $conn->prepare('UPDATE cn_manual_bookings SET status = ?, starts_at = ?, partner = ?, updated_by = ?, version = version + 1 WHERE id = ? AND version = ?');
    $update->execute([$next, $slot, $partner, $staff, $id, $version]);
    if ($update->affected_rows !== 1) {
        respond(409, ['error' => 'Booking changed. Reload the list and try again.']);
    }
    respond(200, ['reference' => 'CN-M-' . $id]);
} catch (Throwable $error) {
    error_log('CleanNora manual booking storage error (' . get_class($error) . ')');
    respond(503, ['error' => 'Booking storage is temporarily unavailable.']);
}
