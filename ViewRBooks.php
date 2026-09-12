<?php 
session_start();

if (!isset($_SESSION['username'])) {
    die("You must be logged in to view reserved books.");
}
include 'header.php';
$user = $_SESSION['username'];

$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "librarydb2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



if (isset($_GET['remove'])) {
    $isbn = $_GET['remove'];
    

    $sqlDelete = "DELETE FROM reserved_books WHERE Username='$user' AND ISBN='$isbn'";
    mysqli_query($conn, $sqlDelete);


    $sqlUpdate = "UPDATE Books SET Reserved = 'N' WHERE ISBN = '$isbn'";
    mysqli_query($conn, $sqlUpdate);

    echo "<p style='color:green;'>Reservation removed successfully.</p>";
}
?>

<?php include 'libraryindex.php'; ?>

<h2>Your Reserved Books</h2>

<?php

$sql = "SELECT Books.ISBN, Books.BookTitle, Books.Author, Books.Edition, Books.Year, reserved_books.ReservedDate FROM reserved_books INNER JOIN Books ON reserved_books.ISBN = Books.ISBN WHERE reserved_books.Username = '$user'";

$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<p>You have no reserved books.</p>";
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        
        echo "<div style='border-bottom: 1px solid #ccc; padding: 10px; margin-bottom: 10px;'>";
        
        echo "<strong>" . $row['BookTitle'] . "</strong><br>";
        echo "Author: " . $row['Author'] . "<br>";
        echo "Edition: " . $row['Edition'] . "<br>";
        echo "Year: " . $row['Year'] . "<br>";
        echo "Reserved On: " . $row['ReservedDate'] . "<br><br>";


        echo "<a href='?remove=" . $row['ISBN'] . "' 
                 style='color: red; text-decoration: none; border: 1px solid red; padding: 5px;'
                 onclick=\"return confirm('Are you sure you want to return this book?');\">
                 Remove Reservation
              </a>";
        
        echo "</div>";
    }
}
include 'footer.php';
$conn->close();
?>