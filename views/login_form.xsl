<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:template match="/">
        <html>
        <head>
            <title>Вход администратора</title>
            <script>
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
            </script>
        </head>
        <body>
            <h1>Вход администратора</h1>
            <form id="loginForm" method="POST" action="">
                <label>Имя пользователя:</label>
                <!-- <input type="text" name="username" id="username" required='true'/><br/> -->
                <input type="text" name="username" id="username"/><br/>

                <label>Пароль:</label>
                <!-- <input type="password" name="password" id="password" required='true'/><br/> -->
                <input type="password" name="password" id="password"/><br/>

                <button type="submit">Войти</button>
            </form>
            <div id="errorMessage" style="color: red;"></div>
        </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
