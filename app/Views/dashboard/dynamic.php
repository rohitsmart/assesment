<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Content</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .toggle-buttons {
            text-align: center;
        }

        .toggle-button {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .toggle-button.status-green {
            background-color: #4CAF50;
            color: #fff;
        }

        .toggle-button.status-red {
            background-color: #F44336;
            color: #fff;
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
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ws = new WebSocket('ws://localhost:8090');

            ws.onmessage = function(event) {
                const statuses = JSON.parse(event.data);
                updateButtonColors(statuses);
            };

            const toggleButtons = document.querySelectorAll('.toggle-button');
            const statuses = <?= json_encode($statuses) ?>;
            console.log(statuses);

            toggleButtons.forEach(button => {
                const statusIndex = button.id.replace('toggle', '');
                const isGreen = parseInt(statuses['status' + statusIndex]);
                console.log('Button:', button.id, 'Status:', isGreen);
                button.classList.toggle('status-green', isGreen);
                button.classList.toggle('status-red', !isGreen);

                button.addEventListener('click', function() {
                    const isOn = button.classList.toggle('active');
                    updateDashboardStatus(statusIndex, isOn ? 1 : 0);
                });
            });

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

            function updateDashboardStatus(statusIndex, value) {
                $.ajax({
                    url: '<?= site_url('dashboard/updateStatus') ?>',
                    type: 'POST',
                    data: {
                        statusIndex: statusIndex,
                        value: value
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log('Toggle response:', response.message);
                        } else {
                            console.error('Error:', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
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
        <?php if (session()->has('errors')): ?>
            <?php foreach (session('errors') as $error): ?>
                <div class="flash-message error"><?= $error ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (session()->has('error')): ?>
            <div class="flash-message error"><?= session('error') ?></div>
        <?php endif; ?>

        <?php if (session()->has('success')): ?>
            <div class="flash-message success"><?= session('success') ?></div>
        <?php endif; ?>
    </div>
    <h1>Dynamic Content</h1>
    <div class="toggle-buttons">
        <button id="toggle1" class="toggle-button">Toggle 1</button>
        <button id="toggle2" class="toggle-button">Toggle 2</button>
        <button id="toggle3" class="toggle-button">Toggle 3</button>
        <button id="toggle4" class="toggle-button">Toggle 4</button>
        <button id="toggle5" class="toggle-button">Toggle 5</button>
    </div>
</body>
</html>
