<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Ratchet WebSocket Chat Sample</title>
    <style>
        body {
            padding: 20px;
            margin: 0;
            font-family: arial, sans-serif;
        }
        .received-message, .sent-message {
            padding: 10px;
            margin: 1px 0 0 0;
            text-align: left;
        }
        .sent-message {
            background: lightskyblue;
        }
        .received-message {
            background: lightgreen;
        }
        #chat {
            background: #EAEAEA;
            border: #CCC;
            padding: 20px;
        }
        #message {
            display: block;
            width: 80%;
            border: 5px solid #EAEAEA;
            margin: 10px 0;
            padding: 20px;
            font-size: 20px;
            font-family: arial, sans-serif;
        }
    </style>
    <script>
        var conn = new WebSocket('ws://localhost:8080');

        conn.onopen = function(e)
        {
            console.log("Connection established!");
        };

        function getTime()
        {
            var date = new Date();

            return date.toLocaleDateString()
        };

        function sendMessage(e)
        {
            var code = (e.keyCode ? e.keyCode : e.which);

            if(code !== 13) {
                return;
            }

            var message = document.getElementById('message').value;

            if (message.length == 0) {
                return;
            }

            conn.send(message);

            var content = document.getElementById('chat').innerHTML;

            document.getElementById('chat').innerHTML = content + '<div class="sent-message">Sent on [' + getTime() + '] ' + message + '</div>';
            document.getElementById('message').value = '';
        };

        function receiveMessage(e)
        {
            var content = document.getElementById('chat').innerHTML;

            document.getElementById('chat').innerHTML = content + '<div class="received-message">Received on [' + getTime() + '] ' + e.data + '</div>';
        };

        conn.onmessage = function(e)
        {
            receiveMessage(e);
        };
    </script>
</head>
<body>
<h1>Simple Chat using WebSocket + Ratchet</h1>
<p>
    Open It in two browser tabs and see It working!
</p>
<div id="chat"></div>
<textarea id="message" onkeyup="sendMessage(event)" placeholder="Type your message here..."></textarea>
</body>
</html>
