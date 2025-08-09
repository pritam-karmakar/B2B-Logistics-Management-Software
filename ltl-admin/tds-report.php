<?php
if(!empty($_GET) && !array_key_exists('visible', $_GET) && count($_GET) <= 1){
    echo '<script type="text/javascript" language="javascript">window.location="tds-report?visible=users";</script>';
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
	    
	    <form action="tds-report" method="GET" class="row mb-3">
	        <div class="col-xl-3 col-sm-6 form-group">
	            <label>Choose user type</label>
	            <input type="text" class="form-control form-control-sm bg-light" readonly name="visible" value="<?= $visible; ?>" required>
			</div>
	        <div class="col-xl-4 col-sm-6 form-group">
	            <label>Choose One</label>
	            <select class="form-control form-control-sm" id="single-select" name="orderUsersorBranches">
	              <?php
	                $visible = $newfunc->real_string(trim($visible, " "));
                    $getch = $query->getData('*',$visible,'',array('tds'=>'yes','delete_status'=>'show'),'','','');
                    if($getch != 0){
                        echo '<option value="" hidden>Choose '.ucwords(trim(trim($visible, "s"),"es")).'</option>';
                        foreach($getch as $getall){
                            if($visible == "users"){
                                $name = $getall['party_name'];
                                $username = $getall['username'];
                            }elseif($visible == "branches"){
                                $name = $getall['branch_name'];
                                $username = $getall['branch_user_name'];
                            }
                  ?>
                          <option value="<?= $username; ?>" <?php if($username == $orderUsersorBranches){ echo 'selected'; } ?>><?= $name.' (Username: '.$username.') [Mob: '.$getall['mobile_no'].']'; ?></option>
                  <?php
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
	        <div class="col-xl-1 col-sm-6 form-group d-flex align-items-end pb-1">
	            <button class="btn btn-xs me-1 shadow btn-block" style="background-color: #28a745; color: #fff;">Search</button>
			</div>
	    </form>
	    
		<div class="row">
		    <div class="card">
		        <div class="card-header">
		            <h3 class="card-title"><?php if(!empty($orderUsersorBranches)){ echo $orderUsersorBranches."<span style='text-transform: lowercase;'>'s</span>"; }elseif($visible == "users" || $visible == "branches"){ echo 'All '.ucwords(rtrim(rtrim($visible, "s"), "es"))."<span style='text-transform: lowercase;'>'s</span>"; }else{ echo 'All'; } ?> Orders</h3>
		            <form action="act" method="POST">
	                    <input type="text" hidden class="form-control" name="visible" value="<?php if(!empty($visible)){ echo $visible; } ?>">
	                    <input type="text" hidden class="form-control" name="orderUsersorBranches" value="<?php if(!empty($orderUsersorBranches)){ echo $orderUsersorBranches; } ?>">
	                    <input type="date" hidden class="form-control" name="startDate" value="<?php if(!empty($startDate)){ echo $startDate; } ?>">
		                <input type="date" hidden class="form-control" name="endDate" value="<?php if(!empty($endDate)){ echo $endDate; } ?>">
		                <button class="btn btn-info btn-sm" name="exportBranchorUsersTDS" type="submit">Export All <i class="bi bi-cloud-download-fill"></i></button>
		            </form>
		        </div>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example3" class="display" style="width:100%">
                    		<thead>
                    			<tr>
                    				<th class="text-center" >Customer Type</th>
                    				<th class="text-center" >LR/AWB No.</th>
                                    <th class="text-center" >Order Date</th>
                                    <th class="text-center" >Customer Details</th>
                                    <th class="text-center" >Basic Freight</th>
                                    <th class="text-center" >Consignee Name (Company)</th>
                                    <th class="text-center" >Consignee Contact</th>
                                    <th class="text-center" >PAN</th>
                                    <th class="text-center" >TDS</th>
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
                                      $showusercond['order_date'] = $startDate;
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
                                      $showusercond[] = array('order_date','BETWEEN',$startDate,"AND",$endDate);
                                  }
                                  $order_details = $query->getData('*','orders','',$showusercond,'order_date','DESC','');
                                  foreach($order_details as $orders){
                                      $get_consignee_details = $query->getData('*','consignee_details','',array("order_id"=>$orders['order_id']),'','','');
                                      $get_box_details = $query->getData('*','box_details','',array("order_id"=>$orders['order_id']),'','','');
                                      $getwarehouse = $query->getData('*','warehouses','',array('id'=>$orders['warehouse_id']),'id','DESC','1')[0];
                                      $userdetails = $query->getData("*",$visible,"",array("id"=>$orders['type_id']),"id","DESC","1")[0];
                                      if($userdetails['tds'] == 'yes'){
                                ?>
                                        <tr>
                                            <td class="text-center"><?= ucwords(trim(trim($visible, "s"), "es")); ?></td>
                                            <td class="text-center"><?= $orders['lr']; ?></td>
                                            <td class="text-center"><?= $orders['order_date']; ?></td>
                                            <td class="text-center">
                                                <?php
                                                    if($visible == "users"){
                                                        echo $userdetails['party_name']."<br/><b>Username : </b>".$userdetails['username'];
                                                    }elseif($visible == "branches"){
                                                        echo $userdetails['branch_name']."<br/><b>Username : </b>".$userdetails['branch_user_name'];
                                                    }
                                                ?>
                                            </td>
                                            <td class="text-center"><?= round($orders['weight_charge'], 2); ?></td>
                                            <td class="text-center"><?= $get_consignee_details[0]['name']." (".$get_consignee_details[0]['company'].")"; ?></td>
                                            <td class="text-center"><?= $get_consignee_details[0]['phone'].", ".$get_consignee_details[0]['email']; ?></td>
                                            <td class="text-center">
                                                <?php if($visible == "users"){ echo $userdetails['pan']; }else{ echo $userdetails['pan_no']; } ?>
                                            </td>
                                            <td class="text-center">₹<?= round(($orders['weight_charge']*2)/100, 2); ?>/-</td>
                                        </tr>
                                <?php
                                      $sl++;
                                      }
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