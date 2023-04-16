<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Blood Donation Camp Registration Form</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f2f2f2;
			margin: 0;
            background-image: url(newimages/www.jpg);
            background-repeat: no-repeat;
            background-size:110% 140%;
		}

		h1 {
			text-align: center;
			color: #8b0000;
			margin-top: 20px;
		}

		form {
			background-color: #fff;
			max-width: 600px;
			margin: 20px auto;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
		}

		label {
			display: block;
			margin-bottom: 10px;
			color: #666;
		}

		input[type="text"],
		input[type="email"],
		input[type="tel"],
        input[type="date"],
		select {
			width: 100%;
			padding: 10px;
			border-radius: 5px;
			border: 1px solid #ccc;
			box-sizing: border-box;
			margin-bottom: 20px;
			font-size: 16px;
		}

		input[type="submit"] {
			background-color: #710000;
			color: #fff;
			border: none;
			padding: 12px 20px;
			border-radius: 5px;
			font-size: 18px;
			cursor: pointer;
            position: relative;
            margin-bottom :30px;
            margin-top:20px;
		}

		input[type="submit"]:hover {
			background-color: #3e8e41;
		}
	</style>
</head>
<body>
	<h1>Blood Donation Camp Registration Form</h1>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label for="name"> Organisation Name:</label>
		<input type="text" id="name" name="name" placeholder="Enter your Organisation" required>

		<label for="email">Email:</label>
		<input type="email" id="email" name="email" placeholder="Enter your email"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required />
        

		<label for="phone">Phone:</label>
		<input type="tel" id="phone" name="phone" placeholder=" phone number" pattern="[0-9]{10}" required />

		<label for="location">Location:</label>
		<input type="text" id="location" name="location" placeholder="Enter camp location" required>

		<label for="date">Date:</label>
		<input type="date" id="date" name="date" required><br>

		<input type="submit" name="submit" value="Register">
	</form>

	<?php
    session_start();
// Database connection settings
$conn=mysqli_connect("localhost","root","","enlife") or die("Connection error");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    
    $location = $_POST["location"];
    $date = $_POST["date"];

    // Insert data into database
    $sql = "INSERT INTO blood_donors (name, email, phone,  location, date) VALUES ('$name', '$email', '$phone',  '$location', '$date')";
    $_SESSION['name'] = "Blood Donation Camp";
    $_SESSION['date'] = $date;
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Thank you for registering.');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close database connection
mysqli_close($conn);
?>

</body>
</html>
