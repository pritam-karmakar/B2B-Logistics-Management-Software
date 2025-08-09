<?php
session_start();
include("database/db.php");
include("functions/all-functions.php");
$newquery = new query();
$newfunc = new allfunctions();
if(empty($_GET['success']) && $_GET['success'] != "1" && $_SESSION['sent_otp_email_type'] != "users" && empty($_SESSION['sent_otp_email_id'])):
    header('location:forgot-password');
endif;
$company = $newquery->getData('*','company_master','',array('id'=>'1'),'id','DESC','1')[0];
if(isset($_POST['saveChanges']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])){
    $password = $newfunc->real_string(trim($_POST['password'], ' '));
    $confirm_password = $newfunc->real_string(trim($_POST['confirm_password'], ' '));
    if(strlen($password) >= 6 && strlen($confirm_password) >= 6):
        if($password === $confirm_password):
            $newPassword = md5($confirm_password);
            $updOTP = $newquery->updateData("users",array("password"=>$newPassword),"id",$_SESSION['sent_otp_email_id']);
            if($updOTP):
                unset($_SESSION['sent_otp_email_type']);
                unset($_SESSION['sent_otp_email_id']);
                $newfunc->alertRedirect("Password successfully changed","https://b2b.kingfishlogistics.in/");
            else:
                $newfunc->alertRedirect("An error occured! Contact with administrator", $_SERVER['HTTP_REFERER']);
            endif;
        else:
            $newfunc->alertRedirect("Entered a wrong OTP!", $_SERVER['HTTP_REFERER']);
        endif;
    else:
        $newfunc->alertRedirect("Password and Confirm should have minimum 6 characters!", $_SERVER['HTTP_REFERER']);
    endif;
}
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-wide  customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Create New Password User || Kingfish Logistics</title>
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://themeselection.com/item/sneat-dashboard-pro-bootstrap/">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="https://kingfishlogistics.in/images/logo/logo.png" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="assets/vendor/fonts/flag-icons.css" />
    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="assets/vendor/libs/typeahead-js/typeahead.css" /> 
    <!-- Vendor -->
    <link rel="stylesheet" href="assets/vendor/libs/%40form-validation/umd/styles/index.min.css" />
    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css">
    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>
    <script src="assets/vendor/js/template-customizer.js"></script>
    <script src="assets/js/config.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body style="background:unset;">
    
    <div class="authentication-wrapper authentication-cover">
        <div class="authentication-inner row m-0">
            <!-- /Left Text -->
            <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center p-5">
                <div class="w-100 d-flex justify-content-center">
                    <img src="assets/img/illustrations/banner.jpg" class="img-fluid" alt="Login image" width="auto" data-app-dark-img="illustrations/banner.jpg" data-app-light-img="illustrations/banner.jpg">
                </div>
            </div>
            <!-- /Left Text -->
            <!-- Login -->
            <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
                <div class="w-px-400 mx-auto">
                    <!-- Logo -->
                    <div class="app-brand justify-content-start pb-4">
                        <a href="index" class="app-brand-link gap-2">
                            <span class="app-brand-text text-body fw-bold" style="text-transform: capitalize; font-size: 1.50rem;">Welcome <span style="text-transform: lowercase;">to</span> Kingfish Logistics! 👋</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-2">Create New Password 🔑</h4>
                    <p class="mb-4">Enter new password to reset it</p>
            
                    <form class="mb-3" action="create-new-password" method="POST">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control" minlength="6" id="password" name="password" placeholder="Enter Password" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="text" class="form-control" minlength="6" id="confirm_password" name="confirm_password" placeholder="Enter Confirm Password" required autofocus>
                            <span class="text-danger" id="confirm-error"></span>
                        </div>
                        <button class="btn btn-warning d-grid w-100" type="submit" name="saveChanges">Save Changes</button>
                    </form>
                    <div class="text-center">
                        <a href="forgot-password" class="d-flex align-items-center justify-content-center">
                            <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                            Back to Forgot Password
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Login -->
        </div>
    </div>
    <!-- / Content -->

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
  <script src="assets/vendor/libs/jquery/jquery.js"></script>
  <script src="assets/vendor/libs/popper/popper.js"></script>
  <script src="assets/vendor/js/bootstrap.js"></script>
  <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="assets/vendor/js/menu.js"></script>
  <!-- Main JS -->
  <script src="assets/js/main.js"></script>
  <script src="user/menu/newjQuery.js"></script>
  <script>
      $("#confirm_password").keyup(function(){
          let password = $("#password").val();
          let confirm_password = $("#confirm_password").val();
          if((confirm_password != "") && (password !== confirm_password)){
              $("#confirm-error").text("Password and Confirm should be same");
              $("button[name=verify_otp]").prop("disabled", true);
          }else{
              $("#confirm-error").text("");
              $("button[name=verify_otp]").prop("disabled", false);
          }
      });
  </script>
</body>
</html>