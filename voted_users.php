<?php
include('db_connect.php');

// Check if the clear button is clicked
if (isset($_POST['clear_voted_users'])) {
    $conn->query("DELETE FROM votes");
    // You may also want to perform additional cleanup or logging
}

// Search functionality
$search_query = "";
if (isset($_POST['search'])) {
    $search_query = $_POST['search_query'];
}

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Voted Users</h5>

                    <!-- Add Clear Voted Users Button -->
                    <form method="post" onsubmit="return confirm('Are you sure you want to clear all voted users?');">
                        <button type="submit" name="clear_voted_users" class="btn btn-danger mb-2">Clear Voted Users</button>
                    </form>

                    <!-- Add Search Form -->
                    <form method="post">
                        <div class="form-group">
                            <label for="search_query">Search:</label>
                            <input type="text" name="search_query" class="form-control" value="<?php echo $search_query; ?>">
                        </div>
                        <button type="submit" name="search" class="btn btn-primary">Search</button>
                    </form>

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">User ID</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Name</th>
                                <!-- Add more columns as needed -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Modify the SQL query to use a JOIN for flexibility
                            $sql = "SELECT DISTINCT votes.user_id, users.username, users.name FROM votes JOIN users ON votes.user_id = users.id";

                            // Add search condition
                            if (!empty($search_query)) {
                                $sql .= " WHERE votes.user_id LIKE '%$search_query%' OR users.username LIKE '%$search_query%' OR users.name LIKE '%$search_query%'";
                            }

                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $i = 1;
                                while ($row = $result->fetch_assoc()):
                            ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i++ ?></td>
                                        <td class="text-center"><?php echo $row['user_id'] ?></td>
                                        <td class="text-center"><?php echo $row['username'] ?></td>
                                        <td class="text-center"><?php echo $row['name'] ?></td>
                                        <!-- Add more columns as needed -->
                                    </tr>
                            <?php
                                endwhile;
                            } else {
                                echo '<tr><td colspan="4" class="text-center">No results found.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
