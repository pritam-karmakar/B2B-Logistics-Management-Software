<?php
session_start();
include("../database/db.php");
include("../functions/all-functions.php");
$newquery = new query();
$newfunc = new allfunctions();
if(!empty($_SESSION['ltl_admin_id']) && $_SESSION['ltl_admin_username']){
    header('location:dashboard');
}
if(isset($_POST['signin'])){
    extract($_POST);
    $username = $newfunc->RemoveSpecialChar($newfunc->real_string($username));
    $userpassword = md5($newfunc->RemoveSpecialChar($newfunc->real_string($userpassword)));
    $cond = array("username"=>$username);
    $getlogin = $newquery->getData("*","admin_login","",$cond,"","","");
    if($getlogin != 0){
        if($getlogin[0]['userpassword'] == $userpassword){
            $_SESSION['ltl_admin_id'] = $getlogin[0]['id'];
            $_SESSION['ltl_admin_username'] = $getlogin[0]['username'];
            echo '<script type="text/javascript" language="javascript">
                    alert("You have successfully logged in");
                    window.location = "dashboard";
                  </script>';
        }else{
            echo '<script type="text/javascript" language="javascript">
                    alert("Entered a wrong password");
                    window.location = "dashboard";
                  </script>';
        }
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Login credentials don\'t exists");
                window.location = "dashboard";
              </script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
   <!--Title-->
	<title>LTL Admin || Kingfisher Logistics</title>
    
	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="DexignZone">
	<meta name="robots" content="index, follow">
    
	<meta name="keywords" content="">
    
	<meta name="description" content="">
    
	<meta property="og:title" content="">
	<meta property="og:description" content="">
	<meta property="og:image" content="">
    
	<meta name="format-detection" content="">
    
	<meta name="twitter:title" content="">
	<meta name="twitter:description" content="">
	<meta name="twitter:image" content="">
	<meta name="twitter:card" content="">
    
	<!-- MOBILE SPECIFIC -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- FAVICONS ICON -->
    <link rel="icon" type="image/x-icon" href="https://kingfishlogistics.in/images/logo/logo.png" />
	<link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link class="main-css" href="css/style.css" rel="stylesheet">

</head>

<body style="background-image:url('https://finshiksha.com/wp-content/uploads/2022/05/Delhivery-Banner-Image.jpg'); background-position:center; background-repeat: no-repeat; background-size: cover;">
    <div class="authincation fix-wrapper">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-12">
                    <div class="authincation-content">
                        <div class="row no-gutters" style="display: flex; justify-content: center; align-items: center;">
                            <div class="col-xl-6">
                                <img src="https://www.advotics.com/wp-content/uploads/2022/02/surat-jalan-01-1-4-1024x656.png" style="width: 100%;">
                            </div>
                            <div class="col-xl-6">
                                <div class="auth-form">
									<div class="text-center mb-3">
										<a href="" class="brand-logo" style="flex-direction: column;">
										    <img src="https://kingfishlogistics.in/images/logo/logo.png">
                                        </a>
									</div>
                                    <h4 class="text-center mb-4">Sign in to start your session</h4>
                                    <form action="index" method="POST">
                                        <div class="mb-3">
                                            <label class="mb-1 form-label">Username</label>
                                            <input type="text" class="form-control" placeholder="user name" name="username">
                                        </div>
                                        
                                        <div class="mb-3 position-relative">
                                            <label class="form-label" for="dz-password">Password</label>
                                            <input type="password" id="dz-password" class="form-control" placeholder="user password" name="userpassword">
                                            <span class="show-pass eye">
                                                <i class="fa fa-eye-slash"></i>
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block" name="signin">Sign In</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--**********************************
	Scripts
***********************************-->
<!-- Required vendors -->
<script src="vendor/global/global.min.js"></script>
<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="js/deznav-init.js"></script>
<script src="js/custom.min.js"></script>
<script src="js/demo.js"></script>
</body>
</html>