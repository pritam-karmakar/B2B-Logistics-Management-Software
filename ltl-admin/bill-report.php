<?php
if(!empty($_GET) && !array_key_exists('visible', $_GET) && count($_GET) <= 1){
    echo '<script type="text/javascript" language="javascript">window.location="bill-report?visible=users";</script>';
}else{
    extract($_GET);
}
include("assets/header.php");
include("assets/sidebar.php");
?>

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
	<div class="container-fluid">
	    <form action="bill-report" method="GET" class="row mb-3">
	        <div class="col-xl-3 col-sm-6 form-group">
	            <label>Choose user type</label>
	            <select class="form-control form-control-sm" name="visible" id="visibleType" readonly>
	                <option value="" hidden>Choose user type</option>
	                <option value="users" <?php if($visible == "users"){ echo 'selected'; } ?>>User</option>
	                <option value="branches" <?php if($visible == "branches"){ echo 'selected'; } ?>>Branch</option>
	            </select>
			</div>
	        <div class="col-xl-4 col-sm-6 form-group">
	            <label>Choose One</label>
	            <select class="form-control form-control-sm" id="single-select" name="orderUsersorBranches">
	                <option value="" hidden>Choose one</option>
	                <?php
	                    if(!empty($visible)){
    	                    $getuser = $query->getData('*',$visible,'',array('delete_status'=>'show'),'id','DESC','');
    	                    if($getuser != 0){
    	                        foreach($getuser as $user){
    	                            if($visible == "users"){
    	                                $uName = $user['username'];
    	                                $pName = $user['party_name'];
    	                            }elseif($visible == "branches"){
    	                                $uName = $user['branch_user_name'];
    	                                $pName = $user['branch_name'];
    	                            }
	               ?>
	                    <option value="<?= $uName; ?>" <?php if(!empty($orderUsersorBranches) && $orderUsersorBranches == $uName){ echo 'selected'; } ?>><?= "Name: ".$uName.", Username: ".$uName." ( mobile no.: ".$user['mobile_no']." )"; ?></option>
	               <?php
    	                        }
    	                    }
	                    }
	                ?>
	            </select>
			</div>
	        <div class="col-xl-2 col-sm-6 form-group">
	            <label>One Date / Start Date</label>
	            <input type="date" class="form-control form-control-sm" name="startDate" value="<?= $startDate; ?>">
			</div>
	        <div class="col-xl-2 col-sm-6 form-group">
	            <label>End Date</label>
	            <input type="date" class="form-control form-control-sm" name="endDate" value="<?= $endDate; ?>">
			</div>
	        <div class="col-xl-1 col-sm-6 form-group d-flex align-items-end">
	            <button class="btn btn-xs me-1 shadow btn-block" style="background-color: #28a745; color: #fff;">Search</button>
			</div>
	    </form>
		<div class="row">
		    <div class="card">
		        <div class="card-header">
		            <h3 class="card-title"><?php if(!empty($orderUsersorBranches)){ echo $orderUsersorBranches."<span style='text-transform: lowercase;'>'s</span>"; }elseif($visible == "users" || $visible == "branches"){ echo 'All '.ucwords(rtrim(rtrim($visible, "s"), "es"))."<span style='text-transform: lowercase;'>'s</span>"; }else{ echo 'All'; } ?> Bill Report</h3>
		            <form action="act" method="POST">
	                    <input type="text" hidden class="form-control" name="visible" value="<?php if(!empty($visible)){ echo $visible; } ?>">
	                    <input type="text" hidden class="form-control" name="ordersOfUser" value="<?php if(!empty($orderUsersorBranches)){ echo $orderUsersorBranches; } ?>">
	                    <input type="date" hidden class="form-control" name="startDate" value="<?php if(!empty($startDate)){ echo $startDate; } ?>">
		                <input type="date" hidden class="form-control" name="endDate" value="<?php if(!empty($endDate)){ echo $endDate; } ?>">
		                <button class="btn btn-info btn-sm" name="exportBillReport" type="submit">Export All <i class="bi bi-cloud-download-fill"></i></button>
		            </form>
		        </div>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example3" class="display" style="width:100%">
                    		<thead>
                    			<tr>
                                    <th class="text-center" hidden>Sl No.</td>
                    				<th class="text-center" >Invoice No.</th>
                    				<th class="text-center" >Invoice Date</th>
                                    <th class="text-center" >Name</th>
                                    <th class="text-center" >Address</th>
                                    <th class="text-center" >GST No.</th>
                                    <th class="text-center" >GST Before Amount</th>
                                    <th class="text-center" >IGST</th>
                                    <th class="text-center" >CGST</th>
                                    <th class="text-center" >SGST</th>
                                    <th class="text-center" >Grand Total</th>
                    			</tr>
                    		</thead>
                    		<tbody>
                                <?php
                                  $sl = 1;
                                  if($visible == "users" || $visible == "branches"){
                                      $showusercond["user_type"] = $visible;
                                  }
                                  if(!empty($orderUsersorBranches)){
                                      if($visible == "users"){
                                          $visibleusername = "username";
                                      }elseif($visible == "branches"){
                                          $visibleusername = "branch_user_name";
                                      }
                                      $showusercond['type_id'] = $query->getData('`id`',$visible,'',array($visibleusername=>$orderUsersorBranches),'id','DESC','1')[0]['id'];
                                  }
                                  if(!empty($startDate) && empty($endDate)){
                                      $showusercond['invoice_date'] = $startDate;
                                  }
                                  if(!empty($startDate) && !empty($endDate)){
                                      unset($showusercond);
                                      if($visible == "users" || $visible == "branches"){
                                          $showusercond[] = array("user_type","=",$visible);
                                      }
                                      if(!empty($orderUsersorBranches)){
                                          if($visible == "users"){
                                              $visibleusername = "username";
                                          }elseif($visible == "branches"){
                                              $visibleusername = "branch_user_name";
                                          }
                                          $showusercond[] = array("type_id","=",$query->getData('`id`',$visible,'',array($visibleusername=>$orderUsersorBranches),'id','DESC','1')[0]['id']);
                                      }
                                      $showusercond[] = array('invoice_date','BETWEEN',$startDate,"AND",$endDate);
                                  }
                                  $stationaryInvoice_details = $query->getData('*','stationary_invoices','',$showusercond,'id','DESC','');
                                  foreach($stationaryInvoice_details as $stationaryInvoice){
                                    ?>
                                    <tr>
                                        <td class="text-center" hidden><?= $sl; ?></td>
                                        <td class="text-center"><?= $stationaryInvoice['invoice_no']; ?></td>
                                        <td class="text-center"><?= $stationaryInvoice['invoice_date']; ?></td>
                                        <td class="text-center"><?= $stationaryInvoice['name']; ?></td>
                                        <td class="text-center"><?= $stationaryInvoice['address']; ?></td>
                                        <td class="text-center"><?= $stationaryInvoice['gst_number']; ?></td>
                                        <td class="text-center"><?= $stationaryInvoice['gst_before_amount']; ?></td>
                                        <td class="text-center"><?= $stationaryInvoice['igst']; ?></td>
                                        <td class="text-center"><?= $stationaryInvoice['sgst']; ?></td>
                                        <td class="text-center"><?= $stationaryInvoice['cgst']; ?></td>
                                        <td class="text-center"><?= $stationaryInvoice['grand_total']; ?></td>
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
		</div>
	</div>
</div>

<!--**********************************
    Content body end
***********************************-->
<?php
include("assets/footer.php");
?>