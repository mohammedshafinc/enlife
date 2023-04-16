<?php
// Database connection
$conn=mysqli_connect("localhost","root","","enlife") or die("Connection error");

// Query to select all rows from registration table
$sql = "SELECT * FROM registration";

// Execute query
$result = mysqli_query($conn, $sql);

// Check if query was successful
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Get email address from current row
        $to_email = $row['email'];
        
        // Email details
        $subject = "Update the profile";
        $body = "Hello, this is a message to remind you to update your profile. Team:ENLIFE";
        $headers = "From: tajay5767@gmail.com";

        // Send email
        if (mail($to_email, $subject, $body, $headers)) {
            echo '<script>alert("Email sent successfully"); window.location.href="admin/dashboard.php";</script>';

        
        } else {
            echo '<script>alert("Email sending failed"); window.location.href="admin/dashboard.php";</script>';
            
        }
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);
?>
