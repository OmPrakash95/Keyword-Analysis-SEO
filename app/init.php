<?php
ob_start();
session_start();
define('URL', 'http://localhost/seo/public');
require_once('lib/simple_html_dom.php');
require_once 'lib/Math/Combinatorics.php';
require_once '../vendor/autoload.php';
require_once 'database.php';
require_once 'core/app.php';
require_once 'core/controller.php'
?>