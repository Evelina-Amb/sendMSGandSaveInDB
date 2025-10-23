<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Message</title>
    @vite(['resources/js/app.js'])
</head>
<body class="p-4">

@php
    $messages = \App\Models\Message::orderBy('sent_at', 'asc')->get();
@endphp

<div id="messages-container" style="margin-bottom: 20px; border: 1px solid #ccc; padding: 10px; height: 300px; overflow-y: auto;">
    @foreach($messages as $msg)
        <div>?: {{ $msg->content }}</div>
    @endforeach
</div>

    <h1>Send a Message</h1>
    <form id="msgForm">
        <input type="text" id="message" placeholder="Enter message" required>
        <button type="submit">Send</button>
    </form>

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
            .then(data => {
                messageInput.value = '';

                const container = document.getElementById('messages-container');
                const msgDiv = document.createElement('div');
                msgDiv.textContent = '?: ' + message;
                container.appendChild(msgDiv);

                container.scrollTop = container.scrollHeight;

                console.log('Message sent:', data);
            });
        }
    });

    Echo.channel('chat')
        .listen('MessageSent', (e) => {
            const container = document.getElementById('messages-container');
            const msgDiv = document.createElement('div');
            msgDiv.textContent = '?: ' + e.message; 
            container.scrollTop = container.scrollHeight;
        });
</script>
</body>
</html>
