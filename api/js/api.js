const API_URL = "http://localhost:1234/sistema_picoles/api/";

/**
 * Obtém o perfil do usuário armazenado localmente.
 * @returns {string|null}
 */
function getUserProfile() {
    return localStorage.getItem('userProfile');
}

/**
 * Remove o perfil do usuário e desloga.
 */
function logout() {
    localStorage.removeItem('userProfile');
    window.location.href = "pages/login.html"; // Redireciona para a página de login
}

async function apiGet(endpoint) {
    const resp = await fetch(API_URL + endpoint);
    return resp.json();
}

async function apiPost(endpoint, data) {
    const response = await fetch(url, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
    });
    
    // Se a API retornar um erro (ex: 401), retorna o corpo da resposta JSON (que deve conter o erro)
    if (!resp.ok) {
        return resp.json();
    }
    
    return response.json();
}