<?php
include('menu/header.php');
include('menu/navbar.php');
?>
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-dark fw-bold">Cashbook Request</span></h4>
            <!-- Responsive Table -->
            <div class="card">
                <div class="card-header">
                    <div class="row mb-3">
                        <div class="col-12 mb-3 d-flex justify-content-end">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#basicModal">Create New Request</button>
                            <!-- Modal -->
                            <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="action.php" method="POST">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel1">New</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-12 mb-3">
                                                        <label class="form-label">LR No</label>
                                                        <!--<input type="text" class="form-control" name="lr_no" placeholder="Enter LR Number" required>-->
                                                        <select name="lr_no" class="form-control">
                                                            <option value="" hidden>Choose LR No.</option>
                                                            <?php
                                                                $where = array('user_type'=>'users','type_id'=>$user_id,);
                                                                $getorders = $query->getData("*","orders","",$where,"","","");
                                                                foreach($getorders as $order){
                                                            ?>
                                                                <option value="<?= $order['lr']; ?>"><?= $order['lr']; ?></option>
                                                            <?php
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 mb-3">
                                                        <label class="form-label">Amount</label>
                                                        <input type="number" class="form-control" name="amount" placeholder="Enter amount" required>
                                                    </div>
                                                    <div class="col-12 mb-3">
                                                        <label class="form-label">Bank Reference No</label>
                                                        <input type="text" class="form-control" name="ref_no" placeholder="Enter Reference Number" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                              <button type="submit" name="submitCashbookReq" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="card-body">
                    <!--<ul class="nav nav-pills card-header-pills" role="tablist">-->
                    <!--    <li class="nav-item" role="presentation">-->
                    <!--        <button type="button" class="nav-link" role="tab" id="Open">Open</button>-->
                    <!--    </li>-->
                    <!--    <li class="nav-item" role="presentation">-->
                    <!--        <button type="button" class="nav-link" role="tab" id="Closed">Closed</button>-->
                    <!--    </li>-->
                    <!--</ul>-->
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr class="text-nowrap">
                                    <th class="text-center">SL No</th>
                                    <th class="text-center">Request No</th>
                                    <th class="text-center">LR Number</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Bank Ref No</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Last Updated</th>
                                    <th class="text-center">Creation Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sl = 1;
                                    $where = array("entity_id"=>$user_id);
                                    $cashbook_request = $query->getData("*","cashbook","",$where,"id","DESC","");
                                    foreach($cashbook_request as $val){
                                ?>
                                <tr>
                                    <td class="text-center"><?= $sl; ?></td>
                                    <td class="text-center"><?= $val['req_no']; ?></td>
                                    <td class="text-center"><?= $val['lr_no']; ?></td>
                                    <td class="text-center"><?= $val['amount']; ?></td>
                                    <td class="text-center"><?= $val['ref_no']; ?></td>
                                    <td class="text-center"><?= $val['approve_status']; ?></td>
                                    <td class="text-center"><?= date("d-m-Y H:i:s", strtotime($val['updated_at'])); ?></td>
                                    <td class="text-center"><?= date("d-m-Y H:i:s", strtotime($val['created_at'])); ?></td>
                                </tr>
                                <?php
                                    $sl++;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--/ Responsive Table -->
        </div>
    </div>
<?php
    include('menu/footer.php');
?>