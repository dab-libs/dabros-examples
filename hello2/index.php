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
			#waitPanel, #loginPanel, #helloPanel { display: none; }
			.wait #waitPanel, .login #loginPanel, .hello #helloPanel { display: block; }
		</style>

		<?php dabros::printJavaScriptTags(); ?>

		<script>
			var helloWorldFacade;

			function init()
			{
				$('body').attr('class', 'wait');
				$('#loginPanel form').submit(onLoginSubmit);
				dabros.getSessionFacade().getLoginInfo(onLoggedIn);
			}

			function onHelloWorldFacade(response)
			{
			}

			function onLoggedIn(response)
			{
				if (response.result.loggedIn)
				{
					$('#helloPanel #name').html(response.result.name);
					$('#helloPanel #date').html(response.result.date.toUTCString());
					$('#helloPanel #time').html(response.result.date.toString());
					$('body').attr('class', 'hello');
				}
				else
				{
					$('body').attr('class', 'login');
				}
			}

			function onLoginSubmit(eventData)
			{
				$('body').attr('class', 'wait');
				dabros.getSessionFacade().login($('#login').val(), onLoggedIn);
				eventData.preventDefault();
				return false;
			}

			$(init);
		</script>
	</head>

	<body class="wait">
		<div id="waitPanel">Подождите...</div>
		<div id="loginPanel">
			<form>
				<input id="login" type="text" />
				<input type="submit" value="OK" />
			</form>
		</div>
		<div id="helloPanel">
			Здравствуйте, <span id="name"></span>!
			<br />
			Вы заходили к нам <span id="date"></span> в <span id="time"></span>.
		</div>
	</body>
</html>