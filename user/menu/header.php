<?php
    session_start();
    include("../database/db.php");
    include("../functions/all-functions.php");
    $query = new query();
    $newfunc = new allfunctions();
    date_default_timezone_set("Asia/Kolkata");
    if(!empty($_SESSION['username']) && !empty($_SESSION['user_id'])){
        $username = $_SESSION['username'];
        $user_id = $_SESSION['user_id'];
        $cond=array("id"=>$user_id);
        $get_user_details = $query->getData("*","users","",$cond,"","","");
    }else{
        header("location:../");
    }
    $thisPageIs = str_replace('.php', '', end(explode("/", $_SERVER['PHP_SELF'])));
    define("CurrentPageURL", str_replace(".php", "", end(explode("/", $_SERVER['PHP_SELF']))));
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= ucwords(str_replace('index', 'dashboard', str_replace('_', ' ', $thisPageIs))); ?> - B2B User || Kingfish Logistics</title>

    <base href="https://projects.casfus.com/kingfishlogistics.in/b2b/user/">
    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="https://kingfishlogistics.in/images/logo/logo.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/typeahead-js/typeahead.css" /> 
    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/tagify/tagify.css" />
    <!-- Page CSS -->
    
    <!--Time Picker-->
    <link rel="stylesheet" href="../assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/pickr/pickr-themes.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
    <!--Bootstrap Icon-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
    <link rel="stylesheet" href="menu/newStyle.css">

    <style>
    tbody,tr,td,th{
        color:#222 !important;
    }
    .menu-header-text{
        color:black;
        font-weight: 600;
    }
</style>
  </head>

  <body>
      
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme color_gradient">
          <div class="app-brand demo" style="background-image: linear-gradient(90deg, #2e3a4d, #49576c, #6d7f94);">
            <img src="https://kingfishlogistics.in/images/logo/logo.png" style="width:210px;height:65px;">
          </div>

          <div class="menu-inner-shadow"></div>
          
          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item <?php if($thisPageIs == "index"){ echo 'active'; } ?>">
              <a href="index" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboard">Dashboard</div>
              </a>
            </li>

            <li class="menu-item open <?php if($thisPageIs == "create_order" || $thisPageIs == "all_orders" || $thisPageIs == "franchise_topay" || $thisPageIs == "bulk_orders"){ echo 'active'; } ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-cart-add"></i>
                <div data-i18n="My Orders">My Orders</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?php if($thisPageIs == "create_order"){ echo 'active'; } ?>">
                  <a href="create_order" class="menu-link">
                    <div data-i18n="Create New Order">Create New Order</div>
                  </a>
                </li>
                <li class="menu-item <?php if($thisPageIs == "all_orders"){ echo 'active'; } ?>">
                  <a href="all_orders" class="menu-link" >
                    <div data-i18n="All Orders">All Orders</div>
                  </a>
                </li>
                <li class="menu-item <?php if($thisPageIs == "bulk_orders"){ echo 'active'; } ?>">
                  <a href="bulk_orders" class="menu-link" >
                    <div data-i18n="Bulk Upload ">Bulk Upload </div>
                  </a>
                </li>
              </ul>
            </li>
            
            <li class="menu-item <?php if($thisPageIs == "pickup_request"){ echo 'active'; } ?>">
              <a href="pickup_request" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-truck"></i>
                <div data-i18n="Pick Up Request">Pick Up Request</div>
              </a>
            </li>
            
            <li class="menu-item <?php if($thisPageIs == "self_drop"){ echo 'active'; } ?>">
              <a href="self_drop" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-right-down-arrow-circle"></i>
                <div data-i18n="Self Drop">Self Drop</div>
              </a>
            </li>
            <li class="menu-item <?php if($thisPageIs == "delivery_appointment"){ echo 'active'; } ?>">
              <a href="delivery_appointment" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-calendar-alt"></i>
                <div data-i18n="Delivery Appointment">Delivery Appointment</div>
              </a>
            </li>
            <li class="menu-item <?php if($thisPageIs == "manage_warehouses" || $thisPageIs == 'edit_warehouse'){ echo 'active'; } ?>">
              <a href="manage_warehouses" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-building-house"></i>
                <div data-i18n="Manage Warehouses">Manage Warehouses</div>
              </a>
            </li>
            <li class="menu-item <?php if($thisPageIs == "serviceability"){ echo 'active'; } ?>">
              <a href="serviceability" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-map"></i>
                <div data-i18n="Pincode Serviceability">Pincode Serviceability</div>
              </a>
            </li>
            <li class="menu-item <?php if($thisPageIs == "freight-estimator"){ echo 'active'; } ?>">
              <a href="freight-estimator" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calculator"></i>
                <div data-i18n="Freight Estimator">Freight Estimator</div>
              </a>
            </li>
            <li class="menu-item <?php if($thisPageIs == "ticket" || $thisPageIs == "task"){ echo 'open active'; } ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-support"></i>
                <div data-i18n="Helpdesk">Helpdesk</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item <?php if($thisPageIs == "ticket"){ echo 'active'; } ?>">
                  <a href="ticket" class="menu-link" >
                    <div data-i18n="Ticket">Ticket</div>
                  </a>
                </li>
                
                <li class="menu-item <?php if($thisPageIs == "task"){ echo 'active'; } ?>">
                  <a href="task" class="menu-link" >
                    <div data-i18n="Task">Task</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item <?php if($thisPageIs == "new_rate_card"){ echo 'active'; } ?>">
              <a href="new_rate_card" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-chess"></i>
                <div data-i18n="Rate Chart">Rate Chart</div>
              </a>
            </li>
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
        