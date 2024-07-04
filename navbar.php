
<style>
	
</style>
<?php if($_SESSION['login_type'] == 1): ?>

<nav id="sidebar" class='mx-lt-5 bg-dark' >
		
		<div class="sidebar-list">

				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
				<a href="index.php?page=categories" class="nav-item nav-categories"><span class='icon-field'><i class="fa fa-list"></i></span> Category List</a>
				<a href="index.php?page=voting_list" class="nav-item nav-voting_list nav-manage_voting"><span class='icon-field'><i class="fa fa-poll-h"></i></span> Voting List</a>
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
				<a href="index.php?page=voted_users" class="nav-item nav-voted_users"><span class='icon-field'><i class="fa fa-address-card"></i></span> Voted Users</a>
				
				<a href="index.php?page=settings" class="nav-item nav-settings"><span class='icon-field'><i class="fa fa-cog"></i></span> Settings</a>
				

			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')

</script>