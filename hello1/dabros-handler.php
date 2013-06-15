<?php
require '../dabros/dabros.php';

$config = require 'classes/config.php';

dabros::initialize($config);
dabros::getRemoteCallManager()->handle();
