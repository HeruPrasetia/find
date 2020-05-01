<?php
  session_start();
  session_unset();
  session_destroy();
  setcookie("fm_login", "", time() - (86400 * 30), "/");
  setcookie("username", "", time() - (86400 * 30), "/");
  setcookie("status", "", time() - (86400 * 30), "/");
  setcookie("name", "", time() - (86400 * 30), "/");
  
  
  header('location:index.php');
?>
