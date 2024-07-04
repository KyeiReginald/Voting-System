<?php 
include 'db_connect.php';

// Check for export action
if (isset($_GET['action']) && $_GET['action'] == 'export') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=users.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('ID', 'Name', 'Username', 'Password', 'Type')); // Assuming these are the columns you want to export

    $query = "SELECT id, name, username, password, type FROM users"; // Adjust according to your actual table structure
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }

    fclose($output);
    mysqli_close($conn);
    exit();
}

// Process import if the import button is clicked
if (isset($_POST['import'])) {
    $fileName = $_FILES['import_file']['tmp_name'];

    if ($_FILES['import_file']['size'] > 0) {
        $file = fopen($fileName, "r");

        // Skip the first line if it contains column headers
        fgetcsv($file);

        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            $name = mysqli_real_escape_string($conn, $column[1]);
            $username = mysqli_real_escape_string($conn, $column[2]);
            $password = mysqli_real_escape_string($conn, $column[3]);
            $type = mysqli_real_escape_string($conn, $column[4]);

            // Simple insertion query, consider handling updates or duplicate entries as needed
            $query = "INSERT INTO users (name, username, password, type) VALUES ('$name', '$username', '$password', '$type')";

            $result = mysqli_query($conn, $query);

            if (!$result) {
                // Handle error - maybe log to a file or show an error message
            }
        }

        fclose($file);
        // Optionally, add a success message or redirect
    }
}

?>

<div class="container-fluid">
		 
	<div class="row">
	    <div class="col-lg-12">
		
			<a href="users.php?action=export"><button class="btn btn-primary float-left btn-sm">Export Users </button></a>
			<h1 class="float-left btn-sm">&nbsp; </h1>

			<form action="users.php" method="post" enctype="multipart/form-data">
				<input type="file" name="import_file" />
				<input class="btn btn-primary btn-sm" type="submit" name="import" value="Import Users" />
			</form>
			
			<button class="btn btn-primary float-right btn-sm" id="new_user"><i class="fa fa-plus"></i> New user</button>
			<div class="float-right">
            <input type="text" id="search_user" class="form-control form-control-sm" placeholder="Search User">
			
         </div>
	</div>
	</div>
	<br>
	
	<div class="row">
		<div class="card col-lg-12">
			<div class="card-body">
				<table class="table-striped table-bordered col-md-12">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Name</th>
					<th class="text-center">Username</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
 					include 'db_connect.php';
 					$users = $conn->query("SELECT * FROM users order by name asc");
 					$i = 1;
 					while($row= $users->fetch_assoc()):
				 ?>
				 <tr>
				 	<td>
				 		<?php echo $i++ ?>
				 	</td>
				 	<td>
				 		<?php echo $row['name'] ?>
				 	</td>
				 	<td>
				 		<?php echo $row['username'] ?>
				 	</td>
				 	<td>
				 		<center>
								<div class="btn-group">
								  <button type="button" class="btn btn-primary">Action</button>
								  <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    <span class="sr-only">Toggle Dropdown</span>
								  </button>
								  <div class="dropdown-menu">
								    <a class="dropdown-item edit_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Edit</a>
								    <div class="dropdown-divider"></div>
								    <a class="dropdown-item delete_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Delete</a>
								  </div>
								</div>
								</center>
				 	</td>
				 </tr>
				<?php endwhile; ?>
			</tbody>
		</table>
			</div>
		</div>
	</div>

</div>



<script>
	
$('#new_user').click(function(){
	uni_modal('New User','manage_user.php')
})
$('.edit_user').click(function(){
	uni_modal('Edit User','manage_user.php?id='+$(this).attr('data-id'))
})

$('.delete_user').click(function(){
		_conf("Are you sure to delete this user?","delete_user",[$(this).attr('data-id')])
	})
	function delete_user($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_user',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}


   // Search functionality
   $('#search_user').on('input', function () {
      var search_val = $(this).val().toLowerCase();
      $('.card-body tbody tr').filter(function () {
         $(this).toggle($(this).text().toLowerCase().indexOf(search_val) > -1)
      });
   });
</script>
