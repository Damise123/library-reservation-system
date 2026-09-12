<?php include 'libraryindex.php'?>

<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "librarydb2";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $u = $_POST['Username'];
    $p = $_POST['Password'];
    $f = $_POST['FirstName'];
    $s = $_POST['Surname'];
    $a1 = $_POST['AddressLine1'];
    $a2 = $_POST['AddressLine1'];
    $c = $_POST['City'];
    $t = $_POST['Telephone'];
    $m = $_POST['Mobile'];

    $sql = "INSERT INTO Users (Username, Password, FirstName, Surname,AddressLine1,Addressline2,City,Telephone,Mobile) VALUES ('$u', '$p', '$f', '$s','$a1','$a2','$c','$t','$m')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>New user created</p>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; 
    }
}
?>

<p>Register</p>
<form method="post" >
    User Name: <input type="text" name="Username" required><br><br>
    Password: <input type="Password" name="Password" required><br><br>
    First Name: <input type="text" name="FirstName" required><br><br>
    Surname: <input type="text" name="Surname" required><br><br>
    Address Line 1: <input type="text" name="AddressLine1" ><br><br>
    Address Line 2: <input type="text" name="AddressLine2" ><br><br>
    City: <input type="text" name="City" ><br><br>
    Phone Number: <input type="Number" name="Telephone" ><br><br>
    Mobile: <input type="Number" name="Mobile" required><br><br>
    
    <input type="submit" value="Register">
</form>

<?php
include 'footer.php';

$conn->close();
?>