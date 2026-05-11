<?php

session_start();

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/helpers.php';

$app = new App();
$app->run();
