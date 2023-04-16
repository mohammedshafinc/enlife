<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enlife</title>
  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="shortcut icon" href="newimages\drop.png" type="image/x-icon">
  <!-- custom css file link  -->
  <link rel="stylesheet" href="main.css">
</head>
<body>
  <!-- header section starts  -->
  <header>
    <a href="index.php" class="logo"><span>EN</span>LIFE</a>
    <input type="checkbox" id="menu-bar">
    <label for="menu-bar" class="fas fa-bars"></label>
    <nav class="navbar">
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="canidonate.php">Donate</a>
      <a href="notification.php" onclick="<?php unset($_SESSION['notification_count']); ?>">Camps<?php
        session_start();
        $conn = mysqli_connect("localhost", "root", "", "enlife") or die("Connection error");
        // Fetch all the upcoming camps from the database
        $query = "SELECT COUNT(*) AS count FROM blood_donors WHERE date > NOW()";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        // Set the notification count
        if (!isset($_SESSION['notification_count'])) {
          $_SESSION['notification_count'] = $row['count'];
        }
        // Display the notification count
        if ($_SESSION['notification_count'] > 0) {
          echo '<span class="notification-count">' . $_SESSION['notification_count'] . '</span>';
        }
        ?></a>
      <a href="login.php">Login</a>
      <a href="admin/login.php">Admin</a>
    </nav>
  </header>
  <!-- header section ends -->

  <!-- home section starts  -->
  <section class="home" id="home">
    <div class="content">
      <p>"Be a lifesaver! search our database of willing blood donors and help save life today."</p>
      <h3>Search For <span>Donors</span></h3>
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
      <!-- HTML form for the search bar -->
      <form method="post" action="">
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
        <button type="submit" name=dettab>Search</button>
      </form>
      <!-- Display the search results if a blood group and/or city has been selected -->
      <!-- Add a div for the popup window -->
      <?php
      if (isset($_POST['dettab'])) {
        echo "
      <div id='popup'>
        <h3>Available blood units:</h3>";
        if (count($blood_units) > 0) {

          echo "<div class=tab1><table>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Blood Group</th>
              <th>City</th>
            </tr>";
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

          echo "</table>
          </div>";
        } else {
          echo "<p>No blood units available.</p>";
        }
        echo "<form method=post><input type=hidden value=true name=clso><input type=submit  class ='be' value=close></form>
        </div>";
        unset($_POST['detatab']);
      }
      ?>
    </div>
    </div>
    </div>
    <div class="image">
      <img src="newimages/title6.png" alt="">
    </div>
  </section>

  <script>
    function openPopup() {
      // Get the popup div
      var popup = document.getElementById("popup");

      // Show the popup div
      popup.style.display = "block";
    }

    // Add a JavaScript function to close the popup window
    function closePopup() {
      // Get the popup div
      var popup = document.getElementById("popup");

      // Hide the popup div
      popup.style.display = "none";
    }
  </script>

  <!-- home section ends -->

  <section class="features" id="features">


    <div class="box-container">

      <div class="box">
        <img src="newimages/bluu.png" alt="">
        <h3>Can I donate blood?</h3>
        <p>"Be a life-giver! Check eligibility to donate blood and save a life today.<br>
          Visit our website now!"</p>
        <a href="canidonate.php" class="btn">Check your eligibility&#x2192</a>
      </div>

      <div class="box">
        <img src="newimages/blu.jpg" alt="">
        <h3>Donate now</h3>
        <p>"Give the gift of life! Register now to become a blood donor and<br>
          save lives in your community "</p>
        <a href="canidonate.php" class="btn">Register here&#x2192</a>
      </div>

      <div class="box">
        <img src="newimages/bluuu1.png" alt="">
        <h3>Camp registration</h3>
        <p>"Save a life,give the gift of blood.Register now to conduct a blood donation camp and
          be a hero in someone's story."</p>
        <a href="camp.php" class="btn">Register here&#x2192</a>
      </div>
    </div>
  </section>
  <!-- contact section starts  -->
  <section class="contact" id="contact">
    <div class="image">
      <img src="newimages/contactus1.png" alt="">
    </div>
    <form action="" name="submit-to-google-sheet">
      <h1 class="heading">contact us</h1>
      <div class="inputBox">
        <input type="text" name="name" required>
        <label>Name</label>
      </div>

      <div class="inputBox">
        <input type="email" name="email" required>
        <label>Email</label>
      </div>

      <div class="inputBox">
        <input type="number" name="phone" required>
        <label>Phone</label>
      </div>

      <div class="inputBox">
        <textarea required name="messege" id="" cols="30" rows="10"></textarea>
        <label>Message</label>
      </div>

      <input type="submit" class="btn" value="send message">

    </form>
    <span id="msg"></span>

  </section>

  <!-- contact section edns -->

  <!-- footer section starts  -->
  <div class="footer">
    <div class="box-container">
      <div class="box">
        <h3>About Us</h3>
        <p>EnLife connects those in need of blood transfusions with willing blood donors. Our mission is to make the
          process of finding a blood donor easier and more efficient, ultimately saving lives and improving the health
          of our community.</p>
      </div>

      <div class="box">
        <h3>Quick links</h3>
        <a href="index.php">home</a>
        <a href="about.php">About</a>
        <a href="canidonate.php">Donate</a>
        <a href="notification.php">Camps</a>
        <a href="login.php">Login</a>
        <a href="admin/login.php">Admin</a>
      </div>

      <div class="box">
        <h3>Follow Us</h3>
        <a href="#">facebook</a>
        <a href="#">instagram</a>
        <a href="#">Linkdin</a>
        <a href="#">twitter</a>
      </div>

      <div class="box">
        <h3>Contact Info</h3>
        <div class="info">
          <i class="fas fa-phone"></i>
          <p> +917994648644 <br> +918086151061 </p>
        </div>
        <div class="info">
          <i class="fas fa-envelope"></i>
          <p> shafinms21@gmail.com <br> tajay5657@gmail.com </p>
        </div>
        <div class="info">
          <i class="fas fa-map-marker-alt"></i>
          <p> Nilambur, Kerala - 679328 </p>
        </div>
      </div>

    </div>
    <h1 class="credit"> &copy; Copyright 2023 by Team Enlife </h1>
  </div>
  <script>
  const scriptURL = 'https://script.google.com/macros/s/AKfycbyiyZEMn5toB47uCvoZ_aZZRd9XRb2GH7DxVO2Wlv_DIevZGivqXrvAYnyJNX6N9sth6Q/exec'
  const form = document.forms['submit-to-google-sheet']
  const msg =document.getElementById("msg")

  form.addEventListener('submit', e => {
    e.preventDefault();
    fetch(scriptURL, { method: 'POST', body: new FormData(form)})
        .then(response => {
            form.reset();
        })
        .catch(error => console.error('Error!', error.message));
    showAlert("Message sent successfully!", 5000);
});

function showAlert(message, duration) {
    const alertBox = document.createElement("div");
    alertBox.innerHTML = message;
    alertBox.style.background = "linear-gradient(90deg, var(--black), var(--red))";
    alertBox.style.color = "white";
    alertBox.style.padding = "10px";
    alertBox.style.position = "fixed";
    alertBox.style.top = "0";
    alertBox.style.left = "50%";
    alertBox.style.transform = "translateX(-50%)";
    alertBox.style.zIndex = "9999";
    alertBox.style.borderRadius = "10px";
    document.querySelector("header").appendChild(alertBox);
    setTimeout(() => {
        document.querySelector("header").removeChild(alertBox);
    }, duration);
}
</script>
  <!-- footer section ends -->
</body>
</html>