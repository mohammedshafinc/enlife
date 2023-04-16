<?php
include 'db_connection.php';
session_start();
$user_id = $_SESSION['user_id'];
if(!empty($_POST['update_name']) && !empty($_POST['update_email'])){
   $update_name = mysqli_real_escape_string($con, $_POST['update_name']);
   $update_email = mysqli_real_escape_string($con, $_POST['update_email']);
   $update_phone = mysqli_real_escape_string($con, $_POST['update_phone']);
   $update_dob = mysqli_real_escape_string($con, $_POST['update_dob']);
   $update_gender = mysqli_real_escape_string($con, $_POST['gender']);
   $update_address = mysqli_real_escape_string($con, $_POST['update_address']);
   $update_blood_group = mysqli_real_escape_string($con, $_POST['update_blood_group']);
   $update_city = mysqli_real_escape_string($con, $_POST['update_city']);
   $update_district = mysqli_real_escape_string($con, $_POST['update_district']);
   $update_pincode = mysqli_real_escape_string($con, $_POST['update_pincode']);
   $update_lastdonated = mysqli_real_escape_string($con, $_POST['update_lastdate']);

   mysqli_query($con, "UPDATE `registration` SET name = '$update_name', email = '$update_email', phone = '$update_phone', dob = '$update_dob', gender = '$update_gender', adress = '$update_address', bloodgrp = '$update_blood_group', city='$update_city' ,district = '$update_district', pincode = '$update_pincode',lastdate ='$update_lastdonated' WHERE id = '$user_id'") or die('query failed');
   
  
      
   //$update_lastdonated = mysqli_real_escape_string($con, $_POST['update_lastdate']);
   if(!empty($user_id)){
      $is_exist = mysqli_query($con,"SELECT COUNT(*) AS num_rows FROM donation_history WHERE id='" . $user_id . "' AND donation_date='" . $update_lastdonated . "'  LIMIT 1;");
      $row = mysqli_fetch_array($is_exist);
      if($row["num_rows"] > 0){
        //user exists
      }
      else{
        $history = "INSERT INTO donation_history (donation_date,registration_id ) VALUES ('". $update_lastdonated . "','". $user_id . "')";
        $query_run1 = mysqli_query($con, $history);
      }
    }
   $old_pass = $_POST['old_pass'];
   $update_pass = '';
   if(!empty($_POST['update_pass'])){
      $update_pass = mysqli_real_escape_string($con, md5($_POST['update_pass']));
   }
   $new_pass = '';
   if(!empty($_POST['new_pass'])){
      $new_pass = mysqli_real_escape_string($con, md5($_POST['new_pass']));
   }
   $confirm_pass = '';
   if(!empty($_POST['confirm_pass'])){
      $confirm_pass = mysqli_real_escape_string($con, md5($_POST['confirm_pass']));
   }
   
   
   

   if(!empty($update_pass) || !empty($new_pass)|| !empty($confirm_pass)) {
      if($update_pass != $old_pass) {
         $message[] = 'old password not matched!';
      }
      else if($new_pass !=$confirm_pass){
         $message[] = 'confirm password  not matched!';
      }
      else {
         mysqli_query($con, "UPDATE `registration` SET pwd = '$confirm_pass' WHERE id = '$user_id'") or die('query failed');
         $message[] = 'password updated successfully!';
         header('Location: login.php');
         exit();
       } 
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update profile</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="profile1.css">

</head>
<body>
   
<div class="update-profile">

   <?php
      $select = mysqli_query($con, "SELECT * FROM `registration` WHERE id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select) > 0){
         $fetch = mysqli_fetch_assoc($select);
      }
   ?>

   <form action="" method="post" enctype="multipart/form-data">
     
      <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
   <div>
      <?php
      echo '<image src="newimages/avatar.jpeg">';
      ?>
      <h3><?php echo $fetch['name'];?></h3>
      <br>
   </div>
      <div class="flex">
   <div class="inputBox">
      <span>username :</span>
      <input type="text" name="update_name" value="<?php echo $fetch['name']; ?>" class="box">
      <span>your email :</span>
      <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
      <span>phone number :</span>
      <input type="text" name="update_phone" value="<?php echo $fetch['phone']; ?>" class="box">
      <span>date of birth :</span>
      <input type="date" name="update_dob" value="<?php echo $fetch['dob']; ?>" class="box">
      <select name="update_district" class="box">
         <option value="">district</option>
         <option value="Kasargod" <?php if($fetch['district'] == 'Kasargod') { echo 'selected'; } ?>>Kasargod</option>
         <option value="Kannur" <?php if($fetch['district'] == 'Kannur') { echo 'selected'; } ?>>Kannur</option>
         <option value="Wayanad" <?php if($fetch['district'] == 'Wayanad') { echo 'selected'; } ?>>Wayanad</option>
         <option value="Kozhikode" <?php if($fetch['district'] == 'Kozhikode') { echo 'selected'; } ?>>Kozhikode</option>
         <option value="Malappuram" <?php if($fetch['district'] == 'Malappuram') { echo 'selected'; } ?>>Malappuram</option>
         <option value="Palakkad" <?php if($fetch['district'] == 'Palakkad') { echo 'selected'; } ?>>Palakkad</option>
         <option value="Thrissur" <?php if($fetch['district'] == 'Thrissur') { echo 'selected'; } ?>>Thrissur</option>
         <option value="Ernakulam" <?php if($fetch['district'] == 'Ernakulam') { echo 'selected';}?>>Ernakulam</option>
         <option value="Kottayam" <?php if($fetch['district'] == 'Kottayam') { echo 'selected';}?>>Kottayam</option>
         <option value="Alappuzha" <?php if($fetch['district'] == 'Alappuzha') { echo 'selected';}?>>Alappuzha</option>
         <option value="Idukki" <?php if($fetch['district'] == 'Idukki') { echo 'selected';}?>>Idukki</option>
         <option value="Pathanamthitta" <?php if($fetch['district'] == 'Pathanamthitta') { echo 'selected';}?>>Pathanamthitta</option>
         <option value="Kollam" <?php if($fetch['district'] == 'Kollam') { echo 'selected';}?>>Kollam</option>
         <option value="Thiruvanathapuram" <?php if($fetch['district'] == 'Thiruvanathapuram') { echo 'selected';}?>>Thiruvanathapuram</option>
      <span>city</span>
      <input type="text" name="update_city" value="<?php echo $fetch['city']; ?>" class="box">
      <span>Last donated date :</span>
      <input type="date" name="update_lastdate" value="<?php echo $fetch['lastdate']; ?>" class="box">
      <span>gender :</span>
      <input type="radio" name="gender" value="male" <?php if($fetch['gender'] == 'male') { echo 'checked'; } ?>> Male
      <input type="radio" name="gender" value="female" <?php if($fetch['gender'] == 'female') { echo 'checked'; } ?>> Female
      <input type="radio" name="gender" value="other" <?php if($fetch['gender'] == 'other') { echo 'checked'; } ?>> Other
   </div>
   <div class="inputBox"> 
   <span>pincode</span>
      <input type="text" name="update_pincode" value="<?php echo $fetch['pincode']; ?>" class="box">
      <input type="hidden" name="old_pass" value="<?php echo $fetch['pwd']; ?>"> 
      <span>old password :</span> 
      <input type="password" name="update_pass" placeholder="enter previous password" class="box"> 
      <span>new password :</span> 
      <input type="password" name="new_pass" placeholder="enter new password" class="box"> 
      <span>confirm password :</span> 
      <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
      <span>address :</span> 
      <textarea name="update_address" class="box"><?php echo $fetch['adress']; ?></textarea>
     
      <span>blood group :</span> 
      <select name="update_blood_group" class="box">
         <option value="">Select blood group</option>
         <option value="A+" <?php if($fetch['bloodgrp'] == 'A+') { echo 'selected'; } ?>>A+</option>
         <option value="A-" <?php if($fetch['bloodgrp'] == 'A-') { echo 'selected'; } ?>>A-</option>
         <option value="B+" <?php if($fetch['bloodgrp'] == 'B+') { echo 'selected'; } ?>>B+</option>
         <option value="B-" <?php if($fetch['bloodgrp'] == 'B-') { echo 'selected'; } ?>>B-</option>
         <option value="O+" <?php if($fetch['bloodgrp'] == 'O+') { echo 'selected'; } ?>>O+</option>
         <option value="O-" <?php if($fetch['bloodgrp'] == 'O-') { echo 'selected'; } ?>>O-</option>
         <option value="AB+" <?php if($fetch['bloodgrp'] == 'AB+') { echo 'selected'; } ?>>AB+</option>
         <option value="AB-" <?php if($fetch['bloodgrp'] == 'AB-') { echo 'selected';}?>>AB-</option>
         </select>
         </div>
    </div>
    <span>history :</span> 
    <?php
// Get the user's ID from the session or URL parameter
$user_id = $_SESSION['user_id']; // or $_GET['user_id'] or however you are getting the ID

// Query the database for the user's information and donation history
$sql = "SELECT * FROM registration WHERE id = $user_id";
$result = mysqli_query($con, $sql);

// Display the user's information and donation history
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
  
    
    // Query the donation history table for the user's donations
    $sql = "SELECT * FROM donation_history WHERE registration_id = $user_id ORDER BY donation_date DESC";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Donation History:</h2>";
        echo "<table>";
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row['donation_date'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No donation history found.</p>";
    }
} else {
    echo "<p>User not found.</p>";
}
?>



    <input type="submit" value="update profile"  class="btn">
      <a href="home.php" class="delete-btn">go back</a>
    </from>
    </div>
    </body>
    </html>
