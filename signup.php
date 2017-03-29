<?php 
require "db.php";

if (isset($_POST['reg'])) 
{
	$errors = [];
	if (trim($_POST['login']) == '') 
	{
		$errors[] = 'Введите логин!';
	}
	if (trim($_POST['email']) == '') 
	{
		$errors[] = 'Введите Email!';
	}
	if ($_POST['pass'] == '') 
	{
		$errors[] = 'Введите пароль!';
	}
	if ($_POST['pass2'] != $_POST['pass']) 
	{
		$errors[] = 'Повторный пароль введен не верно!';
	}
	if (R::count('users', "name = ?", [$_POST['login']]) > 0) 
	{
		$errors[] = 'Пользователь с таким логином уже существует!';
	}
	if (R::count('users', "email = ?", [$_POST['email']]) > 0) 
	{
		$errors[] = 'Пользователь с таким Email уже существует!';
	}
	if (empty($errors)) 
	{
		$user = R::dispense('users');
		$user->name = $_POST['login'];
		$user->email = $_POST['email'];
		$user->password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
		R::store($user);
		echo '<div style="color:green">Вы успешно зарегистрировались</div><hr>';
	}
	else
	{
		echo '<div style="color:red">'.array_shift($errors).'</div><hr>';
	}
	
} 


?>
<h2>Регистрация</h2>

<form action="/signup.php" method="post">
	<label for="login">Логин</label><br>
	<input type="text" name="login" id="login" value="<?php echo @$_POST['login'] ?>"><br><br>

	<label for="email">Email</label><br>
	<input type="email" name="email" id="email" value="<?php echo @$_POST['email'] ?>"><br><br>

	<label for="pass">Пароль</label><br>
	<input type="password" name="pass" id="pass" value="<?php echo @$_POST['pass'] ?>"><br><br>

	<label for="pass2">Повторите пароль</label><br>
	<input type="password" name="pass2" id="pass2" value="<?php echo @$_POST['pass2'] ?>"><br><br>

	<button type="submit" name="reg">Зарегистрироваться</button>
</form>