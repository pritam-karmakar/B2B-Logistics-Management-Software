<?php
$page = 1;
include('menu/header.php');
include('menu/navbar.php');
?>
    
    <!-- Content wrapper -->
    <div class="content-wrapper">
            
        <div class="container-xxl flex-grow-1 container-p-y">
      <!--      <div class="row d-flex justify-content-center">-->
    		<!--    <h2 class="py-3 mb-4">Revenues</h2>-->
    		    
    		<!--    <div class="col-xl-4 mb-3 col-sm-6">-->
    		<!--		<div class="card bg-primary text-white">-->
    		<!--			<div class="card-header border-0 flex-wrap">-->
    		<!--				<div class="revenue-date">-->
    		<!--					<span>Today's Revenue </span>-->
    		<!--					<h4 class="text-white">₹<?php //$userTodayRevenue = $query->getData('SUM(`total_charge`) as "branches_revenue"','orders','',array('order_date'=>date('d-m-Y'),'user_type'=>'branches','type_id'=>$user_id),'','','')[0]['branches_revenue'];  if(!empty($userTodayRevenue)){ echo number_format($userTodayRevenue,2); }else{ echo 0; } ?></h4>-->
    		<!--				</div>-->
    		<!--			</div>-->
    		<!--		</div>,-->
    		<!--	</div>-->
    		   
    		<!--    <div class="col-xl-4 mb-3 col-sm-6">-->
    		<!--		<div class="card bg-success text-white">-->
    		<!--			<div class="card-header border-0 flex-wrap">-->
    		<!--				<div class="revenue-date">-->
    		<!--					<span>This month's Total Revenue </span>-->
    		<!--					<h4 class="text-white">₹<?php //$thisMonthUserTotalRevenue = $query->getData('SUM(`total_charge`) as "this_months_total_revenue_user"','orders','',array(array('order_date','BETWEEN',date('Y-m-01'),"AND",date('Y-m-t')),array("user_type","=","branches"),array("type_id","=",$user_id)),'','','')[0]['this_months_total_revenue_user']; if(!empty($thisMonthUserTotalRevenue)){ echo number_format($thisMonthUserTotalRevenue,2); }else{ echo 0; } ?></h4>-->
    		<!--				</div>-->
    		<!--			</div>-->
    		<!--		</div>-->
    		<!--	</div>-->
    		<!--    <?php $prevFirstM = date("Y-m-01", strtotime("-6 months")); $prevLastM = date("Y-m-t", strtotime("last month")); ?>-->
    		    
    		<!--    <div class="col-xl-4 mb-3 col-sm-6">-->
    		<!--		<div class="card bg-warning text-white">-->
    		<!--			<div class="card-header border-0 flex-wrap">-->
    		<!--				<div class="revenue-date">-->
    		<!--					<span>Previous 6 month's Total Revenue</span>-->
    		<!--					<h4 class="text-white">₹<?php //$prevSixMonthUserTotalRevenue = $query->getData('SUM(`total_charge`) as "preSix_months_total_revenue_user"','orders','',array(array('order_date','BETWEEN',$prevFirstM,"AND",$prevLastM),array("user_type","=","branches"),array("type_id","=",$user_id)),'','','')[0]['preSix_months_total_revenue_user']; if(!empty($prevSixMonthUserTotalRevenue)){ echo number_format($prevSixMonthUserTotalRevenue,2); }else{ echo 0; } ?></h4>-->
    		<!--				</div>-->
    		<!--			</div>-->
    		<!--		</div>-->
    		<!--	</div>-->
    		<!--</div>-->
    		<!--<hr/>-->
    		<div class="row d-flex justify-content-start">
    		    <h2 class="py-3 mb-4">Orders</h2>
    			<div class="col-xl-4 mb-3 col-sm-6">
    				<div class="card bg-info text-white">
    					<div class="card-header border-0">
    						<div class="revenue-date">
    							<span class="text-white">Today's Total Orders </span>
    							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "branches_total_order"','orders','',array('order_date'=>date('Y-m-d'),'user_type'=>'branches','type_id'=>$user_id),'','','')[0]['branches_total_order']; ?></h4>
    						</div>
    					</div>
    				</div>
    			</div>
    		    
    		    <div class="col-xl-4 mb-3 col-sm-6">
    				<div class="card bg-secondary text-white">
    					<div class="card-header border-0 flex-wrap">
    						<div class="revenue-date">
    							<span>This month's Total Orders </span>
    							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "this_months_total_order_user"','orders','',array(array('order_date','BETWEEN',date('Y-m-01'),"AND",date('Y-m-t')),array("user_type","=","branches"),array("type_id","=",$user_id)),'','','')[0]['this_months_total_order_user']; ?></h4>
    						</div>
    					</div>
    				</div>
    			</div>
    		    
    		    <div class="col-xl-4 mb-3 col-sm-6">
    				<div class="card bg-primary text-white">
    					<div class="card-header border-0 flex-wrap">
    						<div class="revenue-date">
    							<span>Previous 6 month's Total Orders</span>
    							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "preSix_months_total_order_user"','orders','',array(array('order_date','BETWEEN',$prevFirstM,"AND",$prevLastM),array("user_type","=","branches"),array("type_id","=",$user_id)),'','','')[0]['preSix_months_total_order_user']; ?></h4>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    		<hr/>
    		<div class="row d-flex justify-content-start">
    		    <h2 class="py-3 mb-4">Requests</h2>
    		    <div class="col-xl-3 mb-3 col-sm-6">
    				<div class="card text-white" style="background-color: #28a745;">
    					<div class="card-header border-0 flex-wrap">
    						<div class="revenue-date">
    							<span>New Add Money Requests</span>
    							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "newAddMoneyReq"','add_money_requests','',array('status'=>'Pending','type'=>'branches','type_id'=>$user_id),'id','DESC','1')[0]['newAddMoneyReq']; ?></h4>
    						</div>
    					</div>
    				</div>
    			</div>
    		    <div class="col-xl-3 mb-3 col-sm-6">
    				<div class="card bg-warning text-white">
    					<div class="card-header border-0 flex-wrap">
    						<div class="revenue-date">
    							<span>New Appointment Requests</span>
    							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "newAppointReq"','appointments','',array('status'=>'requested','user_type'=>'branches','type_id'=>$user_id),'id','DESC','1')[0]['newAppointReq']; ?></h4>
    						</div>
    					</div>
    				</div>
    			</div>
    		    <div class="col-xl-3 mb-3 col-sm-6">
    				<div class="card bg-danger text-white">
    					<div class="card-header border-0 flex-wrap">
    						<div class="revenue-date">
    							<span>Open Support Tickets</span>
    							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "newTicketOpen"','tickets','',array('status'=>'Open','type'=>'branches','type_id'=>$branches),'id','DESC','1')[0]['newTicketOpen']; ?></h4>
    						</div>
    					</div>
    				</div>
    			</div>
    		    <div class="col-xl-3 mb-3 col-sm-6">
    				<div class="card bg-primary text-white">
    					<div class="card-header border-0 flex-wrap">
    						<div class="revenue-date">
    							<span>New Pickup Requests</span>
    							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "pick_up_req"','pickup_request','',array('type'=>'branches','type_id'=>$user_id),'id','DESC','')[0]['pick_up_req']; ?></h4>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
	</div>
    

<?php
include('menu/footer.php');
?>
    <!--<script>-->
    <!--    $(document).ready(function(){-->
    <!--        var type = 'branches';-->
    <!--        $.ajax({-->
    <!--            url: "get_order_status.php",-->
    <!--            type: "POST",-->
    <!--            data: {-->
    <!--                type: type,-->
    <!--            },-->
    <!--            beforeSend: function() {-->
    <!--                $("body").css('opacity', '0.3');-->
    <!--            },-->
    <!--            complete: function() {-->
    <!--                $("body").css('opacity', '1');-->
    <!--            },-->
    <!--            success: function(data) {-->
    <!--                console.log('Status changed successfully');-->
    <!--                if(data!==0)-->
    <!--                {-->
    <!--                    $("#get_status").html(data);-->
    <!--                }-->
    <!--            },-->
    <!--            error: function(xhr, status, error) {-->
    <!--                console.error("Error: " + status + " - " + error);-->
    <!--            }-->
    <!--        });-->
    <!--    });-->
    <!--</script>-->