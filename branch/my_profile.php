<?php
include('menu/header.php');
include('menu/navbar.php');
?>
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span></h4>
            <!-- Basic Layout & Basic with Icons -->
            <div class="row d-flex justify-content-center ">
                <!-- Basic Layout -->
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-2">My Profile</h5>
                        </div>
                        <div class="card-body">
                            <form action="action.php" method="POST">
                                <div class="row">
                                    <input type="hidden" name="id" value="<?= $user_id; ?>" />
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-default-fullname">Username</label>
                                        <input type="text" class="form-control" id="basic-default-fullname" value="<?= $get_user_details[0]['branch_user_name']; ?>" readonly/>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-default-fullname">Branch Name</label>
                                        <input type="text" class="form-control" id="basic-default-fullname" value="<?= $get_user_details[0]['branch_name']; ?>" name="branch_name" readonly/>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-default-fullname">Branch Type</label>
                                        <input type="text" class="form-control" id="basic-default-fullname" value="<?php if($get_user_details[0]['type']='branch'){echo'Branch';}else{echo'Agent';} ?>" name="type"  readonly/>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-default-fullname">Contact Person</label>
                                        <input type="text" class="form-control" id="basic-default-fullname" value="<?= $get_user_details[0]['contact_person']; ?>"  readonly/>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-default-email">Email</label>
                                         <input type="email" class="form-control" id="basic-default-email" value="<?= $get_user_details[0]['email']; ?>" readonly/>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                      <label class="form-label" for="basic-default-phone">Mobile No</label>
                                        <input type="text" class="form-control mobile" id="basic-default-name" value="<?= $get_user_details[0]['mobile_no']; ?>"  maxlength="10" readonly/>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                      <label class="form-label" for="basic-default-phone">State</label>
                                        <input type="text" class="form-control mobile" id="basic-default-name" value="<?= $get_user_details[0]['state']; ?>"  readonly/>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                      <label class="form-label" for="basic-default-phone">City</label>
                                        <input type="text" class="form-control mobile" id="basic-default-name" value="<?= $get_user_details[0]['city']; ?>"  readonly/>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                      <label class="form-label" for="basic-default-phone">Pin</label>
                                        <input type="text" class="form-control mobile" id="basic-default-name" value="<?= $get_user_details[0]['pincode']; ?>"   readonly/>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="basic-default-message">District</label>
                                        <input type="text" class="form-control" id="basic-default-fullname" value="<?= $get_user_details[0]['district']; ?>"  readonly/>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="basic-default-message">Address</label>
                                        <input type="text" class="form-control" id="basic-default-fullname" value="<?= $get_user_details[0]['address']; ?>" name="address"  readonly/>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
include('menu/footer.php');
?>