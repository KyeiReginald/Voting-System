<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();

if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}

if($action == 'delete_user'){
	$delete = $crud->delete_user();
	if($delete)
		echo $delete;
}

if($action == 'save_category'){
	$save = $crud->save_category();
	if($save)
		echo $save;
}
if($action == 'delete_category'){
	$delete = $crud->delete_category();
	if($delete)
		echo $delete;
}
if ($_GET['action'] == 'update_default_voting') {
    $id = $_POST['id'];
    // Set all other votings as inactive
    $conn->query("UPDATE voting_list SET is_active = 0 WHERE id != $id");
    // Set the selected voting as active
    $conn->query("UPDATE voting_list SET is_active = 1 WHERE id = $id");
    echo 1;
    exit;
}


if($action == 'save_voting'){
	$save = $crud->save_voting();
	if($save)
		echo $save;
}
if($action == 'get_voting'){
	$get = $crud->get_voting();
	if($get)
		echo $get;
}
if($action == 'update_voting'){
	$update = $crud->update_voting();
	if($update)
		echo $update;
}
if($action == 'delete_voting'){
	$delete = $crud->delete_voting();
	if($delete)
		echo $delete;
}
if($action == 'save_opt'){
	$save = $crud->save_opt();
	if($save)
		echo $save;
}
if($action == 'delete_candidate'){
	$delete = $crud->delete_candidate();
	if($delete)
		echo $delete;
}
if($action == 'save_settings'){
	$save = $crud->save_settings();
	if($save)
		echo $save;
}
if($action == 'submit_vote'){
	$save = $crud->submit_vote();
	if($save)
		echo $save;
}
