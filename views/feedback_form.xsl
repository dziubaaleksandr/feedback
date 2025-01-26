<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:template match="/">
        <html>
        <head>
            <title>Обратная связь</title>
            <script src="../static/js/feedback.js" defer="defer"></script>
        </head>
        <body>
            <h1>Оставьте ваш отзыв</h1>
            <form id='feedbackForm' method="POST" action="" enctype="multipart/form-data">
                <label>Имя:</label>
                <input type="text" name="name" required='true'/><br />

                <label>Email:</label>
                <input type="email" name="email" required='true'/><br />

                <label>Тема:</label>
                <input type="text" name="subject" required='true'/><br />

                <label>Сообщение:</label>
                <textarea name="message" required='true'></textarea><br />

                <label>Загрузить файл (до 1 МБ):</label>
                <input id='file' type="file" name="file" accept="*/*"/><br />

                <button type="submit">Отправить</button>
            </form>
            <div id="errorMessage" style="color: red;"></div>
            <p>
                <a href="/login.php">Войти как администратор</a>
            </p>
        </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
