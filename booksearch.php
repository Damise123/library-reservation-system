<?php 
session_start();

if (!isset($_SESSION['username'])) {
    die("You must be logged in to search for books.");
}

$user = $_SESSION['username'];

$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "librarydb2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
include 'header.php';
?>

<?php include 'libraryindex.php'; ?>


<h2>Search for a Book</h2>

<form method="post">
    Book Title: <input type="text" name="BookTitle"><br><br>
    Author: <input type="text" name="Author"><br><br>

    Category:
    <select name="Category">
        <option value="">-- Please Select --</option>

        <?php
        $catResult = mysqli_query($conn, "SELECT * FROM Category");
        while ($cat = mysqli_fetch_assoc($catResult)) {
            echo "<option value='" . $cat['CategoryID'] . "'>" . $cat['CategoryDescription'] . "</option>";
        }
        ?>
    </select>

    <br><br>
    <input type="submit" value="Search">
</form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $b = trim($_POST['BookTitle']);
    $a = trim($_POST['Author']);
    $c = trim($_POST['Category']);

    if (empty($b) && empty($a) && empty($c)) {
        echo "<p>Please enter at least one search field.</p>";
    } else {

        $sql = "SELECT * FROM Books WHERE 1=1";

        if (!empty($b)) $sql .= " AND BookTitle LIKE '%$b%'";
        if (!empty($a)) $sql .= " AND Author LIKE '%$a%'";
        if (!empty($c)) $sql .= " AND CategoryID = '$c'";

        $qry = mysqli_query($conn, $sql);

        if ($qry && mysqli_num_rows($qry) > 0) {

            while ($row = mysqli_fetch_assoc($qry)) {
                echo "<div style='border:1px solid #ccc; padding:10px; margin:10px 0;'>";

                echo "<strong>" . $row['BookTitle'] . "</strong><br>";
                echo "Author: " . $row['Author'] . "<br>";
                echo "Edition: " . $row['Edition'] . "<br>";
                echo "Year: " . $row['Year'] . "<br>";

                
                if ($row['Reserved'] == 'Y') {
                    echo "<p style='color:red;'>This book is already reserved.</p>";
                } else {
                    
                    echo "<a href='Reservation.php?isbn=" . $row['ISBN'] . "'>Reserve</a>";
                }

                echo "</div>";
            }

        } else {
            echo "<p>No books found matching your search.</p>";
        }
    }
}
include 'footer.php';

$conn->close();
?>
