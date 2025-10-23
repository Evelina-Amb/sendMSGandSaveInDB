<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>WebSocket Test</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <h1>Laravel WebSockets Demo</h1>
    <button id="send">Siųsti pranešimą</button>
    <div id="messages"></div>

   <script>
document.addEventListener('DOMContentLoaded', function () {
    if (!window.Echo) {
        console.error('❌ window.Echo is not defined yet.');
        return;
    }

    const button = document.getElementById('send');
    button.addEventListener('click', () => {
        fetch('/send');
    });

    window.Echo.channel('public-channel')
        .listen('.message.sent', (e) => {
            console.log('Received:', e);
            const box = document.getElementById('messages');
            const div = document.createElement('div');
            div.textContent = e.message;
            box.appendChild(div);
        });
});
</script>
</body>
</html>
