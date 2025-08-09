<?php
    if(!empty($_GET) && array_key_exists('page', $_GET)){
        $page = $_GET['page'];
    }
    include('menu/header.php');
    include('menu/navbar.php');
    
    if(isset($_GET['warehouse_name']))
    {
        extract($_GET);
        if(!empty($warehouse_name))
        {
            
           $cond_index = array(array("type","=","users"),array("type_id","=",$user_id),array("warehouse_name","LIKE",$warehouse_name));
        }
        else
        {
            $cond_index = array("type"=>'users',"type_id"=>$user_id);
        }
        
    }
    else
    {
        $cond_index = array("type"=>'users',"type_id"=>$user_id);
    }
    
    
    if(isset($_POST['create_warehouse']))
    {
       
        // print_r($_POST);
        extract($_POST);
        
        $name = $newfunc->real_string($name);
        $table='warehouses';
        date_default_timezone_set('Asia/Calcutta'); 
        $create_date = date('Y-m-d');
        if(!empty($working_days)){
            $working_days  = implode(",", $working_days);
        }
        $condition = array("type"=>'users',"type_id"=>$user_id,"warehouse_name"=>$name,"pincode"=>$pin,"city"=>$city,"state"=>$state,"country"=>$country,"address"=>$address,"contact_person"=>$contact_person,"email"=>$email,"phone_number"=>$phone_number,"same_return_address"=>$return_address_same,"r_address"=>$r_address,"r_pin"=>$r_pin,"r_city"=>$r_city,"r_state"=>$r_state,"r_country"=>$r_country,"working_days"=>$working_days,"pickup_slots"=>$pickup_slots,"created_date"=>$create_date,"cft"=>$cft);
        
        if($cft == 'all')
        {
            $cond = '';
            $get_3pl = $query->getData("*","3pls","",$cond,"","","");
            $successCount = 0;
            foreach($get_3pl as $threepl)
            {
                $registered_name = $threepl['registered_name'];
                $token = $threepl['api_token'];
                $cftpassword = $threepl['password'];
                
                $loginFields = array(
                "username" => $registered_name,
                "password" => $cftpassword
                );
                $cs = curl_init();
                curl_setopt($cs, CURLOPT_URL, "https://btob.api.delhivery.com/ums/login/");
                curl_setopt($cs, CURLOPT_POSTFIELDS, json_encode($loginFields));
                curl_setopt($cs, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($cs, CURLOPT_HTTPHEADER, array(
                  "accept: application/json",
                  "cache-control: no-cache",
                  "content-type: application/json"
                ));
                $response = curl_exec($cs);
                $error = curl_error($cs);
                curl_close($cs);
                if($error){
                  echo $error;
                }
                else{
                    $jwtToken = json_decode($response)->jwt;
                    $fields = array(
                      "phone" => $phone_number,
                      "city" => $city,
                      "name" => $name,
                      "pin" => $pin,
                      "address" => $address,
                      "country" => $country,
                      "email" => $email,
                      "registered_name" => $registered_name,
                      "return_address" => $r_address,
                      "return_pin" => $r_pin,
                      "return_city" => $r_city,
                      "return_state" => $r_state,
                      "return_country" => $r_country
                    );
                    $sb = curl_init();
                    curl_setopt($sb, CURLOPT_URL, "https://track.delhivery.com/api/backend/clientwarehouse/create/");
                    curl_setopt($sb, CURLOPT_POSTFIELDS, json_encode($fields));
                    curl_setopt($sb, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($sb, CURLOPT_HTTPHEADER, array(
                      "Authorization: Bearer $jwtToken",
                      "accept: application/json",
                      "cache-control: no-cache",
                      "content-type: application/json"
                    ));
                    $response = curl_exec($sb);
                    $error = curl_error($sb);
                    curl_close($sb);
                    if($error){
                      echo $error;
                    }
                    else{
                        $response_array = json_decode($response, true);
                        $error_message = isset($response_array['data']['message']) ? $response_array['data']['message'] : "";
                        $success = isset($response_array['success']) ? $response_array['success'] : '';
                        
                        if ($success == 1) {
                            $successCount++;
                        } 
                        else {
                            echo "<script>displayErrorMessage('$error_message');</script>";
                        }
                    }
                }
            }
            
            if ($successCount == count($get_3pl)) {
                $insert = $query->insertData($table, $condition);
                if ($insert) {
                    echo "<script>displaySuccessMessage('Warehouse created successfully');</script>";
                } else {
                    echo "<script>displayErrorMessage('Warehouse creation  failed!!');</script>";
                }
            }
        }
        else
        {
            $cond = array("id"=>$cft);
            $get_3pl = $query->getData("*","3pls","",$cond,"","","")[0];
            
            $registered_name = $get_3pl['registered_name'];
            $token = $get_3pl['api_token'];
            $cftpassword = $get_3pl['password'];
        
            $loginFields = array(
                "username" => $registered_name,
                "password" => $cftpassword
            );
            $cs = curl_init();
            curl_setopt($cs, CURLOPT_URL, "https://btob.api.delhivery.com/ums/login/");
            curl_setopt($cs, CURLOPT_POSTFIELDS, json_encode($loginFields));
            curl_setopt($cs, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cs, CURLOPT_HTTPHEADER, array(
              "accept: application/json",
              "cache-control: no-cache",
              "content-type: application/json"
            ));
            $response = curl_exec($cs);
            $error = curl_error($cs);
            curl_close($cs);
            if($error){
              echo $error;
            }
            else{
                $jwtToken = json_decode($response)->jwt;
                $fields = array(
                  "phone" => $phone_number,
                  "city" => $city,
                  "name" => $name,
                  "pin" => $pin,
                  "address" => $address,
                  "country" => $country,
                  "email" => $email,
                  "registered_name" => $registered_name,
                  "return_address" => $r_address,
                  "return_pin" => $r_pin,
                  "return_city" => $r_city,
                  "return_state" => $r_state,
                  "return_country" => $r_country
                );
                $sb = curl_init();
                curl_setopt($sb, CURLOPT_URL, "https://track.delhivery.com/api/backend/clientwarehouse/create/");
                curl_setopt($sb, CURLOPT_POSTFIELDS, json_encode($fields));
                curl_setopt($sb, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($sb, CURLOPT_HTTPHEADER, array(
                  "Authorization: Bearer $jwtToken",
                  "accept: application/json",
                  "cache-control: no-cache",
                  "content-type: application/json"
                ));
                $response = curl_exec($sb);
                $error = curl_error($sb);
                curl_close($sb);
                if($error){
                  echo $error;
                }
                else{
                    $response_array = json_decode($response, true);
                    $error_message = isset($response_array['data']['message']) ? $response_array['data']['message'] : "";
                    $success = isset($response_array['success']) ? $response_array['success'] : '';
                    
                    if ($success == 1) {
                        $insert = $query->insertData($table, $condition);
                        
                        if ($insert) {
                            echo "<script>displaySuccessMessage('$error_message');</script>";
                        }
                    } else {
                        echo "<script>displayErrorMessage('$error_message');</script>";
                    }
                }
            }
        }
    }    
        
?>
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-dark fw-bold">Manage Warehouses</span></h4>
            <!-- Responsive Table -->
            <div class="card">
                <div class="card-header">
                    <div class="row mb-3">
                        <div class="col-12 mb-3 d-flex justify-content-end">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#largeModal">Add Warehouse</button>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="largeModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel1">Add Warehouse</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action"manage_warehouses" method="POST">
                                        <div class="modal-body">
                                            <div class="row mb-2">
                                                <div class="col-md-12 col-12">
                                                    <?php
                                                    if($get_user_details[0]['threepl']=='all')
                                                    {
                                                        ?><input type="hidden" id="cft" name="cft" class="form-control" value="all"><?php
                                                    }
                                                    else
                                                    {
                                                        $condit =array("users`.`id"=>$user_id);
                                                        $join= array('0'=>array('LEFT','3pls','3pls','id','users','threepl'));
                                                        $get_3pl = $query->getData("*","users",$join,$condit,"","","1")[0];
                                                        ?><input type="hidden" id="cft" name="cft" class="form-control" value="<?= $get_3pl['id']; ?>"  ><?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-md-8 col-12">
                                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter pickup point name" required>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <label for="pincode" class="form-label">PIN Code <span class="text-danger">*</span></label>
                                                    <input type="text" id="pin" name="pin" class="form-control" placeholder="Enter Pincode" maxlength="6" required>
                                                    <input type="hidden" value="<?= $user_id; ?>" id="type_id">
                                                    <span class="text-danger" id="pin_alert"></span>
                                                    <span class="text-success" id="pin_succ"></span>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-12">
                                                    <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                                    <input type="text" id="address"  name="address" class="form-control" placeholder="Enter pickup point address" required>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-4 col-12">
                                                    <label for="city" class="form-label">City</label>
                                                    <input type="text" id="city" name="city" class="form-control" placeholder="Enter City">
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <label for="state" class="form-label">State</label>
                                                    <input type="text" id="state" name="state" class="form-control" placeholder="Enter State">
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <label for="country" class="form-label">Country</label>
                                                    <input type="text" id="country" name="country" class="form-control" placeholder="Enter Country" value="India" readonly>
                                                </div>
                                            </div>
                                            
                                            <hr>
                                            <div class="row mb-2">
                                                <div class="col-md-4 col-12">
                                                    <label for="city" class="form-label">Contact Person</label>
                                                    <input type="text" id="contact_person" name="contact_person" class="form-control" placeholder="Enter Name">
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <label for="state" class="form-label">Email</label>
                                                    <input type="text" id="email" name="email" class="form-control" placeholder="Enter Email">
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <label for="country" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                                    
                                                    <div class="input-group">
                                                      <span class="input-group-text" id="basic-addon11">+91</span>
                                                      <input type="text" id="phone_number" class="form-control" name="phone_number" placeholder="9876543210" maxlength="10" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row mb-2">
                                                <div class="col-12">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="return_address_same" >
                                                        <input  type="hidden" id="return_address_same_hidden" name="return_address_same" value="N">
                                                        <label class="form-check-label" for="return_address_same">Return address same as pickup address</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-8 col-12">
                                                    <label for="return_address" class="form-label">Return Address <span class="text-danger">*</span></label>
                                                    <input type="text" id="r_address" name="r_address" class="form-control" placeholder="Enter return address" required>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <label for="return_pincode" class="form-label">Return Pincode <span class="text-danger">*</span></label>
                                                    <input type="text" id="r_pin" name="r_pin" class="form-control" placeholder="Enter Pincode" required>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-4 col-12">
                                                    <label for="return_city" class="form-label">Return City</label>
                                                    <input type="text" id="r_city" name="r_city" class="form-control" placeholder="Enter City">
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <label for="return_state" class="form-label">Return State</label>
                                                    <input type="text" id="r_state" name="r_state" class="form-control" placeholder="Enter State">
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <label for="return_country" class="form-label">Return Country</label>
                                                    <input type="text" id="r_country" name="r_country" class="form-control" placeholder="Enter Country" value="India" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <!--<div class="form-group col-md-6">-->
                                                <!--    <label for="timepicker-basic" class="form-label">Form</label>-->
                                                <!--    <input type="text" id="timepicker-basic" placeholder="Form" class="form-control" />-->
                                                <!--</div>-->
                                                <!--<div class="form-group col-md-6">-->
                                                <!--    <label for="timepicker-basic1" class="form-label">To</label>-->
                                                <!--    <input type="text" id="timepicker-basic1" placeholder="To" class="form-control" />-->
                                                <!--</div>-->
                                                <div class="col-md-6">
                                                    <label for="select2Multiple" class="form-label">Days</label>
                                                    <select id="select2Multiple" id="working_days" name="working_days[]" class="select2 form-select" multiple>
                                                        <option value="Monday">Monday</option>
                                                        <option value="Tuesday">Tuesday</option>
                                                        <option value="Wednesday">Wednesday</option>
                                                        <option value="Thursday">Thursday</option>
                                                        <option value="Friday">Friday</option>
                                                        <option value="Saturday">Saturday</option>
                                                        <option value="Sunday">Sunday</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 ">
                                                    <label for="pickup_slots" class="form-label">Preferred Pickup Slot</label>
                                                    <select class="form-control" id="pickup_slots" name="pickup_slots">
                                                        <option value="">Select Pickup Slot</option>
                                                        <option value="01:00 Pm - 04:00 Pm">01:00 Pm - 04:00 Pm</option>
                                                        <option value="04:00 Pm - 07:00 Pm">04:00 Pm - 07:00 Pm</option>
                                                        <option value="07:00 Pm - 10:00 Pm">07:00 Pm - 10:00 Pm</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-primary" name="create_warehouse">Submit</button>
                                        </div>
                                    </form>
                                  </div>
                                </div>
                            </div>
                            
                        </div>
                        
                        <form action="manage_warehouses" method="GET">
                            <div class="row">
                                <div class="col-md-5 mb-2">
                                    <input type="text" class="form-control" name="warehouse_name" placeholder="Search by Warehouse name">
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-outline-primary" type="submit" >Search</button>
                                </div>
                            </div>
                        </form>
                        
                    </div>   
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr class="text-nowrap">
                                    <th class="text-center">Name</th> 
                                    <th class="text-center">City</th>
                                    <th class="text-center">Contact Person</th>
                                    <th class="text-center">Contact Email</th>
                                    <th class="text-center">Create Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="warehouse_td">
                                <?php
                                    $sl = 1;
                                    const dataShow = 25;
                                    if(empty($page)){
                                        $page = 1;
                                    }else{
                                        $page = $page;
                                    }
                                    $offset = ($page - 1) * dataShow;
                                    $limit = $offset.','.dataShow;
                                    $getwarhouse = $query->getData("*","warehouses","",$cond_index,"id","DESC",$limit);
                                    $WareHouseCount = $query->getData("COUNT(`id`) as 'WareHouseCount'","warehouses","",$cond_index,"id","DESC","")[0]['WareHouseCount'];
                                    if($getwarhouse!=0)
                                    {
                                        foreach($getwarhouse as $warehouse)
                                        {
                                ?>
                                            <tr>
                                                <td class="text-center"><?= $warehouse['warehouse_name']; ?></td>
                                                <td class="text-center"><?= $warehouse['city']; ?></td>
                                                <td class="text-center"><?= $warehouse['contact_person']; ?></td>
                                                <td class="text-center"><?= $warehouse['email']; ?></td>
                                                <td class="text-center"><?= $warehouse['created_date']; ?></td>
                                                <td class="text-center"><?php if($warehouse['status']=='Unblock'){echo'<span class="badge bg-success">Active</span>';}else{echo'<span class="badge bg-danger">Deactive</span>';}  ?></td>
                                                <td class="text-center"><button class="btn btn-warning" onclick="editWarehouse('<?= $warehouse['id']; ?>')" <?php if($warehouse['status']=='Block'){echo'disabled';} ?>><i class="fas fa-edit"></i></button></td>
                                            </tr>
                                <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                        $pageCount = ceil($WareHouseCount/dataShow);
                        if($WareHouseCount != 0){
                            foreach($_GET as $getKey => $getVal){
                                if($getKey != "page"){
                                    $GetArr = $GetArr.$getKey."=".$getVal."&";
                                }
                            }
                    ?>
                        <ul class='newpagination d-flex justify-content-end'>
                            <li><a href='<?php if($page != 1){ echo CurrentPageURL."?".$GetArr."page=1"; }else{ echo 'javascript:void(0)'; } ?>'><i class='fa-solid fas fa-angle-double-left'></i></a></li>
                            <li><a href='<?php if($page != 1){ echo CurrentPageURL."?".$GetArr."page=".($page-1); }else{ echo 'javascript:void(0)'; } ?>'>Prev</a></li>
                    <?php
                        for($i = 1; $i <= $pageCount; $i++):
                            if($page <= 5 && $pageCount > 7){
                                for($i = 1; $i <= 5; $i++):
                    ?>
                                    <li><a href="<?= CurrentPageURL."?".$GetArr."page=".$i; ?>" class="<?php if($page == $i){ echo 'active'; } ?>"><?= $i; ?></a></li>
                    <?php
                                endfor;
                    ?>
                                    <span class="ellipsis dot">…</span>
                                    <li><a href="<?= CurrentPageURL."?".$GetArr."page=".$pageCount; ?>"><?= $pageCount; ?></a></li>
                    <?php
                                break;
                            }elseif($page > 5 && $page <= $pageCount-5 && $pageCount > 7){
                    ?>
                                <li><a href="<?= CurrentPageURL."?".$GetArr."page=1"; ?>">1</a></li>
                                <span class="ellipsis dot">…</span>
                    <?php
                                for($j = $page-2; $j <= $page+2; $j++):
                    ?>
                                <li><a href="<?= CurrentPageURL."?".$GetArr."page=".$j; ?>" class="<?php if($page == $j){ echo 'active'; } ?>"><?= $j; ?></a></li>
                    <?php
                                endfor;
                    ?>
                                <span class="ellipsis dot">…</span>
                                <li><a href="<?= CurrentPageURL."?".$GetArr."page=".$pageCount; ?>"><?= $pageCount; ?></a></li>
                    <?php
                                break;
                            }elseif($page > $pageCount-5 && $pageCount > 7){
                    ?>
                                <li><a href="<?= CurrentPageURL."?".$GetArr."page=1"; ?>">1</a></li>
                                <span class="ellipsis dot">…</span>
                    <?php
                                for($k = $pageCount-4; $k <= $pageCount; $k++):
                    ?>
                                    <li><a href="<?= CurrentPageURL."?".$GetArr."page=".$k; ?>" class="<?php if($page == $k){ echo 'active'; } ?>"><?= $k; ?></a></li>
                    <?php
                                endfor;
                                break;
                            }else{
                                for($l = 1; $l <= $pageCount; $l++):
                    ?>
                                    <li><a href="<?= CurrentPageURL."?".$GetArr."page=".$l; ?>" class="<?php if($page == $l){ echo 'active'; } ?>"><?= $l; ?></a></li>
                    <?php
                                endfor;
                                break;
                            }
                        endfor;
                    ?>
                            <li><a href='<?php if($page != $pageCount){ echo CurrentPageURL."?".$GetArr."page=".($page + 1); }else{ echo 'javascript:void(0)'; } ?>'>Next</a></li>
                            <li><a href='<?php if($page != $pageCount){ echo CurrentPageURL."?".$GetArr."page=".$pageCount; }else{ echo 'javascript:void(0)'; } ?>'><i class='fa-solid fas fa-angle-double-right'></i></a></li>
                        </ul>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <!--/ Responsive Table -->
        </div>
    </div>
<?php
    include('menu/footer.php');
?>


<script>
    $(document).ready(function() {
        $('#return_address_same').change(function() {
            if ($(this).prop('checked')) {
                $('#r_pin').val($('#pin').val());
                $('#r_state').val($('#state').val());
                $('#r_address').val($('#address').val());
                $('#r_city').val($('#city').val());
                $('#return_address_same_hidden').val('Y');
            } else {
                $('#r_pin').val('');
                $('#r_state').val('');
                $('#r_address').val('');
                $('#r_city').val('');
                $('#return_address_same_hidden').val('N');
            }
        });
    });
</script>
<script>
    function validatePhoneNumberKey(event) {
        var charCode = event.which || event.keyCode;

        if ((charCode >= 48 && charCode <= 57) || // Digits
            charCode === 8 || // Backspace
            charCode === 9 || // Tab
            charCode === 46 || // Delete
            charCode === 37 || // Left arrow
            charCode === 39) { // Right arrow
            return true;
        } else {
            event.preventDefault();
            return false;
        }
    }
    document.getElementById("pin").addEventListener("keydown", validatePhoneNumberKey);
    document.getElementById("phone_number").addEventListener("keydown", validatePhoneNumberKey);
</script>
    <script>
        // Function to display error message with SweetAlert
        function displayErrorMessage(error_message) {
            swal({
                title: "Error!",
                text: error_message,
                type: "error",
                icon: "error"
            }).then(function() {
                window.location.href = 'manage_warehouses'; // Redirect after clicking OK
            });
        }
    
        // Function to display success message with SweetAlert
        function displaySuccessMessage(message) {
            swal({
                title: "Success!",
                text: message,
                type: "success",
                icon: "success"
            }).then(function() {
                window.location.href = 'manage_warehouses'; // Redirect after clicking OK
            });
        }
    
        // Call the function only if the error or success message is not empty
        window.onload = function() {
            <?php if (!empty($error_message)): ?>
                <?php if ($success == 1): ?>
                    displaySuccessMessage("<?php echo $error_message; ?>");
                <?php else: ?>
                    displayErrorMessage("<?php echo $error_message; ?>");
                <?php endif; ?>
            <?php endif; ?>
        };
    </script>
    
    <script>
        $(document).ready(function() {
            function showWarning(message) {
                swal("Warning!", message, "warning");
            }
        
            $('#pin').blur(function() {
                let pin = $(this).val();
                let type = 'users';
                let type_id = $("#type_id").val();
                let cft = $("#cft").val();
                let name = $("#name").val();
                if(name !=='') 
                {
                    $.ajax({
                        url: "action.php",
                        type: "POST",
                        data: {
                            pin_w: pin,
                            type_w: type,
                            type_id_w: type_id,
                            cft: cft
                        },
                        success: function(data) {
                            if (data == 'Y') {
                                $.ajax({
                                    url: "action.php",
                                    type: "POST",
                                    data: {
                                        w_name: name,
                                        w_pin: pin,
                                        w_type: type,
                                        w_type_id: type_id,
                                    },
                                    beforeSend: function(){
                                        $("body").css('opacity','0.3');
                                    },
                                    complete: function(){
                                        $("body").css('opacity','1');
                                    },
                                    success: function(data) {
                                        if(data==1){
                                            showWarning('Warehouse name is already exists!!');
                                            $('button[name="create_warehouse"]').prop('disabled', true);
                                            $('#pin_succ').text('');
                                            return false;
                                        }
                                        else{
                                            $('#pin_succ').text('This pincode is pickupable');
                                            $('button[name="create_warehouse"]').prop('disabled', false);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error("Error: " + status + " - " + error);
                                    }
                                });
                                $('#pin_alert').text('');
                                $(this).css('border-color', '');
                            } 
                            else if(data == 'N'){
                                $('#pin_alert').text('This pincode is not pickupable');
                                $('#pin_succ').text('');
                                $(this).css('border-color', 'red');
                                $('button[name="create_warehouse"]').prop('disabled', true);
                                return false;
                            }else if(data == 'NTR'){
                                $('#pin_alert').text('System can\'t take the request right now! Please! Try again later');
                                $('#pin_succ').text('');
                                $(this).css('border-color', 'red');
                                $('button[name="create_warehouse"]').prop('disabled', true);
                                return false;
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error: " + status + " - " + error);
                        }
                    });
                }
                else
                {
                    showWarning('Please enter name');
                }
            });
        });
    </script>
    
    <script>
        function editWarehouse(id) {
            let warehouse_id = id;
           
            window.location.href = "edit_warehouse.php?warehouse_id="+warehouse_id;
               
        }
    </script>