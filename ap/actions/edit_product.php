<!doctype html>
<html lang="en">
<head>
	<title>Edit User Info</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
	<div id="container">
		<?php include('header.php');?>
		<?php include('nav_edit.php');?>
		<?php include('info-col.php');?>
		<div id='content'>
			<h2 id='userlist'>Edit User Record</h2>
			<?php
				// checking for valid id number
				if((isset($_GET['id'])) && (is_numeric($_GET['id']))){
					$id = $_GET['id'];
				}elseif((isset($_POST['id'])) && (is_numeric($_POST['id']))){
					$id = $_POST['id'];
				}else{ // no id was found. end script
					echo '<p class="error">This page has been accessed by mistake.</p>';
					include('footer.php');
					exit();
				}
				require('mysqli_connect.php');
				if($_SERVER['REQUEST_METHOD'] == 'POST'){
					$errors = array();
					// check kung may laman yung fname ($fn), lname ($ln), and email ($e) textbox
					if(empty($_POST['fname'])){
						$errors[] = 'Please input your first name.';
					}else{
						$fn = trim($_POST['fname']);
					}
					//check if last name is empty
					if(empty($_POST['lname'])){
						$errors[] = 'Please input your last name.';
					}else{
						$ln = trim($_POST['lname']);
					}
					//check if email is empty
					if(empty($_POST['email'])){
						$errors[] = 'Please input your email.';
					}else{
						$e = trim($_POST['email']);
					}
					if(empty($errors)){
						$q = "UPDATE users SET fname = '$fn', lname = '$ln', email = '$e' WHERE user_id = '$id' LIMIT 1";
						$result = @mysqli_query($dbcon, $q);
						if(mysqli_affected_rows($dbcon) == 1){
							echo '
							<h2 id="iscompletetext">The user record has been updated successfully.</h2>
							<p id="success2">You may now click <a id="here" href="register-view-users.php">HERE</a> to go back to the user list.</p>';
						}else{
							echo '<h3>The user record has not been updated.</h3>';
							echo '<p>'.mysqli_error($dbcon).'</p>';
						}
					}else{
						//display ang laman ng $errors
						echo '
						<div id="Error2">
						<h2 id="errortext2">Error!</h2><p class="error">The following errors occurred:<br/>';
						foreach($errors as $msg){
							echo " - $msg<br/>\n";
						}
						echo '</p><h3>Please Try Again.</h3><br/><br/></div>';
					}
				}
				$q = "SELECT fname, lname, email FROM users WHERE user_id = $id";
				$result = @mysqli_query($dbcon, $q);
				if(mysqli_num_rows($result) == 1){ //valid user id
					$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
					//create form
				
					echo '<div class = "editRecord">
						<form action="edit_user.php" method="post">
				<p><label class="label" for="fname">First Name: </label>
				<input class = "input" type="text" id="fname" name="fname" size="30" maxlength="40"
				value="'.$row["fname"].'">
				</p>

				<p><label class="label" for="lname">Last Name: </label>
				<input class = "input" type="text" id="lname" name="lname" size="30" maxlength="40"
				value="'.$row["lname"].'">
				</p>

				<p><label class="label" for="email">Email Address: </label>
				<input class = "input" type="text" id="email" name="email" size="30" maxlength="50"
				value="'.$row["email"].'">
				</p>

				<p><input class = "button2" type="submit" id="submit" name="submit" value="Edit">
				</p>
				<p><input type="hidden" name="id" value="'.$id.'">
				</p>
						</form></div>
					';
				}else{ //di valid yung id, tell the user to register instead
					echo '<img id = "notfoundimg" src="notfound.png" width="200" height="200">
					<h2 id = "Registerhere">User does not exist.</h2>
					<p id = "registerHere">Do not have an account? Click <a id = "btnRegister" href="register.php">HERE</a>to register.</p>';
				}
				mysqli_close($dbcon);
			?>
		</div>
	</div>
	<?php include('footer.php');?>
</body>

</html>