<?php 
if (empty($_POST) === false) {
	$required_fields = array('username', 'password', 'password_again', 'first_name', 'email');
	//print_arr($required_fields);
	foreach ($_POST as $key => $value) {
		if (empty($value) && in_array($key, $required_fields) === true) {
			$errors[] = 'Fields marked * are required';
			break 1;
		}
	}

	if (empty($errors) === true) {
		if (user_exist($_POST['username']) === true) {
			$errors[] = Sorry, the username''
		}

	}

}


print_arr($errors);
?>

333




<h1 class="panel">Регистрация</h1>

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