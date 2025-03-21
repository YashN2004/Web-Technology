<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: home.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Mentee Management System</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="mentee_list.php">Mentee List</a></li>
                <li><a href="add_mentee.php">Add Mentee</a></li>
                <li><a href="update_mentee.php">Update Mentee</a></li>
                <li><a href="delete_mentee.php">Delete Mentee</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <h2>Admin Options</h2>
        <ul>
            <li><a href="mentee_list.php">View All Mentees</a></li>
            <li><a href="add_mentee.php">Add New Mentee</a></li>
            <li><a href="update_mentee.php">Update Mentee Details</a></li>
            <li><a href="delete_mentee.php">Delete Mentee</a></li>
        </ul>
    </section>

    <footer>
        <p>&copy; 2025 Mentee Management System. All rights reserved.</p>
    </footer>
</body>
</html>
