<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:template match="/">
        <html>
        <head>
            <title>Вход администратора</title>
            <script src="../static/js/login.js" defer="defer"></script>
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
