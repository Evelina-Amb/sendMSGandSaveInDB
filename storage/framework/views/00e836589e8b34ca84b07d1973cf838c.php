<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WebSocket Test</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js']); ?>
</head>
<body class="p-4">
    <h1>Laravel WebSocket Test</h1>
    <div id="messages" style="margin-top:20px; padding:10px; background:#f0f0f0; border-radius:6px;"></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (!window.Echo) {
                console.error('❌ window.Echo is not defined yet.');
                return;
            }

            window.Echo.channel('public-channel')
                .listen('.message.sent', (e) => {
                    console.log('Gauta žinutė:', e.message);
                    document.getElementById('messages').innerHTML += `<p>💬 ${e.message}</p>`;
                });
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\testinimui\laravel10_websocket_demo-main\resources\views/test.blade.php ENDPATH**/ ?>