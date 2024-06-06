<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Not Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        .container {
            text-align: center;
        }
        .message {
            font-size: 24px;
            margin-top: 20px;
        }
        .animation {
            width: 100%;
            max-width: 500px;
            margin: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="animation">
            <dotlottie-player
                src="{{ asset('lottie/animation-not-found.json') }}"
                background="transparent"
                speed="1"
                loop autoplay>
            </dotlottie-player>
        </div>
        @if (session('error'))
            <div class="message">
                {{ session('error') }} !
            </div>
        @endif
    </div>
    <script>
        // Check if there is an error message in local storage
        let errorMessage = localStorage.getItem('errorMessage');
        if (errorMessage) {
            document.getElementById('errorMessage').innerText = errorMessage;
            document.getElementById('errorMessage').style.display = 'block';
            // Clear the error message from local storage
            localStorage.removeItem('errorMessage');
        }
    </script>
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
</body>
</html>
