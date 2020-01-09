<?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: index.php");
  exit;
}

require_once "config.php";
if (isset($_POST['submit'])) {
  $p_location = $_POST["From"];
  $destination = $_POST["To"];
  $class = $_POST["class"];

  $sql = "SELECT * FROM trains WHERE p_location=\"{$p_location}\" and destination=\"{$destination}\" and coach=\"{$class}\"";
  $result = mysqli_query($link, $sql);
  echo "<table>";
  echo "<tr><th>Name</th><th>From</th><th>Destination</th><th>Class</th><th>Fare_Child</th><th>Fare_Adult</th></tr>";
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    echo "<tr><td>";
    echo $row['name'];
    echo "</td><td>";
    echo $row['p_location'];
    echo "</td><td>";
    echo $row['destination'];
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



<script>
  function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
  }


  window.onclick = function(event) {
    if (!event.target.matches(".dropbtn")) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains("show")) {
          openDropdown.classList.remove("show");
        }
      }
    }
  };
</script>
<html>

<head>
  <!-- <link rel="stylesheet" href="trains_css.css"> -->
  <style>
    input[type="text"],
    select,
    input[type="number"] {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    input[type="submit"] {
      width: 100%;
      background-color: #00838f;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    div {
      border-radius: 5px;
      background-color: #e0f7fa;
      padding: 20px;
    }
  </style>
</head>

<body style="background-color: #80deea">
  <h1>Search Trains</h1>
  <!--add IRCTC logo -->
  <h2>Indian Railway IRCTC Train Ticket Reservation</h2>
  <div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <label>From</label>
      <select name="From">
        <option value="DELHI">DELHI</option>
        <option value="JAIPUR">JAIPUR</option>
        <option value="JODHPUR">JODHPUR</option>
        <option value="MUMBAI">MUMBAI</option>
        <option value="AHEMDABAD">AHEMDABAD</option>
      </select>
      <label>To</label>
      <select name="To">
        <option value="DELHI">DELHI</option>
        <option value="JAIPUR">JAIPUR</option>
        <option value="JODHPUR">JODHPUR</option>
        <option value="MUMBAI">MUMBAI</option>
        <option value="AHEMDABAD">AHEMDABAD</option>
      </select>
      <label for="class">Class</label>
      <select name="class">
        <option value="all">ALL CLASSES</option>
        <option value="1A">1A</option>
        <option value="2A">2A</option>
        <option value="3A">3A</option>
        <option value="EC">EC</option>
        <option value="CC">CC</option>
        <option value="SLEEPER">SLEEPER</option>
      </select>
      <!-- <label for="date">Date</label>
      <input type="date" name="date"> -->
      <input type="submit" name="submit" value="SUBMIT">
    </form>
  </div>
</body>

</html>