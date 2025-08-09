<?php
if(!empty($_GET) && array_key_exists('page', $_GET)){
    $page = $_GET['page'];
}
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
		            <h3 class="card-title"><?php if(!empty($orderUsersorBranches)){ echo $orderUsersorBranches."<span style='text-transform: lowercase;'>'s</span>"; }else{ if($visible == "users" || $visible == "branches"){ echo 'All '.ucwords(rtrim(rtrim($visible, "s"), "es"))."<span style='text-transform: lowercase;'>'s</span>"; } } ?> Franchise To-Pay Orders</h3>
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
                                  $showusercond = array("payment_mode"=>"Franchise-ToPay");
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
                                  if(!empty($startDate) && !empty($endDate)){
                                      unset($showusercond);
                                      $showusercond[] = array("payment_mode","=","Franchise-ToPay");
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
                                  $order_details = $query->getData('*','orders','',$showusercond,'order_date','DESC',$limit);
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
                                                }elseif($orders['user_type'] == "branches"){
                                                    $branch = $query->getData("`branch_name`,`branch_user_name`","branches","",array("id"=>$orders['type_id']),"id","DESC","1")[0];
                                                    echo $branch['branch_name']."<br/><b>Username : </b>".$branch['branch_user_name']."<br/><span class='badge badge-sm bg-dark'><b>User type : </b>Branch</span>";
                                                }
                                            ?>
                                        </td>
                                        <td class="text-center"><?= $get_consignee_details[0]['name'].','.$get_consignee_details[0]['address'].','.$get_consignee_details[0]['city'].','.$get_consignee_details[0]['state']; ?></td>
                                        <td class="text-center"><?= $orders['payment_mode']; ?></td>
                                        <td class="text-center"><?php foreach($get_box_details as $box){ $totalBox = $totalBox+$box['qty']; } echo $totalBox; ?></td>
                                        <td class="text-center">
                                            <a type="button" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg<?= $orders['id']; ?>" class="btn btn-info shadow btn-xs sharp me-1"><i class="bi bi-binoculars-fill"></i></a>
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
                                        <!--    <button type="button" onclick="genLabel(<?= $orders['lr']; ?>)" id="genLabel<?= $orders['lr']; ?>" class="btn btn-light shadow btn-xs me-1">Generate label</button>-->
                                        <!--    <button data-bs-toggle="modal" data-bs-target=".bd-example-modal-generate-label<?= $orders['lr']; ?>" class="btn btn-light d-none gn-btn shadow btn-xs me-1">Generate label</button>-->
                                        <!--</td>-->
                                    </tr>
                                    
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
                                                                    <span class="col-3"><dt>Company name: </dt><dd><?= $get_consignee_details[0]['company']; ?></dd></span>
                                                                    <span class="col-3"><dt>Pincode: </dt><dd><?= $orders['del_pin']; ?></dd></span>
                                                                    <span class="col-3"><dt>City: </dt><dd><?= $get_consignee_details[0]['city']; ?></dd></span>
                                                                    <span class="col-9"><dt>Address: </dt><dd><?= $get_consignee_details[0]['address']; ?></dd></span>
                                                                    <span class="col-3"><dt>State: </dt><dd><?= $get_consignee_details[0]['state']; ?></dd></span>
                                                                    <span class="col-3"><dt>Phone: </dt><dd><?= $get_consignee_details[0]['phone']; ?></dd></span>
                                                                    <span class="col-6"><dt>Email: </dt><dd><?= $get_consignee_details[0]['email']; ?></dd></span>
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
                                    
                                    
                        			<div class="modal fade" id="modal-upload-pod<?= $orders['lr']; ?>">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                            		        <div class="modal-content">
                                                <form action="actions" <?php if(!empty($orders['pod_on_delivery'])){ ?>onsubmit="return confirm('Are you sure to want to update this POD?')"<?php } ?> method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" value="<?= $orders['lr']; ?>" class="form-control form-control-sm" name="orderLR" required>
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">POD Update for LR No. <?= $orders['lr']; ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group mb-3">
                                                                <label>POD File <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control form-control-sm" name="podFile" required>
                                                            </div>
                                                            <div class="form-group d-flex justify-content-end">
                                                                <button class="btn btn-sm btn-success shadow me-1" type="submit" name="podUpload">Upload <i class="bi bi-patch-check-fill"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                <?php
                                    $totalBox = 0;
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