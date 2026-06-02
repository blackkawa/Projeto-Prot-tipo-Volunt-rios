function showLogin(type) {
    document.getElementById('screen-selection').classList.add('hidden');
    document.getElementById('screen-login').classList.remove('hidden');
    const btn = document.getElementById('btn-entrar');
    const txtCadastro = document.getElementById('txt-cadastro');
    
    if(type === 'voluntario') {
        btn.className = 'btn btn-voluntario';
        document.getElementById('login-title').innerText = 'Portal de acesso do Voluntário';
        txtCadastro.style.display = 'block'; 
    } else {
        btn.className = 'btn btn-admin';
        document.getElementById('login-title').innerText = 'Portal de acesso Administrativo';
        txtCadastro.style.display = 'none'; 
    }
}

function goBack() {
    document.getElementById('screen-login').classList.add('hidden');
    document.getElementById('screen-selection').classList.remove('hidden');
}

function login() {
    // Aqui no futuro você fará a integração com o back-end (PHP/DB2)
    document.getElementById('screen-login').classList.add('hidden');
    document.getElementById('screen-dashboard').style.display = 'flex';
}

function logout() {
    document.getElementById('screen-dashboard').style.display = 'none';
    document.getElementById('screen-selection').classList.remove('hidden');
}