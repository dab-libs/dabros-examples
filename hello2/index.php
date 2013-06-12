<?php
require 'classes/ClassLoader.php';
require '../dabros/dabros.php';

$config = require 'classes/config.php';
dabros::initialize($config);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<style>
			#waitPanel, #enterPanel, .register #loginPanel, #registerPanel, #loginError, #registerError, #helloPanel
			{ display: none; }
			.wait #waitPanel, .enter #enterPanel, .register #registerPanel, .error #loginError, .error #registerError, .hello #helloPanel
			{ display: block; }
		</style>

		<?php dabros::printJavaScriptTags(); ?>

		<script>

			function init()
			{
				$('body').attr('class', 'wait');
				$('#loginPanel form').submit(onLoginSubmit);
				$('#registerPanel form').submit(onRegisterSubmit);
				$('#gotoRegister, #gotoLogin').click(onToggleEnterType);
				$('#logout').click(onLogoutClick);
				dabros.getSessionFacade().getMyUser(onMyUser);
			}

			function onMyUser(response)
			{
				var myUser = response.result;
				if (myUser != null)
				{
					myUser.isGuest(function(response)
					{
						if (response.result)
						{
							$('body').attr('class', 'enter');
						}
						else
						{
							$('body').attr('class', 'wait');
							myUser.getLogin(function(response)
							{
								$('body').attr('class', 'hello');
								$('#helloPanel #name').html(response.result);
							});
							myUser.getCreatedDate(function(response)
							{
								$('body').attr('class', 'hello');
								$('#helloPanel #date').html(response.result.toLocaleDateString());
								$('#helloPanel #time').html(response.result.toLocaleTimeString());
							});
						}
					});
				}
				else
				{
					$('body').attr('class', 'enter');
					$('#enterPanel').addClass('error');
				}
			}

			function onLoginSubmit(eventData)
			{
				$('body').attr('class', 'wait');
				$('#enterPanel').removeClass('error');
				dabros.getSessionFacade().login($('#loginPanel #login').val(), $('#loginPanel #password').val(), onMyUser);
				eventData.preventDefault();
				return false;
			}

			function onRegisterSubmit(eventData)
			{
				$('body').attr('class', 'wait');
				$('#enterPanel').removeClass('error');
				dabros.getSessionFacade().register($('#registerPanel #login').val(), $('#registerPanel #password').val(), onMyUser);
				eventData.preventDefault();
				return false;
			}

			function onToggleEnterType(eventData)
			{
				$('#enterPanel').toggleClass('register');
				$('#enterPanel').removeClass('error');
				eventData.preventDefault();
				return false;
			}

			function onLogoutClick(eventData)
			{
				$('#login').val('');
				$('#password').val('');
				$('#enterPanel').removeClass('register');
				$('body').attr('class', 'wait');
				dabros.getSessionFacade().logout(onMyUser);
				eventData.preventDefault();
				return false;
			}

			$(init);
		</script>
	</head>

	<body class="wait">
		<section id="waitPanel">Подождите...</section>
		<section id="enterPanel">
			<section id="loginPanel">
				<h1>Ввход</h1>
				<form>
					<dl>
						<dt><label for="login">Логин</label></dt>
						<dd><input id="login" type="text" /></dd>
						<dt><label for="password">Пароль</label></dt>
						<dd><input id="password" type="password" /></dd>
					</dl>
					<input type="submit" value="Войти" />
				</form>
				<div id="loginError">Такое сочетание логина и пароля <b>не найдено</b>.</div>
				<div>Я еще не зарегистрирован. <a href="#" id="gotoLogin">Зарегистрироваться</a></div>
			</section>
			<section id="registerPanel">
				<h1>Регстрация</h1>
				<form>
					<dl>
						<dt><label for="login">Логин</label></dt>
						<dd><input id="login" type="text" /></dd>
						<dt><label for="password">Пароль</label></dt>
						<dd><input id="password" type="password" /></dd>
					</dl>
					<input type="submit" value="Зарегистрироваться" />
				</form>
				<div id="registerError">Такой логин <b>занят</b>.</div>
				<div>Я уже зарегистрирован. <a href="#" id="gotoLogin">Войти</a></div>
			</section>
		</section>
		<section id="helloPanel">
			<h1>Здравствуйте, <span id="name"></span>!</h1>
			<div>Вы зарегистрировались у нас <span id="date"></span> в <span id="time"></span>.</div>
			<div><a href="#" id="logout">Выйти</a></div>
		</section>
	</body>
</html>