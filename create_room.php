<?php
session_start();
require 'config.php'; // Database connection

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Check if user is admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

// Handle the room creation form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_room'])) {
    // Sanitize user input
    $room_name = htmlspecialchars($_POST['room_name']);
    $capacity = htmlspecialchars($_POST['capacity']);

    // Validate the inputs
    if (empty($room_name) || empty($capacity)) {
        $error = "All fields are required.";
    } elseif (!is_numeric($capacity) || $capacity <= 0) {
        $error = "Capacity must be a positive number.";
    } else {
        // Insert the new room into the rooms table
        $stmt = $conn->prepare("INSERT INTO rooms (room_name, capacity) VALUES (?, ?)");
        if (!$stmt) {
            die("Error in SQL statement: " . $conn->error);
        }
        $stmt->bind_param('si', $room_name, $capacity);

        if ($stmt->execute()) {
            $success = "Room successfully created!";
        } else {
            $error = "Failed to create room. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Room | Room Scheduling System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> <!-- SweetAlert for alerts -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f7f7f7;
        }
        .room-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="room-container">
        <h2>Create a New Room</h2>

        <!-- Display error or success message -->
        <?php if (isset($error)): ?>
            <script>
                Swal.fire('Error', '<?= $error ?>', 'error');
            </script>
        <?php elseif (isset($success)): ?>
            <script>
                Swal.fire('Success', '<?= $success ?>', 'success');
            </script>
        <?php endif; ?>

        <!-- Room Creation Form -->
        <form method="POST" action="create_room.php">
            <input type="text" name="room_name" placeholder="Enter Room Name (e.g., 3rd Floor Room 301)" required>
            <input type="number" name="capacity" placeholder="Enter Room Capacity" required>
            <button type="submit" name="create_room">Create Room</button>
        </form>
    </div>

</body>
</html>
