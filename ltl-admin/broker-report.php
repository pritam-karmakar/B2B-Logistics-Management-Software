<?php
extract($_GET);
include("assets/header.php");
include("assets/sidebar.php");
?>

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
	<div class="container-fluid">
	    
	    <form action="broker-report" method="GET" class="row mb-3">
	        <div class="col-xl-3 col-sm-6 form-group">
	            <label>Choose Agent</label>
	            <select class="form-control form-control-sm" id="single-select" name="orderUsersorBranches">
	              <?php
                    $getch = $query->getData('*','branches','',array('type'=>'agent','delete_status'=>'show'),'','','');
                    if($getch != 0){
                        echo '<option value="" hidden>Choose one</option>';
                        foreach($getch as $getall){
                            $name = $getall['branch_name'];
                            $username = $getall['branch_user_name'];
                  ?>
                          <option value="<?= $username; ?>" <?php if($username == $orderUsersorBranches){ echo 'selected'; } ?>><?= $name.' (Username: '.$username.') [Mob: '.$getall['mobile_no'].']'; ?></option>
                  <?php
                        }
                    }
                  ?>
	            </select>
			</div>
	        <div class="col-xl-3 col-sm-6 form-group">
	            <label>One Date / Start Date</label>
	            <input type="date" class="form-control form-control-sm" name="startDate" value="<?= $startDate; ?>">
			</div>
	        <div class="col-xl-3 col-sm-6 form-group">
	            <label>End Date</label>
	            <input type="date" class="form-control form-control-sm" name="endDate" value="<?= $endDate; ?>">
			</div>
	        <div class="col-xl-1 col-sm-6 form-group d-flex align-items-end pb-1">
	            <button class="btn btn-xs me-1 shadow btn-block" style="background-color: #28a745; color: #fff;">Search</button>
			</div>
	        <div class="col-xl-2 col-sm-6 form-group d-flex align-items-end pb-1">
	            <a href="bulk-broker-commission" class="btn btn-xs me-1 btn-warning shadow btn-block">Send Bulk Commission</a>
			</div>
	    </form>
	    
		<div class="row">
		    <div class="card">
		        <div class="card-header">
		            <h3 class="card-title"><?php if(!empty($orderUsersorBranches)){ echo $orderUsersorBranches."<span style='text-transform: lowercase;'>'s</span>"; }else{ echo 'All agent\'s'; } ?> Orders</h3>
		            <form action="act" method="POST">
	                    <input type="text" hidden class="form-control" name="orderUsersorBranches" value="<?php if(!empty($orderUsersorBranches)){ echo $orderUsersorBranches; } ?>">
	                    <input type="date" hidden class="form-control" name="startDate" value="<?php if(!empty($startDate)){ echo $startDate; } ?>">
		                <input type="date" hidden class="form-control" name="endDate" value="<?php if(!empty($endDate)){ echo $endDate; } ?>">
		                <button class="btn btn-info btn-sm" name="exportBrokerReport" type="submit">Export All <i class="bi bi-cloud-download-fill"></i></button>
		            </form>
		        </div>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example3" class="display" style="width:100%">
                    		<thead>
                    			<tr>
                    			    <th class="text-center" hidden>Sl No.</th>
                    				<th class="text-center" >LR/AWB No.</th>
                                    <th class="text-center" >Receipt Date</th>
                                    <th class="text-center" >Consigner Name (Company)</th>
                                    <th class="text-center" >Consignee Name (Company)</th>
                                    <th class="text-center" >From</th>
                                    <th class="text-center" >To</th>
                                    <th class="text-center" >Broker Name</th>
                                    <th class="text-center" >Quantity</th>
                                    <th class="text-center" >Weight</th>
                                    <th class="text-center" >Total Charge</th>
                                    <th class="text-center" >Total Commission</th>
                                    <th class="text-center" >Payment Status</th>
                    			</tr>
                    		</thead>
                    		<tbody>
                                <?php
                                  $sl = 1;
                                  if(!empty($orderUsersorBranches) && empty($startDate) && empty($endDate)){
                                      $showusercond['type_id'] = $query->getData('`id`','branches','',array('branch_user_name'=>$orderUsersorBranches),'id','DESC','1')[0]['id'];
                                  }
                                  $showusercond['orders`.`user_type'] = "branches";
                                  $showusercond['branches`.`type'] = "agent";
                                  if(!empty($startDate) && empty($endDate)){
                                      $showusercond['order_date'] = $startDate;
                                  }
                                  if(!empty($startDate) && !empty($endDate)){
                                      unset($showusercond);
                                      $showusercond = array(array("user_type","=","branches"));
                                      if(!empty($orderUsersorBranches)){
                                          $showusercond[] = array("type_id","=",$query->getData('`id`','branches','',array('branch_user_name'=>$orderUsersorBranches),'id','DESC','1')[0]['id']);
                                      }
                                      $showusercond[] = array('order_date','BETWEEN',$startDate,"AND",$endDate);
                                      $showusercond[] = array("orders`.`user_type","=","branches");
                                      $showusercond[] = array("branches`.`type","=","agent");
                                  }
                                  $order_details = $query->getData('`orders`.*,`branches`.`type`,`branches`.`id`','orders',array(array('LEFT','branches','branches','id','orders','type_id')),$showusercond,'orders`.`id','DESC','');
                                  foreach($order_details as $orders){
                                    $get_consignee_details = $query->getData('*','consignee_details','',array("order_id"=>$orders['order_id']),'','','');
                                    $get_consigner_details = $query->getData('*','consigner_details','',array("order_id"=>$orders['order_id']),'','','');
                                    $get_box_details = $query->getData('*','box_details','',array("order_id"=>$orders['order_id']),'','','');
                                    $getwarehouse = $query->getData('*','warehouses','',array('id'=>$orders['warehouse_id']),'id','DESC','1')[0];
                                ?>
                                    <tr>
                                        <td class="text-center" hidden><?= $sl; ?></td>
                                        <td class="text-center"><?= $orders['lr']; ?></td>
                                        <td class="text-center"><?= $orders['order_date']; ?></td>
                                        <td class="text-center"><?= $get_consigner_details[0]['name']." (".$get_consigner_details[0]['company'].")"; ?></td>
                                        <td class="text-center"><?= $get_consignee_details[0]['name']." (".$get_consignee_details[0]['company'].")"; ?></td>
                                        <td class="text-center"><?= $orders['pick_pin']; ?></td>
                                        <td class="text-center"><?= $orders['del_pin']; ?></td>
                                        <td class="text-center">
                                            <?php
                                                $branch = $query->getData("*",'branches',"",array("id"=>$orders['type_id']),"id","DESC","1")[0];
                                                echo $branch['branch_name']."<br/><b>Username :</b> ".$branch['branch_user_name'];
                                            ?>
                                        </td>
                                        <td class="text-center"><?= $query->getData('SUM(`qty`) as "box_count"','box_details','',array('order_id'=>$orders['order_id']),'id','DESC','')[0]['box_count']; ?></td>
                                        <td class="text-center"><?= $orders['vol_weight']." kgs"; ?></td>
                                        <td class="text-center">₹<?= $orders['total_charge']; ?></td>
                                        <td class="text-center">
                                            ₹<?php
                                                if($branch['broker_commission_type'] == "Kg"){
                                                    echo round($branch['broker_commission']*$orders['vol_weight'], 2);
                                                }elseif($branch['broker_commission_type'] == "Percentage"){
                                                    echo round((($orders['weight_charge']+$orders['fuel_surcharge']+$orders['awb_charge']+$orders['fob_surcharge'])*$branch['broker_commission'])/100, 2);
                                                }
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                                if($orders['commission_status'] == "Paid"){
                                            ?>
                                                <span class="badge badge-sm shadow me-1" style="background-color: #28a745; color: #fff;">Paid <i class="bi bi-patch-check-fill"></i></span>
                                            <?php
                                                }elseif($orders['commission_status'] == "Pending"){
                                            ?>
                                            <a data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg-commission<?= $orders['order_id']; ?>" class="btn btn-warning btn-sm shadow me-1"><?= $orders['commission_status']; ?> <i class="bi bi-hourglass-split"></i></a>
                                            <?php
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    
                                    <div class="modal fade bd-example-modal-lg-commission<?= $orders['order_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="act" method="POST">
                                                <input type="hidden" value="<?= $orders['lr']; ?>" name="commissionLRs[]">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Pay commission for Agent: <?= $branch['branch_name']; ?> (<?= $branch['branch_user_name'];  ?>)</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row d-flex justify-content-center">
                                                            <div class="col-md-8">
                                                                <label>Transaction Id</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control form-control-sm" placeholder="Enter Transaction Id"  name="transactionId" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer d-flex p-2" style="justify-content: space-between;">
                                                        <button class="btn btn-danger btn-sm" type="reset">Clear <i class="bi bi-slash-circle"></i></button>
                                                        <button class="btn btn-success btn-sm" type="submit" name="payCommissionToAgent">Deposit Now <i class="bi bi-patch-check-fill"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
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