<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .status {
            display: inline-block;
            width: 100px;
            height: 100px;
            border-radius: 8px;
            text-align: center;
            line-height: 100px;
            margin: 10px;
            color: #fff;
            font-weight: bold;
        }

        .status-green {
            background-color: #4CAF50;
        }

        .status-red {
            background-color: #F44336;
        }

        .flash-messages {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            width: 300px;
        }

        .flash-message {
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .flash-message.error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .flash-message.success {
            background-color: #d4edda;
            color: #155724;
        }

        @media (max-width: 600px) {
            .status {
                width: calc(50% - 20px);
                margin: 10px auto;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ws = new WebSocket('ws://localhost:8090');

            ws.onmessage = function(event) {
                const statuses = JSON.parse(event.data);
                updateButtonColors(statuses);
            };

            function updateButtonColors(statuses) {
                for (let i = 1; i <= 5; i++) {
                    const status = statuses['status' + i];
                    const button = document.getElementById('toggle' + i);
                    button.classList.remove('status-green', 'status-red');
                    if (status) {
                        button.classList.add('status-green');
                    } else {
                        button.classList.add('status-red');
                    }
                }
            }

            setTimeout(function() {
                const flashMessages = document.querySelectorAll('.flash-message');
                flashMessages.forEach(function(message) {
                    message.style.opacity = '0';
                    setTimeout(function() {
                        message.style.display = 'none';
                    }, 500);
                });
            }, 3000);
        });
    </script>
</head>
<body>
    <div class="flash-messages">
        <?php if (session()->has('success')): ?>
            <div class="flash-message success"><?= session('success') ?></div>
        <?php elseif (session()->has('error')): ?>
            <div class="flash-message error"><?= session('error') ?></div>
        <?php endif; ?>
    </div>
    <div class="container">
        <h1>User Dashboard</h1>
        <?php ?>
        <div class="status <?= $statuses['status1'] ? 'status-green' : 'status-red' ?>" id="toggle1">Status 1</div>
        <div class="status <?= $statuses['status2'] ? 'status-green' : 'status-red' ?>" id="toggle2">Status 2</div>
        <div class="status <?= $statuses['status3'] ? 'status-green' : 'status-red' ?>" id="toggle3">Status 3</div>
        <div class="status <?= $statuses['status4'] ? 'status-green' : 'status-red' ?>" id="toggle4">Status 4</div>
        <div class="status <?= $statuses['status5'] ? 'status-green' : 'status-red' ?>" id="toggle5">Status 5</div>
        <a href="<?= site_url(route_to('user-url-screen')) ?>">Go to User URL Page</a>
    </div>
</body>
</html>
