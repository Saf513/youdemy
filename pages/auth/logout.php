<?php
require_once dirname(__DIR__, 2) . '/classes/Auth/Authentification.php';
require_once dirname(__DIR__, 2) . '/classes/Auth/Session.php';

Session::start();
Authentification::lougout();
header('Location: http://localhost:3000/logout.php');
exit();