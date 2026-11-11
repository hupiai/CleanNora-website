const $ = (selector) => document.querySelector(selector);
const login = $('#login');
const workspace = $('#workspace');
const logout = $('#logout');
const create = $('#new-booking');
const filters = $('#filters');
const list = $('#list');
const dialog = $('#action');
const actionForm = dialog.querySelector('form');
const actions = {
    pending: { confirmed: 'Confirm slot', reschedule: 'Reschedule', cancelled: 'Cancel booking' },
    confirmed: { assigned: 'Assign partner', reschedule: 'Reschedule', cancelled: 'Cancel booking' },
    assigned: { completed: 'Mark complete', reschedule: 'Reschedule', cancelled: 'Cancel booking' },
};
let auth;
let requestId;
let selectedAction;
let queueRequest = 0;

function message(text, isError = false) {
    $('#message').textContent = text;
    $('#message').classList.toggle('error', isError);
}

function todayInIndia() {
    const parts = new Intl.DateTimeFormat('en-GB', {
        timeZone: 'Asia/Kolkata', year: 'numeric', month: '2-digit', day: '2-digit',
    }).formatToParts();
    const date = Object.fromEntries(parts.map(({ type, value }) => [type, value]));
    return [date.year, date.month, date.day].join('-');
}

async function api({ params, data } = {}) {
    const token = await auth.currentUser.getIdToken();
    const url = new URL('./manual-bookings-api.php', location.href);
    if (params) url.search = new URLSearchParams(params);
    const response = await fetch(url, {
        method: data ? 'POST' : 'GET',
        headers: { Authorization: 'Bearer ' + token, 'Content-Type': 'application/json' },
        body: data ? JSON.stringify(data) : undefined,
        cache: 'no-store',
    });
    const payload = await response.json().catch(() => ({}));
    if (!response.ok) throw new Error(payload.error || 'Booking service unavailable.');
    return payload;
}

function element(tag, text, className = '') {
    const node = document.createElement(tag);
    node.textContent = text;
    node.className = className;
    return node;
}

function quote(paise) {
    return new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' }).format(paise / 100);
}

function renderBooking(booking) {
    const item = element('article', '');
    const heading = element('div', '', 'row');
    heading.append(element('strong', booking.service + ' · ' + booking.plan), element('span', booking.status, 'status'));
    const slot = booking.starts_at.slice(0, 16);
    item.append(heading, element('p', slot + ' IST · ' + booking.area + ' · ' + quote(booking.total_paise)));
    item.append(element('p', booking.customer_name + ' · ' + booking.phone + ' · ' + booking.source, 'meta'));
    const details = element('details', '');
    details.append(element('summary', 'Booking details'), element('p', 'CN-M-' + booking.id, 'meta'), element('p', booking.address));
    if (booking.partner) details.append(element('p', 'Partner: ' + booking.partner));
    if (booking.notes) details.append(element('p', booking.notes));
    item.append(details);

    const buttons = element('div', '', 'actions');
    for (const [next, label] of Object.entries(actions[booking.status] || {})) {
        const button = element('button', label, 'secondary');
        button.type = 'button';
        button.addEventListener('click', () => openAction(booking, next, label));
        buttons.append(button);
    }
    if (['confirmed', 'assigned'].includes(booking.status)) {
        const link = element('a', 'Open WhatsApp confirmation', 'button secondary');
        const text = `Hello ${booking.customer_name}, CleanNora has confirmed your ${booking.service} (${booking.plan}) for ${slot} IST. Total: ${quote(booking.total_paise)}. Reference: CN-M-${booking.id}.`;
        link.href = 'https://wa.me/91' + booking.phone + '?text=' + encodeURIComponent(text);
        link.target = '_blank';
        link.rel = 'noopener noreferrer';
        buttons.append(link);
    }
    item.append(buttons);
    return item;
}

async function loadQueue() {
    const request = ++queueRequest;
    list.replaceChildren(element('p', 'Loading bookings…'));
    const result = await api({ params: new FormData(filters) }).catch((error) => {
        if (request === queueRequest) throw error;
        return null;
    });
    if (request !== queueRequest) return;
    list.replaceChildren(...result.bookings.map(renderBooking));
    if (!result.bookings.length) list.append(element('p', 'No bookings found.'));
    if (result.truncated) list.append(element('p', 'Showing the first 100 results. Search by phone to narrow the queue.'));
}

