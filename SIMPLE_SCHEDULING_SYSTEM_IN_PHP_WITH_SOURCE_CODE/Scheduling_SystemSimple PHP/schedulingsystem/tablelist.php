<?php
include_once("header.php");
include_once("navbar.php");
?>
<html>
<head>
</head>
<body>
    <br>
    <div align="center">
        <fieldset>
            <legend>Schedule</legend>
            <body>
                <?php
                echo "<tr><td>";

                // your database connection
                $host       = "localhost"; 
                $username   = "root"; 
                $password   = "";
                $database   = "insertion"; 

                // create connection
                $conn = new mysqli($host, $username, $password, $database);

                // check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $query = "SELECT * FROM addtable";
                $result = $conn->query($query);

                echo "<div class='container'><table width='' class='table table-bordered' border='1' >
                            <tr>
                                <th>Faculty</th>
                                <th>Course</th>
                                <th>Subject</th>
                                <th>Room</th>
                                <th>Start time</th>
                                <th>End time</th>
                                <th>Action</th>
                            </tr>";

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['faculty'] . "</td>";
                        echo "<td>" . $row['course'] . "</td>";
                        echo "<td>" . $row['subject'] . "</td>";
                        echo "<td>" . $row['room'] . "</td>";
                        echo "<td>" . $row['start_time'] . "</td>";
                        echo "<td>" . $row['end_time'] . "</td>";
                        echo "<td>
                                <form class='form-horizontal' method='post' action='tablelist.php'>
                                    <input name='id' type='hidden' value='".$row['id']."';>
                                    <input type='submit' class='btn btn-danger' name='delete' value='Delete'>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No records found</td></tr>";
                }
                echo "</table>";

                echo "</td></tr>";

                // delete record
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    echo '<script type="text/javascript">
                              alert("Schedule Successfully Deleted");
                              location="tablelist.php";
                           </script>';
                }

                if (isset($_POST['id'])) {
                    $id = $conn->real_escape_string($_POST['id']);
                    $sql = "DELETE FROM addtable WHERE id='$id'";
                    if ($conn->query($sql) === TRUE) {
                        // Record deleted successfully
                    } else {
                        echo "Error deleting record: " . $conn->error;
                    }
                }

                $conn->close();
                ?>
            </body>
        </fieldset>
    </div>
    <div align="center">
        <br>
        <a href="home.php"><input type='submit' class='btn btn-success' name='delete' value='New'></a>
        <a href="Index.php"><input type='submit' class='btn btn-primary' name='delete' value='Logout'></a>
    </div>
</body>
</html>
<?php
   $path = $_SERVER['DOCUMENT_ROOT'];
   $path .= "footer.php";
   include_once("footer.php");
?>
