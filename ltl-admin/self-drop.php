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
		<div class="row">
		    <div class="card">
		        <div class="card-header">
		            <h3 class="card-title">All <?php if($visible == "users" || $visible == "branches"){ echo ucwords(rtrim(rtrim($visible, "s"), "es"))."'s"; } ?> Self Drop</h3>
		        </div>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example5" class="display table" style="min-width: 845px">
                    		<thead>
                    			<tr>
                                    <th class="text-center" hidden>Sl No.</td>
                    				<th class="text-center" >LR/AWB No.</th>
                    				<th class="text-center" >Master Waybill No.</th>
                                    <th class="text-center" >Manifested Date</th>
                                    <th class="text-center" >User Details</th>
                                    <th class="text-center" >Consignee</th>
                                    <th class="text-center" >Payment Type</th>
                                    <th class="text-center" >Box Count</th>
                                    <th class="text-center" >Action</th>
                                    <th class="text-center" >POD</th>
                    			</tr>
                    		</thead>
                    		<tbody>
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
                                  $showusercond = array("selfdrop"=>"Y");
                                  if($visible == "users" || $visible == "branches"){
                                      $showusercond["user_type"] = $visible;
                                  }
                                  $order_details = $query->getData('*','orders','',$showusercond,'id','DESC',$limit);
                                  $ordersCount = $query->getData('COUNT(`id`) as "ordersCount"','orders','',$showusercond,'id','DESC','')[0]['ordersCount'];
                                  foreach($order_details as $orders){
                                    $get_consignee_details = $query->getData('*','consignee_details','',array("order_id"=>$orders['order_id']),'','','');
                                    $get_box_details = $query->getData('*','box_details','',array("order_id"=>$orders['order_id']),'','','');
                                    $getwarehouse = $query->getData('*','warehouses','',array('id'=>$orders['warehouse_id']),'id','DESC','1')[0];
                                    ?>
                                    <tr>
                                        <td class="text-center" hidden><?= $sl; ?></td>
                                        <td class="text-center"><?= $orders['lr']; ?></td>
                                        <td class="text-center"><?= $orders['master_waybill']; ?></td>
                                        <td class="text-center"><?= $orders['order_date']; ?></td>
                                        <td class="text-center">
                                            <?php
                                                if($orders['user_type'] == "users"){
                                                    $user = $query->getData("`party_name`,`username`","users","",array("id"=>$orders['type_id']),"id","DESC","1")[0];
                                                    echo $user['party_name']."<br/><b>Username : </b>".$user['username']."<br/><span class='badge badge-sm bg-dark'><b>User type : </b>User</span>";
                                                }else{
                                                    $branch = $query->getData("`branch_name`,`branch_user_name`","branches","",array("id"=>$orders['type_id']),"id","DESC","1")[0];
                                                    echo $branch['branch_name']."<br/><b>Username : </b>".$branch['branch_user_name']."<br/><span class='badge badge-sm bg-dark'><b>User type : </b>Branch</span>";
                                                }
                                            ?>
                                        </td>
                                        <td class="text-center"><?= '<b>Consignee name: </b>'.$get_consignee_details[0]['name'].'<br/><b>Address: </b>'.$get_consignee_details[0]['address']; ?></td>
                                        <td class="text-center"><?= $orders['payment_mode']; ?></td>
                                        <td class="text-center"><?= count($get_box_details); ?></td>
                                        <td class="text-center">
                                            <a type="button" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg<?= $orders['id']; ?>" class="btn btn-info shadow btn-xs sharp me-1"><i class="bi bi-binoculars-fill"></i></a>
                                            <a data-bs-toggle="modal" data-bs-target=".bd-example-modal-selfDropEdit<?= $orders['lr']; ?>" type="button" class="btn btn-warning shadow btn-xs sharp me-1"><i class="bi bi-pen-fill"></i></a>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                                if($orders['status'] == "DELIVERED"){
                                            ?>
                                            <button title="Download POD" onclick="getPOD(<?= $orders['lr']; ?>)" id="getPOD<?= $orders['lr']; ?>" type="button" class="btn btn-success shadow btn-xs sharp me-1"><i class="bi bi-boxes"></i></button>
                                            <?php
                                                }else{
                                                    echo '<span class="badge badge-sm" style="background-color: #dc3545; color: #fff;">NOT DELIVERED</span>';
                                                }
                                            ?>
                                        </td>
                                        <!--<td class="text-center">-->
                                        <!--    <button type="button" onclick="genLabel(<?= $orders['lr']; ?>)" id="genLabel<?//= $orders['lr']; ?>" class="btn btn-light shadow btn-xs me-1">Generate label</button>-->
                                        <!--    <button class="btn btn-light d-none gn-btn shadow gn-btn btn-xs me-1">Generate label</button>-->
                                        <!--</td>-->
                                    </tr>
                                    
                                    <div class="modal fade bd-example-modal-selfDropEdit<?= $orders['lr']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                            		        <div class="card">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Self Drop for LR No. <?= $orders['lr']; ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="act" method="POST">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="orderLR" value="<?= $orders['lr']; ?>">
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label>Self Drop Status</label>
                                                                    <select class="form-control form-control-sm" name="selfdrop_dis_status">
                                                                        <option value="" hidden>Choose Status</option>
                                                                        <option value="Pending" <?php if($orders['selfdrop_dis_status'] == "Pending"){ echo 'selected'; } ?>>Pending</option>
                                                                        <option value="Work In Process" <?php if($orders['selfdrop_dis_status'] == "Work In Process"){ echo 'selected'; } ?>>Work In Process</option>
                                                                        <option value="Dispatched" <?php if($orders['selfdrop_dis_status'] == "Dispatched"){ echo 'selected'; } ?>>Dispatched</option>
                                                                        <option value="Completed" <?php if($orders['selfdrop_dis_status'] == "Completed"){ echo 'selected'; } ?>>Completed</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label>Self Drop Id</label>
                                                                    <input type="text" class="form-control form-control-sm txtNumeric" placeholder="Enter Id" value="<?= $orders['selfdrop_id']; ?>" name="selfdrop_id">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label>Self Drop Date</label>
                                                                    <input type="date" class="form-control form-control-sm" name="selfdrop_date" value="<?= $orders['selfdrop_date']; ?>">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label>Self Drop Amount</label>
                                                                    <input type="text" class="form-control form-control-sm txtNumeric" placeholder="Enter Amount" name="selfdrop_amount" value="<?= $orders['selfdrop_amount']; ?>">
                                                                </div>
                                                                <!--<div class="col-md-6 mb-3">-->
                                                                <!--    <label>Self Drop Payment Status</label>-->
                                                                <!--    <select class="form-control form-control-sm" name="selfdrop_pay_status">-->
                                                                <!--        <option value="" hidden>Choose Status</option>-->
                                                                <!--        <option value="Pending" <?php //if($orders['selfdrop_dis_status'] == "Pending"){ echo 'selected'; } ?>>Pending</option>-->
                                                                <!--        <option value="Paid" <?php //if($orders['selfdrop_dis_status'] == "Paid"){ echo 'selected'; } ?>>Paid</option>-->
                                                                <!--    </select>-->
                                                                <!--</div>-->
                                                                <div class="col-md-12">
                                                                    <label>Self Drop Location</label>
                                                                    <input type="text" class="form-control form-control-sm" placeholder="Enter Location" name="selfdrop_location"  value="<?= $orders['selfdrop_location']; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer d-flex" style="justify-content: space-between;">
                                                            <button class="btn btn-danger btn-sm shadow me-1" type="reset">Reset <i class="bi bi-ban"></i></button>
                                                            <button class="btn btn-warning btn-sm me-1 shadow" type="submit" name="saveSelfDrop">Save Change <i class="bi bi-pen-fill"></i></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                        			<div class="modal fade bd-example-modal-lg<?= $orders['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                            		        <div class="card">
                                                <form action="actions" method="POST">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Order details for LR No. <?= $orders['lr']; ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <dl class="d-flex justify-content-end">
                                                                <dt>Manifested Date & Time: &nbsp;</dt><dd><?= $orders['order_date']." ".$orders['order_time']; ?></dd>
                                                            </dl>
                                                            <dt>Pickup From: &nbsp;</dt><dd><?= $getwarehouse['warehouse_name']; ?></dd>
                                                            <dl class="row">
                                                                <dl class="col-xl-3 col-md-2 col-1"></dl>
                                                                <dl class="col-xl-9 col-md-12 col-11 row">
                                                                    <span class="col-3"><dt>Pincode: </dt><dd><?= $getwarehouse['pincode']; ?></dd></span>
                                                                    <span class="col-3"><dt>City: </dt><dd><?= $getwarehouse['city']; ?></dd></span>
                                                                    <span class="col-3"><dt>State: </dt><dd><?= $getwarehouse['state']; ?></dd></span>
                                                                    <span class="col-3"><dt>Country: </dt><dd><?= $getwarehouse['country']; ?></dd></span>
                                                                    <span class="col-9"><dt>Address: </dt><dd><?= $getwarehouse['address']; ?></dd></span>
                                                                </dl>
                                                            </dl><hr/>
                                                            <dt>Deliver To: &nbsp;</dt>
                                                            <dl class="row">
                                                                <dl class="col-xl-3 col-md-2 col-1"></dl>
                                                                <dl class="col-xl-9 col-md-12 col-11 row">
                                                                    <span class="col-3"><dt>Name: </dt><dd><?= $get_consignee_details[0]['name']; ?></dd></span>
                                                                    <span class="col-3"><dt>Company name: </dt><dd><?= $get_consignee_details[0]['name']; ?></dd></span>
                                                                    <span class="col-2"><dt>Pincode: </dt><dd><?= $orders['del_pin']; ?></dd></span>
                                                                    <span class="col-2"><dt>City: </dt><dd><?= $get_consignee_details[0]['city']; ?></dd></span>
                                                                    <span class="col-2"><dt>State: </dt><dd><?= $get_consignee_details[0]['state']; ?></dd></span>
                                                                    <span class="col-9"><dt>Address: </dt><dd><?= $get_consignee_details[0]['address']; ?></dd></span>
                                                                </dl>
                                                            </dl><hr/>
                                                            <?php
                                                                if($orders['user_type'] == "branches"){
                                                                $get_consigner_details = $query->getData('*','consigner_details','',$consgn_cond,'','','');
                                                            ?>
                                                                <dt>Consigner Details: &nbsp;</dt>
                                                                <dl class="row">
                                                                    <dl class="col-xl-3 col-md-2 col-1"></dl>
                                                                    <dl class="col-xl-9 col-md-12 col-11 row">
                                                                        <span class="col-4"><dt>Name: </dt><dd><?= $get_consigner_details[0]['name']; ?></dd></span>
                                                                        <span class="col-4"><dt>Company name: </dt><dd><?= $get_consigner_details[0]['company']; ?></dd></span>
                                                                        <span class="col-4"><dt>City: </dt><dd><?= $get_consigner_details[0]['city']; ?></dd></span>
                                                                        <span class="col-9"><dt>Address: </dt><dd><?= $get_consigner_details[0]['address']; ?></dd></span>
                                                                        <span class="col-3"><dt>State: </dt><dd><?= $get_consigner_details[0]['state']; ?></dd></span>
                                                                    </dl>
                                                                </dl><hr/>
                                                            <?php } ?>
                                                            <dt>Invoice Details: &nbsp;</dt>
                                                            <?php
                                                                $invquery = $query->getData('*','invoice_details','',array("order_id"=>$orders['order_id']),"","","");
                                                                foreach($invquery as $invs){
                                                            ?>
                                                            <dl class="row">
                                                                <dl class="col-xl-3 col-md-2 col-1"></dl>
                                                                <dl class="col-xl-9 col-md-12 col-11 row">
                                                                    <span class="col-4"><dt>E-Waybill: </dt><dd><?= $invs['ewaybill']; ?></dd></span>
                                                                    <span class="col-4"><dt>Invoice Amount: </dt><dd>₹<?= $invs['n_value']; ?></dd></span>
                                                                    <span class="col-4"><dt>Invoice Number: </dt><dd><?= $invs['inv_no']; ?></dd></span>
                                                                </dl>
                                                            </dl><hr/>
                                                            <?php } ?>
                                                            <dt>Dimentions: &nbsp;</dt>
                                                            <?php
                                                                $boxquery = $query->getData('*','box_details','',array("order_id"=>$orders['order_id']),"","","");
                                                                foreach($boxquery as $boxs){
                                                            ?>
                                                            <dl class="row">
                                                                <dl class="col-xl-3 col-md-2 col-1"></dl>
                                                                <dl class="col-xl-9 col-md-12 col-11 row">
                                                                    <span class="col-3"><dt>Quantity: </dt><dd><?= $boxs['qty']; ?></dd></span>
                                                                    <span class="col-3"><dt>Length: </dt><dd><?= $boxs['length']; ?></dd></span>
                                                                    <span class="col-3"><dt>Width: </dt><dd><?= $boxs['width']; ?></dd></span>
                                                                    <span class="col-3"><dt>Height: </dt><dd><?= $boxs['height']; ?></dd></span>
                                                                </dl>
                                                            </dl><hr/>
                                                            <?php } ?>
                                                            <dl class="row">
                                                                <dl class="col-xl-12 col-md-12 col-12 row">
                                                                    <span class="col-3"><dt>Weight: </dt><dd><?= $orders['weight']; ?></dd></span>
                                                                    <span class="col-3"><dt>Payment Mode: </dt><dd><?= $orders['payment_mode']; ?></dd></span>
                                                                    <span class="col-3"><dt>COD Amount: </dt><dd>₹<?= $orders['cod_amount']; ?></dd></span>
                                                                    <span class="col-3"><dt>Profit Amount: </dt><dd>₹<?= $orders['profit_amount']; ?></dd></span>
                                                                    <span class="col-3"><dt>Insurance: </dt><dd><?= $orders['insurance']; ?></dd></span>
                                                                    <span class="col-3"><dt>Seller GST TIN: </dt><dd><?= $orders['seller_gst_tin']; ?></dd></span>
                                                                    <span class="col-3"><dt>Consignee GST TIN: </dt><dd><?= $orders['consignee_gst_tin']; ?></dd></span>
                                                                    <span class="col-3"><dt>Master Waybill: </dt><dd><?= $orders['master_waybill']; ?></dd></span>
                                                                    <span class="col-1"><dt>ODA: </dt><dd><?= ucwords($orders['oda']); ?></dd></span>
                                                                    <span class="col-3"><dt>COD Charge: </dt><dd>₹<?= $orders['cod_charge']; ?></dd></span>
                                                                    <span class="col-3"><dt>Fuel Surcharge: </dt><dd>₹<?= $orders['fuel_surcharge']; ?></dd></span>
                                                                    <span class="col-3"><dt>AWB Charge: </dt><dd>₹<?= $orders['awb_charge']; ?></dd></span>
                                                                    <span class="col-2"><dt>FOV Surcharge: </dt><dd>₹<?= $orders['fob_surcharge']; ?></dd></span>
                                                                    <span class="col-3"><dt>Handeling Charge: </dt><dd>₹<?= $orders['handeling_charge']; ?></dd></span>
                                                                    <span class="col-2"><dt>Pickup Charge: </dt><dd>₹<?= $orders['pickup_charge']; ?></dd></span>
                                                                    <span class="col-3"><dt>Damrage Surcharge: </dt><dd>₹<?= $orders['damage_surcharge']; ?></dd></span>
                                                                    <span class="col-2"><dt>ODA Surcharge: </dt><dd>₹<?= $orders['oda_surcharge']; ?></dd></span>
                                                                    <span class="col-2"><dt>Cartage Charge: </dt><dd>₹<?= $orders['cartage_charge']; ?></dd></span>
                                                                    <span class="col-4"><dt>Special Delivery/Appointment Charge: </dt><dd>₹<?= $orders['special_delivery_charge']; ?></dd></span>
                                                                    <span class="col-3"><dt>GST Charge: </dt><dd>₹<?= $orders['igst_amount']+$orders['sgst_amount']+$orders['cgst_amount']; ?></dd></span>
                                                                    <span class="col-3"><dt>Weight Charge: </dt><dd>₹<?= $orders['weight_charge']; ?></dd></span>
                                                                    <span class="col-2"><dt>CFT: </dt><dd><?= $orders['cft_type']; ?></dd></span>
                                                                    <h5 class="col-6 d-flex align-items-center" style="flex-direction: column;"><dt>Total Charge: </dt><dd>₹<?= $orders['total_charge']; ?></dd></h5>
                                                                    <h5 class="col-6 d-flex align-items-center" style="flex-direction: column;"><dt>Status: </dt><dd><?= $orders['status']; ?></dd></h5>
                                                                </dl>
                                                            </dl>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                    $sl++;
                                  }
                                ?>
                            </tbody>
                    	</table>
                    </div>
                    <?php
                        $pageCount = ceil($ordersCount/dataShow);
                        if($ordersCount != 0){
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
		</div>
	</div>
</div>

<!--**********************************
    Content body end
***********************************-->
<?php
include("assets/footer.php");
?>