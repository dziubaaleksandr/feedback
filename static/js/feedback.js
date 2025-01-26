document.addEventListener('DOMContentLoaded', function () {
    const fileFeedback = document.getElementById('file');
    const errorMessage = document.getElementById('errorMessage');

    feedbackForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(feedbackForm);

        try {
            const response = await fetch('../index.php', {
                method: 'POST',
                body: formData,
            });

            const result = await response.json();
            if (response.ok) {
                window.location.href = '/';
                console.log('Success:', result);
            } else {
                errorMessage.textContent = result.message || 'Ошибка отправки.';
            }
        } catch (error) {
            console.error('Ошибка запроса:', error);
            errorMessage.textContent = 'Ошибка подключения к серверу.';
        }
    });
});
