<?php
require_once 'function.php';
header('Content-Type: image/png');
$name = getName();
generateCertificate($name);
