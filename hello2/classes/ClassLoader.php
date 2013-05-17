<?php

function LoadClass($className) {
	 require 'classes/' . $className . '.php';
}

spl_autoload_register('LoadClass');
