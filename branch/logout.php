<?php
session_start();
unset($_SESSION['branchusername']);
unset($_SESSION['branchuser_id']);
header("location:index");
?>