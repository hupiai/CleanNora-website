<?php
/**
 * CleanNora preview Supabase client.
 * Public catalogue reads only. Sensitive writes must go through server-side authenticated endpoints.
 */
const CLEANNORA_SUPABASE_URL = 'https://zvqbwuxpnphosftfffao.supabase.co';
const CLEANNORA_SUPABASE_PUBLISHABLE_KEY = 'sb_publishable_jc6yNvExHSOLPA2QCClssw_oU_Calmu';

function cleannora_supabase_get(string $table, string $query = ''): array {
    $url = CLEANNORA_SUPABASE_URL . '/rest/v1/' . rawurlencode($table);
    if ($query !== '') $url .= '?' . $query;
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_HTTPHEADER => [
            'apikey: ' . CLEANNORA_SUPABASE_PUBLISHABLE_KEY,
            'Accept: application/json'
        ]
    ]);
    $body = curl_exec($ch);
    $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($body === false || $status < 200 || $status >= 300) return [];
    $decoded = json_decode($body, true);
    return is_array($decoded) ? $decoded : [];
}
