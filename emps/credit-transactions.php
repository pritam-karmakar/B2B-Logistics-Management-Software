<?php
    if(!array_key_exists('userIs', $_GET)){
        echo '<script type="text/javascript" language="javascript">window.location="credit-control";</script>';
    }elseif(empty($_GET['userIs'])){
        echo '<script type="text/javascript" language="javascript">window.location="credit-control";</script>';
    }else{
        extract($_GET);
    include("assets/header.php");
    include("assets/sidebar.php");
    $getuser = $query->getData("*","users","",array("username"=>$userIs),"id","DESC","1")[0];
?>

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
	<div class="container-fluid">
		<div class="row">
		    <div class="card">
		        <div class="card-header">
		            <h3 class="card-title">Credit Transactions of <?= $getuser['party_name']." (".$userIs.")"; ?></h3>
		        </div>
		        <div class="card-body">
		             <div class="table-responsive">
                    	<table id="example3" class="display" style="width:100%">
                    		<thead>
                    			<tr>
                    				<th class="text-center">Date & Time</th>
                    				<th class="text-center">Amount</th>
                    				<th class="text-center">Balance</th>
                    				<th class="text-center">Remarks</th>
                    				<th class="text-center">Transaction Id</th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    		    <?php
                    		        $gettxns = $query->getData("*","credit_transactions","",array("type_id"=>$getuser['id']),"id","DESC","");
                                    if($gettxns != 0){
                                        foreach($gettxns as $var){
                    		    ?>
                        			<tr>
                        				<td class="text-center"><?= $var['date_time']; ?></td>
                        				<td class="text-center"><?= $var['amount']; ?></td>
                        				<td class="text-center"><?= $var['balance']; ?></td>
                        				<td class="text-center"><?= $var['details']; ?></td>
                        				<td class="text-center"><?= $var['txn_id']; ?></td>
                        			</tr>
                    			<?php
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
    }
?>