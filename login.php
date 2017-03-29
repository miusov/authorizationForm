<?php 
require "db.php";

if (isset($_POST['auth'])) 
{
	$errors = [];
	$user = R::findOne('users', 'name = ?', [$_POST['login']]);
	if ($user) 
	{
		if(password_verify($_POST['pass'], $user->password))
		{
			$_SESSION['logged_user'] = $user;
			echo '<div style="color:green">Вы успешно авторизовались<br> <a href="/">На главную</a></div><hr>';
		}
		else
		{
			$errors[] = 'Не верно введен пароль!';
		}
	} 
	else 
	{
		$errors[] = 'Пользователь с таким логином не найден!';
	}

	if (!empty($errors)) 
	{
		echo '<div style="color:red">'.array_shift($errors).'</div><hr>';
	}
	
}

?>
<h2>Авторизация</h2>

<form action="login.php" method="post">
	<label for="login">Логин</label><br>
	<input type="text" name="login" id="login" value="<?php echo @$_POST['login'] ?>"><br><br>

	<label for="pass">Пароль</label><br>
	<input type="password" name="pass" id="pass" value="<?php echo @$_POST['pass'] ?>"><br><br>

	<button type="submit" name="auth">Авторизоваться</button>
</form>