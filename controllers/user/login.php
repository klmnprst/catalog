<?php
logged_in_redirect();
if (empty($_POST) === false) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	if (empty($username) || empty($password)) {
		$errors[] = 'Вы должны ввести логин и пароль';

		

	} else if (user_exist($username) === false) {
		$errors[] = 'Такой пользователь не найден. Вы регистрировались?';
	} else if(user_active($username) === false) {
		$errors[] = 'Ваш акаунт не активирован';
	} else {
		$login = login($username,$password);
		if ($login === false) {
			$errors[] = 'Данная комбинация логин/пароль не верна';
		} else {
			$user_info = explode(",", $login);
			print_arr($user_info);
			$user_id = $user_info[0]; 
			$first_name = $user_info[1]; 
			$_SESSION['user_id'] = $user_id;
			$_SESSION['first_name'] = $first_name;
			$_SESSION['username'] = $username;
			//print_arr($_SESSION);
			header("Location: /");
			exit();
		}
	}

	
	
} else {
	$errors[] = 'Данные не отправлены';
}

$title = 'LOGIN';
echo '<h1 class="panel">LOGIN</h1>';
echo output_errors($errors);
