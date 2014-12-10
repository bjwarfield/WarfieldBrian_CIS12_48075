<?php
#Redirect to Admin Index Page
$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = '../admin_index.php';
header("Location: http://$host$uri/$extra");
exit;
?>