<?php
session_start();
unset($_SESSION['ltl_emp_id']);
unset($_SESSION['ltl_emp_code']);
header("location:index");
?>