<?php
require 'classes/ClassLoader.php';
require 'classes/config.php';
require '../dabros/dabros.php';

$config = require 'classes/config.php';

dabros::initialize($config);
dabros::getRemoteObjectManager()->handle();
