<?php
session_start();

// Check if the user is logged in (session is set)
if (!isset($_SESSION['user_id']) || !isset($_SESSION['name'])) {
    // Redirect to login page if session variables are not set
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Room Scheduling System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f7f7f7;
            height: 100vh;
        }
        .navbar {
            background-color: #343a40;
            color: white;
            width: 100%;
            padding: 10px;
            text-align: center;
            position: fixed;
            top: 0;
        }
        .dashboard-container {
            margin-top: 60px;
            padding: 20px;
            width: 100%;
            max-width: 1200px;
        }
        .welcome {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h2>Room Scheduling System Dashboard</h2>
    </div>

    <div class="dashboard-container">
        <div class="welcome">
            <!-- Check if the session variable is set before displaying it -->
            <h1>Welcome, <?= isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest' ?>!</h1>
        </div>

        <div>
            <a href="book_room.php" class="button">Book a Room</a>
            <a href="view_schedule.php" class="button">View Schedule</a>
            <a href="logout.php" class="button">Logout</a>
        </div>
    </div>

<?php if ($_SESSION['role'] === 'admin'): ?>
    <a href="create_room.php">
        <button>Create New Room</button>
    </a>
<?php endif; ?>


</body>
</html>
