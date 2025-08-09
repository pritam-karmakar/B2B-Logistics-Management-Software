<?php
    session_start();
    include("../../database/db.php");
    include("../../functions/all-functions.php");
    // if(isset($_SESSION['ltl_admin_id']) && !empty($_SESSION['ltl_admin_id']) && isset($_SESSION['ltl_admin_username']) && !empty($_SESSION['ltl_admin_username']) && !empty($_SESSION['empf_payslip_id'])){
        $emp_payslip_id = $_SESSION['emp_payslip_id'];
    // }
    // elseif(isset($_SESSION['ltl_emp_id']) && !empty($_SESSION['ltl_emp_id']) && isset($_SESSION['ltl_emp_code']) && !empty($_SESSION['ltl_emp_code']) && !empty($_SESSION['emp_payslip_id'])){
    //     $emp_payslip_id = $_SESSION['emp_payslip_id'];
    // }
    // else{
    //     echo '<script type="text/javascript" language="javascript">
    //             window.location = "'.$_SERVER['HTTP_REFERER'].'";
    //           </script>';
    // }
    $newquery = new query();
    $newfunc = new allfunctions();
    $join = array("0"=>array("LEFT","employees","salary","emp_id","employees","id"));
    $condArr = array("salary`.`id"=>$emp_payslip_id);
    $slip = $newquery->getData("*","salary",$join,$condArr,"","","")[0];
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <!-- Site Title -->
    <title>Payslip</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="tm_container">
        <div class="tm_invoice_wrap">
            <div class="tm_invoice tm_style2" id="tm_download_section">
                <div class="tm_invoice_in" style="border: 1px solid #CCC">
                    <div class="container my-5">
                        <div class="lh-1 mb-2 row">
                            <div class="col-7">
                                <h6 class="fw-bold">Kingfish Logistics</h6>
                                <span class="fw-normal">Plot 315, phase 2 industrial area panchkula 134113</span>
                            </div>
                            <div class="col-4 text-left">
                                <img src="assets/logo/logo.png">
                            </div>
                            <div class="col-12 text-center my-3">
                                <h6 class="fw-bold">Payslip</h6>
                                <span class="fw-normal">Payment Slip for the month of <?= $slip['month']; ?> <?= $slip['year']; ?></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div>
                                    <span class="fw-bolder">EMP Code :</span>
                                    <small class="ms-3"><?= $slip['employee_code']; ?></small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <span class="fw-bolder">EMP Name :</span>
                                    <small class="ms-3"><?= $slip['employee_name']; ?></small>
                                </div>
                            </div>
                        </div>
                        
                        <!--<div class="row">-->
                        <!--    <div class="col-6">-->
                        <!--        <div>-->
                        <!--            <span class="fw-bolder">PF No.</span>-->
                        <!--            <small class="ms-3">PF Number</small>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--    <div class="col-6">-->
                        <!--        <div>-->
                        <!--            <span class="fw-bolder">ESI No.</span>-->
                        <!--            <small class="ms-3"></small>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                        
                        <div class="row">
                            <div class="col-6">
                                <div>
                                    <span class="fw-bolder">Designation :</span>
                                    <small class="ms-3"><?= $slip['designation']; ?></small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <span class="fw-bolder">Ac No.</span>
                                    <small class="ms-3"><?= $slip['account_no']; ?></small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 px-0">
                                <table class="mt-4 table table-bordered">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Earnings</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Salary</th>
                                            <td><?= $slip['salary']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Over Time</th>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <th>Allowances</th>
                                            <td><?= $slip['allowances']; ?></td>
                                        </tr>
                                        <tr class="border-top">
                                            <th>Total Earning</th>
                                            <td><?= $slip['salary']+$slip['allowances']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                             </div>
                            <!--<div class="col-6 px-0">-->
                            <!--    <table class="mt-4 table table-bordered">-->
                            <!--        <thead class="bg-dark text-white">-->
                            <!--            <tr>-->
                            <!--                <th scope="col">Deductions</th>-->
                            <!--                <th scope="col">Amount</th>-->
                            <!--            </tr>-->
                            <!--        </thead>-->
                            <!--        <tbody>-->
                            <!--            <tr>-->
                            <!--                <th>PF</th>-->
                            <!--                <td>0.00</td>-->
                            <!--            </tr>-->
                            <!--            <tr>-->
                            <!--                <th>ESI</th>-->
                            <!--                <td>0.00</td>-->
                            <!--            </tr>-->
                            <!--            <tr>-->
                            <!--                <th>TDS</th>-->
                            <!--                <td>0.00</td>-->
                            <!--            </tr>-->
                            <!--            <tr class="border-top">-->
                            <!--                <th>Total Deductions</th>-->
                            <!--                <td>0.00</td>-->
                            <!--            </tr>-->
                            <!--        </tbody>-->
                            <!--    </table>-->
                            <!--</div>-->
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <span class="fw-bold">Net Pay : <?= $slip['salary']+$slip['allowances']; ?></span>
                                <!--<p>In Words : Twenty Five thousand nine hundred seventy only</p>-->
                            </div>
                            <div class="col-8">
                                <div class="d-flex justify-content-end">
                                    <div class="d-flex flex-column mt-2">
                                        <span class="fw-bolder">For Kingfish Logistics</span>
                                        <span class="mt-4">Authorised Signatory</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tm_invoice_btns tm_hide_print">
            <a href="javascript:window.print()" class="tm_invoice_btn tm_color1">
                <span class="tm_btn_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                        <path d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                        <rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                        <path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                        <circle cx="392" cy="184" r="24" fill='currentColor' />
                    </svg>
                </span>
                <span class="tm_btn_text">Print</span>
            </a>
            <button id="tm_download_btn" class="tm_invoice_btn tm_color2">
                <span class="tm_btn_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                        <path d="M320 336h76c55 0 100-21.21 100-75.6s-53-73.47-96-75.6C391.11 99.74 329 48 256 48c-69 0-113.44 45.79-128 91.2-60 5.7-112 35.88-112 98.4S70 336 136 336h56M192 400.1l64 63.9 64-63.9M256 224v224.03" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
                    </svg>
                </span>
                <span class="tm_btn_text">Download</span>
            </button>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jspdf.min.js"></script>
    <script src="assets/js/html2canvas.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>