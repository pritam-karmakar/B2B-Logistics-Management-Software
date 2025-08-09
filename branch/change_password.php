<?php
    include('menu/header.php');
    include('menu/navbar.php');
?>
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
        <?php
            if(isset($_REQUEST['done'])){
                echo'<h4  style="justify-content: center;display: flex;"><span class="text-dark">Password changed successfully</span></h4>';
            } else{
        ?>
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span></h4>
            <!-- Basic Layout & Basic with Icons -->
            <div class="row d-flex justify-content-center ">
                <!-- Basic Layout -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Change Password</h5>
                            <!--<small class="text-muted float-end">Default label</small>-->
                        </div>
                        <div class="card-body">
                            <form id="formAuthentication" class="mb-3" action="action.php" method="POST">
                                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                <div class="mb-3">
                                  <label for="email" class="form-label">New Password</label>
                                  <input type="password" class="form-control" id="password" name="password" placeholder="Enter New Password" autofocus required/>
                                </div>
                                <div class="mb-3">
                                  <label for="email" class="form-label">Confirm Password</label>
                                  <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" autofocus required/>
                                  <span id="message"></span>
                                </div>
                                <div class="row justify-content-center">
                                  <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary" id="change_password" name="change_password" style="float:right;">Change Password</button>
                                  </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php
            }
        ?>
        </div>
    </div>

<?php
    include('menu/footer.php');
?>