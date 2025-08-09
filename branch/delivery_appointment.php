<?php
    include('menu/header.php');
    include('menu/navbar.php');
?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-dark fw-bold">Delivery Appointment</span></h4>
            <!-- Responsive Table -->
            <div class="card">
                <div class="card-header">
                    <div class="row mb-3">
                        <div class="col-12 mb-3 d-flex justify-content-end">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#basicModal">Add Delivery Appointment</button>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel1">Register Appointment</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="action" method="POST">
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <label for="lr_no" class="form-label">LR No.*</label>
                                                    <select class="form-control" id="lr_no" name="lr_no">
                                                        <option value="" hidden>Choose LR</option>
                                                        <?php
                                                            $appoint = $query->getData("*","orders","",array("user_type"=>"branches","type_id"=>$user_id),"order_id","DESC","");
                                                            foreach($appoint as $lrs){
                                                        ?>
                                                            <option value="<?= $lrs['order_id']; ?>"><?= $lrs['lr']; ?></option>
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                    <!--<input type="text" id="lr_no" class="form-control" placeholder="Put Your LR No">-->
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <label for="appointment_date" class="form-label">Appointment Date</label>
                                                    <input type="date" id="appointment_date" name="appointment_date" class="form-control" placeholder="Select Your Preferred Date">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <label for="start_time" class="form-label">Start Time</label>
                                                    <input type="time" id="start_time" name="start_time" class="form-control">
                                                </div>
                                                <div class="col-6">
                                                    <label for="end_time" class="form-label">End Time</label>
                                                    <input type="time" id="end_time" name="end_time" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <label for="appointment_id" class="form-label">Appointment ID</label>
                                                    <input type="text" id="appointment_id" name="appointment_id" class="form-control" placeholder="Enter Your Appointment ID">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <label for="po" class="form-label">PO#</label>
                                                    <input type="text" id="po" name="po" class="form-control" placeholder="Enter PO#">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-primary" name="submitAppointment">Submit</button>
                                        </div>
                                    </form>
                                  </div>
                                </div>
                            </div>
                            
                        </div>
                        <!--<div class="col-md-3 mb-2">-->
                        <!--    <input type="text" class="form-control" placeholder="Search by AWB/LR">-->
                        <!--</div>-->
                        <!--<div class="col-md-2 mb-2">-->
                        <!--    <select class="form-control" id="search_date">-->
                        <!--        <option value="All Dates">All Dates</option>-->
                        <!--        <option value="Today">Today</option>-->
                        <!--        <option value="Yesterday">Yesterday</option>-->
                        <!--        <option value="Last 7 Days">Last 7 Days</option>-->
                        <!--        <option value="Last 30 Days" >Last 30 Days</option>-->
                        <!--        <option value="This Month">This Month</option>-->
                        <!--        <option value="Last Month" >Last Month</option>-->
                        <!--        <option value="Custom Range">Custom Range</option>-->
                        <!--    </select>-->
                        <!--</div>-->
                        <!--<div class="col-md-3 mb-2" id="form_date">-->
                        <!--    <input type="date" class="form-control">-->
                        <!--</div>-->
                        <!--<div class="col-md-3 mb-2" id="to_date">-->
                        <!--    <input type="date" class="form-control">-->
                        <!--</div>-->
                        <!--<div class="col-md-1">-->
                        <!--    <button class="btn btn-outline-primary" type="submit">Search</button>-->
                        <!--</div>-->
                    </div>   
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr class="text-nowrap">
                                    <th class="text-center">LR No.</th> 
                                    <th class="text-center">Appointment Date </th>  
                                    <th class="text-center">Slot Time </th>
                                    <th class="text-center">PO</th>
                                    <th class="text-center">Appointment ID</th>                        
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $appointments = $query->getData("`appointments`.*,`orders`.`lr`","appointments",array("0"=>array("LEFT","orders","orders","order_id","appointments","lr_no")),array("appointments`.`user_type"=>"branches","appointments`.`type_id"=>$user_id),"id","DESC","");
                                    if($appointments != 0){
                                        foreach($appointments as $apps){
                                ?>
                                <tr>
                                    <td class="text-center"><?= $apps['lr']; ?></td>
                                    <td class="text-center"><?= $apps['appointment_date']; ?></td>
                                    <td class="text-center"><?= $apps['start_time']." - ".$apps['end_time']; ?></td>
                                    <td class="text-center"><?= $apps['po']; ?></td>
                                    <td class="text-center"><?= $apps['appointment_id']; ?></td>
                                    <td class="text-center"><?php if($apps['status'] == "requested"){ echo "<span class='badge bg-info'>Requested</span>"; }elseif($apps['status'] == "processing"){ echo "<span class='badge bg-warning'>Processing</span>"; }elseif($apps['status'] == "completed"){ echo "<span class='badge bg-success'>Completed</span>"; } ?></td>
                                    <td class="text-center"><?php if(empty($apps['remarks'])){  echo "No remarks";}else{ echo $apps['remarks']; } ?></td>
                                </tr>
                                <?php
                                        }
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
<script>
    $( document ).ready(function() {
       $("#form_date").hide();
       $("#to_date").hide();
       $("#search_date").change(function(){
           let search_date = $(this).val();
           if(search_date=='Custom Range')
            {
               $("#form_date").show();
               $("#to_date").show();
            }
            else
            {
                $("#form_date").hide();
                $("#to_date").hide();
            }
       });
    });
</script>