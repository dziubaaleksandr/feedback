<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:template match="/">
        <html>
        <head>
            <title>Обратная связь</title>
        </head>
        <body>
            <h1>Оставьте ваш отзыв</h1>
            <form method="POST" action="">
                <label>Имя:</label>
                <input type="text" name="name" required='true'/><br />

                <label>Email:</label>
                <input type="email" name="email" required='true'/><br />

                <label>Тема:</label>
                <input type="text" name="subject" required='true'/><br />

                <label>Сообщение:</label>
                <textarea name="message" required='true'></textarea><br />

                <button type="submit">Отправить</button>
            </form>
            <p>
                <a href="/login.php">Войти как администратор</a>
            </p>
        </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
