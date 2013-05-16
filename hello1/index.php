<?php
require '../dabros/dabros.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<?php dabros::printJavaScriptTags('/hello1/js'); ?>

		<script>
			var helloWorldFacade;

			function init()
			{
				var rosFactory = new dabros.RemoteObjectFactory('/hello1/dabros-handler.php');
				rosFactory.getSessionFacade('HelloWorldFacade', onHelloWorldFacade);
			}

			function onHelloWorldFacade(response)
			{
				helloWorldFacade = response.result;
				helloWorldFacade.getHello(onHello);
			}

			function onHello(response)
			{
				var helloDiv = document.getElementById('hello');
				helloDiv.innerHTML = response.result;
			}
		</script>
	</head>

	<body onload="init()">
		<div id="hello"></div>
	</body>
</html>