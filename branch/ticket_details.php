<?php
include('menu/header.php');
include('menu/navbar.php');
if(isset($_GET['id']))
{
    $data = $_GET['id'];
    $cond = array("tickets`.`id"=>$data);
    $join= array('0'=>array('LEFT','ticket_category','tickets','ticket_category','ticket_category','id'),
                 '1'=>array('LEFT','ticket_subcategory','tickets','ticket_sub_category','ticket_subcategory','id'));
    $get_ticket_detals = $query->getData("`tickets`.*,`ticket_category`.`category`,`ticket_subcategory`.`subCategory`","tickets",$join,$cond,"tickets`.`id","DESC","");
    ?>
    
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Ticket Details</span></h4>
            
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Tickets Details Of <b><?= $get_ticket_detals[0]['ticket_code']; ?></b></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="" class="form-label">Created ON</label>
                                    <input class="form-control" name="created_on" id="created_on" value="<?= $get_ticket_detals[0]['created_on']; ?>" readonly>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="" class="form-label">Last Update</label>
                                    <input class="form-control" name="last_update" id="last_update" value="<?= $get_ticket_detals[0]['last_update']; ?>"  readonly>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="" class="form-label">Status</label>
                                    <input class="form-control" name="status" id="status" value="<?= $get_ticket_detals[0]['status']; ?>"  readonly>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="emailBasic" class="form-label">Email</label>
                                    <input type="email" id="emailBasic" class="form-control" name="email" placeholder="xxxx@xxx.xx" value="<?= $get_ticket_detals[0]['email']; ?>" readonly>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="" class="form-label">Category</label>
                                    <input class="form-control" name="ticket_category" id="ticket_category" value="<?= $get_ticket_detals[0]['category']; ?>" readonly>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="" class="form-label">Sub Category</label>
                                    <input class="form-control" name="ticket_sub_category" id="ticket_sub_category" value="<?= $get_ticket_detals[0]['subCategory']; ?>"  readonly>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <input class="form-control" name="remarks" id="remarks" value="<?= $get_ticket_detals[0]['remarks']; ?>" readonly>
                                </div>
                                <?php
                                if(!empty($get_ticket_detals[0]['admin_remarks']))
                                {
                                    ?>
                                    <div class="col-12 mb-3">
                                        <label for="remarks" class="form-label">Solutions</label>
                                        <input class="form-control" name="solutions" id="solutions" value="<?= $get_ticket_detals[0]['admin_remarks']; ?>" readonly>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
else
{
    echo'<script>window.location="ticket";</script>';
}
include('menu/footer.php');
?>