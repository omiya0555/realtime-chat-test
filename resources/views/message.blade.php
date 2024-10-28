<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>

    </head>
    <body>
        <div>
            <span>test</span>
        </div>
        <form action="{{ route('message') }}" method="POST">
            <input type="hidden" name="message_id" value=1>
            <input type="text" name="message">
            <button type="submit">送信</button>
        </form>
    </body>
    <script>
        window.Echo.channel('testchat').listen('MessageSent', (e) =>
        {
            console.log(e.message);
            // メッセージをレンダリング
        });
    </script>
</html>

