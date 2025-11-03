<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WebSocket Test</title>
    @vite(['resources/js/app.js'])
</head>
<body class="p-4">
    <h1>Laravel WebSocket Test</h1>
    <div id="messages" style="margin-top:20px; padding:10px; background:#f0f0f0; border-radius:6px;"></div>
<div style="margin-top: 20px;">
    <form id="msgForm">
        @csrf
        <input type="text" id="message" placeholder="Type your message..." autocomplete="off">
        <button type="submit">Send</button>
    </form>
</div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (!window.Echo) {
                console.error(' window.Echo is not defined yet.');
                return;
            }

            window.Echo.channel('public-channel')
                .listen('.message.sent', (e) => {
                    console.log('Gauta žinutė:', e.message);
                    document.getElementById('messages').innerHTML += `<p>💬 ${e.message}</p>`;
                });
        });
    </script>
    <script>
    document.getElementById('msgForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const messageInput = document.getElementById('message');
        const message = messageInput.value;

        if (message.trim() !== "") {
            fetch('/sendmsg', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message })
            })
            .then(res => res.json())
            .then(() => {
                messageInput.value = '';

                const container = document.getElementById('messages-container');
                const msgDiv = document.createElement('div');
                msgDiv.textContent = '?: ' + message;
                container.appendChild(msgDiv);
                container.scrollTop = container.scrollHeight;
            });
        }
    });

    Echo.channel('chat')
        .listen('MessageSent', (e) => {
            const container = document.getElementById('messages-container');
            const msgDiv = document.createElement('div');
            msgDiv.textContent = '?: ' + e.message;
            container.appendChild(msgDiv);
            container.scrollTop = container.scrollHeight;
        });
</script>
</body>
</html>
