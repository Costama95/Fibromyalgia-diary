<?php
session_start();
session_destroy();
header('Location: signinfibro.php');
exit;
?>