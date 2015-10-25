<?php 
//print_r($_POST);
logged_in_redirect();
//print_arr($_GET);
if (isset($_GET['success'])) {
	echo '<p class="panel">You\'ve been registered successfully!</p>';
} else {

		if (empty($_POST) === false) {
			$required_fields = array('username', 'password', 'password_again', 'first_name', 'email');
			//print_arr($required_fields);
			foreach ($_POST as $key => $value) {
				if (empty($value) && in_array($key, $required_fields)) {
					$errors[] = 'Fields marked * are required';
					break 1;
				}
			}

			if (empty($errors) === true) {
				if (user_exist($_POST['username'])) {
					$errors[] = 'Sorry, the username: ' . $_POST['username']. ' is already taken';
				}
			}
			if (preg_match("|\\s|", $_POST['username'])) {
				$errors[] = 'Sorry, your username must not contain any spaces.';
			}
			if (strlen($_POST['password']) < 6) {
				$errors[] = 'Your password must be at least 6 characters';
			}
			if ($_POST['password'] !== $_POST['password_again']) {
				$errors[] = 'Your passwords do not match';
			}
			if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				$errors[] = 'A valid email addres is required';
			}
			if (email_exist($_POST['email'])) {
				$errors[] = 'Sorry, the email: ' . $_POST['email'] . ' is already in use';
			}

		}


#print_arr($errors);
?>






<h1 class="panel">Регистрация</h1>


<?php

if (!empty($_POST) && empty($errors)) {
	$register_data = array(
		'username' => $_POST['username'],
		'password' => $_POST['password'],
		'first_name' => $_POST['first_name'],
		'last_name' => $_POST['last_name'],
		'email' => $_POST['email']
		);
	register_user($register_data);
	header("Location: /user/register?success");
	exit();
} else {
	if (!empty($errors)) {
		echo output_errors($errors);	
	}
	
}
?>


<form action="" method="post">
	<ul>
			<li>Username*:<br>
				<input type="text" name="username">
			</li>
			<li>Password*:<br>
				<input type="password" name="password">
			</li>
			<li>Password again*:<br>
				<input type="password" name="password_again">
			</li>
			<li>First name*:<br>
				<input type="text" name="first_name">
			</li>
			<li>Last name*:<br>
				<input type="text" name="last_name">
			</li>
			<li>Email*:<br>
				<input type="email" name="email">
			</li>
			<li>
				<input type="submit" value="register">
			</li>
		</ul>	
</form>

<?php } 