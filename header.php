<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Reservation System</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

<header>
    <h1>Library Assignment </h1>
</header>

<nav>
    <?php
    if (isset($_SESSION['username'])) {
    } else {

        echo '<a href="login.php">Login</a>';
        echo '<a href="register.php">Register</a>';
    }
    ?>
</nav>

<div class="container">
