<?php
echo '<h1>Hello PHP</h1>';
$url = $_SERVER['REQUEST_URI'];
$url = $url . 'admin.php';
var_dump($url);
header('location: ' . $url);
