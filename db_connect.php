<?php
// Establish the database connection
$conn = new mysqli('localhost', 'root', 'root', 'vote_db') or die("Could not connect to mysql" . mysqli_error($con));

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Convert existing plain text passwords to hashed passwords (only run once)
$users = $conn->query("SELECT id, password FROM users");
while ($user = $users->fetch_assoc()) {
    if (!password_get_info($user['password'])['algo']) {
        $hashed_password = password_hash($user['password'], PASSWORD_DEFAULT);
        $conn->query("UPDATE users SET password = '$hashed_password' WHERE id = " . $user['id']);
    }
}

// You can remove or comment out the above section after running it once
?>
