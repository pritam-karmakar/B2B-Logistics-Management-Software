<?php
if(!empty($_GET) && array_key_exists('page', $_GET)){
    $page = $_GET['page'];
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
	    <form action="branch-report" method="GET" class="row mb-3">
	        <div class="col-xl-4 col-sm-6 form-group">
	            <label>Choose branch</label>
	            <select class="form-control" id="single-select" name="orderBranches">
	                <option value="" hidden>Choose one branch</option>
	                <?php
	                    $getuser = $query->getData('*','branches','',array('delete_status'=>'show'),'id','DESC','');
	                    if($getuser != 0){
	                        foreach($getuser as $user){
	               ?>
	                    <option value="<?= $user['branch_user_name']; ?>" <?php if(!empty($orderBranches) && $orderBranches == $user['branch_user_name']){ echo 'selected'; } ?>><?= $user['branch_name'].", Username: ".$user['branch_user_name']." ( mobile no.: ".$user['mobile_no']." )"; ?></option>
	               <?php
	                        }
	                    }
	                ?>
	            </select>
			</div>
	        <div class="col-xl-3 col-sm-6 form-group">
	            <label>One Date / Start Date</label>
	            <input type="date" class="form-control" name="startDate" value="<?php if(!empty($startDate)){ echo $startDate; } ?>">
			</div>
	        <div class="col-xl-3 col-sm-6 form-group">
	            <label>End Date</label>
	            <input type="date" class="form-control" name="endDate" value="<?php if(!empty($endDate)){ echo $endDate; } ?>">
			</div>
	        <div class="col-xl-2 col-sm-6 form-group d-flex align-items-end">
	            <button class="btn me-1 shadow btn-block" style="background-color: #28a745; color: #fff;">Search</button>
			</div>
	    </form>
		<div class="row">
		    <div class="card">
		        <div class="card-header">
		            <h3 class="card-title">
		                <?php if(!empty($orderBranches)){ echo $orderBranches."<span style='text-transform: lowercase;'>'s</span>"; }else{ echo 'All Branches'; } ?> Booking Orders
		            </h3>
		            <form action="act" method="POST">
	                    <input type="text" hidden class="form-control" name="ordersOfBranch" value="<?php if(!empty($orderBranches)){ echo $orderBranches; } ?>">
	                    <input type="date" hidden class="form-control" name="startDate" value="<?php if(!empty($startDate)){ echo $startDate; } ?>">
		                <input type="date" hidden class="form-control" name="endDate" value="<?php if(!empty($endDate)){ echo $endDate; } ?>">
		                <button class="btn btn-info btn-sm" name="exportBranchesOrders" type="submit">Export All <i class="bi bi-cloud-download-fill"></i></button>
		            </form>
		        </div>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example5" class="display table" style="min-width: 845px">
                    		<thead>
                    			<tr>
                    				<th class="text-center" hidden>Serial No.</th>
                    				<th class="text-center">Order Id</th>
                                    <th class="text-center">LR No.</th>
                                    <th class="text-center">Master Waybill No.</th>
                                    <th class="text-center">Manifested Date</th>
                                    <th class="text-center">Pickup Date</th>
                                    <th class="text-center">Delivered Date</th>
                                    <th class="text-center">Invoice No.</th>
                                    <th class="text-center">Ewaybill</th>
                                    <th class="text-center">Count of Boxes</th>
                                    <th class="text-center">Branch Name (username)</th>
                                    <th class="text-center">Consigner Details</th>
                                    <th class="text-center">Consigner Contacts</th>
                                    <th class="text-center">Consigner Address</th>
                                    <th class="text-center">Consignee Details</th>
                                    <th class="text-center">Consignee Contacts</th>
                                    <th class="text-center">Consignee Address</th>
                                    <th class="text-center">Warehouse Name</th>
                                    <th class="text-center">Origin Center</th>
                                    <th class="text-center">Destination Center</th>
                                    <th class="text-center">Origin City</th>
                                    <th class="text-center">Destination City</th>
                                    <th class="text-center">Origin Pincode</th>
                                    <th class="text-center">Destination Pincode</th>
                                    <th class="text-center">Billing Type</th>
                                    <th class="text-center">Product Type</th>
                                    <th class="text-center">Product Name</th>
                                    <th class="text-center">Client Reference No.</th>
                                    <th class="text-center">Invoice Value</th>
                                    <th class="text-center">COD Amount</th>
                                    <th class="text-center">Profit Amount</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Rate</th>
                                    <th class="text-center">Weight</th>
                                    <th class="text-center">Volumatric Weight</th>
                                    <th class="text-center">Freight Charge</th>
                                    <th class="text-center">ROV/Insurance</th>
                                    <th class="text-center">ODA</th>
                                    <th class="text-center">COD Charge</th>
                                    <th class="text-center">Fuel Surcharge</th>
                                    <th class="text-center">AWB Charge</th>
                                    <th class="text-center">FOV Surcharge</th>
                                    <th class="text-center">Handeling Charge</th>
                                    <th class="text-center">Cartage Charge</th>
                                    <th class="text-center">Pickup Charge</th>
                                    <th class="text-center">Damarage Charge</th>
                                    <th class="text-center">ODA Surcharge</th>
                                    <th class="text-center">Special Delivery / Appointment Charge</th>
                                    <th class="text-center">Sub Total</th>
                                    <th class="text-center">Discount Amount</th>
                                    <th class="text-center">IGST</th>
                                    <th class="text-center">CGST</th>
                                    <th class="text-center">SGST</th>
                                    <th class="text-center">Total Amount</th>
                                    <th class="text-center">Consigner GSTIN</th>
                                    <th class="text-center">Consignee GSTIN</th>
                                    <th class="text-center">HSN</th>
                                    <th class="text-center">CFT</th>
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
                                    $showusercond = array("user_type"=>"branches");
                                    if(!empty($orderBranches)){
                                        $showusercond['type_id'] = $query->getData('`id`','branches','',array('branch_user_name'=>$orderBranches),'id','DESC','1')[0]['id'];
                                    }
                                    if(!empty($startDate) && empty($endDate)){
                                        $showusercond['order_date'] = $startDate;
                                    }
                                    if(!empty($startDate) && !empty($endDate)){
                                        unset($showusercond);
                                        $showusercond = array(array("user_type","=","branches"));
                                        if(!empty($orderBranches)){
                                            $showusercond[] = array("type_id","=",$query->getData('`id`','branches','',array('branch_user_name'=>$orderBranches),'id','DESC','1')[0]['id']);
                                        }
                                        $showusercond[] = array('orders`.`order_date','BETWEEN',$startDate,"AND",$endDate);
                                    }
                                    $order_details = $query->getData('*','orders','',$showusercond,'id','DESC',$limit);
                                    $ordersCount = $query->getData('COUNT(`id`) as "ordersCount"','orders','',$showusercond,'id','DESC','')[0]['ordersCount'];
                                    foreach($order_details as $orders){
                                        $getBranch = $query->getData('*','branches','',array('id'=>$orders['type_id']),'','','')[0];
                                        $get_consigner_details = $query->getData('*','consigner_details','',array("order_id"=>$orders['order_id']),'','','')[0];
                                        $get_consignee_details = $query->getData('*','consignee_details','',array("order_id"=>$orders['order_id']),'','','')[0];
                                        $boxCount = $query->getData('SUM(`qty`) as "box_count"','box_details','',array('order_id'=>$orders['order_id']),'id','DESC','')[0]['box_count'];
                                        $getwarehouse = $query->getData('*','warehouses','',array('id'=>$orders['warehouse_id']),'id','DESC','1')[0];
                                        $charges = $query->getData('*','charges','',array('id'=>'1'),'id','DESC','1')[0];
                                        $subtotalCharge = round($orders['total_charge']-($orders['igst_amount']+$orders['cgst_amount']+$orders['sgst_amount']), 2);
                                        $invs = $query->getData('*','invoice_details','',array('order_id'=>$orders['order_id']),'id','DESC','');
                                        $inv_numbers;
                                        $ewaybills;
                                        if($invs != 0){
                                            foreach($invs as $inv){
                                                $inv_no[] = $inv['inv_no'];
                                                $eway_no[] = $inv['ewaybill'];
                                            }
                                            if(!empty($inv_no)){
                                                $inv_numbers = trim(implode(", ", $inv_no), ", ");
                                            }
                                            if(!empty($eway_no)){
                                                $ewaybills = trim(implode(", ", $eway_no), ", ");
                                            }
                                        }
                                        $productType = $query->getData('*','order_items','',array('id'=>$orders['item_type']),'id','DESC','1')[0]['item'];
                                ?>
                                    <tr>
                                        <td class="text-center" hidden><?= $sl; ?></td>
                                        <td class="text-center"><?= $orders['order_id']; ?></td>
                                        <td class="text-center"><?= $orders['lr']; ?></td>
                                        <td class="text-center"><?= $orders['master_waybill']; ?></td>
                                        <td class="text-center"><?= $orders['order_date']." ".date_format(date_create($orders['order_time']), "H:i:s"); ?></td>
                                        <td class="text-center"><?= $orders['pickup_date']; ?></td>
                                        <td class="text-center"><?= $orders['delivered_date']; ?></td>
                                        <td class="text-center"><?= $inv_numbers; ?></td>
                                        <td class="text-center"><?= $ewaybills; ?></td>
                                        <td class="text-center"><?= $boxCount; ?></td>
                                        <td class="text-center"><?= $getBranch['branch_name']."- (".$getBranch['branch_user_name'].")"; ?></td>
                                        <td class="text-center"><?= $get_consigner_details['name'].", ".$get_consigner_details['company_name']; ?></td>
                                        <td class="text-center"><?= $get_consigner_details['phone'].", ".$get_consigner_details['email']; ?></td>
                                        <td class="text-center"><?= $get_consigner_details['address'].", ".$get_consigner_details['city'].", ".$get_consigner_details['state']; ?></td>
                                        <td class="text-center"><?= $get_consignee_details['name'].", ".$get_consignee_details['company_name']; ?></td>
                                        <td class="text-center"><?= $get_consignee_details['phone'].", ".$get_consignee_details['email']; ?></td>
                                        <td class="text-center"><?= $get_consignee_details['address'].", ".$get_consignee_details['city'].", ".$get_consignee_details['state']; ?></td>
                                        <td class="text-center"><?= $getwarehouse['warehouse_name']; ?></td>
                                        <td class="text-center"><?= $orders['origin_center']; ?></td>
                                        <td class="text-center"><?= $orders['destination_center']; ?></td>
                                        <td class="text-center"><?= $orders['origin_city']; ?></td>
                                        <td class="text-center"><?= $orders['destination_city']; ?></td>
                                        <td class="text-center"><?= $orders['pick_pin']; ?></td>
                                        <td class="text-center"><?= $orders['del_pin']; ?></td>
                                        <td class="text-center"><?= $orders['payment_mode']; ?></td>
                                        <td class="text-center"><?= $productType; ?></td>
                                        <td class="text-center"><?= $orders['description']; ?></td>
                                        <td class="text-center"><?= $orders['subident']; ?></td>
                                        <td class="text-center"><?= $orders['invoice_amount']; ?></td>
                                        <td class="text-center"><?= $orders['cod_amount']; ?></td>
                                        <td class="text-center"><?= $orders['profit_amount']; ?></td>
                                        <td class="text-center"><?= $orders['status']; ?></td>
                                        <td class="text-center"><?php if(empty($orders['weight_charge'])){ $orders['weight_charge'] = 0; } echo round($orders['weight_charge']/$orders['weight'], 2); ?></td>
                                        <td class="text-center"><?= $orders['weight']; ?></td>
                                        <td class="text-center"><?= $orders['vol_weight']; ?></td>
                                        <td class="text-center"><?= $orders['weight_charge']; ?></td>
                                        <td class="text-center"><?= $orders['insurance']; ?></td>
                                        <td class="text-center"><?= $orders['oda']; ?></td>
                                        <td class="text-center"><?= $orders['cod_charge']; ?></td>
                                        <td class="text-center"><?= $orders['fuel_surcharge']; ?></td>
                                        <td class="text-center"><?= $orders['awb_charge']; ?></td>
                                        <td class="text-center"><?= $orders['fob_surcharge']; ?></td>
                                        <td class="text-center"><?= $orders['handeling_charge']; ?></td>
                                        <td class="text-center"><?= $orders['cartage_charge']; ?></td>
                                        <td class="text-center"><?= $orders['pickup_charge']; ?></td>
                                        <td class="text-center"><?= $orders['damage_surcharge']; ?></td>
                                        <td class="text-center"><?= $orders['oda_surcharge']; ?></td>
                                        <td class="text-center"><?= $orders['special_delivery_charge']; ?></td>
                                        <td class="text-center"><?= $subtotalCharge; ?></td>
                                        <td class="text-center">0</td>
                                        <td class="text-center"><?= $orders['igst_amount']; ?></td>
                                        <td class="text-center"><?= $orders['cgst_amount']; ?></td>
                                        <td class="text-center"><?= $orders['sgst_amount']; ?></td>
                                        <td class="text-center"><?= $orders['total_charge']; ?></td>
                                        <td class="text-center"><?= $orders['seller_gst_tin']; ?></td>
                                        <td class="text-center"><?= $orders['consignee_gst_tin']; ?></td>
                                        <td class="text-center"><?= $orders['hsn']; ?></td>
                                        <td class="text-center"><?= $orders['cft_type']; ?></td>
                                    </tr>
                                <?php
                                    unset($inv_no);
                                    unset($eway_no);
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