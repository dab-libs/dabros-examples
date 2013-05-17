<?php
require '../dabros/dabros.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<style>
			#waitPanel, #loginPanel, #helloPanel { display: none; }
			.wait #waitPanel, .login #loginPanel, .hello #helloPanel { display: block; }
		</style>

		<?php dabros::printJavaScriptTags('/hello1/js'); ?>

		<script>
			var helloWorldFacade;

			function init()
			{
				$('body').attr('class', 'wait');
				$('#loginPanel form').submit();
				var rosFactory = new dabros.RemoteObjectFactory('/hello2/dabros-handler.php');
				rosFactory.getSessionFacade('HelloWorldFacade', onHelloWorldFacade);
			}

			function onHelloWorldFacade(response)
			{
				helloWorldFacade = response.result;
				helloWorldFacade.getLoginInfo(onLoggedIn);
			}

			function onLoggedIn(response)
			{
				if (response.result.loggedIn)
				{
					$('#helloPanel #name').html(response.result.login);
					$('#helloPanel #date').html();
					$('#helloPanel #time').html();
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
				helloWorldFacade.login(onLoggedIn);
			}

			$(init);
		</script>
	</head>

	<body class="wait">
		<div id="waitPanel"></div>
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