<?php

// Start output buffering and a new session
ob_start();
session_start();

// Include the database connection file
require "db_connection.php";
//  print_R($_POST);die;
// Check if all required POST variables have been set
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['pwd']) && isset($_POST['phone']) && isset($_POST['dob']) && isset($_POST['gender']) && isset($_POST['address']) && isset($_POST['bloodgrp']) && isset($_POST['city']) && isset($_POST['district']) && isset($_POST['pincode']) ) {
  // Check if all required POST variables are not empty
  // print_R($_POST);die;
  if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['pwd']) && !empty($_POST['phone']) && !empty($_POST['dob']) && !empty($_POST['gender']) && !empty($_POST['address']) && !empty($_POST['bloodgrp']) && !empty($_POST['city']) && !empty($_POST['district']) && !empty($_POST['pincode'] ) ) {
    // print_r($_POST);die;
    // Store POST variables in local variables
    $name = $_POST['name'];
    $email = ($_POST['email']);
    $pwd = md5($_POST['pwd']);
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $bloodgrp = $_POST['bloodgrp'];
    $district = $_POST['district'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];
    $lastdonated= $_POST['lastdate'];
    // $donate= $_POST['donateddate'];
    $email_query = "SELECT * FROM registration WHERE email='$email' OR phone='$phone' LIMIT 1";
    $email_query_run = mysqli_query($con, $email_query);
    if (mysqli_num_rows($email_query_run) > 0) {
      $_SESSION['status'] = "Email already exists";

      echo '<script language="javascript">';
      echo 'alert("Email or mobile number already exists");';
      echo 'window.location.href = "register.php";';
      echo '</script>';
      die();
    }
  }
  // Check if a session is active
  if (isset($_SESSION['sess_user_id']) && !empty($_SESSION['sess_user_id'])) {
    // If a session is active
    $sess = $_SESSION['sess_user_id'];
    $SQL = "UPDATE registration SET 'name='" . $name . "',email='" . $email . "',pwd='" . $pwd . "',phone='" . $phone . "',dob='" . $dob . "',gender='" . $gender . "',address='" . $address . "',bloodgrp='" . $bloodgrp . "',city='" . $city . "',diistrict='" . $district . "',pincode='" . $pincode . "',lastdate='" . $lastdonated . "' WHERE id='" . $sess . "'";
   // $up = "UPDATE donation_history SET 'donation_date='" . $lastdonated . "',WHERE id='" . $sess . "'";
  } else {
    $SQL = "INSERT INTO registration (name, email, pwd, phone, dob, gender, adress, bloodgrp, city, district, pincode,lastdate) VALUES ('" . $name . "', '" . $email . "', '" . $pwd . "', '" . $phone . "', '" . $dob . "', '" . $gender . "', '" . $address . "', '" . $bloodgrp . "', '" . $city . "', '" . $district . "', '" . $pincode . "','" . $lastdonated . "')";
    // $up = "INSERT INTO donation_history (donation_date) VALUES ('". $lastdonated . "')";
  }

  $query_run = mysqli_query($con, $SQL);

  if ($query_run) {
    if(empty($sess)){
      $sess = $con->insert_id;
    }
    if(!empty($sess)){
      $is_exist = mysqli_query($con,"SELECT COUNT(*) AS num_rows FROM donation_history WHERE id='" . $sess . "' AND donation_date='" . $lastdonated . "'  LIMIT 1;");
      $row = mysqli_fetch_array($is_exist);
      if($row["num_rows"] > 0){
        //user exists
      }
      else{
        $history = "INSERT INTO donation_history (donation_date,registration_id ) VALUES ('". $lastdonated . "','". $sess . "')";
        $query_run1 = mysqli_query($con, $history);
      }
    }
    // If it did, show an alert message saying that the message was successfully sent
    echo "<script >
        window.alert('Donor added successfully!');window.location.href = 'login.php'</script>";
        


    // Check if a session is active
    if (isset($_SESSION['sess_user_id']) && !empty($_SESSION['sess_user_id'])) {
      // If a session is active, redirect the user to the logout page
      header("Location: logout.php");
    }
  } else {
    // If the query did not run successfully, show an alert message saying that the registration failed
    echo "<script >
        window.alert('Registration failed');</script>";
  }
}
// else {
//   echo "<script >
//   window.alert('Please select all required fields');</script>";
// } 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>REGISTRATION</title>
  <link rel="stylesheet" href="register.css" />
  <link rel="icon" type="image/x-icon" href="newimages/blooddrop.jpg">
</head>

<body>
  <section class="container">
    <form action="register.php" method="post" class="form" >
      <div class="form-box">
        <h1 id="title">REGISTRATION FORM</h1>
        <div class="input-box">
          <label>Full Name</label>
          <input type="text" name="name" placeholder="Enter full name" required />
        </div>

        <div class="input-box">
          <label>Email Address</label>
          <input type="email" name="email" placeholder="Enter email address" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required />
        </div>
        <div class="input-box">
          <label>Password</label>
          <input type="password" name="pwd" placeholder=" Enter password" required />
        </div>
        <div class="column">
          <div class="input-box">
            <label>Mobile  Number</label>
            <input type="tel" name="phone" placeholder="eg:9988776655" pattern="[0-9]{10}" required />
          </div>
          <div class="input-box">
            <label>Date Of Birth</label>
            <input type="date" name="dob" placeholder="Enter birth date" required />
          </div>
        </div>
        <div class="gender-box">
          <h3>Gender</h3>
          <div class="gender-option">
            <div class="gender">
              <input type="radio" id="check-male" name="gender" value="male" checked />
              <label for="check-male">male</label>
            </div>
            <div class="gender">
              <input type="radio" id="check-female" name="gender" value="female" />
              <label for="check-female">Female</label>
            </div>
            <div class="gender">
              <input type="radio" id="check-other" name="gender" value="other" />
              <label for="check-other">other</label>
            </div>
          </div>
        </div>
        <div class="input-box address">
          <label>Address</label>
          <input type="text" name="address" placeholder="Enter street address" required />
          <input type="text" placeholder="Enter street address line 2" />
          <div class="column">
            <div class="select-box">
              <select name="bloodgrp">
                <option hidden>blood group</option>
                <option>A+</option>
                <option>A-</option>
                <option>B+</option>
                <option>B-</option>
                <option>O+</option>
                <option>O-</option>
                <option>AB+</option>
                <option>AB-</option>
              </select>
            </div>
            <input type="text" name="city" placeholder="Enter your city" required />
          </div>
          <div class="column">
            <div class="select-box">
              <select name="district">
                <option hidden>EnterDistrict</option>
                <option> Kasaragod</option>
                <option>Kannur</option>
                <option>Wayanad</option>
                <option> Kozhikode</option>
                <option>Malappuram</option>
                <option> Palakkad</option>
                <option>Thrissur</option>
                <option>Eranakulam</option>
                <option>Kottayam </option>
                <option>Idukki</option>
                <option>Alappuzha</option>
                <option> Kollam</option>
                <option>Pathanamthitta</option>
                <option>Thiruvananthapuram</option>
              </select>
            </div>
            <input name="pincode" type="number" placeholder="Enter postal code" required />
          </div>
          <div class="input-box">
            <label>Last donated date</label>
            <input type="date" name="lastdate" placeholder="Enter last blood donated date"/>
          </div>
        </div>
        <button type="submit" value="">Submit</button>
        <button onclick="goBack()">Cancel</button>

    </form>
  </section>
  <script>
  function goBack() {
    window.location.assign("login.php")
}

</script>

</body>

</html>