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

        // Handle delete action
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['subject_id'])) {
            $subject_id = $conn->real_escape_string($_POST['subject_id']);
            $stmt = $conn->prepare("DELETE FROM subject WHERE subject_id = ?");
            $stmt->bind_param("i", $subject_id);

            if ($stmt->execute()) {
                echo '<script type="text/javascript">
                          alert("Schedule Successfully Deleted");
                          location="sublist.php";
                      </script>';
            } else {
                echo "Error deleting record: " . $conn->error;
            }
            $stmt->close();
        }

        // Fetch subjects from the database
        $query = "SELECT * FROM subject";
        $result = $conn->query($query);
        
        if ($result->num_rows > 0) {
            echo "<div class='container'>
                    <table class='table table-bordered' border='1'>
                        <tr>
                            <th>Code</th>
                            <th>Subject</th>
                            <th>Action</th>
                        </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['subject_code'] . "</td>
                        <td>" . $row['subject_description'] . "</td>
                        <td>
                            <form class='form-horizontal' method='post' action='sublist.php'>
                                <input name='subject_id' type='hidden' value='" . $row['subject_id'] . "'>
                                <input type='submit' class='btn btn-danger' name='delete' value='Delete'>
                            </form>
                        </td>
                      </tr>";
            }
            echo "</table></div>";
        } else {
            echo "No subjects found.";
        }

        $conn->close();
    ?>
</div>
<?php
include_once("footer.php");
?>
</body>
</html>
