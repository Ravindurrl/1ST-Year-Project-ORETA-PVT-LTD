<?php
session_start();
session_unset();  
session_destroy();  
header("Location: slmlogin.php");
exit;
?>
