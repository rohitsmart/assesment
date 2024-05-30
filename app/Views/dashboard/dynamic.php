<!-- dynamic.php -->
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
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .toggle-button.active {
            background-color: #45a049;
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.toggle-button');

            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const isOn = button.classList.toggle('active');
                    const statusIndex = button.id.replace('toggle', '') - 1; // Extract the status index from button id
                    updateDashboardStatus(statusIndex, isOn ? 1 : 0); // Update dashboard status
                });
            });

            // Function to update dashboard status
            function updateDashboardStatus(statusIndex, value) {
                // Send an AJAX request to update the status in the backend
                // You can use fetch or XMLHttpRequest to send the request
                // Example:
                // fetch('update-status', {
                //     method: 'POST',
                //     body: JSON.stringify({ statusIndex, value }),
                //     headers: {
                //         'Content-Type': 'application/json'
                //     }
                // })
                // .then(response => response.json())
                // .then(data => {
                //     console.log(data);
                // })
                // .catch(error => {
                //     console.error('Error:', error);
                // });

                // For demonstration, we'll just log the status update
                console.log(`Status ${statusIndex + 1} updated to ${value}`);
            }
        });
    </script>

<script>
        document.addEventListener("DOMContentLoaded", function() {
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
</body>
</html>
