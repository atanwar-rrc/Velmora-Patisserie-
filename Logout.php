<?php
session_start();
include_once("getConnection.php");
unset($_SESSION['user_name']);
unset($_SESSION['user_mail']);
unset($_SESSION['user_type']);
redirect('SignIn.php');
?>