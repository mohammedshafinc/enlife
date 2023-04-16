
<?php
$connect=mysqli_connect("localhost","root","","enlife") or die ("connection failed");
session_start();
if(!empty($_POST['un']) && !empty($_POST['pwd']))
{
 
  $username=$_POST['un'];
  $password=md5($_POST['pwd']);
  $query="select * from registration where email='$username' and pwd='$password'";
  $result=mysqli_query($connect,$query);
  $count=mysqli_num_rows($result);
  if($count>0)
  { 
    echo"login suucsfull";
    $row = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $row['id'];
    
    header("location:home.php");
  }
  else
  {
    echo " <script>window.alert('Invalid username or password');window.location.href = 'login.php'</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN</title>
  <link rel="stylesheet" href="login.css">
  <link rel="icon" type="image/x-icon" href="newimages/blooddrop.jpg">
  <script src="https://kit.fontawesome.com/a972348b0e.js" crossorigin="anonymous"></script>
</head>
<body>
  <div class="container">
    <div class="form-box">
      <h1 id="title">SIGN IN</h1>
      <form action="login.php" method="post">
        <div class="input-group">
          <div class="input-field">
            <i class="fa-solid fa-envelope"></i>
            <input type="email" name="un" placeholder="email"pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
          </div>
          <div class="input-field">
            <i class="fa-solid fa-lock"></i>
            <input type="password" name="pwd" placeholder="password">
          </div>
          <p><a href="#">Forgot your Password?</a></p>
        </div>
        <div class="btn-field">
          <button type="submit" id="signinBtn" name="submit" class="disable" >Sign In</button>
        </div>
        <div class="check-box">
          <input type="checkbox" id="rememberMeCheckbox">
          <label for="rememberMeCheckbox">Remember me</label>
        </div>
        <p>Don't have account?</p>
        <div class="btn-1">
        <!-- <button href="register.php" type="button" id="btn-1" class="disable">REGISTER</button> -->
          <a href="canidonate.php" type="button" id="btn-1" class="disable clickable">REGISTER</a>
          <a href="index.php" type="button" class="back" >&#8592 Go back</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
