<?php
include("assets/header.php");
include("assets/sidebar.php");
?>

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
	<div class="container-fluid">
		<div class="row d-flex justify-content-start">
		    <h2 class="dashboard_bar">Revenues</h2>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-primary text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Today's Total Revenue</span>
							<h4 class="text-white">₹<?php $todaysRevenue = $query->getData('SUM(`total_charge`) as "todays_revenue"','orders','',array('order_date'=>date('Y-m-d')),'','','')[0]['todays_revenue']; if(!empty($todaysRevenue)){ echo round($todaysRevenue, 2); }else{ echo 0; } ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-warning text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Today's Revenue From Branches</span>
							<h4 class="text-white">₹<?php $branchTodaysRevenue = $query->getData('SUM(`total_charge`) as "branches_revenue"','orders','',array('order_date'=>date('Y-m-d'),'user_type'=>'branches'),'','','')[0]['branches_revenue']; if(!empty($branchTodaysRevenue)){ echo round($branchTodaysRevenue, 2); }else{ echo 0; } ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-info text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Today's Revenue From Users</span>
							<h4 class="text-white">₹<?php $userTodayRevenue = $query->getData('SUM(`total_charge`) as "users_revenue"','orders','',array('order_date'=>date('Y-m-d'),'user_type'=>'users'),'','','')[0]['users_revenue'];  if(!empty($userTodayRevenue)){ echo round($userTodayRevenue, 2); }else{ echo 0; } ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-primary text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>This month's Total Revenue</span>
							<h4 class="text-white">₹<?php $thisMonthTotalRevenue = $query->getData('SUM(`total_charge`) as "this_months_total_revenue"','orders','',array(array('order_date','BETWEEN',date('Y-m-01'),"AND",date('Y-m-t'))),'','','')[0]['this_months_total_revenue'];  if(!empty($thisMonthTotalRevenue)){ echo round($thisMonthTotalRevenue, 2); }else{ echo 0; } ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-warning text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>This month's Total Revenue From Branches</span>
							<h4 class="text-white">₹<?php $thisMonthBranchTotalRevenue = $query->getData('SUM(`total_charge`) as "this_months_total_revenue_branch"','orders','',array(array('order_date','BETWEEN',date('Y-m-01'),"AND",date('Y-m-t')),array("user_type","=","branches")),'','','')[0]['this_months_total_revenue_branch']; if(!empty($thisMonthBranchTotalRevenue)){ echo round($thisMonthBranchTotalRevenue, 2); }else{ echo 0; } ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-info text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>This month's Total Revenue From Users</span>
							<h4 class="text-white">₹<?php $thisMonthUserTotalRevenue = $query->getData('SUM(`total_charge`) as "this_months_total_revenue_user"','orders','',array(array('order_date','BETWEEN',date('Y-m-01'),"AND",date('Y-m-t')),array("user_type","=","users")),'','','')[0]['this_months_total_revenue_user']; if(!empty($thisMonthUserTotalRevenue)){ echo round($thisMonthUserTotalRevenue, 2); }else{ echo 0; } ?></h4>
						</div>
					</div>
				</div>
			</div>
		<?php $prevFirstM = date("Y-m-01", strtotime("-6 months")); $prevLastM = date("Y-m-t", strtotime("last month")); ?>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-primary text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Previous 6 month's Total Revenue</span>
							<h4 class="text-white">₹<?php $prevSixMonthTotalRevenue = $query->getData('SUM(`total_charge`) as "preSix_months_total_revenue"','orders','',array(array('order_date','BETWEEN',$prevFirstM,"AND",$prevLastM)),'','','')[0]['preSix_months_total_revenue']; if(!empty($prevSixMonthTotalRevenue)){ echo round($prevSixMonthTotalRevenue, 2); }else{ echo 0; } ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-warning text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Previous 6 month's Total Revenue From Branches</span>
							<h4 class="text-white">₹<?php $prevSixMonthBranchTotalRevenue = $query->getData('SUM(`total_charge`) as "preSix_months_total_revenue_branch"','orders','',array(array('order_date','BETWEEN',$prevFirstM,"AND",$prevLastM),array("user_type","=","branches")),'','','')[0]['preSix_months_total_revenue_branch']; if(!empty($prevSixMonthBranchTotalRevenue)){ echo round($prevSixMonthBranchTotalRevenue, 2); }else{ echo 0; } ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-info text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Previous 6 month's Total Revenue From Users</span>
							<h4 class="text-white">₹<?php $prevSixMonthUserTotalRevenue = $query->getData('SUM(`total_charge`) as "preSix_months_total_revenue_user"','orders','',array(array('order_date','BETWEEN',$prevFirstM,"AND",$prevLastM),array("user_type","=","users")),'','','')[0]['preSix_months_total_revenue_user']; if(!empty($prevSixMonthUserTotalRevenue)){ echo round($prevSixMonthUserTotalRevenue, 2); }else{ echo 0; } ?></h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr/>
		<div class="row d-flex justify-content-start">
		    <h2 class="dashboard_bar">Orders</h2>
			<div class="col-xl-2 col-sm-6">
				<div class="card text-white" style="background-color: #28a745;">
					<div class="card-header border-0">
						<div class="revenue-date">
							<span class="text-white">Today's Total Orders</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "total_order"','orders','',array('order_date'=>date('Y-m-d')),'','','')[0]['total_order']; ?></h4>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-2 col-sm-6">
				<div class="card bg-warning text-white">
					<div class="card-header border-0">
						<div class="revenue-date">
							<span class="text-white">Today's Total Orders From Branches</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "branches_total_order"','orders','',array('order_date'=>date('Y-m-d'),'user_type'=>'branches'),'','','')[0]['branches_total_order']; ?></h4>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-2 col-sm-6">
				<div class="card bg-info text-white">
					<div class="card-header border-0">
						<div class="revenue-date">
							<span class="text-white">Today's Total Orders From Users</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "users_total_order"','orders','',array('order_date'=>date('Y-m-d'),'user_type'=>'users'),'','','')[0]['users_total_order']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card text-white" style="background-color: #28a745;">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>This month's Total Orders</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "this_months_total_order"','orders','',array(array('order_date','BETWEEN',date('Y-m-01'),"AND",date('Y-m-t'))),'','','')[0]['this_months_total_order']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-warning text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>This month's Total Orders From Branches</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "this_months_total_order_branch"','orders','',array(array('order_date','BETWEEN',date('Y-m-01'),"AND",date('Y-m-t')),array("user_type","=","branches")),'','','')[0]['this_months_total_order_branch']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-info text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>This month's Total Orders From Users</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "this_months_total_order_user"','orders','',array(array('order_date','BETWEEN',date('Y-m-01'),"AND",date('Y-m-t')),array("user_type","=","users")),'','','')[0]['this_months_total_order_user']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card text-white" style="background-color: #28a745;">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Previous 6 month's Total Orders</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "preSix_months_total_order"','orders','',array(array('order_date','BETWEEN',$prevFirstM,"AND",$prevLastM)),'','','')[0]['preSix_months_total_order']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-warning text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Previous 6 month's Total Orders From Branches</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "preSix_months_total_order_branch"','orders','',array(array('order_date','BETWEEN',$prevFirstM,"AND",$prevLastM),array("user_type","=","branches")),'','','')[0]['preSix_months_total_order_branch']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-info text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Previous 6 month's Total Orders From Users</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "preSix_months_total_order_user"','orders','',array(array('order_date','BETWEEN',$prevFirstM,"AND",$prevLastM),array("user_type","=","users")),'','','')[0]['preSix_months_total_order_user']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr/>
		<div class="row d-flex justify-content-start">
		    <h2 class="dashboard_bar">Requests</h2>
		    <div class="col-xl-2 col-sm-6">
				<div class="card text-white" style="background-color: #28a745;">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>New Add Money Requests</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "newAddMoneyReq"','add_money_requests','',array('status'=>'Pending'),'id','DESC','1')[0]['newAddMoneyReq']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-warning text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>New Appointment Requests</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "newAppointReq"','appointments','',array('status'=>'requested'),'id','DESC','1')[0]['newAppointReq']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-danger text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Open Support Tickets</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "newTicketOpen"','tickets','',array('status'=>'Open'),'id','DESC','1')[0]['newTicketOpen']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-primary text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>New Cashbook Requests</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "newAddCashbook"','cashbook','',array('approve_status'=>'Pending'),'id','DESC','')[0]['newAddCashbook']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-danger text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Pending COD Remittances</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "pendingCODremittance"','orders','',array('payment_mode'=>'CoD','cod_remittance_status'=>'Pending'),'id','DESC','')[0]['pendingCODremittance']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr/>
		<div class="row d-flex justify-content-start">
		    <h2 class="dashboard_bar">All Users</h2>
		    <div class="col-xl-2 col-sm-6">
				<div class="card text-white" style="background-color: #f14e01;">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Total Users</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "totalUser"','users','',array('delete_status'=>'show'),'id','DESC','')[0]['totalUser']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-primary text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Total Paid Users</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "TotalPaidUser"','users','',array('party_type'=>'Paid','delete_status'=>'show'),'id','DESC','')[0]['TotalPaidUser']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-info text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Total To-Pay Users</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "totalToPayUser"','users','',array('party_type'=>'To-Pay','delete_status'=>'show'),'id','DESC','')[0]['totalToPayUser']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-warning text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Total TBB Users</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "totalTBBUser"','users','',array('party_type'=>'TBB','delete_status'=>'show'),'id','DESC','')[0]['totalTBBUser']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card text-white" style="background-color: #28a745;">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Total Active Users</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "totalActiveUser"','users','',array('status'=>'Unblock','delete_status'=>'show'),'id','DESC','')[0]['totalActiveUser']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-danger text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Total Deactive Users</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "totalDeactiveUser"','users','',array('status'=>'Block','delete_status'=>'show'),'id','DESC','')[0]['totalDeactiveUser']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr/>
		<div class="row d-flex justify-content-start">
		    <h2 class="dashboard_bar">All Branches</h2>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-warning text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Total Branches Type</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "totalBranch"','branches','',array('type'=>'branch','delete_status'=>'show'),'id','DESC','')[0]['totalBranch']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-secondary text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Total Agents Type</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "totalAgent"','branches','',array('type'=>'agent','delete_status'=>'show'),'id','DESC','')[0]['totalAgent']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card text-white" style="background-color: #28a745;">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Total Active Branches</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "totalActiveBranch"','branches','',array('status'=>'Unblock','delete_status'=>'show'),'id','DESC','')[0]['totalActiveBranch']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-danger text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Total Deactive Branches</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "totalDeactiveBranch"','branches','',array('status'=>'Block','delete_status'=>'show'),'id','DESC','')[0]['totalDeactiveBranch']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr/>
		<div class="row d-flex justify-content-start">
		    <h2 class="dashboard_bar">All Emps</h2>
		    <div class="col-xl-2 col-sm-6">
				<div class="card text-white" style="background-color: #571a92;">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Total employees</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "empsId"','employees','',array('delete_status'=>'show'),'id','DESC','')[0]['empsId']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card text-white" style="background-color: #28a745;">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Total Active Emps</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "totalActiveEmps"','employees','',array('status'=>'Unblock','delete_status'=>'show'),'id','DESC','')[0]['totalActiveEmps']; ?></h4>
						</div>
					</div>
				</div>
			</div>
		    <div class="col-xl-2 col-sm-6">
				<div class="card bg-danger text-white">
					<div class="card-header border-0 flex-wrap">
						<div class="revenue-date">
							<span>Total Deactive Emps</span>
							<h4 class="text-white"><?= $query->getData('COUNT(`id`) as "totalDeactiveEmps"','employees','',array('status'=>'Block','delete_status'=>'show'),'id','DESC','')[0]['totalDeactiveEmps']; ?></h4>
						</div>
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