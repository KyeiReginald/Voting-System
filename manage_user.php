<?php 
include('db_connect.php');
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM users where id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	
	<form action="" id="manage-user"novalidate>
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required>
		</div>
		<div class="form-group">
        <label for="password">Password</label>
        <div class="input-group">
        <input type="password" name="password" id="password" class="form-control" value="<?php echo isset($meta['password']) ? $meta['password']: '' ?>" required>
            <div class="input-group-append">
            <span class="input-group-text">
                <i class="fa fa-eye" id="toggle-password"></i>
            </span>
            </div>
            </div>
        </div>

		<div class="form-group">
			<label for="type">User Type</label>
			<select name="type" id="type" class="custom-select">
				<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected': '' ?>>User</option>
				<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected': '' ?>>Admin</option>
			</select>
		</div>
	</form>
</div>
<script>
	$('#manage-user').submit(function(e){
    e.preventDefault();

// Updated alert_toast function
// Updated alert_toast function
function alert_toast($msg, $type) {
    var bg_color = $type === 'error' ? 'red' : 'green';
    var placement_from = 'top';
    var placement_align = 'right';
    var animate_enter = 'animated fadeInDown';

    // Update the background color to red for error messages
    var template = '<div class="alert alert-' + $type + ' alert-dismissible ' + animate_enter + '" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; background-color: ' + bg_color + ';">' +
        '<span>' + $msg + '</span>' +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '<span aria-hidden="true">&times;</span>' +
        '</button>' +
        '</div>';

    $('body').append(template);

    // Auto close the alert after 2 seconds
    setTimeout(function () {
        $('.alert').addClass('animated fadeOutUp');
        setTimeout(function () {
            $('.alert').remove();
        }, 2000);
    }, 2000);
}


    // Check if the form is valid
    if (this.checkValidity()) {
        var username = $('#username').val();
        var password = $('#password').val();

        // Additional validation for the username (minimum length of 3 characters)
        if (username.length < 4) {
            alert_toast("Username must be at least 4 characters long", 'error');
            return;
        }

        // Additional validation for the password (minimum length of 6 characters)
        if (password.length < 6) {
            alert_toast("Password must be at least 6 characters long", 'error');
            return;
        }


        // Proceed with the AJAX request
        start_load();
        $.ajax({
            url: 'ajax.php?action=save_user',
            method: 'POST',
            data: $(this).serialize(),
            success: function (resp) {
                if (resp == 1) {
                    alert_toast("Data successfully saved", 'success')
                    setTimeout(function () {
                        location.reload()
                    }, 1500)
                }
            }
        });
    } else {
        // If the form is not valid, trigger HTML5 form validation
        this.reportValidity();
    }
});

$(document).ready(function() {
    // Attach event handler for form submission
    $('#manage-user').submit(function(e) {
        // ... (your existing form submission code)
    });

    // Attach event handler for password visibility toggle using event delegation
    $(document).on('click', '#toggle-password', function() {
        var passwordField = $('#password');
        var passwordFieldType = passwordField.attr('type');

        if (passwordFieldType === 'password') {
            passwordField.attr('type', 'text');
        } else {
            passwordField.attr('type', 'password');
        }
    });

    // Check if the password field is pre-filled (for edit operation)
    checkPasswordField();
});

function checkPasswordField() {
    var passwordField = $('#password');
    var passwordValue = passwordField.val();

    if (passwordValue.length > 0 && passwordValue.replace(/[*]/g, '').length === 0) {
        passwordField.attr('type', 'password');
    }
}

</script>