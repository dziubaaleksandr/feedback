<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:template match="/">
        <html>
        <head>
            <title>Панель администратора</title>
        </head>
        <body>
            <h1>Панель администратора</h1>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Тема</th>
                        <th>Сообщение</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <xsl:for-each select="feedbacks/feedback">
                        <tr>
                            <td><xsl:value-of select="id" /></td>
                            <td><xsl:value-of select="name" /></td>
                            <td><xsl:value-of select="email" /></td>
                            <td><xsl:value-of select="subject" /></td>
                            <td><xsl:value-of select="message" /></td>
                            <td>
                                <a>
                                    <xsl:attribute name="href">
                                        <xsl:text>?delete=</xsl:text>
                                        <xsl:value-of select="id" />
                                    </xsl:attribute>
                                    Удалить
                                </a>
                            </td>
                        </tr>
                    </xsl:for-each>
                </tbody>
            </table>
            <xsl:for-each select="feedbacks/pagination/page">
                <a style="display: inline-block; margin-right: 10px; text-decoration: none;" href="?page={.}">
                    <xsl:value-of select="." />
                </a>
            </xsl:for-each>
            <p>
                <a href="/">Оставить отзыв</a>
            </p>
        </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
