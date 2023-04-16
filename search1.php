
<?php
// Connection parameters for the database
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_database = 'enlife';

// Connect to the database using the mysqli extension
$con = mysqli_connect($db_host, $db_user, $db_password, $db_database);

// If the connection fails, display an error message
if (mysqli_connect_errno()) {
  die('Could not connect: ' . mysqli_error($con));
}

// Retrieve blood groups from the database
$sql = "SELECT DISTINCT bloodgrp FROM registration";
$result = $con->query($sql);
$blood_groups = array();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $blood_groups[] = $row["bloodgrp"];
  }
}

// Retrieve cities from the database
$sql = "SELECT DISTINCT city FROM registration";
$result = $con->query($sql);
$cities = array();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $cities[] = $row["city"];
  }
}

// Check if a blood group and/or city has been selected
if (isset($_POST['bloodgrp']) || isset($_POST['city'])) {
  $selected_blood_group = $_POST['bloodgrp'];
  $selected_city = $_POST['city'];

  // Retrieve available blood units for the selected blood group and city, whose last donation date is 90 days or more ago
  $sql = "SELECT name, email, phone, bloodgrp, city, lastdate FROM registration WHERE 1=1";
  if (!empty($selected_blood_group)) {
    $sql .= " AND bloodgrp = '$selected_blood_group'";
  }
  if (!empty($selected_city)) {
    $sql .= " AND city = '$selected_city'";
  }
  $sql .= " AND lastdate <= DATE_SUB(NOW(), INTERVAL 90 DAY)";
  $result = $con->query($sql);
  $blood_units = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $blood_units[] = $row;
    }
  }
}

// Close the database connection
$con->close();
?>

<!DOCTYPE html>
        <html>

        <head>
          <title>Blood Unit Search</title>
        </head>

        <body>
          <h1>Blood Unit Search</h1>

          <!-- HTML form for the search bar -->
          <form method="post" >
            <label for="bloodgrp">Select blood group:</label>
            <select name="bloodgrp">
              <option value="">--Select--</option>
              <?php
              // Display blood groups in the dropdown
              foreach ($blood_groups as $group) {
                echo "<option value='" . $group . "'>" . $group . "</option>";
              }
              ?>
            </select>

            <label for="city">Select city:</label>
            <select name="city">
              <option value="">--Select--</option>
              <?php
              // Display cities in the dropdown
              foreach ($cities as $city) {
                echo "<option value='" . $city . "'>" . $city . "</option>";
              }
              ?>
            </select>

            <button type="submit">Search</button>
          </form>

          <!-- Display the search results if a blood group and/or city has been selected -->
          <?php
          if (isset($selected_blood_group) || isset($selected_city)) {
            echo "<h3>Available blood units:</h3>";
            if (count($blood_units) > 0) {
              ?>
              <table>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Blood Group</th>
                  <th>City</th>
                </tr>
                <?php
                // Display the blood units in a table
                foreach ($blood_units as $unit) {
                  echo "<tr>";
                  echo "<td>" . $unit['name'] . "</td>";
                  echo "<td>" . $unit['email'] . "</td>";
                  echo "<td>" . $unit['phone'] . "</td>";
                  echo "<td>" . $unit['bloodgrp'] . "</td>";
                  echo "<td>" . $unit['city'] . "</td>";
                  echo "</tr>";
                }
                ?>
              </table>
              <?php
            } else {
              echo "<p>No blood units available.</p>";
            }
          }
          ?>
          <?php
          // Display the back button if a search has been performed
          if (isset($selected_blood_group) || isset($selected_city)) {
            echo "<button onclick=\"window.location.href='index.php'\">Back</button>";
          }
          ?>
        </body>
        </html>