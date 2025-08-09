<?php
include('menu/header.php');
include('menu/navbar.php');

$query = new query();

    if(isset($_POST['t_sbm']))
    {
        $getTicket = $query->getData('*','tickets','','','id','DESC','1');
      	if($getTicket != 0){
            $ticket_code = "TICKET".(str_replace("TICKET","",$getTicket[0]['ticket_code'])+1);
        }else{
            $ticket_code = 'TICKET100000';
        }
        extract($_POST);
        $remarks = str_replace("'", "\'", $remarks);
        $table='tickets';
        date_default_timezone_set('Asia/Calcutta'); 
        $create_date = date('d-m-Y H:i:s');
        $condition = array("ticket_code"=>$ticket_code,"type"=>'users',"type_id"=>$user_id,"email"=>$email,"ticket_category"=>$ticket_category,"ticket_sub_category"=>$ticket_sub_category,"remarks"=>$remarks,"created_on"=>$create_date,"last_update"=>$create_date);
        $insert = $query->insertData($table,$condition);
        
    }
?>


        <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-dark fw-bold">Tickets</span></h4>
            <!-- Responsive Table -->
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#basicModal">Raise New Tickets</button>
                            <!-- Modal -->
                            <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="ticket" method="POST">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel1">Raise a ticket</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-12 mb-3">
                                                        <label for="emailBasic" class="form-label">Email</label>
                                                        <input type="email" id="emailBasic" class="form-control" name="email" placeholder="xxxx@xxx.xx" required>
                                                    </div>
                                                    <div class="col-12 mb-3">
                                                        <label for="category" class="form-label">Category</label>
                                                        <select class="form-control" name="ticket_category" id="ticket_category" required>
                                                            <option value="">Choose Category</option>
                                                            <?php
                                                            $cond = array("delete_status"=>'show');
                                                            $getTicketcat = $query->getData("*","ticket_category","",$cond,"","","");
                                                            if($getTicketcat!=0)
                                                            {
                                                                $data_count = count($getTicketcat);
                                                                for($i=0;$i<$data_count;$i++)
                                                                {
                                                                    ?><option value="<?= $getTicketcat[$i]['id'] ?>"><?= $getTicketcat[$i]['category'] ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 mb-3">
                                                        <label for="category" class="form-label">Sub Category</label>
                                                        <select class="form-control" name="ticket_sub_category" id="ticket_sub_category" required>
                                                            <option value="">Choose Category First</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 mb-3">
                                                        <label for="remarks" class="form-label">Remarks</label>
                                                        <input class="form-control" name="remarks" id="remarks" required></select>
                                                        <input type="hidden" value="<?= $user_id; ?>" id="type_id">
                                                        <input type="hidden" value="users" id="type">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                              <button type="submit" name="t_sbm" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<div class="col-md-3 mb-2">-->
                        <!--    <input type="text" class="form-control" placeholder="Search by Ticket id">-->
                        <!--</div>-->
                        <!--<div class="col-md-6 mb-2">-->
                        <!--    <input type="text" class="form-control" placeholder="Search by AWBn/LRn">-->
                        <!--</div>-->
                        <!--<div class="col-md-1">-->
                        <!--    <button class="btn btn-outline-primary" type="submit">Search</button>-->
                        <!--</div>-->
                    </div>   
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills card-header-pills" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" role="tab" id="Open">Open</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" role="tab" id="Resolved">Resolved</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" role="tab" id="Closed">Closed</button>
                        </li>
                    </ul>
                    
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr class="text-nowrap">
                                    <th class="text-center" >Ticket ID & LR</th>
                                    <th class="text-center" >CATEGORY & SUB-CATEGORY</th>
                                    <th class="text-center" >TICKET CREATED ON</th>
                                    <th class="text-center" >LAST UPDATE</th>
                                    <th class="text-center" >STATUS</th>
                                    <th class="text-center" >ACTION</th>
                                </tr>
                            </thead>
                            <tbody id="table_show">
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
    $(document).ready(function(){
        let data = 'Open';
        let type = $("#type").val();
        let type_id = $("#type_id").val();
        $.ajax({
            url: "action.php", 
            type: "POST", 
            data: { data: data,
                    type:type,
                    type_id:type_id,
                  }, 
            success: function(data) {
                $("#table_show").html(data);
                $("#Open").addClass('active');
            },
            error: function(xhr, status, error) {
                console.error("Error: " + status + " - " + error);
            }
        });
            
        
        $("#ticket_category").on("change", function() {
        let ticket_category = $(this).val();
            $.ajax({
                url: "action.php", 
                type: "POST", 
                data: { ticket_category: ticket_category }, 
                success: function(data) {
                    $("#ticket_sub_category").html(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + status + " - " + error);
                }
            });
        });
        
        $("#Open").on("click", function() {
        let data = 'Open';
        let type = $("#type").val();
        let type_id = $("#type_id").val();
            $.ajax({
                url: "action.php", 
                type: "POST", 
                data: { data: data,
                        type:type,
                        type_id:type_id,
                      },  
                success: function(data) {
                    $("#table_show").html(data);
                    $("#Open").addClass('active');
                    $("#Resolved").removeClass('active');
                     $("#Closed").removeClass('active');
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + status + " - " + error);
                }
            });
        });
        $("#Resolved").on("click", function() {
        let data = 'Resolved';
        let type = $("#type").val();
        let type_id = $("#type_id").val();
            $.ajax({
                url: "action.php", 
                type: "POST", 
                data: { data: data,
                        type:type,
                        type_id:type_id,
                      }, 
                success: function(data) {
                    $("#table_show").html(data);
                    $("#Open").removeClass('active');
                    $("#Resolved").addClass('active');
                    $("#Closed").removeClass('active');
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + status + " - " + error);
                }
            });
        });
        $("#Closed").on("click", function() {
        let data = 'Closed';
        let type = $("#type").val();
        let type_id = $("#type_id").val();
            $.ajax({
                url: "action.php", 
                type: "POST", 
                data: { data: data,
                        type:type,
                        type_id:type_id,
                      }, 
                success: function(data) {
                    $("#table_show").html(data);
                    $("#Open").removeClass('active');
                    $("#Resolved").removeClass('active');
                    $("#Closed").addClass('active');
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + status + " - " + error);
                }
            });
        });
    });
</script>

<script>
    // Function to display error message with SweetAlert
    function displayErrorMessage(error_message) {
        swal("Error!", error_message, "error");
    }

    // Function to display success message with SweetAlert
    function displaySuccessMessage(message) {
        swal("Success!", message, "success");
    }
    <?php if (isset($_POST['t_sbm'])): ?>
        <?php if ($insert): ?>
            displaySuccessMessage("Ticket Raised Successfully");
        <?php else: ?>
            displayErrorMessage("Something went wrong! Please contact the administrator.");
        <?php endif; ?>
    <?php endif; ?>
</script>