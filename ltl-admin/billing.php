<?php
if(!array_key_exists('visible', $_GET)){
    echo '<script type="text/javascript" language="javascript">window.location="billing?visible=users";</script>';
}elseif(empty($_GET['visible'])){
    echo '<script>window.location = "billing?visible=users";</script>';
}elseif($_GET['visible'] != "users" && $_GET['visible'] != "branches"){
    echo '<script>window.location = "billing?visible=users";</script>';
}
extract($_GET);
include("assets/header.php");
include("assets/sidebar.php");
?>

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
	<div class="container-fluid">
	    <div class="row">
            <form action="billing" method="GET" class="row mb-3">
                <input type="hidden" name="visible" value="<?= $visible; ?>">
                <div class="col-xl-4 col-sm-6 form-group">
                    <label>Choose <?php if($visible == 'users'){echo "User";} elseif ($visible == 'branches'){echo "Branch";} ?></label>
                    <select class="form-control select-2 form-control-sm" id="single-select" name="orderUsersorBranches" required>
                        <option value="" hidden>Choose from Dropdown</option>
                        <?php
                            $getEntity = $query->getData('*',$visible, '', array('delete_status'=>'show'), 'id', 'DESC', '');
                            if($getEntity != 0){
                                foreach ($getEntity as $entity) {
                                if($visible == 'users'){
                                    $name = $entity['party_name'];
                                    $uname = $entity['username'];
                                }
                                elseif ($visible == 'branches'){
                                    $name = $entity['branch_name'];
                                    $uname = $entity['branch_user_name'];
                                }
                        ?>
                        <option value="<?= $uname; ?>" <?php if($orderUsersorBranches == $uname){ echo 'selected'; } ?>> <?= "Name: " . $name . ", Username: " . $uname . " ( Mobile : " . $entity['mobile_no'] . " )"; ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xl-3 col-sm-6 form-group">
                    <label>Payment mode</label>
                    <select class="form-control select-2 form-control-sm" name="paymentMode">
                        <option value="" hidden>Choose Payment mode</option>
                        <option value="Prepaid" <?php if($paymentMode == "Prepaid"){ echo "selected"; } ?>>Prepaid</option>
                        <option value="CoD" <?php if($paymentMode == "CoD"){ echo "selected"; } ?>>COD</option>
                        <option value="To-Pay" <?php if($paymentMode == "To-Pay"){ echo "selected"; } ?>>To-Pay</option>
                        <option value="Franchise-ToPay" <?php if($paymentMode == "Franchise-ToPay"){ echo "selected"; } ?>>Franchise-ToPay</option>
                    </select>
                </div>
                <div class="col-xl-2 col-sm-6 form-group">
                    <label>One Date / Start Date</label>
                    <input type="date" class="form-control form-control-sm" name="startDate" value="<?php if(!empty($startDate)){echo $startDate;} ?>">
                </div>
                <div class="col-xl-2 col-sm-6 form-group">
                    <label>End Date</label>
                    <input type="date" class="form-control form-control-sm" name="endDate" value="<?php if(!empty($endDate)){echo $endDate;} ?>">
                </div>
    	        <div class="col-xl-1 col-sm-6 form-group d-flex align-items-end mb-1">
    	            <button class="btn btn-xs me-1 shadow btn-block" style="background-color: #28a745; color: #fff;">Search</button>
    			</div>
            </form>
	    </div>
	    <?php if(!empty($orderUsersorBranches)){ ?>
    		<div class="row">
    		    <div class="card">
    		        <div class="card-header">
    		            <h3 class="card-title">Bills of <?= $orderUsersorBranches; ?></h3>
    		        </div>
                    <?php if($visible == "users"){ ?>
		            <form class="card-body" action="actions" method="POST">
    		            <input type="hidden" name="entityType" value="<?= $visible; ?>">
    		            <input type="hidden" name="entityUname" value="<?= $orderUsersorBranches; ?>">
    		        <?php } ?>
    		             <div class="table-responsive mb-3">
                        	<table class="table table-responsive-md" style="width:100%">
                        		<thead>
                        			<tr>
                        				<th class="text-center" hidden>SL No.</th>
                                        <?php if($visible == "users"){ ?>
                            				<th class="text-center">
                            				    <div class="form-check custom-checkbox checkbox-success">
        											<input type="checkbox" class="form-check-input" id="checkAlldataOfTable">
        											<label class="form-check-label" for="checkAlldataOfTable"></label>
        										</div>
                            				</th>
                            			<?php } ?>
                        				<th class="text-center">LR/AWB No.</th>
                        				<th class="text-center">Master Waybill</th>
                                        <th class="text-center">Manifested Date</th>
                                        <th class="text-center">User Details</th>
                                        <th class="text-center">Consignee</th>
                                        <th class="text-center">Payment Type</th>
                                        <th class="text-center">Box Count</th>
                                        <th class="text-center d-flex justify-content-center">Generate Invoice</th>
                        			</tr>
                        		</thead>
                        		<tbody>
                                    <?php
                                      $sl = 1;
                                      $showusercond = array("selfdrop"=>"N");
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
                                      if(!empty($paymentMode)){
                                          $showusercond['payment_mode'] = $paymentMode;
                                      }
                                      if(!empty($startDate) && !empty($endDate)){
                                          unset($showusercond);
                                          $showusercond = array(array("selfdrop","=","N"));
                                          if($visible == "users" || $visible == "branches"){
                                              $showusercond[] = array("user_type","=",$visible);
                                          }
                                          if(!empty($paymentMode)){
                                              $showusercond[] = array('payment_mode',"=",$paymentMode);
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
                                      $lrs = array();
                                      $getThisusersInvoice = $query->getData('*','stationary_invoices','','','','','');
                                      foreach($getThisusersInvoice as $invdetails):
                                          $lrs = array_merge($lrs, explode(",", $invdetails['lrs']));
                                      endforeach;
                                      $order_details = $query->getData('*','orders','',$showusercond,'id','DESC','');
                                      if($order_details != 0):
                                          foreach($order_details as $orders):
                                              if(!in_array($orders['lr'], $lrs)):
                                                  $get_consignee_details = $query->getData('*','consignee_details','',array("order_id"=>$orders['order_id']),'','','');
                                                  $boxCount = $query->getData('SUM(`qty`) as "boxcount"','box_details','',array("order_id"=>$orders['order_id']),'','','')[0]['boxcount'];
                                                  $getwarehouse = $query->getData('*','warehouses','',array('id'=>$orders['warehouse_id']),'id','DESC','1')[0];
                                    ?>
                                        <tr>
                                            <?php if($visible == "users"){ ?>
                                                <td>
                                                    <div class="form-check custom-checkbox">
            											<input type="checkbox" class="form-check-input customCheckBoxOne" name="billForLR[]" value="<?= $orders['lr']; ?>" id="customCheckBox<?= $sl; ?>">
            											<label class="form-check-label" for="customCheckBox<?= $sl; ?>"></label>
            										</div>
            									</td>
            								<?php } ?>
                                            <td class="text-center" hidden><?= $sl; ?></td>
                                            <td class="text-center"><?= $orders['lr']; ?></td>
                                            <td class="text-center"><?= $orders['master_waybill']; ?></td>
                                            <td class="text-center"><?= $orders['order_date']; ?></td>
                                            <td class="text-center">
                                                <?php
                                                    if($visible == "users"){
                                                        $user = $query->getData("`party_name`,`username`",$visible,"",array("id"=>$orders['type_id']),"id","DESC","1")[0];
                                                        echo $user['party_name']."<br/><b>Username : </b>".$user['username'];
                                                    }elseif($visible == "branches"){
                                                        $branch = $query->getData("`branch_name`,`branch_user_name`",$visible,"",array("id"=>$orders['type_id']),"id","DESC","1")[0];
                                                        echo $branch['branch_name']."<br/><b>Username : </b>".$branch['branch_user_name'];
                                                    }
                                                ?>
                                            </td>
                                            <td class="text-center"><?= $get_consignee_details[0]['name'].','.$get_consignee_details[0]['address'].','.$get_consignee_details[0]['city'].','.$get_consignee_details[0]['state']; ?></td>
                                            <td class="text-center"><?= $orders['payment_mode']; ?></td>
                                            <td class="text-center"><?= $boxCount; ?></td>
                                            <td class="text-center">
                                                <div class="d-flex">
                                                    <form action="actions" method="POST">
                                				        <input type="hidden" name="lr_no" value="<?= $orders['lr']; ?>">
                                				        <input type="submit" class="btn btn-primary btn-sm shadow" <?php if($visible == "branches"){ ?>style="border-radius: 4px 0px 0px 4px;"<?php } ?> name="bilInvoiceSubmit" value="Get Invoice">
                                				    </form>
                                				    <?php
                                				        if($visible == "branches"){
                                				    ?>
                                                    <form action="actions" method="POST" onsubmit="return confirm('Are you sure to want to send bill to this branch?')">
                                				        <input type="hidden" name="entityType" value="<?= $orders['user_type']; ?>">
                                				        <input type="hidden" name="entityUname" value="<?php if($visible == "users"){ echo $user['username']; }elseif($visible == "branches"){ echo $branch['branch_user_name']; } ?>">
                                				        <input type="hidden" name="billForLR[]" value="<?= $orders['lr']; ?>">
                            				            <button class="btn btn-sm btn-success shadow" type="submit" style="border-radius: 0px 4px 4px 0px;" name="sendEmailbillSubmit">Send Bill to Email <i class="bi bi-envelope-at-fill"></i></button>
                                				    </form>
                                				    <?php
                                				        }
                                				    ?>
                                				</div>
                                            </td>
                                        </tr>
                                    <?php
                                                  $sl++;
	                                          endif;
                                          endforeach;
                                        else:
                                            if($visible == "users"):
                                                echo "<tr><td colspan='9' class='text-center'>No Order Found !</td></tr>";
                                            else:
                                                echo "<tr><td colspan='8' class='text-center'>No Order Found !</td></tr>";
                                            endif;
                                        endif;
                                    ?>
                                </tbody>
                        	</table>
                        </div>
                    <?php if($visible == "users"  && $order_details != 0): ?>
                    	<div class="row d-flex justify-content-end">
                    	    <button class="col-md-2 col-5 btn btn-xs btn-info shadow me-1" disabled type="submit" name="viewbillSubmit">View Bill <i class="bi bi-receipt-cutoff"></i></button>
                            <button class="col-md-2 col-5 btn btn-xs btn-success shadow me-1" disabled type="submit" name="sendEmailbillSubmit">Send Bill to Email <i class="bi bi-envelope-at-fill"></i></button>
                    	</div>
    		        </form>
                    <?php endif; ?>
    		    </div>
    		</div>
    	<?php
    	    }else{
    	        echo '<span class="d-flex justify-content-center">Search here to get billing details!</span>';
    	    }
    	?>
	</div>
</div>

<!--**********************************
    Content body end
***********************************-->
<?php
include("assets/footer.php");
?>