document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');
    const errorMessage = document.getElementById('errorMessage');

    loginForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();

        if (!username || !password) {
            errorMessage.textContent = 'Введите логин и пароль.';
            return;
        }

        try {
            const response = await fetch('../login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({username, password}),
            });
            const result = await response.json();

            if (response.ok) {
                window.location.href = '../admin.php';
            } else {
                errorMessage.textContent = result.message || 'Ошибка авторизации.';
            }
        } catch (error) {
            console.error('Ошибка запроса:', error);
            errorMessage.textContent = 'Ошибка подключения к серверу.';
        }
    });
});