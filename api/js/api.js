const API_URL = "http://127.0.0.1:1234/sistema_picoles/api/routes/";

async function apiGet(endpoint) {
    const resp = await fetch(API_URL + endpoint);
    return resp.json();
}

async function apiPost(endpoint, data) {
    const resp = await fetch(API_URL + endpoint, {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify(data)
    });
    return resp.json();
}
