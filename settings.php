<?php
include('db_connect.php');

// Check if the reset button is clicked
if (isset($_POST['reset_system'])) {
    // Reset voted users
    $conn->query("DELETE FROM votes");
    header("Location: admin_dashboard.php");
    exit();
}

// Check if data is sent from the Forgot Password page
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['name'])) {
    $username = $_POST['username'];
    $name = $_POST['name'];
    // TODO: Insert data into a table or use it as needed
}
?>

<!-- Your HTML structure for the Settings page -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Settings</h5>

                    <!-- Add Reset System Button -->
                    <form method="post" onsubmit="return confirm('Are you sure you want to reset the entire system? This action cannot be undone.');">
                        <button type="submit" name="reset_system" class="btn btn-danger mb-2">Reset System</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