function openAction(booking, next, label) {
    actionForm.reset();
    $('#action-error').hidden = true;
    selectedAction = { action: 'update', id: booking.id, version: booking.version, next };
    $('#action-title').textContent = label;
    for (const [row, field, status] of [
        ['#check-row', 'availability_checked', 'confirmed'],
        ['#partner-row', 'partner', 'assigned'],
        ['#slot-row', 'starts_at', 'reschedule'],
    ]) {
        $(row).hidden = next !== status;
        actionForm.elements[field].required = next === status;
    }
    actionForm.elements.starts_at.value = booking.starts_at.slice(0, 16).replace(' ', 'T');
    dialog.showModal();
}

async function submit(button, operation, errorHandler = (error) => message(error.message, true)) {
    button.disabled = true;
    try {
        await operation();
    } catch (error) {
        errorHandler(error);
    } finally {
        button.disabled = false;
    }
}

create.addEventListener('submit', (event) => {
    event.preventDefault();
    submit(event.submitter, async () => {
        requestId ||= crypto.randomUUID().replaceAll('-', '');
        const data = Object.fromEntries(new FormData(create));
        const result = await api({ data: { ...data, action: 'create', id: requestId } });
        requestId = null;
        create.reset();
        filters.elements.phone.value = '';
        filters.elements.day.value = data.starts_at.slice(0, 10);
        message('Pending booking saved · ' + result.reference);
        await loadQueue().catch((error) => list.replaceChildren(element('p', error.message, 'error')));
    });
});
filters.addEventListener('submit', (event) => {
    event.preventDefault();
    submit(event.submitter, loadQueue, (error) => list.replaceChildren(element('p', error.message, 'error')));
});
$('#close-action').addEventListener('click', () => dialog.close());
actionForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const data = {
        ...selectedAction,
        ...Object.fromEntries(new FormData(actionForm)),
        availability_checked: actionForm.elements.availability_checked.checked,
    };
    submit(event.submitter, async () => {
        await api({ data });
        dialog.close();
        if (data.next === 'reschedule' && !filters.elements.phone.value) {
            filters.elements.day.value = data.starts_at.slice(0, 10);
        }
        message('Booking updated.');
        await loadQueue().catch((error) => list.replaceChildren(element('p', error.message, 'error')));
    }, (error) => {
        $('#action-error').textContent = error.message;
        $('#action-error').hidden = false;
    });
});

async function start() {
    const [app, sdk, config] = await Promise.all([
        import('https://www.gstatic.com/firebasejs/12.1.0/firebase-app.js'),
        import('https://www.gstatic.com/firebasejs/12.1.0/firebase-auth.js'),
        import('/assets/js/firebase-config.js'),
    ]);
    auth = sdk.getAuth(app.initializeApp(config.firebaseConfig, 'cleannora-customer-care'));
    await sdk.setPersistence(auth, sdk.browserSessionPersistence);
    filters.elements.day.value = todayInIndia();
    login.addEventListener('submit', (event) => {
        event.preventDefault();
        submit(event.submitter, async () => {
            await sdk.signInWithEmailAndPassword(auth, login.elements.email.value, login.elements.password.value);
            login.reset();
        }, () => message('Sign-in failed. Check your staff credentials.', true));
    });
    logout.addEventListener('click', () => submit(logout, () => sdk.signOut(auth)));
    sdk.onAuthStateChanged(auth, async (user) => {
        ++queueRequest;
        workspace.hidden = true;
        login.hidden = Boolean(user);
        logout.hidden = !user;
        if (dialog.open) dialog.close();
        list.replaceChildren();
        create.reset();
        filters.elements.phone.value = '';
        requestId = null;
        if (!user) {
            message('');
            return;
        }
        try {
            const result = await user.getIdTokenResult();
            if (auth.currentUser !== user) return;
            if (result.claims.customerCare !== true) {
                message('This account does not have customer-care access.', true);
                return;
            }
            await loadQueue();
            if (auth.currentUser !== user) return;
            workspace.hidden = false;
            message('');
        } catch (error) {
            if (auth.currentUser === user) message(error.message, true);
        }
    });
}
start().catch(() => message('Staff sign-in could not load. Contact your CleanNora administrator.', true));
