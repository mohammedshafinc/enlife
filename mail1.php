<?php
// Database connection
$conn=mysqli_connect("localhost","root","","enlife") or die("Connection error");

// Query to select email addresses and last updated time
$sql = "SELECT email, lastdate, updated_time, reminder_sent FROM registration";

// Execute query
$result = mysqli_query($conn, $sql);

// Check if query was successful
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Get email address, last updated time, and reminder sent time from current row
        $to_email = $row['email'];
        $last_updated = strtotime($row['updated_time']);
        $reminder_sent = strtotime($row['reminder_sent']);
        
        // Calculate difference between current date and last updated time
        $diff = time() - $last_updated;
        $days_diff = round($diff / (60 * 60 * 24));
        
        // Send email if last updated more than 30 days ago and no reminder has been sent in the last 7 days
        if ($days_diff >= 30 && (empty($reminder_sent) || (time() - $reminder_sent) >= (7 * 24 * 60 * 60))) {
            // Email details
            $subject = "Update the profile";
            $body = "Hello, this is a message to remind you to update the profile   Team:ENLIFE";
            $headers = "From: tajay5767@gmail.com";

            // Send email
            if (mail($to_email, $subject, $body, $headers)) {
                echo '<script>alert("Email sent successfully"); window.location.href="admin/dashboard.php";</script>';
                // Update reminder_sent column with current date and time
                $update_sql = "UPDATE registration SET reminder_sent = NOW() WHERE email = '$to_email'";
                mysqli_query($conn, $update_sql);
            } else {
                echo '<script>alert("Email sending failed"); window.location.href="admin/dashboard.php";</script>';
            }
        } else {
            // Delete user's account from the database
            $delete_sql = "DELETE FROM registration WHERE email = '$to_email'";
            mysqli_query($conn, $delete_sql);
        }
    }
} else {
    echo '<script>alert("Email sending failed"); window.location.href="admin/dashboard.php";</script>' . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);
?>
