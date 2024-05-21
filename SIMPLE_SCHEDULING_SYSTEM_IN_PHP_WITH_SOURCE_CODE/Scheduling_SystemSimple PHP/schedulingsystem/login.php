<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

if ($username && $password) {
    $mysqli = new mysqli("localhost", "root", "", "insertion");

    // Check connection
    if ($mysqli->connect_error) {
        die("Couldn't connect to the database: " . $mysqli->connect_error);
    }

    $username = $mysqli->real_escape_string($username);
    $password = $mysqli->real_escape_string($password);

    $query = "SELECT * FROM admin WHERE username='$username'";
    $result = $mysqli->query($query);

    if ($result) {
        $numrows = $result->num_rows;

        if ($numrows !== 0) {
            $row = $result->fetch_assoc();
            $dbusername = $row['username'];
            $dbpassword = $row['password'];

            if ($username == $dbusername && $password == $dbpassword) {
                echo '<script type="text/javascript">
                      alert("Welcome User!");
                      location="home.php";
                      </script>';
                $_SESSION['username'] = $username;
            } else {
                echo '<script type="text/javascript">
                      alert("Wrong Password!");
                      location="index.php";
                      </script>';
            }
        } else {
            echo '<script type="text/javascript">
                      alert("That user does not exist!");
                      location="index.php";
                      </script>';
        }
    } else {
        echo "Error: " . $mysqli->error;
    }

    $mysqli->close();
} else {
    echo '<script type="text/javascript">
              alert("Please enter a username and password!");
              location="tb.php";
              </script>';
}
?>
