<?php 

if (logged_in() === true) {
	echo '<p class="panel">Привет ' . $_SESSION['first_name'] . '</p>';
	echo '<p><a href="/user/logout">logout</a></p>';
} else { ?>


<form action="/user/login" method="post">
	<ul id="login">
		<li>Username:<br>
			<input type="text" name="username"></input>
		</li>
		<li>Password: <br>
			<input type="password" name="password"></input>
		</li>
		<li>
			<input type="submit" value="Log in">
		</li>
		<li>
			<a href="/user/register">Register</a>
		</li>
	</ul>
</form>


<?php }





