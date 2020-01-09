    <html>
    <style>
        table{
            border:2px solid red;
            background-color:#FFC;
        }
        th{
            border-bottom: 5px solid #000;
        }
        td{
            border-bottom: 2px solid #666;
        }
    </style>
    <body>
        <?php
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        header("location: index.php");
        exit;
    }

    require_once "config.php";
    if (isset($_POST['submit'])) {
        echo "ooooooo";
        $p_location = $_POST['From'];
        $destination = $_POST['To'];
        $class = $_GET['class'];
        
            $sql = "SELECT * FROM trains WHERE p_location=$p_location and destination=$destination and coach=$class";
            $result = $link->query($sql);
            echo "<table>";
            echo "<tr><th>Name</th><th>From</th><th>Destination</th><th>Class</th><th>Fare_Child</th><th>Fare_Adult</th></tr>";
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<tr><td>";
                    echo $row['name'];
                    echo "</td><td>";
                    echo $row['p_location'];
                    echo "</td><td>";
                    echo $row['desitination'];
                    echo "</td><td>";
                    echo $row['coach'];
                    echo "</td><td>";
                    echo $row['fare_child'];
                    echo "</td><td>";
                    echo $row['fare_adult'];
                    echo "</td></tr>";
            }
            echo "</table>";
   
        } 
    ?>
    </html>
    </body>
    