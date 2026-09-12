<?php
session_start();


if (!isset($_SESSION['username'])) {
    die("You must be logged in to reserve a book.");
}

$user = $_SESSION['username'];


$servername = "localhost:3307";
$dbuser = "root";
$dbpass = "";
$dbname = "librarydb2";

$conn = new mysqli($servername, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['isbn'])) {
    $isbn = $_GET['isbn'];
    $date = date("Y-m-d"); 

    $insertSql = "INSERT INTO reserved_books (ISBN, Username, ReservedDate) VALUES ('$isbn', '$user', '$date')";
    

    if (mysqli_query($conn, $insertSql)) {

        $updateSql = "UPDATE Books SET Reserved = 'Y' WHERE ISBN = '$isbn'";
        mysqli_query($conn, $updateSql);

        echo "<h3>Success!</h3>";
        echo "<p> The book (ISBN: $isbn) has been reserved for $user.</p>";
        echo "<a href='booksearch.php'>Search for another book</a> | ";
        echo "<a href='ViewRBooks.php'>View my reserved books</a>";

    } else {

        echo "<h3>Error</h3>";
        echo "<p>Could not reserve book. " . mysqli_error($conn) . "</p>";
    }

} else {
    echo "No ISBN provided.";
}


$conn->close();
?>