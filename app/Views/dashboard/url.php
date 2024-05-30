<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User URL</title>
    <!-- Add CSS styles here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
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

        .link-section {
            margin-bottom: 20px;
        }

        .link-section h2 {
            margin-bottom: 10px;
        }

        .dynamic-link {
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }

        .dynamic-link a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .dynamic-link a:hover {
            color: #4CAF50;
        }

        .create-link-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .create-link-button:hover {
            background-color: #45a049;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 5px;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User URL</h1>

        <div class="link-section">
            <h2>Dynamic Link</h2>
            <?php if ($dynamicLink): ?>
                <div class="dynamic-link">
                    <a href="<?= base_url('world/link/' . $dynamicLink['dynamic_link']) ?>">http://localhost/world/link/<?= $dynamicLink['dynamic_link'] ?></a>
                </div>
            <?php else: ?>
                <div>No dynamic link found. <button class="create-link-button" onclick="openCreateLinkModal()">Create one</button></div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Create Link Modal -->
    <div id="createLinkModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeCreateLinkModal()">&times;</span>
            <h2>Create Dynamic Link</h2>
            <form action="<?= route_to('create-dynamic-url') ?>" method="post">
                <input type="text" name="dynamic_link" placeholder="Enter link" required>
                <br><br>
                <button type="submit" class="create-link-button">Create</button>
            </form>
        </div>
    </div>

    <!-- JavaScript for modal -->
    <script>
        function openCreateLinkModal() {
            document.getElementById('createLinkModal').style.display = 'block';
        }

        function closeCreateLinkModal() {
            document.getElementById('createLinkModal').style.display = 'none';
        }
    </script>
</body>
</html>
