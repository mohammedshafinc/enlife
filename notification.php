<?php
session_start();

$_SESSION['notification_count'] = 0;

$conn=mysqli_connect("localhost","root","","enlife") or die("Connection error");

// Fetch all the camps from the database
$query = "SELECT name, date, location,phone FROM blood_donors";
$result = mysqli_query($conn, $query);



?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Blood Donation Camp Notification</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f2f2f2;
			margin: 0;
            background-image: url(newimages/www.jpg);
            background-repeat: no-repeat;
            background-size:110% 100%;
		}

		h1 {
			text-align: center;
			color: #8b0000;
			margin-top: 20px;
		}

		.notification {
			background-color: #fff;
			max-width: 600px;
			margin: 20px auto;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
			text-align: center;
		}

		.notification h2 {
			color: #8b0000;
		}
	</style>
</head>
<body>
	<h1>Blood Donation Camp Notification</h1>
	<?php
	// Check if there are any camps in the database
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			// Check if the camp date is in the future
			if (strtotime($row['date']) > time()) {
				// Display each camp's name and date
				echo '<div class="notification">';
				echo '<h2>' . $row['name'] . '</h2>';
				echo '<p>Camp Date: ' . $row['date'] . '</p>';
				echo '<p>Camp Location: ' . $row['location'] . '</p>';
                echo '<p>Camp phone: ' . $row['phone'] . '</p>';
				echo '</div>';
			}
		}
	} else {
		// If there are no camps in the database, display a message
		echo '<div class="notification">';
		echo '<h2>No camps found</h2>';
		echo '</div>';
	}
   
	?>
</body>
</html>
