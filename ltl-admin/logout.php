<?php
session_start();
unset($_SESSION['ltl_admin_id']);
unset($_SESSION['ltl_admin_username']);
header("location:index");
?>