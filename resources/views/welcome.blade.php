<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Bootstrap Chat</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h1 class="text-center mb-4">Laravel Bootstrap Chat</h1>

        <div id="messages" class="card mb-4" style="max-height: 300px; overflow-y: auto;">
            <div class="card-body">
                <!-- メッセージがここに追加される -->
            </div>
        </div>

        <form id="message-form" action="/send-message" method="POST" class="card p-3">
            @csrf
            <div class="form-group">
                <label for="message-id">Select User:</label>
                <select id="message-id" class="form-control">
                    <option value="1">Omiya</option>
                    <option value="2">Murata</option>
                    <option value="3">Gouda</option>
                </select>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <input type="text" id="message" class="form-control" placeholder="Enter a message">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Send</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Pusherの初期設定
        Pusher.logToConsole = true;
        var pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
            cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
            forceTLS: true
        });

        // チャネルを購読してイベントをリッスン
        var channel = pusher.subscribe('chat');
        channel.bind('message.sent', function(data) {
            var messagesDiv = document.getElementById('messages').querySelector('.card-body');
            var messageElement = document.createElement('div');

            // クラスの適用（Omiyaは右、それ以外は左）
            if (data.message_id == 1) {
                messageElement.className = "alert alert-primary text-right";
                messageElement.innerHTML = `<strong>Omiya:</strong> ${data.message}`;
            } else {
                messageElement.className = "alert alert-secondary text-left";
                var userName = data.message_id == 2 ? 'Murata' : 'Gouda';
                messageElement.innerHTML = `<strong>${userName}:</strong> ${data.message}`;
            }

            messagesDiv.appendChild(messageElement);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        });

        // メッセージ送信フォームの送信イベント
        document.getElementById('message-form').addEventListener('submit', function(e) {
            e.preventDefault();
            var messageId = document.getElementById('message-id').value;
            var message = document.getElementById('message').value;
            axios.post('/send-message', { 
                message_id: messageId,
                message: message,
            });
            document.getElementById('message').value = '';
        });
    </script>
</body>
</html>
