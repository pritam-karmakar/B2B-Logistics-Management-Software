<?php
    include('menu/header.php');
    include('menu/navbar.php');
?>
<style>
    img.img-fluid.qrcode {
        width: 50%;
    }
    .bod-left {
        border-left: 1px solid #ff3e1d;
    }
    .bod-bott {
        border-bottom: 1px solid #ff3e1d;
        margin-bottom: 6px;
    }
    @media screen and (max-width: 992px){
        .bod-left {
            border-left: 1px solid #fff;
        }
        .bod-bott {
            border-bottom: 1px solid #fff;
            margin-bottom: 6px;
        }
    }
</style>
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <?php
            if(isset($_GET['done'])) {
                
                echo '<script>alert("Money Added Successfully");window.location="add_money";</script>';
            } 
            
            ?>
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span></h4>
            <!-- Basic Layout & Basic with Icons -->
            <div class="row d-flex justify-content-center ">
                <!-- Basic Layout -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Add Money</h5>
                            <!--<small class="text-muted float-end">Default label</small>-->
                        </div>
                        <div class="card-body">
                            <div class="nav-align-top mb-4">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true">Online</button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="false">Manual</button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="navs-top-home" role="tabpanel">
                                        <form action="https://kingfishlogistics.in/b2b/user/addmoney" method="POST">
                                            <div class="row mb-3">
                                              <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                                              <input type="hidden" class="form-control" name="type_id"  value="<?php echo $user_id; ?>" />
                                              <div class="col-sm-10">
                                                <input type="text" class="form-control name" name="name" id="basic-default-name" value="<?= $get_user_details[0]['party_name']; ?>" readonly/>
                                              </div>
                                            </div>
                                    
                                            <div class="row mb-3">
                                              <label class="col-sm-2 col-form-label" for="basic-default-phone">Phone No</label>
                                              <div class="col-sm-10">
                                                <input type="text" class="form-control mobile" name="mobile" id="basic-default-name" value="<?= $get_user_details[0]['mobile_no']; ?>" readonly/>
                                              </div>
                                            </div>
                                            <div class="row mb-3">
                                              <label class="col-sm-2 col-form-label" for="basic-default-phone">Amount</label>
                                              <div class="col-sm-10">
                                                <input type="text" class="form-control amnt" name="amount" id="basic-default-name" placeholder="Enter Your Amount" required/>
                                              </div>
                                            </div>
                                            <!--<div class="row mb-3 d-none" id="charge_row">-->
                                            <!--  <label class="col-sm-2 col-form-label" for="basic-default-phone">Charges</label>-->
                                            <!--  <div class="col-sm-10">-->
                                            <!--    <input type="text" class="form-control charge" name="charge" id="basic-default-name" readonly />-->
                                            <!--  </div>-->
                                            <!--</div>-->
                                            <div class="row justify-content-end">
                                              <div class="col-sm-12">
                                                <button type="submit" class="btn btn-danger" name="add_money" style="float:right;">Add Money</button>
                                              </div>
                                            </div>
                                        </form>
                                    </div>
                                    <?php
                        		        $get_bank = $query->getData('*','bank_details','','','id','DESC','')[0];
                        		    ?>
                                    <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
                                        <div class="col-md-12 text-center">
                                            <img src="../storage/bank/<?= $get_bank['qr_code']; ?>" class="img-fluid qrcode">
                                        </div>
                                        <div class="col-md-12 text-center bod-bott">
                                            <div class="mb-3">
                                                <p><strong>UPI ID : <?= $get_bank['upid']; ?></strong></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 text-center">
                                                <div class="mb-3">
                                                    <p><strong>Bank Name : <?= $get_bank['b_name']; ?></strong></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-center bod-left">
                                                <div class="mb-3">
                                                    <p><strong>A/C Holder : <?= $get_bank['ac_holder']; ?></strong></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-center">
                                                <div class="mb-3">
                                                    <p><strong>A/C Number : <?= $get_bank['ac_number']; ?></strong></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-center bod-left">
                                                <div class="mb-3">
                                                    <p><strong>IFSC : <?= $get_bank['ifsc']; ?></strong></p>
                                                </div>
                                            </div>
                                        </div>
                                        <form method="POST" action="action.php">
                                            <input type="hidden" class="form-control" name="user_id"  value="<?= $_SESSION['ltl_user_id']; ?>">
                                            <input type="hidden" class="form-control" name="upid"  value="<?= $get_bank['upid']; ?>">
                                            <input type="hidden" class="form-control" name="b_name"  value="<?= $get_bank['b_name']; ?>">
                                            <input type="hidden" class="form-control" name="ac_holder"  value="<?= $get_bank['ac_holder']; ?>">
                                            <input type="hidden" class="form-control" name="ac_number"  value="<?= $get_bank['ac_number']; ?>">
                                            <input type="hidden" class="form-control" name="ifsc"  value="<?= $get_bank['ifsc']; ?>">
                                            <div class="mb-3">
                                                <label for="defaultFormControlInput" class="form-label">Amount</label>
                                                <input type="text" class="form-control" id="defaultFormControlInput" name="amount" placeholder="Amount" aria-describedby="defaultFormControlHelp" required>
                                                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="defaultFormControlInput" class="form-label">Transaction Id</label>
                                                <input type="text" class="form-control" id="defaultFormControlInput" name="txn_id" placeholder="Transaction Id" aria-describedby="defaultFormControlHelp" required>
                                            </div>
                                            <div class="row">
                                              <!--<div class="col-sm-6 d-flex justify-content-start">-->
                                              <!--  <a href="https://api.whatsapp.com/send/?phone=919623002366" type="button" class="btn btn-success" target="_blank" >Help</a>-->
                                              <!--</div>-->
                                              <div class="col-sm-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-danger" name="add_money_manual" style="float:right;">Add Money</button>
                                              </div>
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
    </div>
    <?php
include('menu/footer.php');
?>
                
