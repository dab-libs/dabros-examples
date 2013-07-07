<?php
// Подключаем библиотеку
require 'dabros/dabros.php';
// Считываем настройки
$config = require 'classes/config.php';
// Инициалируем библиотеку
dabros::initialize($config);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<style>
			#waitPanel, #enterPanel, .register #loginPanel, #registerPanel,
			#loginError, #registerError, #helloPanel
			{ display: none; }
			.wait #waitPanel, .enter #enterPanel, .register #registerPanel,
			.error #loginError, .error #registerError, .hello #helloPanel
			{ display: block; }
		</style>

		<?php
// Вставляем теги script для подключения клиентской части библиотеки dabros
		dabros::printJavaScriptTags();
		?>

		<script>
			var myUser = null;

			/**
			 * Инициализирует клиент
			 */
			function init()
			{
				// Инициализируем интерфейс
				$('body').attr('class', 'wait');
				$('#loginPanel form').submit(onLoginSubmit);
				$('#registerPanel form').submit(onRegisterSubmit);
				$('#gotoRegister, #gotoLogin').click(onToggleEnterType);
				$('#logout').click(onLogoutClick);

				// Запрашиваем пользователя приложения текущей сессии
				dabros.getSessionFacade().getMyUser(onMyUser);
			}

			/**
			 * Обрабатывает запрос пользователя приложения текущей сессии
			 */
			function onMyUser(response)
			{
				// Сохраняем полученного пользователя приложения текущей сессии
				myUser = response.result;

				// Запрашиваем является ли пользователь "гостем"
				myUser.isGuest(function(response) // Обработчик ответа - анонимная функция
				{
					if (response.result) // Если результат ответа - true, то это гость
					{
						// Переводим интерфейс в состояние "вход пользователя"
						$('body').attr('class', 'enter');
					}
					else
					{
						// Переводим интерфейс в состояние "ожидание"
						$('body').attr('class', 'wait');

						// Запрашиваем имя пользователя
						myUser.getLogin(function(response)
						{
							// Переводим интерфейс в состояние "приветствие"
							$('body').attr('class', 'hello');
							// Отображаем имя пользователя
							$('#helloPanel #name').html(response.result);
						});

						// Запрашиваем дату регистрации пользователя
						myUser.getCreatedDate(function(response)
						{
							// Переводим интерфейс в состояние "приветствие"
							$('body').attr('class', 'hello');
							// Отображаем дату регистрации пользователя
							$('#helloPanel #date').html(response.result.toLocaleDateString());
							$('#helloPanel #time').html(response.result.toLocaleTimeString());
						});
					}
				});
			}

			/**
			 * Обработчик заполнения формы входа пользователя
			 */
			function onLoginSubmit(eventData)
			{
				// Переводим интерфейс в состояние "ожидание"
				$('body').attr('class', 'wait');
				$('#enterPanel').removeClass('error');

				// Передаем на сервер имя пользователя и пароль для входа
				var login = $('#loginPanel #login').val();
				var password = $('#loginPanel #password').val();
				dabros.getSessionFacade().login(login, password, function (response)
				{
					if (!response.result) // Если вход не удался
					{
						// Переводим интерфейс в состояние "ошибка входа"
						$('body').attr('class', 'enter');
						$('#enterPanel').addClass('error');
					}
				});

				// Запрашиваем пользователя приложения текущей сессии
				dabros.getSessionFacade().getMyUser(onMyUser);

				// Запрещаем отправку формы на сервер по умолчанию
				eventData.preventDefault();
				return false;
			}

			/**
			 * Обработчик заполнения формы регистрации пользователя
			 */
			function onRegisterSubmit(eventData)
			{
				// Переводим интерфейс в состояние "ожидание"
				$('body').attr('class', 'wait');
				$('#enterPanel').removeClass('error');

				// Передаем на сервер имя пользователя и пароль для регистрации
				var login = $('#registerPanel #login').val();
				var password = $('#registerPanel #password').val();
				dabros.getSessionFacade().register(login, password, function (response)
				{
					if (!response.result) // Если регистрация не удалась
					{
						// Переводим интерфейс в состояние "ошибка регистрации"
						$('body').attr('class', 'enter');
						$('#enterPanel').addClass('error');
					}
				});

				// Запрашиваем пользователя приложения текущей сессии
				dabros.getSessionFacade().getMyUser(onMyUser);

				// Запрещаем отправку формы на сервер по умолчанию
				eventData.preventDefault();
				return false;
			}

			/**
			 * Обработчик щелчка на переключатель между формами входа пользователя и регистрации
			 */
			function onToggleEnterType(eventData)
			{
				$('#enterPanel').toggleClass('register').removeClass('error');
				eventData.preventDefault();
				return false;
			}

			/**
			 * Обработчик щелчка на кнопку выхода
			 */
			function onLogoutClick(eventData)
			{
				// Переводим интерфейс в состояние "вход пользователя"
				$('#login, #password').val('');
				$('#enterPanel').removeClass('register');

				// Переводим интерфейс в состояние "ожидание"
				$('body').attr('class', 'wait');

				// Выполняем на сервере выход пользователя
				myUser.logout();

				// Запрашиваем пользователя приложения текущей сессии
				dabros.getSessionFacade().getMyUser(onMyUser);

				// Запрещаем обработка щелчка мышью по умолчанию
				eventData.preventDefault();
				return false;
			}

			// Выполняем инициализацию сразу после загрузки страницы
			$(init);
		</script>
	</head>

	<body class="wait">
		<!-- Панель ожидания -->
		<section id="waitPanel">Подождите...</section>

		<!-- Панель входа -->
		<section id="enterPanel">
			<!-- Форма входа -->
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

			<!-- Форма регистрации -->
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

		<!-- панель приветствия -->
		<section id="helloPanel">
			<h1>Здравствуйте, <span id="name"></span>!</h1>
			<div>Вы зарегистрировались у нас <span id="date"></span> в <span id="time"></span>.</div>
			<div><a href="#" id="logout">Выйти</a></div>
		</section>
	</body>
</html>