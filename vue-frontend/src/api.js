const BASE_URL = 'http://localhost:8081';

function getHeaders(auth = false) {
    const headers = { 'Content-Type': 'application/json' };
    if (auth) {
        const token = localStorage.getItem('token');
        if (token) headers['Authorization'] = `Bearer ${token}`;
    }
    return headers;
}

export async function apiRequest(path, options = {}, auth = false) {
    try {
        const res = await fetch(`${BASE_URL}${path}`, {
            ...options,
            headers: getHeaders(auth),
        });
        const data = await res.json().catch(() => ({}));
        return { ok: res.ok, status: res.status, data };
    } catch (err) {
        console.error('API request failed:', err);
        return { ok: false, status: 0, data: { error: 'Network error' } };
    }
}
