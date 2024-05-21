<?php
   include_once("header.php");
   include_once("navbar.php");
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-image: url();
            background-color: white;
        }
        th {
            text-align: center;
        }
        tr {
            height: 30px;
        }
        td {
            padding-top: 5px;
            padding-left: 20px;    
            padding-bottom: 5px;    
            height: 20px;
        }
    </style>
</head>
<body><br>
<div class="container">
    <?php
        // Database connection
        $host       = "localhost"; 
        $username   = "root"; 
        $password   = "";
        $database   = "insertion"; 
        
        $conn = new mysqli($host, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['id'])) {
            $id = $conn->real_escape_string($_POST['id']);
            $sql = "DELETE FROM rooms WHERE id='$id'";
            if ($conn->query($sql) === TRUE) {
                echo '<script type="text/javascript">
                          alert("Schedule Successfully Deleted");
                          location="roomlist.php";
                      </script>';
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        }

        $query = "SELECT * FROM rooms";
        $result = $conn->query($query);
        
        if ($result->num_rows > 0) {
            echo "<div class='container'>
                    <table width='' class='table table-bordered' border='1'>
                        <tr>
                            <th>Rooms</th>
                            <th>Action</th>
                        </tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['room'] . "</td>
                        <td>
                            <form class='form-horizontal' method='post' action=''>
                                <input name='id' type='hidden' value='".$row['id']."'>
                                <input type='submit' class='btn btn-danger' name='delete' value='Delete'>
                            </form>
                        </td>
                      </tr>";
            }
            echo "</table></div>";
        } else {
            echo "0 results";
        }

        $conn->close();
    ?>
</div>
<?php
   include_once("footer.php");
?>
</body>
</html>
