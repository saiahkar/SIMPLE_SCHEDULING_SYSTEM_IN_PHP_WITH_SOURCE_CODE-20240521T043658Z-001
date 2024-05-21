<?php
include_once("header.php");
include_once("navbar.php");
?>

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

        $query = "SELECT * FROM timer";
        $result = $conn->query($query);

        echo "<div class='container'><table width='' class='table table-bordered' border='1' >
                <tr>
                    <th>Start time</th>
                    <th>End time</th>
                    <th>Action</th>
                </tr>";

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['start_time'] . "</td>";
                echo "<td>" . $row['end_time'] . "</td>";
                echo "<td>
                        <form class='form-horizontal' method='post' action='timelist.php'>
                            <input name='id' type='hidden' value='".$row['id']."';>
                            <input type='submit' class='btn btn-danger' name='delete' value='Delete'>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No records found</td></tr>";
        }
        echo "</table>";

        echo "</td></tr>";

        // delete record
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            echo '<script type="text/javascript">
                      alert("Schedule Successfully Deleted");
                         location="tablelist.php";
                           </script>';
        }

        if(isset($_POST['id'])) {
            $id = $conn->real_escape_string($_POST['id']);
            $sql = "DELETE FROM timer WHERE id='$id'";
            if ($conn->query($sql) === TRUE) {
                // Record deleted successfully
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        }

        $conn->close();
        ?>
    </body>
</div>
</html>

<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "footer.php";
include_once("footer.php");
?>
