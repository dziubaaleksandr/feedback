<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:template match="/">
        <html>
        <head>
            <title>Вход администратора</title>
        </head>
        <body>
            <h1>Вход администратора</h1>
            <form method="POST" action="">
                <label>Имя пользователя:</label>
                <input type="text" name="username" required='true'/><br/>

                <label>Пароль:</label>
                <input type="password" name="password" required='true'/><br/>

                <button type="submit">Войти</button>
            </form>
        </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
