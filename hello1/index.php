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

		<?php dabros::printJavaScriptTags(); ?>

		<script>
			var helloWorldFacade;

			function init()
			{
				dabros.getSessionFacade().getHello(function(response)
				{
					var helloDiv = document.getElementById('hello');
					helloDiv.innerHTML = response.result;
				});
			}

		</script>
	</head>

	<body onload="init()">
		<div id="hello"></div>
	</body>
</html>