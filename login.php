
    

    <?php
    session_start();
    include 'libraryindex.php';

    $servername = "localhost:3307";
    $username = "root";
    $password = "";
    $dbname = "librarydb2";


    $conn = new mysqli($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }  
    include 'header.php';

    $username = "";
    $errors = [];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $u = $_POST['Username'];
        $p = $_POST['Password'];
        if (empty($u) || empty($p)) {
            $errors[] = "Please enter both username and password.";
        } else {
            
            $sql = "SELECT * FROM users WHERE Username='$u' and Password = '$p'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                
                $_SESSION['Username'] = $row['Username'];
                echo "Login successful! Welcome, " . $row['Username'];
                session_start();
                $_SESSION['username'] = $u;
                header("Location: ViewRBooks.php");
                return;

            } else {
                echo "Username or password is incorrect.";
            }
        }
    }
    ?>
    <p>Login</p>
    <form method="post" >
        User Name: <input type="text" name="Username" required><br><br>
        Password: <input type="Password" name="Password" required><br><br>
        <input type="submit" value="Login">
        
    <?php
    include 'footer.php';
    $conn->close();

    ?>