<?php
    if(isset($_GET['warehouse_id']))
    {
        
        $warehouse_id = $_GET['warehouse_id'];
        include('menu/header.php');
        include('menu/navbar.php');
        $query = new query();
        
        
        $cond =array("id"=>$warehouse_id);
        $get_warehouse = $query->getData("*","warehouses","",$cond,"","","")[0];
    
    
        if(isset($_POST['edit_warehouse']))
        {
            extract($_POST);
            
            $table='warehouses';
            date_default_timezone_set('Asia/Calcutta'); 
            $create_date = date('d-m-Y');
            if($return_address_same=='Y')
            {
                $r_address= $address;
                $r_pin=$pin;
                $r_city = $city;
                $r_state = $state;
            }
            $condition = array("type"=>'branches',"type_id"=>$user_id,"warehouse_name"=>$name,"pincode"=>$pin,"city"=>$city,"state"=>$state,"country"=>$country,"address"=>$address,"contact_person"=>$contact_person,"email"=>$email,"phone_number"=>$phone_number,"same_return_address"=>$return_address_same,"r_address"=>$r_address,"r_pin"=>$r_pin,"r_city"=>$r_city,"r_state"=>$r_state,"r_country"=>$r_country,"pickup_slots"=>$pickup_slots,"created_date"=>$create_date);
            
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
                        curl_setopt($sb, CURLOPT_URL, "https://track.delhivery.com/api/backend/clientwarehouse/edit/");
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
                            // echo'<pre>';print_r($response_array);
                            if ($success == 1) {
                                $successCount++;
                                
                            } else {
                                echo "<script>displayErrorMessage('$error_message');</script>";
                            }
                        }
                    }
                }
                
                if ($successCount == count($get_3pl)) {
                    $update = $query->updateData($table,$condition,'id',$warehouse_id);
                    if ($update) {
                        echo "<script>displaySuccessMessage(Warehouse updated successfully!!);window.location='manage_warehouses';</script>";
                    } 
                    else {
                        echo "<script>displayErrorMessage('Warehouse updation  failed!!');window.location='manage_warehouses';</script>";
                    }
                }
            }
            else
            {
                $cond =array("id"=>$cft);
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
                    curl_setopt($sb, CURLOPT_URL, "https://track.delhivery.com/api/backend/clientwarehouse/edit/");
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
                        // echo'<pre>';print_r($response_array);
                        if ($success == 1) {
                            $update = $query->updateData($table,$condition,'id',$warehouse_id);
                            if ($update) {
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
                
                <div class="card-body">
                    <form action"edit_warehouse" method="POST" onsubmit="return checkPincode()">
                        <div class="modal-body">
                            <div class="row mb-2">
                                <div class="col-md-8 col-12">
                                    <input type="hidden" name="cft" id="cft" value="<?= $get_warehouse['cft']; ?>">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter pickup point name" value="<?= $get_warehouse['warehouse_name']; ?>" readonly>
                                </div>
                                <div class="col-md-4 col-12">
                                    <label for="pincode" class="form-label">PIN Code <span class="text-danger">*</span></label>
                                    <input type="text" id="pin" name="pin" class="form-control" placeholder="Enter Pincode" maxlength="6" value="<?= $get_warehouse['pincode']; ?>" required>
                                    <input type="hidden" value="<?= $user_id; ?>" id="type_id">
                                    <span class="text-danger" id="pin_alert"></span>
                                    <span class="text-success" id="pin_succ"></span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                    <input type="text" id="address"  name="address" class="form-control" placeholder="Enter pickup point address" value="<?= $get_warehouse['address']; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4 col-12">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" id="city" name="city" class="form-control" placeholder="Enter City"  value="<?= $get_warehouse['city']; ?>" >
                                </div>
                                <div class="col-md-4 col-12">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" id="state" name="state" class="form-control" placeholder="Enter State" value="<?= $get_warehouse['state']; ?>">
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
                                    <input type="text" id="contact_person" name="contact_person" class="form-control" placeholder="Enter Name" value="<?= $get_warehouse['contact_person']; ?>">
                                </div>
                                <div class="col-md-4 col-12">
                                    <label for="state" class="form-label">Email</label>
                                    <input type="text" id="email" name="email" class="form-control" placeholder="Enter Email" value="<?= $get_warehouse['email']; ?>">
                                </div>
                                <div class="col-md-4 col-12">
                                    <label for="country" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    
                                    <div class="input-group">
                                      <span class="input-group-text" id="basic-addon11">+91</span>
                                      <input type="text" id="phone_number" class="form-control" name="phone_number" placeholder="9876543210" maxlength="10" value="<?= $get_warehouse['phone_number']; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <?php
                                    if($get_warehouse['same_return_address']=='Y')
                                    {
                                        ?>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="return_address_same" checked>
                                                <input  type="hidden" id="return_address_same_hidden" name="return_address_same" value="Y">
                                                <label class="form-check-label" for="return_address_same">Return address same as pickup address</label>
                                            </div>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="return_address_same" >
                                                <input  type="hidden" id="return_address_same_hidden" name="return_address_same" value="N">
                                                <label class="form-check-label" for="return_address_same">Return address same as pickup address</label>
                                            </div>
                                        <?php
                                        
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-8 col-12">
                                    <label for="return_address" class="form-label">Return Address <span class="text-danger">*</span></label>
                                    <input type="text" id="r_address" name="r_address" class="form-control" placeholder="Enter return address"  value="<?= $get_warehouse['r_address']; ?>"  required>
                                </div>
                                <div class="col-md-4 col-12">
                                    <label for="return_pincode" class="form-label">Return Pincode <span class="text-danger">*</span></label>
                                    <input type="text" id="r_pin" name="r_pin" class="form-control" placeholder="Enter Pincode" value="<?= $get_warehouse['r_pin']; ?>"  required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 col-12">
                                    <label for="return_city" class="form-label">Return City</label>
                                    <input type="text" id="r_city" name="r_city" class="form-control" placeholder="Enter City"  value="<?= $get_warehouse['r_city']; ?>">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label for="return_state" class="form-label">Return State</label>
                                    <input type="text" id="r_state" name="r_state" class="form-control" placeholder="Enter State"   value="<?= $get_warehouse['r_state']; ?>">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 col-12">
                                    <label for="return_country" class="form-label">Return Country</label>
                                    <input type="text" id="r_country" name="r_country" class="form-control" placeholder="Enter Country" value="India" readonly>
                                </div>
                                <div class="col-md-6 ">
                                    <label for="pickup_slots" class="form-label">Preferred Pickup Slot</label>
                                    <select class="form-control" id="pickup_slots" name="pickup_slots">
                                        <option value="">Select Pickup Slot</option>
                                        <option value="01:00 Pm - 04:00 Pm" <?php if($get_warehouse['pickup_slots']=='01:00 Pm - 04:00 Pm'){echo'selected';} ?>>01:00 Pm - 04:00 Pm</option>
                                        <option value="04:00 Pm - 07:00 Pm" <?php if($get_warehouse['pickup_slots']=='04:00 Pm - 07:00 Pm'){echo'selected';} ?>>04:00 Pm - 07:00 Pm</option>
                                        <option value="07:00 Pm - 10:00 Pm" <?php if($get_warehouse['pickup_slots']=='07:00 Pm - 10:00 Pm'){echo'selected';} ?>>07:00 Pm - 10:00 Pm</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-info" name="edit_warehouse">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--/ Responsive Table -->
        </div>
    </div>
    <?php
    }
    include('menu/footer.php');
?>
    
    <script>
        function checkPincode()
        {
            let pin = $("#pin").val();
            let type = 'branches';
            let type_id = $("#type_id").val();
            let cft = $("#cft").val();
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
                                pin: pin,
                                type: type,
                                type_id: type_id,
                            },
                            beforeSend: function(){
                                $("body").css('opacity','0.3');
                            },
                            complete: function(){
                                $("body").css('opacity','1');
                            },
                            success: function(data) {
                                if(data=='no_ware'){
                                    $('#pin_succ').text('This pincode is pickupable');
                                    $('button[name="edit_warehouse"]').prop('disabled', false);
                                }
                                else{
                                    
                                    showWarning('Warehouse already exist on this pincode!!');
                                    $('button[name="edit_warehouse"]').prop('disabled', true);
                                    $('#pin_succ').text('');
                                    return false;
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
                        $('button[name="edit_warehouse"]').prop('disabled', true);
                        return false;
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + status + " - " + error);
                }
            });
           
        }
    </script>
    <script>
        $(document).ready(function() {
           $(".form_date").hide();
           $(".to_date").hide();
           $("#search_date").change(function(){
               let search_date = $(this).val();
               if(search_date=='Custom Range')
                {
                    $(".form_date").show();
                    $(".to_date").show();
                }
                else
                {
                    $(".form_date").hide();
                    $(".to_date").hide();
                }
           });
        });
    
    </script>
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
                    displaySuccessMessage("<?php echo addslashes($error_message); ?>");
                <?php else: ?>
                    displayErrorMessage("<?php echo addslashes($error_message); ?>");
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
    
    