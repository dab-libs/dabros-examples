<?php
require 'classes/ClassLoader.php';

$auth = new Auth();
if ($auth->restoreSession())
{
	header("Location: /chat.php");
	exit;
}

$loginFormData = new LoginFormData();
if ($loginFormData->validate($_POST['LoginForm']))
{
	if ($auth->authenticateUser($loginFormData->login, $loginFormData->password))
	{
		header("Location: /chat.php");
		exit;
	}
	else
	{
		$loginFormData->addError('password', 'Ннеправильный логин или пароль');
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="css/common.css" />
	</head>

	<body>
		<div id="loginPanel">
			<h1>Вход в чат</h1>
			<?php if ($loginFormData->hasErrors()): ?>
				<ul class="errorSummary">
					<?php foreach ($loginFormData->getErrorFields() as $field): ?>
					<li><?php echo $loginFormData->getError($field); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<form name="LoginForm">
				<label for="LoginForm_login">Логин</label>
				<input id="LoginForm_login" name="LoginForm[login]" type="text" value="<?php echo $loginFormData->login ?>" />
				<label for="LoginForm_password">Пароль</label>
				<input id="LoginForm_password" name="LoginForm[password]" type="password" />
				<input type="submit" value="OK" />
			</form>
		</div>
	</body>
</html>
