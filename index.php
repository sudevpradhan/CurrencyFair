<?php

error_reporting(E_ALL);
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

// @TODO: use an autoloader.
require 'libs/Bootstrap.php';

require 'libs/Controller.php';
require 'libs/View.php';
require 'libs/Model.php';

require 'config/settings.php';

$app = new Bootstrap();

