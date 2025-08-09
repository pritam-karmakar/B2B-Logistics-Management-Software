<?php
session_start();
include("../database/db.php");
include("../functions/all-functions.php");
date_default_timezone_set("Asia/Kolkata");
if(isset($_SESSION['ltl_admin_id']) && !empty($_SESSION['ltl_admin_id']) && isset($_SESSION['ltl_admin_username']) && !empty($_SESSION['ltl_admin_username'])){
    $ltl_admin_id = $_SESSION['ltl_admin_id'];
}else{
    header("location:index");
}
$newquery = new query();
$newfunc = new allfunctions();
$company = $newquery->getData('*','company_master','',array('id'=>'1'),'id','DESC','1')[0];


// update company
if(isset($_POST['saveCompanyMaster'])){
    if(!empty($_POST['passwordOf6CFT'])){
        $cft6Passes = $newfunc->real_string(trim($_POST['passwordOf6CFT'], " "));
        $upd6 = $newquery->updateData('3pls',array('password'=>$cft6Passes),'api_token_name','6CFT');
        if(!$upd6){
            $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
        }
    }
    if(!empty($_POST['passwordOf8CFT'])){
        $cft8Passes = $newfunc->real_string(trim($_POST['passwordOf8CFT'], " "));
        $upd8 = $newquery->updateData('3pls',array('password'=>$cft8Passes),'api_token_name','8CFT');
        if(!$upd8){
            $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
        }
    }
    if(!empty($_POST['passwordOf10CFT'])){
        $cft10Passes = $newfunc->real_string(trim($_POST['passwordOf10CFT'], " "));
        $upd10 = $newquery->updateData('3pls',array('password'=>$cft10Passes),'api_token_name','10CFT');
        if(!$upd10){
            $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
        }
    }
    if(!empty($_POST['passwordOfemailAddress'])){
        $passwordOfemailAddress = $newfunc->real_string(trim($_POST['passwordOfemailAddress'], " "));
        $passwordOfemailAddressUPD = $newquery->updateData('company_master',array('email_id_password'=>$passwordOfemailAddress),'id','1');
        if(!$passwordOfemailAddressUPD){
            $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
        }
    }
    $emailAddressUPD = $newquery->updateData('company_master',array('email_id'=>$newfunc->real_string(trim($_POST['emailAddress'], " "))),'id','1');
    if($emailAddressUPD){
        $newfunc->alertRedirect("You have successfully updated the Company master",$_SERVER['HTTP_REFERER']);
    }else{
        $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
    }
    
}


// update user's freight
if(isset($_POST['savethisUsersFreight'])){
    $username = $newfunc->real_string(trim($_POST['UserName'], " "));
    $percentage = $newfunc->real_string(trim($_POST['percent'], " "));
    $getDefault = $newquery->getData('*','default_fright_master','','','id','DESC','1')[0];
    foreach($getDefault as $defKey => $defVal){
        $forUserArr[$defKey] = round(floatval($defVal+floatval(($defVal*$percentage)/100)),2);
    }
    unset($forUserArr['id']);
    $getuserid = $newquery->getData('`id`','users','',array('username'=>$username),'id','DESC','1');
    if($getuserid != 0){
        $updUsersFreight = $newquery->updateData('users_fright_master',$forUserArr,'user_id',$getuserid[0]['id']);
        if($updUsersFreight){
            $newfunc->alertRedirect("Freight successfully updated for this user",$_SERVER['HTTP_REFERER']);
        }else{
            $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
        }
    }else{
        $newfunc->alertRedirect("User not found! Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
    }
}


// update user's freight
if(isset($_POST['savethisBranchesFreight'])){
    $BranchUserName = $newfunc->real_string(trim($_POST['BranchUserName'], " "));
    $percentage = $newfunc->real_string(trim($_POST['percent'], " "));
    $getDefault = $newquery->getData('*','default_fright_master','','','id','DESC','1')[0];
    foreach($getDefault as $defKey => $defVal){
        $forBranchArr[$defKey] = round(floatval($defVal+floatval(($defVal*$percentage)/100)),2);
    }
    unset($forBranchArr['id']);
    $getbranchid = $newquery->getData('`id`','branches','',array('branch_user_name'=>$BranchUserName),'id','DESC','1');
    if($getbranchid != 0){
        $updUsersFreight = $newquery->updateData('branches_fright_master',$forBranchArr,'branch_id',$getbranchid[0]['id']);
        if($updUsersFreight){
            $newfunc->alertRedirect("Freight successfully updated for this branch",$_SERVER['HTTP_REFERER']);
        }else{
            $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
        }
    }else{
        $newfunc->alertRedirect("Branch not found! Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
    }
}


// cod remittance
if(isset($_POST['payCODamount'])){
    extract($_POST);
    $visible = $newfunc->real_string(trim($visible, " "));
    $codUsersorBranches = $newfunc->real_string(trim($codUsersorBranches, " "));
    if($visible == "users"){
        $getuserArr = array('username'=>$codUsersorBranches);
    }elseif($visible == "branches"){
        $getuserArr = array('branch_user_name'=>$codUsersorBranches);
    }
    $orderD = $newquery->getData('*','orders','',array('lr'=>$codLR[0]),'id','DESC','1')[0];
    foreach($codLR as $lRs):
        $CODamount = $CODamount+$newquery->getData('`cod_amount`','orders','',array('lr'=>$lRs),'id','DESC','1')[0]['cod_amount'];
    endforeach;
    $thisUserId = $orderD['type_id'];
    $transactionId = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($transactionId, " ")));
    $getuser = $newquery->getData('*',$visible,'',array('id'=>$thisUserId),'id','DESC','1');
    if($getuser != 0){
        $getuser = $getuser[0];
        $balance = floatval($getuser['wallet_balance'] + $CODamount);
        $addatetime = date('Y-m-d H:i:s');
        $adtransactions = $newquery->insertData('transactions',array('date_time'=>$addatetime,'user_type'=>$visible,'user_id'=>$getuser['id'],'amount'=>$CODamount,'balance'=>$balance,'type'=>'Manual','details'=>'COD amount has added to wallet',"txn_id_type"=>"Different",'txn_id'=>$transactionId,'status'=>'Credit'));
        if($adtransactions){
            $adgetTxn = $newquery->getData('*','transactions','',array('txn_id_type'=>'Serial'),'id','DESC','1');
          	if($adgetTxn != 0){
                $adtxn_id = "KINGFISH".(str_replace("KINGFISH","",$adgetTxn[0]['txn_id'])+1);
            }else{
                $adtxn_id = 'KINGFISH100000';
            }
            $balance2 = floatval($balance - $CODamount);
            $adtransactions2 = $newquery->insertData('transactions',array('date_time'=>$addatetime,'user_type'=>$visible,'user_id'=>$getuser['id'],'amount'=>$CODamount,'balance'=>$balance2,'type'=>'Manual','details'=>'COD amount has withdrawaled and sent to bank account','txn_id'=>$adtxn_id));
            if($adtransactions2){
                foreach($codLR as $lRs):
                    $remittanceStatus = $newquery->updateData('orders',array('cod_remittance_status'=>'Paid'),'lr',$lRs);
                endforeach;
                if($remittanceStatus){
                    $newfunc->alertRedirect("COD Remittance successfully done",$_SERVER['HTTP_REFERER']);
                }else{
                    $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
                }
            }else{
                $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
            }
        }else{
            $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
        }
    }else{
        $newfunc->alertRedirect("User not found! Contact with administrator",$_SERVER['HTTP_REFERER']);
    }
}


// new update
// franchise to pay profit remittance
if(isset($_POST['payProfitamount'])){
    extract($_POST);
    $visible = $newfunc->real_string(trim($visible, " "));
    $frantoPayUsersorBranches = $newfunc->real_string(trim($frantoPayUsersorBranches, " "));
    if($visible == "users"){
        $getuserArr = array('username'=>$frantoPayUsersorBranches);
    }elseif($visible == "branches"){
        $getuserArr = array('branch_user_name'=>$frantoPayUsersorBranches);
    }
    $orderD = $newquery->getData('*','orders','',array('lr'=>$frantoPayLR[0]),'id','DESC','1')[0];
    foreach($frantoPayLR as $lRs):
        $ProfitAmount = $ProfitAmount+$newquery->getData('`profit_amount`','orders','',array('lr'=>$lRs),'id','DESC','1')[0]['profit_amount'];
    endforeach;
    $thisUserId = $orderD['type_id'];
    $transactionId = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($transactionId, " ")));
    $getuser = $newquery->getData('*',$visible,'',array('id'=>$thisUserId),'id','DESC','1');
    if($getuser != 0){
        $getuser = $getuser[0];
        $balance = floatval($getuser['wallet_balance'] + $ProfitAmount);
        $addatetime = date('Y-m-d H:i:s');
        $adtransactions = $newquery->insertData('transactions',array('date_time'=>$addatetime,'user_type'=>$visible,'user_id'=>$getuser['id'],'amount'=>$ProfitAmount,'balance'=>$balance,'type'=>'Manual','details'=>'Franchise to pay profit amount has added to wallet',"txn_id_type"=>"Different",'txn_id'=>$transactionId,'status'=>'Credit'));
        if($adtransactions){
            $adgetTxn = $newquery->getData('*','transactions','',array('txn_id_type'=>'Serial'),'id','DESC','1');
          	if($adgetTxn != 0){
                $adtxn_id = "KINGFISH".(str_replace("KINGFISH","",$adgetTxn[0]['txn_id'])+1);
            }else{
                $adtxn_id = 'KINGFISH100000';
            }
            $balance2 = floatval($balance - $ProfitAmount);
            $adtransactions2 = $newquery->insertData('transactions',array('date_time'=>$addatetime,'user_type'=>$visible,'user_id'=>$getuser['id'],'amount'=>$ProfitAmount,'balance'=>$balance2,'type'=>'Manual','details'=>'Franchise to pay profit amount has withdrawaled and sent to bank account','txn_id'=>$adtxn_id));
            if($adtransactions2){
                foreach($frantoPayLR as $lRs):
                    $remittanceStatus = $newquery->updateData('orders',array('franchise_to_pay_remittance_status'=>'Paid'),'lr',$lRs);
                endforeach;
                if($remittanceStatus){
                    $newfunc->alertRedirect("Franchise to pay Remittance successfully done",$_SERVER['HTTP_REFERER']);
                }else{
                    $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
                }
            }else{
                $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
            }
        }else{
            $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
        }
    }else{
        $newfunc->alertRedirect("User not found! Contact with administrator",$_SERVER['HTTP_REFERER']);
    }
}
// new update


// clear due of to pay amount of user
if(isset($_POST['clearToPayDue'])){
    extract($_POST);
    $toPayvisibleType = $newfunc->real_string(trim($visible, " "));
    $toPayUsersorBranches = $newfunc->real_string(trim($toPayUsersorBranches, " "));
    $toPayClearAm = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($toPayClearAm, " ")));
    $transactionId = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($transactionId, " ")));
    if($toPayvisibleType == "users"){
        $userNameType = "username";
    }elseif($toPayvisibleType == "branches"){
        $userNameType = "branch_user_name";
    }
    $getuser = $newquery->getData('*',$toPayvisibleType,'',array($userNameType=>$toPayUsersorBranches),'id','DESC','1');
    if($getuser != 0){
        $getuser = $getuser[0];
        if($toPayClearAm <= $getuser['to_pay_due']){
            $newDue = floatval($getuser['to_pay_due'] - $toPayClearAm);
            $balance = floatval($getuser['wallet_balance'] + $toPayClearAm);
            $updUser = $newquery->updateData($toPayvisibleType,array('to_pay_due'=>$newDue),$userNameType,$toPayUsersorBranches);
            if($updUser){
                $addatetime = date('Y-m-d H:i:s');
                $adtransactions = $newquery->insertData('transactions',array('date_time'=>$addatetime,'user_type'=>$toPayvisibleType,'user_id'=>$getuser['id'],'amount'=>$toPayClearAm,'balance'=>$balance,'type'=>'Manual','details'=>'Add money manually for to pay due',"txn_id_type"=>"Different",'txn_id'=>$transactionId,'status'=>'Credit'));
                if($adtransactions){
                    $adgetTxn = $newquery->getData('*','transactions','',array('txn_id_type'=>'Serial'),'id','DESC','1');
                  	if($adgetTxn != 0){
                        $adtxn_id = "KINGFISH".(str_replace("KINGFISH","",$adgetTxn[0]['txn_id'])+1);
                    }else{
                        $adtxn_id = 'KINGFISH100000';
                    }
                    $addatetime2 = date('Y-m-d H:i:s');
                    $balance2 = floatval($balance - $toPayClearAm);
                    $adtransactions2 = $newquery->insertData('transactions',array('date_time'=>$addatetime2,'user_type'=>$toPayvisibleType,'user_id'=>$getuser['id'],'amount'=>$toPayClearAm,'balance'=>$balance2,'type'=>'Manual','details'=>'Deducted for To-Pay due clearance','txn_id'=>$adtxn_id));
                    if($adtransactions2){
                        $newfunc->alertRedirect("To-Pay due successfully cleared",$_SERVER['HTTP_REFERER']);
                    }else{
                        $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
                    }
                }else{
                    $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
                }
            }else{
                $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
            }
        }else{
            $newfunc->alertRedirect('This amount is greater than the due amount!',$_SERVER['HTTP_REFERER']);
        }
    }else{
        $newfunc->alertRedirect("User not found! Contact with administrator",$_SERVER['HTTP_REFERER']);
    }
}


// clear due of franchise to pay amount of user
if(isset($_POST['clearFranToPayDue'])){
    extract($_POST);
    $franToPayvisibleType = $newfunc->real_string(trim($visible, " "));
    $franToPayUsersorBranches = $newfunc->real_string(trim($franToPayUsersorBranches, " "));
    $franToPayClearAm = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($franToPayClearAm, " ")));
    $transactionId = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($transactionId, " ")));
    if($franToPayvisibleType == "users"){
        $userNameType = "username";
    }elseif($franToPayvisibleType == "branches"){
        $userNameType = "branch_user_name";
    }
    $getuser = $newquery->getData('*',$franToPayvisibleType,'',array($userNameType=>$franToPayUsersorBranches),'id','DESC','1');
    if($getuser != 0){
        $getuser = $getuser[0];
        if($franToPayClearAm <= $getuser['franchise_topay_due']){
            $newDue = floatval($getuser['franchise_topay_due'] - $franToPayClearAm);
            $balance = floatval($getuser['wallet_balance'] + $franToPayClearAm);
            $updUser = $newquery->updateData($franToPayvisibleType,array('franchise_topay_due'=>$newDue),$userNameType,$franToPayUsersorBranches);
            if($updUser){
                $addatetime = date('Y-m-d H:i:s');
                $adtransactions = $newquery->insertData('transactions',array('date_time'=>$addatetime,'user_type'=>$franToPayvisibleType,'user_id'=>$getuser['id'],'amount'=>$franToPayClearAm,'balance'=>$balance,'type'=>'Manual','details'=>'Add money manually for franchise to pay due',"txn_id_type"=>"Different",'txn_id'=>$transactionId,'status'=>'Credit'));
                if($adtransactions){
                    $adgetTxn2 = $newquery->getData('*','transactions','',array('txn_id_type'=>'Serial'),'id','DESC','1');
                  	if($adgetTxn2 != 0){
                        $adtxn_id = "KINGFISH".(str_replace("KINGFISH","",$adgetTxn2[0]['txn_id'])+1);
                    }else{
                        $adtxn_id = 'KINGFISH100000';
                    }
                    $addatetime2 = date('Y-m-d H:i:s');
                    $balance2 = floatval($balance - $franToPayClearAm);
                    $adtransactions2 = $newquery->insertData('transactions',array('date_time'=>$addatetime2,'user_type'=>$franToPayvisibleType,'user_id'=>$getuser['id'],'amount'=>$franToPayClearAm,'balance'=>$balance2,'type'=>'Manual','details'=>'Deducted for Franchise To-Pay due clearance','txn_id'=>$adtxn_id));
                    if($adtransactions2){
                        $newfunc->alertRedirect("Franchise To-Pay due successfully cleared",$_SERVER['HTTP_REFERER']);
                    }else{
                        $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
                    }
                }else{
                    $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
                }
            }else{
                $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
            }
        }else{
            $newfunc->alertRedirect('This amount is greater than the due amount!',$_SERVER['HTTP_REFERER']);
        }
    }else{
        $newfunc->alertRedirect("User not found! Contact with administrator",$_SERVER['HTTP_REFERER']);
    }
}


// clear due of to pay amount of branch
if(isset($_POST['clearbranchToPayDue'])){
    extract($_POST);
    $branchIs = $newfunc->real_string(trim($branchIs, " "));
    $toPayClearAm = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($toPayClearAm, " ")));
    $transactionId = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($transactionId, " ")));
    $getbranch = $newquery->getData('*','branches','',array('branch_user_name'=>$branchIs),'id','DESC','1');
    if($getbranch != 0){
        $getbranch = $getbranch[0];
        if($toPayClearAm <= $getbranch['to_pay_due']){
            $newDue = floatval($getbranch['to_pay_due'] - $toPayClearAm);
            $balance = floatval($getbranch['wallet_balance'] + $toPayClearAm);
            $updBranch = $newquery->updateData('branches',array('to_pay_due'=>$newDue),'branch_user_name',$branchIs);
            if($updBranch){
                $addatetime = date('Y-m-d H:i:s');
                $adtransactions = $newquery->insertData('transactions',array('date_time'=>$addatetime,'user_type'=>'branches','user_id'=>$getbranch['id'],'amount'=>$toPayClearAm,'balance'=>$balance,'type'=>'Manual','details'=>'Add money manually','txn_id'=>$transactionId,"txn_id_type"=>"Different",'status'=>'Credit'));
                if($adtransactions){
                    $adgetTxn2 = $newquery->getData('*','transactions','',array('txn_id_type'=>'Serial'),'id','DESC','1');
                  	if($adgetTxn2 != 0){
                        $adtxn_id2 = "KINGFISH".(str_replace("KINGFISH","",$adgetTxn2[0]['txn_id'])+1);
                    }else{
                        $adtxn_id2 = 'KINGFISH100000';
                    }
                    $addatetime2 = date('Y-m-d H:i:s');
                    $balance2 = floatval($balance - $toPayClearAm);
                    $adtransactions2 = $newquery->insertData('transactions',array('date_time'=>$addatetime2,'user_type'=>'branches','user_id'=>$getbranch['id'],'amount'=>$toPayClearAm,'balance'=>$balance2,'type'=>'Manual','details'=>'Deducted for To-Pay due clearance','txn_id'=>$adtxn_id2));
                    if($adtransactions2){
                        $newfunc->alertRedirect("To-Pay due successfully cleared",$_SERVER['HTTP_REFERER']);
                    }else{
                        $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
                    }
                }else{
                    $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
                }
            }else{
                $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
            }
        }else{
            $newfunc->alertRedirect('This amount is greater than the due amount!',$_SERVER['HTTP_REFERER']);
        }
    }else{
        $newfunc->alertRedirect("User not found! Contact with administrator",$_SERVER['HTTP_REFERER']);
    }
}


// check mobile number and phone of user
if(isset($_POST['checkMobUser'])){
    extract($_POST);
    $checkMobUser = $newfunc->real_string(trim($checkMobUser, " "));
    $haveornot = $newquery->getData('*','users','',array('mobile_no'=>$checkMobUser),'id','DESC','');
    if($haveornot == 0){
        $haveornot2 = $newquery->getData('*','users','',array('phone'=>$checkMobUser),'id','DESC','');
        if($haveornot2 == 0){
            echo 0;
        }else{
            echo 1;
        }
    }else{
        echo 1;
    }
}


// check email of user
if(isset($_POST['checkEmail']) && isset($_POST['search'])){
    extract($_POST);
    $checkEmail = $newfunc->real_string(trim($checkEmail, " "));
    $search = $newfunc->real_string(trim($search, " "));
    $haveornot = $newquery->getData('*',$search,'',array('email'=>$checkEmail),'id','DESC','');
    if($haveornot == 0){
        echo 0;
    }else{
        echo 1;
    }
}


// check mobile number and phone number of branch
if(isset($_POST['checkMobBranch'])){
    extract($_POST);
    $checkMobBranch = $newfunc->real_string(trim($checkMobBranch, " "));
    $haveornot = $newquery->getData('*','branches','',array('mobile_no'=>$checkMobBranch),'id','DESC','');
    if($haveornot == 0){
        $haveornot2 = $newquery->getData('*','branches','',array('phone_no'=>$checkMobBranch),'id','DESC','');
        if($haveornot2 == 0){
            echo 0;
        }else{
            echo 1;
        }
    }else{
        echo 1;
    }
}


// save changes ticket
if(isset($_POST['editTicket'])){
    extract($_POST);
    $adminRemarks = $newfunc->real_string(trim($adminRemarks, " "));
    $update_date = date('d-m-Y H:i:s');
    $updTicket = $newquery->updateData("tickets",array("status"=>$ticketStatus,"admin_remarks"=>$adminRemarks,"last_update"=>$update_date),"ticket_code",$ticketCode);
    if($updTicket){
        $newfunc->alertRedirect("You have successfully updated the ticket","support-ticket?tickets=Open");
    }else{
        $newfunc->alertRedirect("Something went wrong! Please! contact with administrator","support-ticket?tickets=Open");
    }
}


// get cities based on state selected on zone-master-pincode
if(isset($_POST['fetchStateForCity'])){
    $state_id = $_POST['fetchStateForCity'];
    $where = array("state_id"=>$state_id);
    $getcities = $newquery->getData("*","cities","",$where,"","","");
    echo "<option value='' hidden>Choose City</option>";
    foreach($getcities as $cities){
        echo "<option value='".$cities['id']."'>".$cities['city']."</option>";
    }
}


// get salary based on employee selected on salary page
if(isset($_POST['getSalaryofEmp'])){
    $emp_id = $_POST['getSalaryofEmp'];
    $where = array("id"=>$emp_id);
    $getsal = $newquery->getData("*","employees","",$where,"","","");
    echo $getsal[0]['salary'];
}


// get user or branch based on table selected on task page
if(isset($_POST['getTable'])){
    $table = $_POST['getTable'];
    $where = array("delete_status"=>"show");
    if($table == "users"){
        $getusers = $newquery->getData("*","users","",$where,"","","");
        echo "<option value='' hidden>Choose User</option>";
        foreach($getusers as $user){
            // echo "<option value='".$user['id']."'>".$user['party_name']."</option>";
            echo "<option value='{$user['id']}'>{$user['party_name']} - ({$user['username']})</option>";
        }
    }
    elseif($table == "branches"){
        $getbranches = $newquery->getData("*","branches","",$where,"","","");
        echo "<option value='' hidden>Choose Branch</option>";
        foreach($getbranches as $branch){
            // echo "<option value='".$branch['id']."'>".$branch['branch_name']."</option>";
            echo "<option value='{$branch['id']}'>{$branch['branch_name']} - ({$branch['branch_user_name']})</option>";
        }
    }
}


// upload bulk city
if(isset($_POST['submitCity'])){
    extract($_POST);
    $state = $newfunc->real_string(trim($state, " "));
	$ext = pathinfo($_FILES['city']['name'],PATHINFO_EXTENSION);
	if($ext == 'xlsx' || $ext == 'csv'){
		require('excelReader/excel_reader2.php');
        require('excelReader/SpreadsheetReader.php');

        $upl = time().".".$ext;
        $uio = "../dyfiles/bulkuploads/" . $upl;
        move_uploaded_file($_FILES['city']['tmp_name'], $uio);

        $obj = new SpreadsheetReader($uio);
        foreach($obj as $sheet){
            if(!empty($sheet[0])){
                $city = $sheet[0];
                $cityCheck = $newquery->getData("*","cities","",array("state_id"=>$state,"city"=>$city,"delete_status"=>"show"),"id","DESC","1");
                if($cityCheck == 0){
                    if(strtolower($cityCheck[0]['city']) != strtolower($city)){
                        $newquery->insertData("cities",array("state_id"=>$state,"city"=>$city));
                    }
                }
            }
        }
		echo '<script type="text/javascript" language="javascript">
        		alert("You are successfully added the cities");
                window.location = "zone-master-cities";
        	  </script>';
	}else{
		echo '<script type="text/javascript" language="javascript">
        		alert("Invalid file format");
                window.location = "zone-master-cities";
        	  </script>';
	}
}


// submit bulk pincode
if(isset($_POST['submitPinCode'])){
    $state = $newfunc->real_string(trim($_POST['state'], " "));
    $city = $newfunc->real_string(trim($_POST['city'], " "));
	$ext = pathinfo($_FILES['pincode']['name'],PATHINFO_EXTENSION);
	if($ext == 'xlsx' || $ext == 'csv'){
		require('excelReader/excel_reader2.php');
        require('excelReader/SpreadsheetReader.php');

        $upl = time().".".$ext;
        $uio = "../dyfiles/bulkuploads/" . $upl;
        move_uploaded_file($_FILES['pincode']['tmp_name'], $uio);

        $obj = new SpreadsheetReader($uio);
        foreach($obj as $sheet){
            if(!empty($sheet[0])){
                $pincode = $sheet[0];
                $pincodeCheck = $newquery->getData("*","pincodes","",array("city_id"=>$city,"state_id"=>$state,"pincode"=>$pincode,"delete_status"=>"show"),"id","DESC","1");
                if($pincodeCheck == 0){
                    $newquery->insertData("pincodes",array("city_id"=>$city,"state_id"=>$state,"pincode"=>$pincode));
                }
            }
        }
		echo '<script type="text/javascript" language="javascript">
        		alert("You are successfully added the pincodes");
                window.location = "zone-master-pincodes";
        	  </script>';
	}else{
		echo '<script type="text/javascript" language="javascript">
        		alert("Invalid file format");
                window.location = "zone-master-pincodes";
        	  </script>';
	}
}


// tax rate charges update
if(isset($_POST['saveTaxRate'])){
    extract($_POST);
    foreach($_POST as $varkey => $varvalue){
        $taxRates[$varkey] = $newfunc->real_string(trim($varvalue, " "));
    }
    unset($taxRates['saveTaxRate']);
    $updTaxes = $newquery->updateData("charges",$taxRates,"id","1");
    if($updTaxes){
        echo '<script type="text/javascript" language="javascript">
                alert("You are successfully updated the tax rates");
                window.location = "tax-rate-master";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "tax-rate-master";
              </script>';
    }
}


// credit edit
if(isset($_POST['editCredit'])){
    extract($_POST);
    $type = $newfunc->real_string(trim($type, " "));
    $usernameType = ($type == "users")? "username" : "branch_user_name";
    $username = $newfunc->real_string(trim($username, " "));
    $creditControl = $newfunc->real_string(trim($creditControl, " "));
    $getUserName = $newquery->getData('*',$type,'',array($usernameType=>$username),'id','DESC','1');
  	if($getUserName != 0){
        $userdetails = $getUserName[0];
        if($userdetails['wallet_balance'] > -($creditControl)){
            $updcredit = $newquery->updateData($type,array("credit_limit"=>$creditControl),$usernameType,$username);
            if($updcredit){
                echo '<script type="text/javascript" language="javascript">
                        alert("Credit limit sucessfully updated for this '.trim(trim($type, "s"), "es").'");
                        window.location = "'.$_SERVER['HTTP_REFERER'].'";
                      </script>';
            }else{
                echo '<script type="text/javascript" language="javascript">
                        alert("Something went wrong! Please contact with administrator");
                        window.location = "'.$_SERVER['HTTP_REFERER'].'";
                      </script>';
            }
        }else{
            echo "<script type='text/javascript' language='javascript'>
                    alert('This ".trim(trim($type, 's'), 'es')." exceeded the credit limit');
                    window.location = '".$_SERVER['HTTP_REFERER']."';
                  </script>";
        }
    }else{
        echo "<script type='text/javascript' language='javascript'>
                alert('".ucwords(trim(trim($type, "s"), "es"))." doesn't exists');
                window.location = '".$_SERVER['HTTP_REFERER']."';
              </script>";
    }
}


// add user form
if(isset($_POST['add_user_submit'])){
    extract($_POST);
    $party_name = $newfunc->real_string(trim($party_name, " "));
    $contact_person_name = $newfunc->real_string(trim($contact_person_name, " "));
    $booking_agent = $newfunc->real_string(trim($booking_agent, " "));
    $address = $newfunc->real_string(trim($address, " "));
    $mobile_no = $newfunc->real_string(trim($mobile_no, " "));
    $fuel_surcharge = $newfunc->real_string(trim($fuel_surcharge, " "));
    $fuel_surcharge_type = $newfunc->real_string(trim($fuel_surcharge_type, " "));
    $pincode = $newfunc->real_string(trim($pincode, " "));
    $cod_charge = $newfunc->real_string(trim($cod_charge, " "));
    $cod_charge_type = $newfunc->real_string(trim($cod_charge_type, " "));
    $pan = $newfunc->real_string(trim($pan, " "));
    $branch = $newfunc->real_string(trim($branch, " "));
    $cft = $newfunc->real_string(trim($cft, " "));
    $gst_type = $newfunc->real_string(trim($gst_type, " "));
    $gst_number = $newfunc->real_string(trim($gst_number, " "));
    $taxes_paid_by = $newfunc->real_string(trim($taxes_paid_by, " "));
    $threepl = $newfunc->real_string(trim($threepl, " "));
    $min_charge_weight = $newfunc->real_string(trim($min_charge_weight, " "));
    $delivery_type = $newfunc->real_string(trim($delivery_type, " "));
    $phone = $newfunc->real_string(trim($phone, " "));
    $email = $newfunc->real_string(trim($email, " "));
    $state = $newfunc->real_string(trim($state, " "));
    $awb_charge = $newfunc->real_string(trim($awb_charge, " "));
    $fob_surcharge_minimum = $newfunc->real_string(trim($fob_surcharge_minimum, " "));
    $fob_surcharge_percentage = $newfunc->real_string(trim($fob_surcharge_percentage, " "));
    $handeling_charge = $newfunc->real_string(trim($handeling_charge, " "));
    $handeling_charge_type = $newfunc->real_string(trim($handeling_charge_type, " "));
    $cartage_charge = $newfunc->real_string(trim($cartage_charge, " "));
    $cartage_charge_type = $newfunc->real_string(trim($cartage_charge_type, " "));
    $damage_surcharge = $newfunc->real_string(trim($damage_surcharge, " "));
    $damage_surcharge_type = $newfunc->real_string(trim($damage_surcharge_type, " "));
    $oda_surcharge = $newfunc->real_string(trim($oda_surcharge, " "));
    $oda_surcharge_type = $newfunc->real_string(trim($oda_surcharge_type, " "));
    $packaging_surcharge = $newfunc->real_string(trim($packaging_surcharge, " "));
    $packaging_surcharge_type = $newfunc->real_string(trim($packaging_surcharge_type, " "));
    $special_delivery_or_appointment_charge = $newfunc->real_string(trim($special_delivery_or_appointment_charge, " "));
    $special_delivery_or_appointment_charge_type = $newfunc->real_string(trim($special_delivery_or_appointment_charge_type, " "));
    $pickup_charge = $newfunc->real_string(trim($pickup_charge, " "));
    $pickup_charge_type = $newfunc->real_string(trim($pickup_charge_type, " "));
    $credit_limit = $newfunc->real_string(trim($credit_limit, " "));
    $cod_charge_min = $newfunc->real_string(trim($cod_charge_min, " "));
    $damage_surcharge_min = $newfunc->real_string(trim($damage_surcharge_min, " "));
    $oda_surcharge_min = $newfunc->real_string(trim($oda_surcharge_min, " "));
    $special_delivery_or_appointment_charge_min = $newfunc->real_string(trim($special_delivery_or_appointment_charge_min, " "));
    $freight_type = $newfunc->real_string(trim($freight_type, " "));
    if($newfunc->real_string(trim($tds, " ")) == "Yes"){
        $tds = "yes";
    }elseif($newfunc->real_string(trim($tds, " ")) == "No"){
        $tds = "no";
    }
    if(array_key_exists('igst', $_POST)){
        $igstval = "yes";
    }else{
        $igstval = "not";
    }
    if(array_key_exists('cod_enable', $_POST)){
        $cod_charge_enable_disable = "enable";
    }else{
        $cod_charge_enable_disable = "disable";
    }
    if(array_key_exists('userwise_charge', $_POST)){
        $userWiseCharge = "yes";
    }else{
        $userWiseCharge = "no";
    }
    $account_head = $newfunc->real_string(trim($account_head, " "));
    $finance_mobile_number = $newfunc->real_string(trim($finance_mobile_number, " "));
    $bank = $newfunc->real_string(trim($bank, " "));
    $finance_branch_address = $newfunc->real_string(trim($finance_branch_address, " "));
    $account_no = $newfunc->real_string(trim($account_no, " "));
    $ifsc_code = $newfunc->real_string(trim($ifsc_code, " "));
    $logistic_head = $newfunc->real_string(trim($logistic_head, " "));
    $logistic_mobile_number = $newfunc->real_string(trim($logistic_mobile_number, " "));
    $email_of_dispatch = $newfunc->real_string(trim($email_of_dispatch, " "));
    $logistic_branch_address = $newfunc->real_string(trim($logistic_branch_address, " "));
    $industry_type = $newfunc->real_string(trim($industry_type, " "));
    $remarks = $newfunc->real_string(trim($remarks, " "));
    
    if(!empty($_FILES['files']['name'][0])){
        $allFiles = [];
        for($i = 0; $i < count($_FILES['files']['name']); $i++){
            $files = $newfunc->real_string(trim($_FILES['files']['name'][$i], " "));
            $files_ext = pathinfo($files, PATHINFO_EXTENSION);
            $filename = time().$_FILES['files']['tmp_name'][$i].$files_ext;
            move_uploaded_file($_FILES['files']['tmp_name'][$i], "images/dynamic-images/".$filename);
            $allFiles[] = $filename;
        }
        $allFiles = implode(",", $allFiles);
    }else{
        $allFiles = "";
    }
    if($threepl == "all"){
        $threePLType = "ALL";
    }else{
        $threePLType = str_replace("CFT", "", $newquery->getData('*','3pls','',array('id'=>$threepl),'id','DESC','1')[0]['api_token_name']);
    }
    $partyFirstName = strtoupper(explode(" ", $party_name)[0]);
    $nameCount = strlen(str_replace(" ", "", explode(" ", $party_name)[1]));
    $forPartyUsernameAfter = strtoupper(str_replace(" ", "", explode(" ", $party_name)[1]));
    $username = $partyFirstName.$threePLType."B2BC";
    if($newquery->getData('*','users','',array('username'=>$username),'id','DESC','1') != 0){
        for($i = 0; $i < $nameCount; $i++){
            $username = $partyFirstName.substr($forPartyUsernameAfter, 0, $i+1).$threePLType."B2BC";
            if($newquery->getData('*','users','',array('username'=>$username),'id','DESC','1') == 0){
                $username = $username;
                break;
            }
        }
    }
    $password = rand(100000,999999);
    $md5password = md5($password);
    $insArr = array("party_name"=>$party_name,"contact_person_name"=>$contact_person_name,"booking_agent"=>$booking_agent,"address"=>$address,"mobile_no"=>$mobile_no,"fuel_surcharge"=>$fuel_surcharge,"fuel_surcharge_type"=>$fuel_surcharge_type,"pincode"=>$pincode,"party_type"=>$party_type,"cod_charge"=>$cod_charge,"cod_charge_type"=>$cod_charge_type,"pan"=>$pan,"branch"=>$branch,"cft"=>$cft,"gst_type"=>$gst_type,"gst_number"=>$gst_number,"taxes_paid_by"=>$taxes_paid_by,"threepl"=>$threepl,"state"=>$state,"min_charge_weight"=>$min_charge_weight,"delivery_type"=>$delivery_type,"phone"=>$phone,"email"=>$email,"awb_charge"=>$awb_charge,"fob_surcharge_minimum"=>$fob_surcharge_minimum,"fob_surcharge_percentage"=>$fob_surcharge_percentage,"handeling_charge"=>$handeling_charge,"handeling_charge_type"=>$handeling_charge_type,"damage_surcharge"=>$damage_surcharge,"damage_surcharge_type"=>$damage_surcharge_type,"oda_surcharge"=>$oda_surcharge,"oda_surcharge_type"=>$oda_surcharge_type,"packaging_surcharge"=>$packaging_surcharge,"packaging_surcharge_type"=>$packaging_surcharge_type,"special_delivery_or_appointment_charge"=>$special_delivery_or_appointment_charge,"special_delivery_or_appointment_charge_type"=>$special_delivery_or_appointment_charge_type,"pickup_charge"=>$pickup_charge,"pickup_charge_type"=>$pickup_charge_type,"credit_limit"=>$credit_limit,"igst"=>$igstval,"cod_charge_enable_disable"=>$cod_charge_enable_disable,"fright_charge"=>$userWiseCharge,"account_head"=>$account_head,"finance_mobile_number"=>$finance_mobile_number,"bank"=>$bank,"finance_branch_address"=>$finance_branch_address,"account_no"=>$account_no,"ifsc_code"=>$ifsc_code,"logistic_head"=>$logistic_head,"logistic_mobile_number"=>$logistic_mobile_number,"email_of_dispatch"=>$email_of_dispatch,"logistic_branch_address"=>$logistic_branch_address,"industry_type"=>$industry_type,"files"=>$allFiles,"remarks"=>$remarks,"username"=>$username,"password"=>$md5password,"cod_charge_min"=>$cod_charge_min,"damage_surcharge_min"=>$damage_surcharge_min,"oda_surcharge_min"=>$oda_surcharge_min,"special_delivery_or_appointment_charge_min"=>$special_delivery_or_appointment_charge_min,"freight_type"=>$freight_type,"tds"=>$tds);
    $insQuery = $newquery->insertData('users',$insArr);
    $name = $party_name;
    $type = "a user";
    if($insQuery){
        if(array_key_exists('userwise_charge', $_POST)){
            $user_id = $newquery->getData('*','users','','','id','DESC','1')[0]['id'];
            $insfright = $newquery->insertData('users_fright_master',array('user_id'=>$user_id));
            if(!$insfright){
                echo '<script type="text/javascript" language="javascript">
                        alert("Something went wrong! Please contact with administrator");
                        window.location = "add-user";
                      </script>';
            }
        }
        $headers = [
          "MIME-Version" => "1.0",
          "Content-Type" => "text/html;charset=UTF-8",
          "From" => $company['email_id'],
          "Reply-To" => "noreply@kingfishlogistics.in",
        ];

        $to = $email;
        $subject = "Account creation completed";
        ob_start();
        include("../assets/email-structure.php");
        $message = ob_get_contents();
        ob_get_clean();
        
        if(mail($to, $subject, $message, $headers)){
            echo '<script type="text/javascript" language="javascript">
                    alert("You are successfully created a user");
                    window.location = "users-list";
                  </script>';
        }else{
            echo '<script type="text/javascript" language="javascript">
                    alert("An error occured! Please contact with administrator");
                    window.location = "add-user";
                  </script>';
        }
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "add-user";
              </script>';
    }
}


// edit user form
if(isset($_POST['edit_user_submit'])){
    extract($_POST);
    $party_name = $newfunc->real_string(trim($party_name, " "));
    $contact_person_name = $newfunc->real_string(trim($contact_person_name, " "));
    $booking_agent = $newfunc->real_string(trim($booking_agent, " "));
    $address = $newfunc->real_string(trim($address, " "));
    $mobile_no = $newfunc->real_string(trim($mobile_no, " "));
    $fuel_surcharge = $newfunc->real_string(trim($fuel_surcharge, " "));
    $fuel_surcharge_type = $newfunc->real_string(trim($fuel_surcharge_type, " "));
    $pincode = $newfunc->real_string(trim($pincode, " "));
    $cod_charge = $newfunc->real_string(trim($cod_charge, " "));
    $cod_charge_type = $newfunc->real_string(trim($cod_charge_type, " "));
    $pan = $newfunc->real_string(trim($pan, " "));
    $branch = $newfunc->real_string(trim($branch, " "));
    $cft = $newfunc->real_string(trim($cft, " "));
    $gst_type = $newfunc->real_string(trim($gst_type, " "));
    $gst_number = $newfunc->real_string(trim($gst_number, " "));
    $taxes_paid_by = $newfunc->real_string(trim($taxes_paid_by, " "));
    $threepl = $newfunc->real_string(trim($threepl, " "));
    $min_charge_weight = $newfunc->real_string(trim($min_charge_weight, " "));
    $delivery_type = $newfunc->real_string(trim($delivery_type, " "));
    $phone = $newfunc->real_string(trim($phone, " "));
    $email = $newfunc->real_string(trim($email, " "));
    $state = $newfunc->real_string(trim($state, " "));
    $awb_charge = $newfunc->real_string(trim($awb_charge, " "));
    $fob_surcharge_minimum = $newfunc->real_string(trim($fob_surcharge_minimum, " "));
    $fob_surcharge_percentage = $newfunc->real_string(trim($fob_surcharge_percentage, " "));
    $handeling_charge = $newfunc->real_string(trim($handeling_charge, " "));
    $handeling_charge_type = $newfunc->real_string(trim($handeling_charge_type, " "));
    $damage_surcharge = $newfunc->real_string(trim($damage_surcharge, " "));
    $damage_surcharge_type = $newfunc->real_string(trim($damage_surcharge_type, " "));
    $oda_surcharge = $newfunc->real_string(trim($oda_surcharge, " "));
    $oda_surcharge_type = $newfunc->real_string(trim($oda_surcharge_type, " "));
    $packaging_surcharge = $newfunc->real_string(trim($packaging_surcharge, " "));
    $packaging_surcharge_type = $newfunc->real_string(trim($packaging_surcharge_type, " "));
    $special_delivery_or_appointment_charge = $newfunc->real_string(trim($special_delivery_or_appointment_charge, " "));
    $special_delivery_or_appointment_charge_type = $newfunc->real_string(trim($special_delivery_or_appointment_charge_type, " "));
    $pickup_charge = $newfunc->real_string(trim($pickup_charge, " "));
    $pickup_charge_type = $newfunc->real_string(trim($pickup_charge_type, " "));
    $credit_limit = $newfunc->real_string(trim($credit_limit, " "));
    $cod_charge_min = $newfunc->real_string(trim($cod_charge_min, " "));
    $damage_surcharge_min = $newfunc->real_string(trim($damage_surcharge_min, " "));
    $oda_surcharge_min = $newfunc->real_string(trim($oda_surcharge_min, " "));
    $special_delivery_or_appointment_charge_min = $newfunc->real_string(trim($special_delivery_or_appointment_charge_min, " "));
    $freight_type = $newfunc->real_string(trim($freight_type, " "));
    if($newfunc->real_string(trim($tds, " ")) == "Yes"){
        $tds = "yes";
    }elseif($newfunc->real_string(trim($tds, " ")) == "No"){
        $tds = "no";
    }
    if(array_key_exists('igst', $_POST)){
        $igstval = "yes";
    }else{
        $igstval = "not";
    }
    if(array_key_exists('cod_enable', $_POST)){
        $cod_charge_enable_disable = "enable";
    }else{
        $cod_charge_enable_disable = "disable";
    }
    if(array_key_exists('userwise_charge', $_POST)){
        $userWiseCharge = "yes";
    }else{
        $userWiseCharge = "no";
    }
    $account_head = $newfunc->real_string(trim($account_head, " "));
    $finance_mobile_number = $newfunc->real_string(trim($finance_mobile_number, " "));
    $bank = $newfunc->real_string(trim($bank, " "));
    $finance_branch_address = $newfunc->real_string(trim($finance_branch_address, " "));
    $account_no = $newfunc->real_string(trim($account_no, " "));
    $ifsc_code = $newfunc->real_string(trim($ifsc_code, " "));
    $logistic_head = $newfunc->real_string(trim($logistic_head, " "));
    $logistic_mobile_number = $newfunc->real_string(trim($logistic_mobile_number, " "));
    $email_of_dispatch = $newfunc->real_string(trim($email_of_dispatch, " "));
    $logistic_branch_address = $newfunc->real_string(trim($logistic_branch_address, " "));
    $industry_type = $newfunc->real_string(trim($industry_type, " "));
    $remarks = $newfunc->real_string(trim($remarks, " "));
    $allFiles = "";
    if(!empty($_FILES['files']['name'][0])){
        $allFiles = [];
        for($i = 0; $i < count($_FILES['files']['name']); $i++){
            $files = $newfunc->real_string(trim($_FILES['files']['name'][$i], " "));
            $files_ext = pathinfo($files, PATHINFO_EXTENSION);
            $filename = time().$_FILES['files']['tmp_name'][$i].$files_ext;
            move_uploaded_file($_FILES['files']['tmp_name'][$i], "images/dynamic-images/".$filename);
            $allFiles[] = $filename;
        }
        $allFiles = implode(",", $allFiles);
    }
    if(!empty($oldFiles)){
        $allFiles = $allFiles.",".implode(",", $oldFiles);
    }
    $allFiles = trim($allFiles, ",");
    $updArr = array("party_name"=>$party_name,"contact_person_name"=>$contact_person_name,"booking_agent"=>$booking_agent,"address"=>$address,"mobile_no"=>$mobile_no,"fuel_surcharge"=>$fuel_surcharge,"fuel_surcharge_type"=>$fuel_surcharge_type,"pincode"=>$pincode,"party_type"=>$party_type,"cod_charge"=>$cod_charge,"cod_charge_type"=>$cod_charge_type,"pan"=>$pan,"branch"=>$branch,"cft"=>$cft,"gst_type"=>$gst_type,"gst_number"=>$gst_number,"taxes_paid_by"=>$taxes_paid_by,"threepl"=>$threepl,"state"=>$state,"min_charge_weight"=>$min_charge_weight,"delivery_type"=>$delivery_type,"phone"=>$phone,"email"=>$email,"awb_charge"=>$awb_charge,"fob_surcharge_minimum"=>$fob_surcharge_minimum,"fob_surcharge_percentage"=>$fob_surcharge_percentage,"handeling_charge"=>$handeling_charge,"handeling_charge_type"=>$handeling_charge_type,"damage_surcharge"=>$damage_surcharge,"damage_surcharge_type"=>$damage_surcharge_type,"oda_surcharge"=>$oda_surcharge,"oda_surcharge_type"=>$oda_surcharge_type,"packaging_surcharge"=>$packaging_surcharge,"packaging_surcharge_type"=>$packaging_surcharge_type,"special_delivery_or_appointment_charge"=>$special_delivery_or_appointment_charge,"special_delivery_or_appointment_charge_type"=>$special_delivery_or_appointment_charge_type,"pickup_charge"=>$pickup_charge,"pickup_charge_type"=>$pickup_charge_type,"credit_limit"=>$credit_limit,"igst"=>$igstval,"cod_charge_enable_disable"=>$cod_charge_enable_disable,"fright_charge"=>$userWiseCharge,"account_head"=>$account_head,"finance_mobile_number"=>$finance_mobile_number,"bank"=>$bank,"finance_branch_address"=>$finance_branch_address,"account_no"=>$account_no,"ifsc_code"=>$ifsc_code,"logistic_head"=>$logistic_head,"logistic_mobile_number"=>$logistic_mobile_number,"email_of_dispatch"=>$email_of_dispatch,"logistic_branch_address"=>$logistic_branch_address,"industry_type"=>$industry_type,"files"=>$allFiles,"remarks"=>$remarks,"cod_charge_min"=>$cod_charge_min,"damage_surcharge_min"=>$damage_surcharge_min,"oda_surcharge_min"=>$oda_surcharge_min,"special_delivery_or_appointment_charge_min"=>$special_delivery_or_appointment_charge_min,"freight_type"=>$freight_type,"tds"=>$tds);
    
    $updQuery = $newquery->updateData("users",$updArr,"id",$id);
    if($updQuery){
        if(array_key_exists('userwise_charge', $_POST) && $newquery->getData("*","users_fright_master","",array('user_id'=>$id),"id","DESC","1") == 0){
                $insfright = $newquery->insertData('users_fright_master',array('user_id'=>$id));
                if($insfright){
                    echo '<script type="text/javascript" language="javascript">
                            alert("You have successfully updated this user");
                            window.location = "users-list?visible=edit";
                          </script>';
                }else{
                    echo '<script type="text/javascript" language="javascript">
                            alert("Something went wrong! Please contact with administrator");
                            window.location = "users-list?visible=edit";
                          </script>';
                }
        }else{
            echo '<script type="text/javascript" language="javascript">
                    alert("You have successfully updated this user");
                    window.location = "users-list?visible=edit";
                  </script>';
        }
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "users-list?visible=edit";
              </script>';
    }
}


// submit order item
if(isset($_POST['submitItem'])){
    extract($_POST);
    $orderItem = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($orderItem, " ")));
    $arr = array('item'=>$orderItem,'delete_status'=>'show');
    $selret = $newquery->getData('*','order_items','',$arr,'','','');
    if(strtolower($selret[0]['item']) != strtolower($orderItem)){
        $ret = $newquery->insertData('order_items',$arr);
        if($ret){
            echo '<script type="text/javascript" language="javascript">
                    alert("You are successfully added a order item");
                    window.location = "item-master";
                  </script>';
        }else{
            echo '<script type="text/javascript" language="javascript">
                    alert("Something went wrong! Please contact with administrator");
                    window.location = "item-master";
                  </script>';
        }
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("This item is already added");
                window.location = "item-master";
              </script>';
    }
}


// edit order item
if(isset($_POST['editOrderItem'])){
    extract($_POST);
    $orderItem = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($orderItem, " ")));
    $orderItemOwner = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($orderItemOwner, " ")));
    $arr = array('item'=>$orderItem,'delete_status'=>'show');
    $selret = $newquery->getData('*','order_items','',$arr,'','','');
    if(strtolower($selret[0]['item']) != strtolower($orderItem)){
        $ret = $newquery->updateData('order_items',$arr,'id',$orderItemOwner);
        if($ret){
            echo '<script type="text/javascript" language="javascript">
                    alert("You are successfully edited this order item");
                    window.location = "item-master";
                  </script>';
        }else{
            echo '<script type="text/javascript" language="javascript">
                    alert("Something went wrong! Please contact with administrator");
                    window.location = "item-master";
                  </script>';
        }
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("This item is already added");
                window.location = "item-master";
              </script>';
    }
}


// delete status update of order item
if(isset($_POST['deleteOrderItem'])){
    extract($_POST);
    $orderItemOwner = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($orderItemOwner, " ")));
    $arr = array('delete_status'=>'delete');
    $ret = $newquery->updateData('order_items',$arr,'id',$orderItemOwner);
    if($ret){
        echo '<script type="text/javascript" language="javascript">
                alert("You are successfully deleted this order item");
                window.location = "item-master";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "item-master";
              </script>';
    }
}


// Submit Stationary master
if(isset($_POST['submitStationary'])){
    extract($_POST);
    $stationary_name = str_replace("'", "\'", $newfunc->real_string(trim($stationary_name, " ")));
    $stationary_prefix = str_replace("'", "\'", $newfunc->real_string(trim($stationary_prefix, " ")));
    $arr = array('stationary_name'=>$stationary_name,'stationary_prefix'=>$stationary_prefix);
    if($newquery->getData('*','stationaries','',$arr,'id','DESC','') == 0):
        $ret = $newquery->insertData('stationaries',$arr);
        if($ret){
            $newfunc->alertRedirect("You have successfully added a stationary input",$_SERVER['HTTP_REFERER']);
        }else{
            $newfunc->alertRedirect("Something went wrong! Please contact with administrator",$_SERVER['HTTP_REFERER']);
        }
    else:
        $newfunc->alertRedirect("Stationary name and prefix already exist!",$_SERVER['HTTP_REFERER']);
    endif;
}


// Edit stationary master
if(isset($_POST['editStationary'])){
    extract($_POST);
    $stationary_name = str_replace("'", "\'", $newfunc->real_string(trim($stationary_name, " ")));
    $stationary_prefix = str_replace("'", "\'", $newfunc->real_string(trim($stationary_prefix, " ")));
    $arr = array('stationary_name'=>$stationary_name);
    if($newquery->getData('*','stationaries','',array('stationary_name'=>$stationary_name,'stationary_prefix'=>$stationary_prefix),'id','DESC','') == 0):
        $return = $newquery->updateData('stationaries',$arr,'id',$id);
        if($return):
            if($newquery->getData('*','stationary_invoice_allotments','',array('stationary_invoice_id'=>$id),'id','DESC','') == 0):
                $newarr = array('stationary_prefix'=>$stationary_prefix);
                $ret = $newquery->updateData('stationaries',$newarr,'id',$id);
                if($ret):
                    $newfunc->alertRedirect("You have successfully updated this stationary Prefix",$_SERVER['HTTP_REFERER']);
                else:
                    $newfunc->alertRedirect("Something went wrong! Please contact with administrator",$_SERVER['HTTP_REFERER']);
                endif;
            else:
                $newfunc->alertRedirect("Can't change the prefix due to already assigned!",$_SERVER['HTTP_REFERER']);
            endif;
        else:
            $newfunc->alertRedirect("Something went wrong! Please contact with administrator",$_SERVER['HTTP_REFERER']);
        endif;
    else:
        $newfunc->alertRedirect("Stationary name and prefix already exist!",$_SERVER['HTTP_REFERER']);
    endif;
}


// Delete stationary master
if(isset($_POST['deleteStationary'])){
    extract($_POST);
    if($newquery->getData('*','stationary_invoice_allotments','',array('stationary_invoice_id'=>$id),'id','DESC','') == 0){
        $arr = array('delete_status'=>'delete');
        $ret = $newquery->updateData('stationaries',$arr,'id',$id);
        if($ret){
            $newfunc->alertRedirect("You are successfully deleted this stationary Prefix",$_SERVER['HTTP_REFERER']);
        }else{
            $newfunc->alertRedirect("Something went wrong! Please contact with administrator",$_SERVER['HTTP_REFERER']);
        }
    }else{
        $newfunc->alertRedirect("Can't delete due to already assigned!",$_SERVER['HTTP_REFERER']);
    }
}


// submit task
if(isset($_POST['submitTask'])){
    extract($_POST);
    $task = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($task, " ")));
    $getTask = $newquery->getData('*','tasks','','','id','DESC','1');
  	if($getTask != 0){
        $task_id = explode("-", $getTask[0]['task_id']);
        $task_id = "TASK-".($task_id[1]+1);
    }else{
        $task_id = 'TASK-10001';
    }
    $dataArr = array("task_id"=>$task_id,"assigned_id"=>$tableReponse,"assignee_type"=>$table,"task"=>$task);
    if($newquery->insertData('tasks',$dataArr)){
        echo '<script type="text/javascript" language="javascript">
                alert("Task added successfully");
                window.location = "tasks";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "tasks";
              </script>';
    }
}


// Change Task
if(isset($_POST['changeTask'])){
    extract($_POST);
    $time = date("Y-m-d H:i:s");
    $arr = array('task'=>$modifiedTask,'status'=>$status,'updated_at'=>$time);
    $ret = $newquery->updateData('tasks',$arr,'id',$taskId);
    if($ret){
        echo '<script type="text/javascript" language="javascript">
                alert("Task Updated Successfully");
                window.location = "tasks";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "tasks";
              </script>';
    }
}


// submit ticket category
if(isset($_POST['submitCat'])){
    extract($_POST);
    $ticketCategory = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($ticketCategory, " ")));
    $arr = array('category'=>$ticketCategory,'delete_status'=>'show');
    $selret = $newquery->getData('*','ticket_category','',$arr,'','','');
    if(strtolower($selret[0]['category']) != strtolower($ticketCategory)){
        $ret = $newquery->insertData('ticket_category',$arr);
        if($ret){
            echo '<script type="text/javascript" language="javascript">
                    alert("You are successfully added a category");
                    window.location = "ticket-category";
                  </script>';
        }else{
            echo '<script type="text/javascript" language="javascript">
                    alert("Something went wrong! Please contact with administrator");
                    window.location = "ticket-category";
                  </script>';
        }
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("This category is already added");
                window.location = "ticket-category";
              </script>';
    }
}


// edit ticket category
if(isset($_POST['editTickCat'])){
    extract($_POST);
    $ticketCategory = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($ticketCategory, " ")));
    $ticketCategoryOwner = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($ticketCategoryOwner, " ")));
    $arr = array('category'=>$ticketCategory,'delete_status'=>'show');
    $selret = $newquery->getData('*','ticket_category','',$arr,'','','');
    if(strtolower($selret[0]['category']) != strtolower($ticketCategory)){
        $ret = $newquery->updateData('ticket_category',$arr,'id',$ticketCategoryOwner);
        if($ret){
            echo '<script type="text/javascript" language="javascript">
                    alert("You are successfully edited this ticket category");
                    window.location = "ticket-category";
                  </script>';
        }else{
            echo '<script type="text/javascript" language="javascript">
                    alert("Something went wrong! Please contact with administrator");
                    window.location = "ticket-category";
                  </script>';
        }
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("This item is already added");
                window.location = "ticket-category";
              </script>';
    }
}


// delete status update of ticket category
if(isset($_POST['deleteTicketCategory'])){
    extract($_POST);
    $ticketCategoryOwner = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($ticketCategoryOwner, " ")));
    $arr1 = array('categoryId'=>$ticketCategoryOwner,'delete_status'=>'show');
    $getreturn = $newquery->getData('*','ticket_subcategory','',$arr1,'','','');
    if($getreturn == 0){
        $arr2 = array('delete_status'=>'delete');
        $ret = $newquery->updateData('ticket_category',$arr2,'id',$ticketCategoryOwner);
        if($ret){
            echo '<script type="text/javascript" language="javascript">
                    alert("You are successfully deleted this category");
                    window.location = "ticket-category";
                  </script>';
        }else{
            echo '<script type="text/javascript" language="javascript">
                    alert("Something went wrong! Please contact with administrator");
                    window.location = "ticket-category";
                  </script>';
        }
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("You have subcategories of this category. So, you can\'t delete this category!");
                window.location = "ticket-category";
              </script>';
    }
}


// submit ticket category
if(isset($_POST['submitTicketSubCategory'])){
    extract($_POST);
    $ticketCategory = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($ticketCategory, " ")));
    $ticket_subCategory = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($ticket_subCategory, " ")));
    $arr = array('categoryId'=>$ticketCategory,'subCategory'=>$ticket_subCategory,'delete_status'=>'show');
    $selret = $newquery->getData('*','ticket_subcategory','',$arr,'','','');
    if(strtolower($selret[0]['subCategory']) != strtolower($ticket_subCategory)){
        $ret = $newquery->insertData('ticket_subcategory',$arr);
        if($ret){
            echo '<script type="text/javascript" language="javascript">
                    alert("You are successfully added a sub category");
                    window.location = "ticket-sub-category";
                  </script>';
        }else{
            echo '<script type="text/javascript" language="javascript">
                    alert("Something went wrong! Please contact with administrator");
                    window.location = "ticket-sub-category";
                  </script>';
        }
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("This sub category is already added");
                window.location = "ticket-sub-category";
              </script>';
    }
}


// edit sub ticket category
if(isset($_POST['editTickSubCat'])){
    extract($_POST);
    $ticket_subCategory = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($ticket_subCategory, " ")));
    $ticketCategory = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($ticketCategory, " ")));
    $ticketSubCategoryOwner = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($ticketSubCategoryOwner, " ")));
    $arr = array('categoryId'=>$ticketCategory,'subCategory'=>$ticket_subCategory,'delete_status'=>'show');
    $selret = $newquery->getData('*','ticket_subcategory','',$arr,'','','');
    if(strtolower($selret[0]['subCategory']) != strtolower($ticket_subCategory)){
        $ret = $newquery->updateData('ticket_subcategory',$arr,'id',$ticketSubCategoryOwner);
        if($ret){
            echo '<script type="text/javascript" language="javascript">
                    alert("You are successfully edited this ticket sub category");
                    window.location = "ticket-sub-category";
                  </script>';
        }else{
            echo '<script type="text/javascript" language="javascript">
                    alert("Something went wrong! Please contact with administrator");
                    window.location = "ticket-sub-category";
                  </script>';
        }
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("This item is already added");
                window.location = "ticket-sub-category";
              </script>';
    }
}


// delete status update of ticket sub category
if(isset($_POST['deleteTicketSubCategory'])){
    extract($_POST);
    $ticketSubCategoryOwner = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($ticketSubCategoryOwner, " ")));
    $arr = array('delete_status'=>'delete');
    $ret = $newquery->updateData('ticket_subcategory',$arr,'id',$ticketSubCategoryOwner);
    if($ret){
        echo '<script type="text/javascript" language="javascript">
                alert("You are successfully deleted this sub category");
                window.location = "ticket-sub-category";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "ticket-sub-category";
              </script>';
    }
}


// Edit default fright master
if(isset($_POST['saveChangesDeafultFright'])){
    foreach($_POST as $varkey => $varvalue){
        $arrnew[$varkey] = $newfunc->real_string(trim($varvalue, " "));
    }
    unset($arrnew['saveChangesDeafultFright']);
    $updateDefaultFright = $newquery->updateData('default_fright_master',$arrnew,'id','1');
    if($updateDefaultFright){
        echo '<script type="text/javascript" language="javascript">
                alert("Default fright successfully updated");
                window.location = "default-fright-master";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "default-fright-master";
              </script>';
    }
}


// Reset default fright master
if(isset($_POST['resetDefaultFreight'])){
    foreach($_POST as $varkey => $varvalue){
        $arrnew[$varkey] = 0;
    }
    unset($arrnew['resetDefaultFreight']);
    $updateDefaultFright = $newquery->updateData('default_fright_master',$arrnew,'id','1');
    if($updateDefaultFright){
        echo '<script type="text/javascript" language="javascript">
                alert("Default fright successfully reset");
                window.location = "default-fright-master";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "default-fright-master";
              </script>';
    }
}


// submit a branch
if(isset($_POST['submitaBranch'])){
    extract($_POST);
  	$getBranchUserName = $newquery->getData('*','branches','','','id','DESC','1');
  	if($getBranchUserName != 0){
        $branch_user_name = explode("-", $getBranchUserName[0]['branch_user_name']);
        $branchArray['branch_user_name'] = "KINGFISH-".($branch_user_name[1]+1);
    }else{
        $branchArray['branch_user_name'] = 'KINGFISH-10001';
    }
    $branchArray['branch_name'] = $newfunc->real_string(trim($branch_name, " "));
    $password = rand(100000,999999);
    $branchArray['password'] = md5($password);
    $branchArray['contact_person'] = $newfunc->real_string(trim($contact_person, " "));
    $branchArray['gst_trade_name'] = $newfunc->real_string(trim($gst_trade_name, " "));
    $branchArray['address'] = $newfunc->real_string(trim($address, " "));
    $branchArray['phone_no'] = $newfunc->real_string(trim($phone_no, " "));
    $branchArray['ewb_transporter_id'] = $newfunc->real_string(trim($ewb_transporter_id, " "));
    $branchArray['city'] = $newfunc->real_string(trim($city, " "));
    $branchArray['mobile_no'] = $newfunc->real_string(trim($mobile_no, " "));
    $branchArray['district'] = $newfunc->real_string(trim($district, " "));
    $branchArray['email'] = $newfunc->real_string(trim($email, " "));
    $branchArray['state'] = $newfunc->real_string(trim($state, " "));
    $branchArray['pincode'] = $newfunc->real_string(trim($pincode, " "));
    $branchArray['type'] = $newfunc->real_string(trim($type, " "));
    $branchArray['credit_type'] = $newfunc->real_string(trim($credit_type, " "));
    $branchArray['credit_limit'] = $newfunc->real_string(trim($credit_limit, " "));
    $branchArray['min_charge_weight'] = $newfunc->real_string(trim($min_charge_weight, " "));
    $branchArray['service_tax_no'] = $newfunc->real_string(trim($service_tax_no, " "));
    $branchArray['nature'] = $newfunc->real_string(trim($nature, " "));
    $branchArray['weight_round_off'] = $newfunc->real_string(trim($weight_round_off, " "));
    $branchArray['pan_no'] = $newfunc->real_string(trim($pan_no, " "));
    $branchArray['gst_no'] = $newfunc->real_string(trim($gst_no, " "));
    $branchArray['fuel_surcharge'] = $newfunc->real_string(trim($fuel_surcharge, " "));
    $branchArray['fuel_surcharge_type'] = $newfunc->real_string(trim($fuel_surcharge_type, " "));
    $branchArray['cod_charge'] = $newfunc->real_string(trim($cod_charge, " "));
    $branchArray['cod_charge_type'] = $newfunc->real_string(trim($cod_charge_type, " "));
    $branchArray['awb_charge'] = $newfunc->real_string(trim($awb_charge, " "));
    $branchArray['fob_surcharge_minimum'] = $newfunc->real_string(trim($fob_surcharge_minimum, " "));
    $branchArray['fob_surcharge_percentage'] = $newfunc->real_string(trim($fob_surcharge_percentage, " "));
    $branchArray['handeling_charge'] = $newfunc->real_string(trim($handeling_charge, " "));
    $branchArray['handeling_charge_type'] = $newfunc->real_string(trim($handeling_charge_type, " "));
    $branchArray['cartage_charge'] = $newfunc->real_string(trim($cartage_charge, " "));
    $branchArray['cartage_charge_type'] = $newfunc->real_string(trim($cartage_charge_type, " "));
    $branchArray['damage_surcharge'] = $newfunc->real_string(trim($damage_surcharge, " "));
    $branchArray['damage_surcharge_type'] = $newfunc->real_string(trim($damage_surcharge_type, " "));
    $branchArray['oda_surcharge'] = $newfunc->real_string(trim($oda_surcharge, " "));
    $branchArray['oda_surcharge_type'] = $newfunc->real_string(trim($oda_surcharge_type, " "));
    $branchArray['packaging_surcharge'] = $newfunc->real_string(trim($packaging_surcharge, " "));
    $branchArray['packaging_surcharge_type'] = $newfunc->real_string(trim($packaging_surcharge_type, " "));
    $branchArray['special_delivery_or_appointment_charge'] = $newfunc->real_string(trim($special_delivery_or_appointment_charge, " "));
    $branchArray['special_delivery_or_appointment_charge_type'] = $newfunc->real_string(trim($special_delivery_or_appointment_charge_type, " "));
    $branchArray['pickup_charge'] = $newfunc->real_string(trim($pickup_charge, " "));
    $branchArray['pickup_charge_type'] = $newfunc->real_string(trim($pickup_charge_type, " "));
    if(array_key_exists('branch_charge', $_POST)){
        $branchArray['branch_charge'] = "yes";
    }else{
        $branchArray['branch_charge'] = "no";
    }
    if(array_key_exists('igst', $_POST)){
        $branchArray['igst'] = "yes";
    }else{
        $branchArray['igst'] = "not";
    }
    if($type == 'agent'){
        $branchArray['broker_commission'] = $newfunc->real_string(trim($broker_commission, " "));
        $branchArray['broker_commission_type'] = $newfunc->real_string(trim($broker_commission_type, " "));
    }
    $branchArray['threepl'] = $newfunc->real_string(trim($threepl, " "));
    $branchArray['cod_charge_min'] = $newfunc->real_string(trim($cod_charge_min, " "));
    $branchArray['damage_surcharge_min'] = $newfunc->real_string(trim($damage_surcharge_min, " "));
    $branchArray['oda_surcharge_min'] = $newfunc->real_string(trim($oda_surcharge_min, " "));
    $branchArray['special_delivery_or_appointment_charge_min'] = $newfunc->real_string(trim($special_delivery_or_appointment_charge_min, " "));
    $branchArray['freight_type'] = $newfunc->real_string(trim($freight_type, " "));
    if($newfunc->real_string(trim($tds, " ")) == "Yes"){
        $branchArray['tds'] = "yes";
    }elseif($newfunc->real_string(trim($tds, " ")) == "No"){
        $branchArray['tds'] = "no";
    }
    $submitBranch = $newquery->insertData('branches',$branchArray);
    if($submitBranch){
        if($branchArray['branch_charge'] == "yes"){
            $getBranchId = $newquery->getData('`id`','branches','','','id','DESC','1')[0];
            $arrnew['branch_id'] = $getBranchId['id'];
            foreach($_POST as $varkey => $varvalue){
                if(!array_key_exists($varkey, $branchArray)){
                    $arrnew[$varkey] = $newfunc->real_string(trim($varvalue, " "));
                }
            }
            unset($arrnew['submitaBranch']);
            if($type == 'branch'){
                unset($arrnew['broker_commission']);
                unset($arrnew['broker_commission_type']);
            }
            $submitBranchCharge = $newquery->insertData('branches_fright_master',$arrnew);
            if($submitBranchCharge){
                $headers = [
                  "MIME-Version" => "1.0",
                  "Content-Type" => "text/html;charset=UTF-8",
                  "From" => $company['email_id'],
                  "Reply-To" => "noreply@kingfishlogistics.in",
                ];
                $name = $branchArray['branch_name'];
                $username = $branchArray['branch_user_name'];
                $type = "a branch";
                $to = $branchArray['email'];
                $subject = "Account creation completed";
                ob_start();
                include("../assets/email-structure.php");
                $message = ob_get_contents();
                ob_get_clean();
                
                if(mail($to, $subject, $message, $headers)){
                    echo '<script type="text/javascript" language="javascript">
                            alert("You are successfully created a branch");
                            window.location = "branches-list";
                          </script>';
                }
            }else{
                echo '<script type="text/javascript" language="javascript">
                        alert("Something went wrong! Please contact with administrator");
                        window.location = "add-branch";
                      </script>';
            }
        }else{
            $headers = [
              "MIME-Version" => "1.0",
              "Content-Type" => "text/html;charset=UTF-8",
              "From" => $company['email_id'],
              "Reply-To" => "noreply@kingfishlogistics.in",
            ];
            $name = $branchArray['branch_name'];
            $username = $branchArray['branch_user_name'];
            $type = "a branch";
            $to = $branchArray['email'];
            $subject = "Account creation completed";
            ob_start();
            include("../assets/email-structure.php");
            $message = ob_get_contents();
            ob_get_clean();
            
            if(mail($to, $subject, $message, $headers)){
                echo '<script type="text/javascript" language="javascript">
                        alert("You are successfully created a branch");
                        window.location = "branches-list";
                      </script>';
            }
        }
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "add-branch";
              </script>';
    }
}


// update a branch
if(isset($_POST['saveChangesBranch'])){
    extract($_POST);
    $branch_user_name = $newfunc->real_string(trim($branch_user_name, " "));
    $branchArray['branch_name'] = $newfunc->real_string(trim($branch_name, " "));
    $branchArray['contact_person'] = $newfunc->real_string(trim($contact_person, " "));
    $branchArray['gst_trade_name'] = $newfunc->real_string(trim($gst_trade_name, " "));
    $branchArray['address'] = $newfunc->real_string(trim($address, " "));
    $branchArray['phone_no'] = $newfunc->real_string(trim($phone_no, " "));
    $branchArray['ewb_transporter_id'] = $newfunc->real_string(trim($ewb_transporter_id, " "));
    $branchArray['city'] = $newfunc->real_string(trim($city, " "));
    $branchArray['mobile_no'] = $newfunc->real_string(trim($mobile_no, " "));
    $branchArray['district'] = $newfunc->real_string(trim($district, " "));
    $branchArray['email'] = $newfunc->real_string(trim($email, " "));
    $branchArray['state'] = $newfunc->real_string(trim($state, " "));
    $branchArray['pincode'] = $newfunc->real_string(trim($pincode, " "));
    $branchArray['type'] = $newfunc->real_string(trim($type, " "));
    $branchArray['credit_type'] = $newfunc->real_string(trim($credit_type, " "));
    $branchArray['credit_limit'] = $newfunc->real_string(trim($credit_limit, " "));
    $branchArray['min_charge_weight'] = $newfunc->real_string(trim($min_charge_weight, " "));
    $branchArray['service_tax_no'] = $newfunc->real_string(trim($service_tax_no, " "));
    $branchArray['nature'] = $newfunc->real_string(trim($nature, " "));
    $branchArray['weight_round_off'] = $newfunc->real_string(trim($weight_round_off, " "));
    $branchArray['pan_no'] = $newfunc->real_string(trim($pan_no, " "));
    $branchArray['gst_no'] = $newfunc->real_string(trim($gst_no, " "));
    $branchArray['fuel_surcharge'] = $newfunc->real_string(trim($fuel_surcharge, " "));
    $branchArray['fuel_surcharge_type'] = $newfunc->real_string(trim($fuel_surcharge_type, " "));
    $branchArray['cod_charge'] = $newfunc->real_string(trim($cod_charge, " "));
    $branchArray['cod_charge_type'] = $newfunc->real_string(trim($cod_charge_type, " "));
    $branchArray['awb_charge'] = $newfunc->real_string(trim($awb_charge, " "));
    $branchArray['fob_surcharge_minimum'] = $newfunc->real_string(trim($fob_surcharge_minimum, " "));
    $branchArray['fob_surcharge_percentage'] = $newfunc->real_string(trim($fob_surcharge_percentage, " "));
    $branchArray['handeling_charge'] = $newfunc->real_string(trim($handeling_charge, " "));
    $branchArray['handeling_charge_type'] = $newfunc->real_string(trim($handeling_charge_type, " "));
    $branchArray['cartage_charge'] = $newfunc->real_string(trim($cartage_charge, " "));
    $branchArray['cartage_charge_type'] = $newfunc->real_string(trim($cartage_charge_type, " "));
    $branchArray['damage_surcharge'] = $newfunc->real_string(trim($damage_surcharge, " "));
    $branchArray['damage_surcharge_type'] = $newfunc->real_string(trim($damage_surcharge_type, " "));
    $branchArray['oda_surcharge'] = $newfunc->real_string(trim($oda_surcharge, " "));
    $branchArray['oda_surcharge_type'] = $newfunc->real_string(trim($oda_surcharge_type, " "));
    $branchArray['packaging_surcharge'] = $newfunc->real_string(trim($packaging_surcharge, " "));
    $branchArray['packaging_surcharge_type'] = $newfunc->real_string(trim($packaging_surcharge_type, " "));
    $branchArray['special_delivery_or_appointment_charge'] = $newfunc->real_string(trim($special_delivery_or_appointment_charge, " "));
    $branchArray['special_delivery_or_appointment_charge_type'] = $newfunc->real_string(trim($special_delivery_or_appointment_charge_type, " "));
    $branchArray['pickup_charge'] = $newfunc->real_string(trim($pickup_charge, " "));
    $branchArray['pickup_charge_type'] = $newfunc->real_string(trim($pickup_charge_type, " "));
    if(array_key_exists('branch_charge', $_POST)){
        $branchArray['branch_charge'] = "yes";
    }else{
        $branchArray['branch_charge'] = "no";
    }
    if(array_key_exists('igst', $_POST)){
        $branchArray['igst'] = "yes";
    }else{
        $branchArray['igst'] = "not";
    }
    if($type == 'agent'){
        $branchArray['broker_commission'] = $newfunc->real_string(trim($broker_commission, " "));
        $branchArray['broker_commission_type'] = $newfunc->real_string(trim($broker_commission_type, " "));
    }
    $branchArray['threepl'] = $newfunc->real_string(trim($threepl, " "));
    $branchArray['cod_charge_min'] = $newfunc->real_string(trim($cod_charge_min, " "));
    $branchArray['damage_surcharge_min'] = $newfunc->real_string(trim($damage_surcharge_min, " "));
    $branchArray['oda_surcharge_min'] = $newfunc->real_string(trim($oda_surcharge_min, " "));
    $branchArray['special_delivery_or_appointment_charge_min'] = $newfunc->real_string(trim($special_delivery_or_appointment_charge_min, " "));
    $branchArray['freight_type'] = $newfunc->real_string(trim($freight_type, " "));
    if($newfunc->real_string(trim($tds, " ")) == "Yes"){
        $branchArray['tds'] = "yes";
    }elseif($newfunc->real_string(trim($tds, " ")) == "No"){
        $branchArray['tds'] = "no";
    }
    $updateBranch = $newquery->updateData('branches',$branchArray,'branch_user_name',$branch_user_name);
    if($updateBranch){
        if($branchArray['branch_charge'] = "yes"){
            $Branch_id = $newquery->getData('`id`','branches','',array('branch_user_name'=>$branch_user_name),'','','')[0]['id'];
            foreach($_POST as $varkey => $varvalue){
                if(!array_key_exists($varkey, $branchArray)){
                    $arrnew[$varkey] = $newfunc->real_string(trim($varvalue, " "));
                }
            }
            unset($arrnew['branch_user_name']);
            unset($arrnew['saveChangesBranch']);
            if($type == 'branch'){
                unset($arrnew['broker_commission']);
                unset($arrnew['broker_commission_type']);
            }
            if($newquery->getData('*','branches_fright_master','',array('branch_id'=>$Branch_id),'id','DESC','1') != 0){
                $updateBranchCharge = $newquery->updateData('branches_fright_master',$arrnew,'branch_id',$Branch_id);
            }else{
                $arrnew['branch_id'] = $Branch_id;
                $updateBranchCharge = $newquery->insertData('branches_fright_master',$arrnew);
            }
            if($updateBranchCharge){
                echo '<script type="text/javascript" language="javascript">
                        alert("You are successfully updated that branch");
                        window.location = "branches-list";
                      </script>';
            }else{
                echo '<script type="text/javascript" language="javascript">
                        alert("Something went wrong! Please contact with administrator");
                        window.location = "edit-branch";
                      </script>';
            }
        }else{
            echo '<script type="text/javascript" language="javascript">
                    alert("You are successfully updated that branch");
                    window.location = "branches-list";
                  </script>';
        }
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "edit-branch";
              </script>';
    }
}


// change status of branch (block / unblock)
if(isset($_POST['branchStatus']) && !empty($_POST['branchStatus']) && isset($_POST['thisBranchId']) && !empty($_POST['thisBranchId'])){
    extract($_POST);
    $arrnew = array('status'=>$branchStatus);
    echo $newquery->updateData('branches',$arrnew,'id',$thisBranchId);
}


// change status of user (block / unblock)
if(isset($_POST['userStatus']) && !empty($_POST['userStatus']) && isset($_POST['thisUserId']) && !empty($_POST['thisUserId'])){
    extract($_POST);
    $arrnew = array('status'=>$userStatus);
    echo $newquery->updateData('users',$arrnew,'id',$thisUserId);
}


// change status of ware house (block / unblock)
if(isset($_POST['wareHouseStatus']) && !empty($_POST['wareHouseStatus']) && isset($_POST['thisWareHouseId']) && !empty($_POST['thisWareHouseId'])){
    extract($_POST);
    echo $newquery->updateData('warehouses',array('status'=>$wareHouseStatus),'id',$thisWareHouseId);
}


// change status of employee (block / unblock)
if(isset($_POST['employeeStatus']) && !empty($_POST['employeeStatus']) && isset($_POST['thisemployeeId']) && !empty($_POST['thisemployeeId'])){
    extract($_POST);
    $arrnew = array('status'=>$employeeStatus);
    echo $newquery->updateData('employees',$arrnew,'id',$thisemployeeId);
}


// delete a branch
if(isset($_GET['deleteBranch']) && isset($_GET['branchuserName']) && !empty($_GET['branchuserName'])){
    extract($_GET);
    $arrnew = array('delete_status'=>'delete');
    $updatedelete = $newquery->updateData('branches',$arrnew,'branch_user_name',$branchuserName);
    if($updatedelete){
        echo '<script type="text/javascript" language="javascript">
                alert("You are successfully delete a branch");
                window.location = "branches-list";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "branches-list";
              </script>';
    }
}

// delete a user
if(isset($_GET['deleteUser']) && isset($_GET['userName']) && !empty($_GET['userName'])){
    extract($_GET);
    $arrnew = array('delete_status'=>'delete');
    $updatedelete = $newquery->updateData('users',$arrnew,'username',$userName);
    if($updatedelete){
        echo '<script type="text/javascript" language="javascript">
                alert("You are successfully delete a user");
                window.location = "users-list?visible=edit";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "users-list?visible=edit";
              </script>';
    }
}

// delete a employee
if(isset($_GET['deleteEmp']) && isset($_GET['employeeCode']) && !empty($_GET['employeeCode'])){
    extract($_GET);
    $arrnew = array('delete_status'=>'delete');
    $updatedelete = $newquery->updateData('employees',$arrnew,'employee_code',$employeeCode);
    if($updatedelete){
        echo '<script type="text/javascript" language="javascript">
                alert("You are successfully delete a employee");
                window.location = "employee-master";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "employee-master";
              </script>';
    }
}


// edit fright master for a branch
if(isset($_POST['saveChangesFrightMaster'])){
    extract($_POST);
    $arrnew = array('branch_user_name'=>$newfunc->real_string(trim($branchUserName, " ")));
    $branchId = $newquery->getData('`id`','branches','',$arrnew,'id','DESC','1')[0];
    $Branch_id = $branchId['id'];
    foreach($_POST as $varkey => $varvalue){
        $frightMasterArray[$varkey] = $newfunc->real_string(trim($varvalue, " "));
    }
    unset($frightMasterArray['saveChangesFrightMaster']);
    unset($frightMasterArray['branchUserName']);
    $updatefrightmaster = $newquery->updateData('branches_fright_master',$frightMasterArray,'branch_id',$Branch_id);
    if($updatefrightmaster){
        echo '<script type="text/javascript" language="javascript">
                alert("You are successfully edited a this branch\'s fright");
                window.location = "branches-fright-master";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "branches-fright-master";
              </script>';
    }
}


// edit fright master for a user
if(isset($_POST['saveChangesUsersFrightMaster'])){
    extract($_POST);
    $userId = $newquery->getData('`id`','users','',array('username'=>$newfunc->real_string(trim($UserName, " "))),'','','')[0];
    $User_id = $userId['id'];
    foreach($_POST as $varkey => $varvalue){
        $frightMasterArray[$varkey] = $newfunc->real_string(trim($varvalue, " "));
    }
    unset($frightMasterArray['saveChangesUsersFrightMaster']);
    unset($frightMasterArray['UserName']);
    $updatefrightmaster = $newquery->updateData('users_fright_master',$frightMasterArray,'user_id',$User_id);
    if($updatefrightmaster){
        echo '<script type="text/javascript" language="javascript">
                alert("You are successfully edited a this user\'s fright");
                window.location = "users-fright-master";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "users-fright-master";
              </script>';
    }
}


// edit bank details
if(isset($_POST['saveChangesbankDetails'])){
    extract($_POST);
    if(!empty($_FILES['qr_code']['name'])){
        $qrcode = str_replace(array("/","php","tmp"), "", $_FILES['qr_code']['tmp_name']).uniqid().".".pathinfo($_FILES['qr_code']['name'],PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['qr_code']['tmp_name'],"../storage/bank/".$qrcode);
        $_POST['qr_code'] = $qrcode;
    }else{
        $getbank = $newquery->getData('*','bank_details','',array("id"=>"1"),'','','')[0];
        $_POST['qr_code'] = $getbank['qr_code'];
    }
    foreach($_POST as $varkey => $varvalue){
        $bankMasterArray[$varkey] = $newfunc->real_string(trim($varvalue, " "));
    }
    unset($bankMasterArray['saveChangesbankDetails']);
    $updatebankmaster = $newquery->updateData('bank_details',$bankMasterArray,'id',"1");
    if($updatebankmaster){
        echo '<script type="text/javascript" language="javascript">
                alert("You are successfully updated bank details");
                window.location = "bank-master";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "bank-master";
              </script>';
    }
}

// add role
if(isset($_POST['submitEmpRoles'])){
    extract($_POST);
    $roleName = $newfunc->real_string(trim($roleName, " "));
    $rolesArray = $newfunc->real_string(trim(implode(",", $roles), " "));
    $arr = array('role_name'=>$roleName,'delete_status'=>'show');
    $selret = $newquery->getData('*','roles','',$arr,'','','');
    if(strtolower($selret[0]['role_name']) != strtolower($roleName)){
        $rolesmaster = $newquery->insertData('roles',array('role_name'=>$roleName,'roles'=>$rolesArray));
        if($rolesmaster){
            echo '<script type="text/javascript" language="javascript">
                    alert("You are successfully added a roles");
                    window.location = "role-master";
                  </script>';
        }else{
            echo '<script type="text/javascript" language="javascript">
                    alert("Something went wrong! Please contact with administrator");
                    window.location = "role-master";
                  </script>';
        }
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("This role is already added");
                window.location = "role-master";
              </script>';
    }
}

// update role
if(isset($_POST['updateEmpRoles'])){
    extract($_POST);
    $roleIs = $newfunc->real_string(trim($roleIs, " "));
    $roleName = $newfunc->real_string(trim($roleName, " "));
    $rolesArray = $newfunc->real_string(trim(implode(",", $roles), " "));
    $arr = array('role_name'=>$roleName,'delete_status'=>'show');
    $selret = $newquery->getData('*','roles','',$arr,'','','');
    if(strtolower($selret[0]['role_name']) != strtolower($roleName)){
        $rolesmaster = $newquery->updateData('roles',array('role_name'=>$roleName,'roles'=>$rolesArray),'role_name',$roleIs);
        if($rolesmaster){
            echo '<script type="text/javascript" language="javascript">
                    alert("You are successfully updated this roles");
                    window.location = "role-master";
                  </script>';
        }else{
            echo '<script type="text/javascript" language="javascript">
                    alert("Something went wrong! Please contact with administrator");
                    window.location = "role-master";
                  </script>';
        }
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("This role is already added");
                window.location = "role-master";
              </script>';
    }
}


// Update users role
if(isset($_POST['submitRoles'])){
    extract($_POST);
    $userName = $newfunc->real_string(trim($userName, " "));
    $rolesArray = $newfunc->real_string(trim(implode(",", $roles), " "));
    $rolesmaster = $newquery->updateData('users',array('roles'=>$rolesArray),'username',$userName);
    if($rolesmaster){
        echo '<script type="text/javascript" language="javascript">
                alert("You are successfully updated this user roles");
                window.location = "role-master";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "role-master";
              </script>';
    }
}


// submit employee
if(isset($_POST['submitaEmployee'])){
    $getEmpUserName = $newquery->getData('*','employees','','','id','DESC','1');
  	if($getEmpUserName != 0){
        $emp_user_name = explode("-", $getEmpUserName[0]['employee_code']);
        $username = "EMP-".($emp_user_name[1]+1);
        $empArray['employee_code'] = $username;
    }else{
        $username = 'EMP-10001';
        $empArray['employee_code'] = $username;
    }
    $password = rand(100000,999999);
    $md5password = md5($password);
    $empArray['password'] = $md5password;
    $name = $_POST['employee_name'];
    foreach($_POST as $varkey => $varvalue){
        $empArray[$varkey] = $newfunc->real_string(trim($varvalue, " "));
    }
    unset($empArray['documents']);
    unset($empArray['submitaEmployee']);
    $empTotalDetails = [];
    for($i = 0; $i < count($_FILES['documents']['tmp_name']); $i++):
        $employeeDetails = str_replace(array("/","php","tmp"), "", $_FILES['documents']['tmp_name'][$i]).uniqid().".".pathinfo($_FILES['documents']['name'][$i],PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['documents']['tmp_name'][$i],"../storage/employees/".$employeeDetails);
        $empTotalDetails[] = $employeeDetails;
    endfor;
    $empArray['documents'] = implode("|", $empTotalDetails);
    $insemp = $newquery->insertData('employees',$empArray);
    $type = "an employee";
    $headers = [
      "MIME-Version" => "1.0",
      "Content-Type" => "text/html;charset=UTF-8",
      "From" => $company['email_id'],
      "Reply-To" => "noreply@kingfishlogistics.in",
    ];
    
    $to = $empArray['email'];
    $subject = "Account creation completed";
    ob_start();
    include("../assets/email-structure.php");
    $message = ob_get_contents();
    ob_get_clean();
    
    mail($to, $subject, $message, $headers);
    if($insemp){
        echo '<script type="text/javascript" language="javascript">
                alert("You are successfully created a employee");
                window.location = "employee-master";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "employee-master";
              </script>';
    }
}


// edit a employee
if(isset($_POST['updateaEmployee'])){
    foreach($_POST as $varkey => $varvalue){
        if($varkey != "oldFiles"):
            $empUpdArray[$varkey] = $newfunc->real_string(trim($varvalue, " "));
        endif;
    }
    unset($empUpdArray['updateaEmployee']);
    unset($empUpdArray['employee']);
    if(!empty($_FILES['documents']['name'][0])){
        $allFiles = [];
        for($i = 0; $i < count($_FILES['documents']['name']); $i++){
            $employeeDetails = str_replace(array("/","php","tmp"), "", $_FILES['documents']['tmp_name'][$i]).uniqid().".".pathinfo($_FILES['documents']['name'][$i],PATHINFO_EXTENSION);
            move_uploaded_file($_FILES['documents']['tmp_name'][$i],"../storage/employees/".$employeeDetails);
            $allFiles[] = $employeeDetails;
        }
        $allFiles = implode("|", $allFiles);
    }
    if(!empty($oldFiles)){
        $allFiles = $allFiles."|".implode("|", $oldFiles);
    }
    $empUpdArray['documents'] = trim($allFiles, "|");
    $employeeCode = $newfunc->real_string(trim($_POST['employee'], " "));
    $updEmp = $newquery->updateData('employees',$empUpdArray,'employee_code',$employeeCode);
    if($updEmp){
        echo '<script type="text/javascript" language="javascript">
                alert("You have successfully updated this employee");
                window.location = "employee-master";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "employee-master";
              </script>';
    }
}


// Update employee role
if(isset($_POST['submitEmpRoles'])){
    extract($_POST);
    $empCode = $newfunc->real_string(trim($empCode, " "));
    $rolesArray = $newfunc->real_string(trim(implode(",", $roles), " "));
    $empRolesmaster = $newquery->updateData('employees',array('roles'=>$rolesArray),'employee_code',$empCode);
    if($empRolesmaster){
        echo '<script type="text/javascript" language="javascript">
                alert("You are successfully updated this employee roles");
                window.location = "role-master";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "role-master";
              </script>';
    }
}


// upload POD file
if(isset($_POST['podUpload'])){
    extract($_POST);
    $lr = $newfunc->real_string(trim($orderLR, " "));
    $ext = pathinfo($_FILES['podFile']['name'], PATHINFO_EXTENSION);
    $podFile = "PODOF".$lr.".".$ext;
    move_uploaded_file($_FILES['podFile']['tmp_name'], "../dyfiles/PODS/".$podFile);
    $uppod = $newquery->updateData('orders',array('pod_on_delivery'=>$podFile),'lr',$lr);
    if($uppod){
        echo '<script type="text/javascript" language="javascript">
                alert("You have successfully updated the order POD");
                window.location = "'.$_SERVER['HTTP_REFERER'].'";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "'.$_SERVER['HTTP_REFERER'].'";
              </script>';
    }
}


// add money status
if(isset($_GET['submit']) && $_GET['submit'] == "Submit" && !empty($_GET['thisIs']) && !empty($_GET['style']) && $_GET['style'] == "Approve" || $_GET['style'] == "Reject"){
    extract($_GET);
    $thisIs = $newfunc->real_string(trim($thisIs, " "));
    $style = $newfunc->real_string(trim($style, " "));
    $getdetails = $newquery->getData("*","add_money_requests","",array("id"=>$thisIs),"id","DESC","1")[0];
    if($style == "Approve"){
        $outstanding = $newquery->getData("*","outstanding_report","",array("user_type"=>$getdetails['type'],"type_id"=>$getdetails['type_id'],"status"=>"Not Clear"),"","","1");
        if($outstanding != 0):
            $haveClearPrice = $outstanding[0]['outstanding_price'] - $outstanding[0]['cleared_price'];
            if($haveClearPrice > $getdetails['amount']):
                $clearPrice = $getdetails['amount'];
                $clearStatus = "Not Clear";
            elseif($haveClearPrice <= $getdetails['amount']):
                $clearPrice = $outstanding[0]['outstanding_price'];
                $clearStatus = "Cleared";
            endif;
            $updOurStand = $newquery->updateData("outstanding_report",array("cleared_price"=>$clearPrice,"clear_date"=>date("Y-m-d"),"status"=>$clearStatus),"id",$outstanding[0]['id']);
            if(!$updOurStand):
                $newfunc->alertRedirect("Something went wrong! Please Contact with administrator", $_SERVER['HTTP_REFERER']);
            endif;
        endif;
        $getEmpUserName = $newquery->getData('*','transactions','',array('txn_id_type'=>'Serial'),'id','DESC','1');
      	if($getEmpUserName != 0){
            $txn_id = "KINGFISH".(str_replace("KINGFISH","",$getEmpUserName[0]['txn_id'])+1);
        }else{
            $txn_id = 'KINGFISH100000';
        }
        $getbalance = $newquery->getData("`wallet_balance`",$getdetails['type'],"",array("id"=>$getdetails['type_id']),"id","DESC","1")[0];
        $newBalance = ($getbalance['wallet_balance']+$getdetails['amount']);
        $datetime = date('Y-m-d H:i:s');
        $add_m = $newquery->insertData('transactions',array('date_time'=>$datetime,'user_type'=>$getdetails['type'],'user_id'=>$getdetails['type_id'],'amount'=>$getdetails['amount'],'balance'=>$newBalance,'type'=>'Manual','details'=>'Add money manually','txn_id'=>$txn_id,'status'=>'Credit'));
        if($add_m){
            $updsuccDetails = $newquery->updateData("add_money_requests",array('status'=>'Approved'),"id",$thisIs);
            if($updsuccDetails){
                $updwalBal = $newquery->updateData($getdetails['type'],array('wallet_balance'=>$newBalance),"id",$getdetails['type_id']);
                if($updwalBal){
                    echo '<script type="text/javascript" language="javascript">
                            alert("You have successfully approved the add money request");
                            window.location = "add-money-requests";
                          </script>';
                }else{
                    echo '<script type="text/javascript" language="javascript">
                            alert("Something went wrong! Please contact with administrator");
                            window.location = "add-money-requests";
                          </script>';
                }
            }else{
                echo '<script type="text/javascript" language="javascript">
                        alert("Something went wrong! Please contact with administrator");
                        window.location = "add-money-requests";
                      </script>';
            }
        }else{
            echo '<script type="text/javascript" language="javascript">
                    alert("Something went wrong! Please contact with administrator");
                    window.location = "add-money-requests";
                  </script>';
        }
    }elseif($style == "Reject"){
        $updDetails = $newquery->updateData("add_money_requests",array('status'=>'Rejected'),"id",$thisIs);
        if($updDetails){
            echo '<script type="text/javascript" language="javascript">
                    alert("You have successfully rejected the add money request");
                    window.location = "add-money-requests";
                  </script>';
        }else{
            echo '<script type="text/javascript" language="javascript">
                    alert("Something went wrong! Please contact with administrator");
                    window.location = "add-money-requests";
                  </script>';
        }
    }
}

// Change Zone of a State
if(isset($_POST['changeZone'])){
    extract($_POST);
    $arr = array('zone_id'=>$zone);
    $ret = $newquery->updateData('states',$arr,'id',$stateId);
    if($ret){
        echo '<script type="text/javascript" language="javascript">
                alert("Zone Changed for this State");
                window.location = "zone-master-states";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "zone-master-states";
              </script>';
    }
}

// Change State of a city
if(isset($_POST['changeState'])){
    extract($_POST);
    $arr = array('state_id'=>$state,'city'=>$city);
    $ret = $newquery->updateData('cities',$arr,'id',$cityId);
    if($ret){
        echo '<script type="text/javascript" language="javascript">
                alert("City Updated Successfully");
                window.location = "zone-master-cities";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "zone-master-cities";
              </script>';
    }
}

// delete a city
if(isset($_POST['deleteCity'])){
    extract($_POST);
    $arr = array('delete_status'=>'delete');
    $ret = $newquery->updateData('cities',$arr,'id',$cityId);
    if($ret){
        echo '<script type="text/javascript" language="javascript">
                alert("You have successfully deleted this City");
                window.location = "zone-master-cities";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "zone-master-cities";
              </script>';
    }
}


// Change City of a PIN Code
if(isset($_POST['changeCity'])){
    extract($_POST);
    $arr = array('city_id'=>$city,'state_id'=>$state);
    $ret = $newquery->updateData('pincodes',$arr,'id',$pincodeId);
    if($ret){
        echo '<script type="text/javascript" language="javascript">
                alert("PIN Code Updated Successfully");
                window.location = "zone-master-pincodes";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "zone-master-pincodes";
              </script>';
    }
}

// delete a PIN Code
if(isset($_POST['deletePinCode'])){
    extract($_POST);
    $arr = array('delete_status'=>'delete');
    $ret = $newquery->updateData('pincodes',$arr,'id',$pincodeId);
    if($ret){
        echo '<script type="text/javascript" language="javascript">
                alert("You have successfully deleted this PIN Code");
                window.location = "zone-master-pincodes";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "zone-master-pincodes";
              </script>';
    }
}

// appointment status change
if(isset($_POST['appointmentStatus'])){
    extract($_POST);
    $sts = explode(",", $newfunc->real_string(trim($appointmentStatus, " ")));
    $valid = 1;
    if($sts[0] == "processing"){
        $lRn = $newquery->getData('*','appointments','',array("id"=>$sts[1]),'id','DESC','1')[0]['lr_no'];
        $data = $newquery->getData('*','orders','',array("lr"=>$lRn),'id','DESC','1')[0];
        if($data['special_delivery_charge_applied'] == "No"){
            $updatedTotalCharge = round($data['total_charge']+$data['special_delivery_charge'], 2);
            $updateCharge = $newquery->updateData('orders',array('special_delivery_charge_applied'=>'Yes','total_charge'=>$updatedTotalCharge),'lr',$lRn);
            if($updateCharge){
                $new_bal = round(($newquery->getData("`wallet_balance`",$data['user_type'],"",array("id"=>$data['type_id']),"id","DESC","1")[0]['wallet_balance']) - $data['special_delivery_charge'], 2);
                $updWalletBal = $newquery->updateData($data['user_type'],array("wallet_balance"=>$new_bal),'id',$data['type_id']);
                if($updWalletBal){
                    $getTxnId = $newquery->getData('*','transactions','',array("txn_id_type"=>"Serial"),'id','DESC','1');
                  	$merchantTransactionId = ($getTxnId != 0)? "KINGFISH".(str_replace("KINGFISH","",$getTxnId[0]['txn_id'])+1) : 'KINGFISH100000';
                  	if($newquery->insertData('transactions',array("date_time"=>date('Y-m-d H:i:s'),"user_type"=>$data['user_type'],"user_id"=>$data['type_id'],"amount"=>$data['special_delivery_charge'],"balance"=>$new_bal,"type"=>"Online","details"=>str_replace("'", "\'", "Order Id: ".$data['order_id']."'s appointment charge deducted due to booking of appointment"),"txn_id"=>$merchantTransactionId,'status'=>'Debit'))){
                  	    $valid = 1;
                  	}else{
                  	    $valid = 0;
                  	}
                }else{
              	    $valid = 0;
              	}
            }else{
          	    $valid = 0;
          	}
        }else{
      	    $valid = 1;
      	}
    }
    if($valid == 0){
        echo 0;
    }else{
        echo $newquery->updateData('appointments',array("status"=>$sts[0]),'id',$sts[1]);
    }
}

// submit salary
if(isset($_POST['submitSalary'])){
    extract($_POST);
    $emp_id = $employee;
    $where = array("emp_id"=>$emp_id,"month"=>$month,"year"=>$year);
    $getsal = $newquery->getData("*","salary","",$where,"","","");
    if($getsal!=0){
        echo '<script type="text/javascript" language="javascript">
                alert("Salary of this month has been already paid to the employee");
                window.location = "salary";
              </script>';
    }else{
        $whemp = array("id"=>$emp_id);
        $getemp = $newquery->getData("*","employees","",$whemp,"","","");
        $allowances = $getemp[0]['allowances'];
        $ot_day = $getemp[0]['ot_day'];
        $ot_hour = $getemp[0]['ot_hour'];
        $dataArr = array("emp_id"=>$employee,"year"=>date("Y"),"month"=>$month,"allowances"=>$allowances,"ot_day"=>$ot_day,"nos_ot_days"=>$nos_ot_days,"ot_hour"=>$ot_hour,"nos_ot_hours"=>$nos_ot_hours,"amount"=>$salary);
        
        if($newquery->insertData('salary',$dataArr)){
            echo '<script type="text/javascript" language="javascript">
                    alert("Salary Payment Recorded Successfully");
                    window.location = "salary-master";
                  </script>';
        }else{
            echo '<script type="text/javascript" language="javascript">
                    alert("Something went wrong! Please contact with administrator");
                    window.location = "salary";
                  </script>';
        }
    }
}

// submit Payslip Generation
if(isset($_POST['salSlipSubmit'])){
    extract($_POST);
    $cndr = array("employee_code"=>$empCode);
    $getEmp = $newquery->getData("*","employees","",$cndr,"","","");
    $emp_id = $getEmp[0]['id'];
    $where = array("emp_id"=>$emp_id,"month"=>$salaryMonth,"year"=>$salaryYear);
    $getsal = $newquery->getData("id","salary","",$where,"","","");
    if($getsal){
        $_SESSION['emp_payslip_id'] = $getsal[0]['id'];
        echo '<script type="text/javascript" language="javascript">
                window.location = "../emps/payslip/index.php";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "salary-master";
              </script>';
    }
}

// edit admin profile
if(isset($_POST['updateProfile'])){
    extract($_POST);
    $dataArr = array("name"=>$name,"mobile"=>$mobile,"email"=>$email,"address"=>$address);
    if($newquery->updateData('admin_login',$dataArr,'id',$id)){
        echo '<script type="text/javascript" language="javascript">
                alert("Profile Updated Successfully");
                window.location = "profile";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "profile";
              </script>';
    }
}

// change password
if(isset($_POST['changePassword']))
{
    $id = $_POST['id'];
    $password = md5($_POST['password']);
    $cond = array("userpassword"=>$password);
    if($updPassword = $newquery->updateData('admin_login',$cond,'id',$id))
    {
        echo '<script type="text/javascript" language="javascript">
                alert("Password Changed Successfully !!");
                window.location = "change-password.php";
              </script>';
    }
    else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "change-password.php";
              </script>';
    }
}

// cashbook request approve reject
if($_GET['save'] == "cashbooksubmit" && !empty($_GET['cshbk']) && !empty($_GET['option'])){
    extract($_GET);
    $cshbk = $newfunc->real_string(trim($cshbk, " "));
    $option = $newfunc->real_string(trim($option, " "));
    if($option == 'Approve'){
        $option="Approved";
    }
    elseif($option == 'Reject'){
        $option="Rejected";
    }
    if($newquery->updateData("cashbook",array('approve_status'=>$option),"id",$cshbk)){
        echo '<script type="text/javascript" language="javascript">
                alert("You have '.$option.' this request");
                window.location = "cashbook";
              </script>';
    }else{
        echo '<script type="text/javascript" language="javascript">
                alert("Something went wrong! Please contact with administrator");
                window.location = "cashbook";
              </script>';
    }
}

// Single invoice generation
if(isset($_POST['bilInvoiceSubmit'])){
    extract($_POST);
    $cndr = array("lr"=>$lr_no);
    $getOrd = $newquery->getData("*","orders","",$cndr,"id","DESC","1");
    if($getOrd){
        echo '<script type="text/javascript" language="javascript">
                window.location = "../invoice/bill?bill_report_entity_type='.$getOrd[0]['user_type'].'&bill_report_entity_id='.$getOrd[0]['type_id'].'&bill_report_LRs='.$lr_no.'";
              </script>';
    }else{
        $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
    }
}


// Submit other stationary master
if(isset($_POST['submitOtherStationary'])){
    extract($_POST);
    $stationary_name = str_replace("'", "\'", $newfunc->real_string(trim($stationary_name, " ")));
    $stationary_prefix = str_replace("'", "\'", $newfunc->real_string(trim($stationary_prefix, " ")));
    $arr = array('stationary_name'=>$stationary_name,'stationary_prefix'=>$stationary_prefix);
    if($newquery->getData('*','other_stationaries','',$arr,'id','DESC','') == 0):
        $ret = $newquery->insertData('other_stationaries',$arr);
        if($ret){
            $newfunc->alertRedirect("You have successfully added a stationary input",$_SERVER['HTTP_REFERER']);
        }else{
            $newfunc->alertRedirect("Something went wrong! Please contact with administrator",$_SERVER['HTTP_REFERER']);
        }
    else:
        $newfunc->alertRedirect("Stationary name and prefix already exist!",$_SERVER['HTTP_REFERER']);
    endif;
}


// Edit other Stationary master
if(isset($_POST['editOtherStationary'])){
    extract($_POST);
    $stationary_name = str_replace("'", "\'", $newfunc->real_string(trim($stationary_name, " ")));
    $stationary_prefix = str_replace("'", "\'", $newfunc->real_string(trim($stationary_prefix, " ")));
    $arr = array('stationary_name'=>$stationary_name);
    if($newquery->getData('*','other_stationaries','',array('stationary_name'=>$stationary_name,'stationary_prefix'=>$stationary_prefix),'id','DESC','') == 0):
        $return = $newquery->updateData('other_stationaries',$arr,'id',$id);
        if($return):
            if($newquery->getData('*','others_stationary_allotments','',array('other_stationary_id'=>$id),'id','DESC','') == 0):
                $newarr = array('stationary_prefix'=>$stationary_prefix);
                $ret = $newquery->updateData('other_stationaries',$newarr,'id',$id);
                if($ret):
                    $newfunc->alertRedirect("You have successfully updated this stationary Prefix",$_SERVER['HTTP_REFERER']);
                else:
                    $newfunc->alertRedirect("Something went wrong! Please contact with administrator",$_SERVER['HTTP_REFERER']);
                endif;
            else:
                $newfunc->alertRedirect("Can't change the prefix due to already assigned!",$_SERVER['HTTP_REFERER']);
            endif;
        else:
            $newfunc->alertRedirect("Something went wrong! Please contact with administrator",$_SERVER['HTTP_REFERER']);
        endif;
    else:
        $newfunc->alertRedirect("Stationary name and prefix already exist!",$_SERVER['HTTP_REFERER']);
    endif;
}


// Delete stationary master
if(isset($_POST['deleteOtherStationary'])){
    extract($_POST);
    if($newquery->getData('*','others_stationary_allotments','',array('other_stationary_id'=>$id),'id','DESC','') == 0){
        $arr = array('delete_status'=>'delete');
        $ret = $newquery->updateData('other_stationaries',$arr,'id',$id);
        if($ret){
            $newfunc->alertRedirect("You are successfully deleted this stationary Prefix",$_SERVER['HTTP_REFERER']);
        }else{
            $newfunc->alertRedirect("Something went wrong! Please contact with administrator",$_SERVER['HTTP_REFERER']);
        }
    }else{
        $newfunc->alertRedirect("Can't delete due to already assigned!",$_SERVER['HTTP_REFERER']);
    }
}


// Multiple invoice generation
if(isset($_POST['viewbillSubmit'])){
    extract($_POST);
    if($entityType == 'users'){
        $cndr = array("username"=>$entityUname);
    }
    elseif($entityType == 'branches'){
        $cndr = array("branch_user_name"=>$entityUname);
    }
    $getId = $newquery->getData("*",$entityType,"",$cndr,"","","");
    $id = $getId[0]['id'];
    if($getId){
        $billForLR = implode(",", $billForLR);
        echo '<script type="text/javascript" language="javascript">
                window.location = "../invoice/bill?bill_report_entity_type='.$entityType.'&bill_report_entity_id='.$id.'&bill_report_LRs='.$billForLR.'";
              </script>';
    }else{
        $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
    }
}


if(isset($_POST['notChangeStationary'])){
    extract($_POST);
    if(!empty($stationary) && !empty($start_allotment_no) && !empty($end_allotment_no)):
        if($start_allotment_no < $end_allotment_no):
            $thisPrefixDataForThisNo = $newquery->getData('*','stationary_invoice_allotments','',array(array('stationary_invoice_id','=',$stationary),array('user_type','!=',$user_type),array('type_id','!=',$type_id)),'id','DESC','');
            $searchForThisNo = 0;
            if($thisPrefixDataForThisNo != 0):
                foreach($thisPrefixDataForThisNo as $checking):
                    for($i = $start_allotment_no; $i <= $end_allotment_no; $i++):
                        if($checking['start_allotment_no'] <= $i && $i <= $checking['end_allotment_no']):
                            $searchForThisNo = 1;
                            break;
                        endif;
                    endfor;
                endforeach;
            endif;
            if($searchForThisNo == 0):
                $insertInvNo = $newquery->insertData('stationary_invoice_allotments',array('user_type'=>$user_type,'type_id'=>$type_id,'stationary_invoice_id'=>$stationary,'start_allotment_no'=>$start_allotment_no,'end_allotment_no'=>$end_allotment_no));
                if($insertInvNo):
                    $newfunc->alertRedirect("Invoice numbers successfully alloted",$_SERVER['HTTP_REFERER']);
                else:
                    $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
                endif;
            else:
                $newfunc->alertRedirect("Staionary numbers already alloted for this prefix",$_SERVER['HTTP_REFERER']);
            endif;
        else:
            $newfunc->alertRedirect("End allotment number should be greater than start!",$_SERVER['HTTP_REFERER']);
        endif;
    else:
        $newfunc->alertRedirect("Please fill the required fields!",$_SERVER['HTTP_REFERER']);
    endif;
}


// change stationary master for Invoice
// if(isset($_POST['changeStationary'])){
//     extract($_POST);
//     if(!empty($stationary) && !empty($start_allotment_no) && !empty($end_allotment_no)):
//         if($start_allotment_no < $end_allotment_no):
//             if($newquery->getData('*','stationary_invoice_allotments','',array('user_type'=>$user_type,'type_id'=>$type_id),'id','DESC','1') != 0):
//                 $thisPrefixDataForThisNo = $newquery->getData('*','stationary_invoice_allotments','',array(array('stationary_invoice_id','=',$stationary),array('user_type','!=',$user_type),array('type_id','!=',$type_id)),'id','DESC','');
//                 $searchForThisNo = 0;
//                 if($thisPrefixDataForThisNo != 0):
//                     foreach($thisPrefixDataForThisNo as $checking):
//                         for($i = $start_allotment_no; $i <= $end_allotment_no; $i++):
//                             if($checking['start_allotment_no'] <= $i && $i <= $checking['end_allotment_no']):
//                                 $searchForThisNo = 1;
//                                 break;
//                             endif;
//                         endfor;
//                     endforeach;
//                 endif;
//                 if($searchForThisNo == 0):
//                     $haveInvoiceChecking = $newquery->getData('*','stationary_invoice_allotments','',array(array('stationary_invoice_id','=',$stationary),array('user_type','=',$user_type),array('type_id','=',$type_id)),'id','DESC','')[0];
//                     if($haveInvoiceChecking['start_allotment_no'] == $start_allotment_no):
//                         $lastInvNo = 0;
//                         for($j = $haveInvoiceChecking['start_allotment_no']; $j <= $haveInvoiceChecking['end_allotment_no']; $j++):
//                             $invNewChecking = $newquery->getData('*','stationary_invoices','',array('invoice_no'=>$newquery->getData('`stationary_prefix`','stationaries','',array('id'=>$stationary),'id','DESC','1')[0]['stationary_prefix'].$j),'id','DESC','');
//                             if($invNewChecking == 0):
//                                 $lastInvNo = $j;
//                                 break;
//                             endif;
//                         endfor;
//                         if($lastInvNo == 0):
//                             $isValid = 1;
//                         else:
//                             $isValid = ($lastInvNo < $end_allotment_no)? 1 : 0;
//                         endif;
//                         if($isValid == 1):
//                             $insertInvNo = $newquery->updateData('stationary_invoice_allotments',array('stationary_invoice_id'=>$stationary,'start_allotment_no'=>$start_allotment_no,'end_allotment_no'=>$end_allotment_no),'id',$stationaryAllomentId);
//                             if($insertInvNo):
//                                 $insertStationaryNo = $newquery->updateData($user_type,array('stationary_id'=>$type_id),'id',$type_id);
//                                 if($insertStationaryNo):
//                                     $newfunc->alertRedirect("Invoice numbers successfully saved",$_SERVER['HTTP_REFERER']);
//                                 else:
//                                     $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
//                                 endif;
//                             else:
//                                 $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
//                             endif;
//                         else:
//                             $newfunc->alertRedirect("The end allotment number should be same or greater than ".$lastInvNo,$_SERVER['HTTP_REFERER']);
//                         endif;
//                     else:
//                         $invFirstChecking = $newquery->getData('*','stationary_invoices','',array('invoice_no'=>$newquery->getData('`stationary_prefix`','stationaries','',array('id'=>$stationary),'id','DESC','1')[0]['stationary_prefix'].$start_allotment_no),'id','DESC','');
//                         if($invFirstChecking == 0):
//                             $insertInvNo = $newquery->updateData('stationary_invoice_allotments',array('stationary_invoice_id'=>$stationary,'start_allotment_no'=>$start_allotment_no,'end_allotment_no'=>$end_allotment_no),'id',$stationaryAllomentId);
//                             if($insertInvNo):
//                                 $insertStationaryNo = $newquery->updateData($user_type,array('stationary_id'=>$type_id),'id',$type_id);
//                                 if($insertStationaryNo):
//                                     $newfunc->alertRedirect("Invoice numbers successfully saved",$_SERVER['HTTP_REFERER']);
//                                 else:
//                                     $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
//                                 endif;
//                             else:
//                                 $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
//                             endif;
//                         else:
//                             $newfunc->alertRedirect("Invoice created for first allotment no. So, you can't change the first allotment number.",$_SERVER['HTTP_REFERER']);
//                         endif;
                        
//                     endif;
//                 else:
//                     $newfunc->alertRedirect("Numbers are already alloted for this Prefix",$_SERVER['HTTP_REFERER']);
//                 endif;
//             else:
//                 $insertInvNo = $newquery->insertData('stationary_invoice_allotments',array('user_type'=>$user_type,'type_id'=>$type_id,'stationary_invoice_id'=>$stationary,'start_allotment_no'=>$start_allotment_no,'end_allotment_no'=>$end_allotment_no));
//                 if($insertInvNo):
//                     $insertStationaryNo = $newquery->updateData($user_type,array('stationary_id'=>$type_id),'id',$type_id);
//                     if($insertStationaryNo):
//                         $newfunc->alertRedirect("Invoice numbers successfully saved",$_SERVER['HTTP_REFERER']);
//                     else:
//                         $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
//                     endif;
//                 else:
//                     $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
//                 endif;
//             endif;
//         else:
//             $newfunc->alertRedirect("Start allotment number should be greater than end!",$_SERVER['HTTP_REFERER']);
//         endif;
//     else:
//         $newfunc->alertRedirect("Please fill the required fields!",$_SERVER['HTTP_REFERER']);
//     endif;
// }

if(isset($_POST['allotStationary'])):
    extract($_POST);
    if($start_allotment_no < $end_allotment_no):
        $allotedChecking = $newquery->getData("*","stationary_invoice_allotments","",array("user_type"=>$user_type,"type_id"=>$type_id),"id","DESC","1");
        if($allotedChecking != 0):
            if($allotedChecking[0]['number_status'] == "End"):
                $allot = $newquery->insertData("stationary_invoice_allotments",array("user_type"=>$user_type,"type_id"=>$type_id,"stationary_invoice_id"=>$stationary,"start_allotment_no"=>$start_allotment_no,"end_allotment_no"=>$end_allotment_no));
                if($allot):
                    $newfunc->alertRedirect("Numbers successfully alloted!",$_SERVER['HTTP_REFERER']);
                endif;
            else:
                $newfunc->alertRedirect("Previous numbers are not ended!",$_SERVER['HTTP_REFERER']);
            endif;
        else:
            $numberChecking = $newquery->getData("*","stationary_invoice_allotments","","","id","DESC","");
            $isValid = 1;
            foreach($numberChecking as $num):
                for($i = $start_allotment_no; $i <= $end_allotment_no; $i++):
                    if($num['start_allotment_no'] <= $i && $num['end_allotment_no'] >= $i):
                        $isValid = 0;
                        break;
                        break;
                    endif;
                endfor;
            endforeach;
            if($isValid == 1):
                $allot = $newquery->insertData("stationary_invoice_allotments",array("user_type"=>$user_type,"type_id"=>$type_id,"stationary_invoice_id"=>$stationary,"start_allotment_no"=>$start_allotment_no,"end_allotment_no"=>$end_allotment_no));
                if($allot):
                    $newfunc->alertRedirect("Numbers successfully alloted!",$_SERVER['HTTP_REFERER']);
                endif;
            else:
                $newfunc->alertRedirect("Number already alloted with this prefix!",$_SERVER['HTTP_REFERER']);
            endif;
        endif;
    else:
        $newfunc->alertRedirect("Start allotment number should be greater than end!",$_SERVER['HTTP_REFERER']);
    endif;
endif;


// allot other stationary
if(isset($_POST['allotOtherStationary'])):
    extract($_POST);
    if($start_allotment_no < $end_allotment_no):
        $allotedChecking = $newquery->getData("*",$stationary_type."_stationary_allotments","",array("user_type"=>$user_type,"type_id"=>$type_id),"id","DESC","1");
        if($allotedChecking != 0):
            if($allotedChecking[0]['number_status'] == "End"):
                $allot = $newquery->insertData($stationary_type."_stationary_allotments",array("user_type"=>$user_type,"type_id"=>$type_id,"other_stationary_id"=>$stationary,"start_allotment_no"=>$start_allotment_no,"end_allotment_no"=>$end_allotment_no));
                if($allot):
                    $newfunc->alertRedirect("Numbers successfully alloted!",$_SERVER['HTTP_REFERER']);
                endif;
            else:
                $newfunc->alertRedirect("Previous numbers are not ended!",$_SERVER['HTTP_REFERER']);
            endif;
        else:
            $numberChecking = $newquery->getData("*",$stationary_type."_stationary_allotments","","","id","DESC","");
            $isValid = 1;
            foreach($numberChecking as $num):
                for($i = $start_allotment_no; $i <= $end_allotment_no; $i++):
                    if($num['start_allotment_no'] <= $i && $num['end_allotment_no'] >= $i):
                        $isValid = 0;
                        break;
                        break;
                    endif;
                endfor;
            endforeach;
            if($isValid == 1):
                $allot = $newquery->insertData($stationary_type."_stationary_allotments",array("user_type"=>$user_type,"type_id"=>$type_id,"other_stationary_id"=>$stationary,"start_allotment_no"=>$start_allotment_no,"end_allotment_no"=>$end_allotment_no));
                if($allot):
                    $newfunc->alertRedirect("Numbers successfully alloted!",$_SERVER['HTTP_REFERER']);
                endif;
            else:
                $newfunc->alertRedirect("Number already alloted with this prefix!",$_SERVER['HTTP_REFERER']);
            endif;
        endif;
    else:
        $newfunc->alertRedirect("Start allotment number should be greater than end!",$_SERVER['HTTP_REFERER']);
    endif;
endif;


// change stationary master for others
// if(isset($_POST['changeOtherStationary'])){
//     extract($_POST);
//     if(!empty($stationary) && !empty($start_allotment_no) && !empty($end_allotment_no)):
//         if($start_allotment_no < $end_allotment_no):
//             if($newquery->getData('*','stationary_invoice_allotments','',array('user_type'=>$user_type,'type_id'=>$type_id),'id','DESC','1') != 0):
//                 $thisPrefixDataForThisNo = $newquery->getData('*','stationary_invoice_allotments','',array(array('stationary_invoice_id','=',$stationary),array('user_type','!=',$user_type),array('type_id','!=',$type_id)),'id','DESC','');
//                 $searchForThisNo = 0;
//                 if($thisPrefixDataForThisNo != 0):
//                     foreach($thisPrefixDataForThisNo as $checking):
//                         for($i = $start_allotment_no; $i <= $end_allotment_no; $i++):
//                             if($checking['start_allotment_no'] <= $i && $i <= $checking['end_allotment_no']):
//                                 $searchForThisNo = 1;
//                                 break;
//                             endif;
//                         endfor;
//                     endforeach;
//                 endif;
//                 if($searchForThisNo == 0):
//                     $haveInvoiceChecking = $newquery->getData('*','stationary_invoice_allotments','',array(array('stationary_invoice_id','=',$stationary),array('user_type','=',$user_type),array('type_id','=',$type_id)),'id','DESC','')[0];
//                     if($haveInvoiceChecking['start_allotment_no'] == $start_allotment_no):
//                         $lastInvNo = 0;
//                         for($j = $haveInvoiceChecking['start_allotment_no']; $j <= $haveInvoiceChecking['end_allotment_no']; $j++):
//                             $invNewChecking = $newquery->getData('*','stationary_invoices','',array('invoice_no'=>$newquery->getData('`stationary_prefix`','stationaries','',array('id'=>$stationary),'id','DESC','1')[0]['stationary_prefix'].$j),'id','DESC','');
//                             if($invNewChecking == 0):
//                                 $lastInvNo = $j;
//                                 break;
//                             endif;
//                         endfor;
//                         if($lastInvNo == 0):
//                             $isValid = 1;
//                         else:
//                             $isValid = ($lastInvNo < $end_allotment_no)? 1 : 0;
//                         endif;
//                         if($isValid == 1):
//                             $insertInvNo = $newquery->updateData('stationary_invoice_allotments',array('stationary_invoice_id'=>$stationary,'start_allotment_no'=>$start_allotment_no,'end_allotment_no'=>$end_allotment_no),'id',$stationaryAllomentId);
//                             if($insertInvNo):
//                                 $insertStationaryNo = $newquery->updateData($user_type,array('stationary_id'=>$type_id),'id',$type_id);
//                                 if($insertStationaryNo):
//                                     $newfunc->alertRedirect("Invoice numbers successfully saved",$_SERVER['HTTP_REFERER']);
//                                 else:
//                                     $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
//                                 endif;
//                             else:
//                                 $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
//                             endif;
//                         else:
//                             $newfunc->alertRedirect("The end allotment number should be same or greater than ".$lastInvNo,$_SERVER['HTTP_REFERER']);
//                         endif;
//                     else:
//                         $invFirstChecking = $newquery->getData('*','stationary_invoices','',array('invoice_no'=>$newquery->getData('`stationary_prefix`','stationaries','',array('id'=>$stationary),'id','DESC','1')[0]['stationary_prefix'].$start_allotment_no),'id','DESC','');
//                         if($invFirstChecking == 0):
//                             $insertInvNo = $newquery->updateData('stationary_invoice_allotments',array('stationary_invoice_id'=>$stationary,'start_allotment_no'=>$start_allotment_no,'end_allotment_no'=>$end_allotment_no),'id',$stationaryAllomentId);
//                             if($insertInvNo):
//                                 $insertStationaryNo = $newquery->updateData($user_type,array('stationary_id'=>$type_id),'id',$type_id);
//                                 if($insertStationaryNo):
//                                     $newfunc->alertRedirect("Invoice numbers successfully saved",$_SERVER['HTTP_REFERER']);
//                                 else:
//                                     $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
//                                 endif;
//                             else:
//                                 $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
//                             endif;
//                         else:
//                             $newfunc->alertRedirect("Invoice created for first allotment no. So, you can't change the first allotment number.",$_SERVER['HTTP_REFERER']);
//                         endif;
                        
//                     endif;
//                 else:
//                     $newfunc->alertRedirect("Numbers are already alloted for this Prefix",$_SERVER['HTTP_REFERER']);
//                 endif;
//             else:
//                 $insertInvNo = $newquery->insertData('stationary_invoice_allotments',array('user_type'=>$user_type,'type_id'=>$type_id,'stationary_invoice_id'=>$stationary,'start_allotment_no'=>$start_allotment_no,'end_allotment_no'=>$end_allotment_no));
//                 if($insertInvNo):
//                     $insertStationaryNo = $newquery->updateData($user_type,array('stationary_id'=>$type_id),'id',$type_id);
//                     if($insertStationaryNo):
//                         $newfunc->alertRedirect("Invoice numbers successfully saved",$_SERVER['HTTP_REFERER']);
//                     else:
//                         $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
//                     endif;
//                 else:
//                     $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
//                 endif;
//             endif;
//         else:
//             $newfunc->alertRedirect("Start allotment number should be greater than end!",$_SERVER['HTTP_REFERER']);
//         endif;
//     else:
//         $newfunc->alertRedirect("Please fill the required fields!",$_SERVER['HTTP_REFERER']);
//     endif;
// }


// send email Billing Report page
if(isset($_POST['sendEmailbillSubmit'])){
    extract($_POST);
    if($entityType == 'users'){
        $cndr = array("username"=>$entityUname);
    }
    elseif($entityType == 'branches'){
        $cndr = array("branch_user_name"=>$entityUname);
    }
    $getId = $newquery->getData("*",$entityType,"",$cndr,"","","");
    $id = $getId[0]['id'];
    if($entityType == 'users'){
        $hisOrHerNameIs = $getId[0]['party_name'];
    }
    elseif($entityType == 'branches'){
        $hisOrHerNameIs = $getId[0]['branch_name'];
    }
    if($getId){
        $billForLR = implode(",", $billForLR);
        $redirect = str_replace("&", ",", $_SERVER['HTTP_REFERER']);
        $downloadURL = "../invoice/bill?bill_report_entity_type=$entityType&bill_report_entity_id=$id&bill_report_LRs=$billForLR";
        echo   '<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
                <script type="text/javascript">
                    $.get( "'.$downloadURL.'", function( inv ) {
                        const invoice = inv;
                        html2pdf().from(invoice).toPdf().outputPdf().output("datauristring").then(function(pdfAsString){
                            var arr = pdfAsString.split(",");
                            pdfAsString= arr[1];
                            var data = new FormData();
                            data.append("data" , pdfAsString);
                            var xhr = new XMLHttpRequest();
                            xhr.open( "post", "act.php", true );
                            xhr.send(data);
                            xhr.onreadystatechange = function() {
                                if(this.readyState == 4 && this.status == 200){
                                    window.location.href = "actions?mailPdf=done&redirect='.$redirect.'&bill_report_entity_type='.$entityType.'&bill_report_entity_id='.$id.'&bill_report_LRs='.$billForLR.'&emailId='.$getId[0]['email'].'&hisOrHerNameIs='.$hisOrHerNameIs.'";
                               }
                            };
                        });
                    });
                </script>';
    }else{
        $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
    }
}


// send mail for bill
if(!empty($_GET['mailPdf']) && $_GET['mailPdf'] == "done" && !empty($_GET['redirect'])){
    extract($_GET);
    
    $entityType = $_GET['bill_report_entity_type'];
    $id = $_GET['bill_report_entity_id'];
    $lrs = explode(",", $_GET['bill_report_LRs']);
    $condEntity = array("$entityType`.`id"=>$id);
    $entity = $newquery->getData("`$entityType`.*,`stationaries`.`stationary_prefix`",$entityType,array(array('LEFT','stationaries','stationaries','id',$entityType,'stationary_id')),$condEntity,"","","")[0];
    if($entityType == 'users'){
        $name = $entity['party_name'];
        $uname = $entity['username'];
        $credit = $entity['party_type'];
    }elseif($entityType == 'branches'){
        $name = $entity['branch_name'];
        $uname = $entity['branch_user_name'];
        $credit = $entity['credit_type'];
    }
    $allotedInvoiceN = $newquery->getData("`stationary_invoice_allotments`.*,`stationaries`.`stationary_prefix`, `stationaries`.`id` as 'stationary_id'","stationary_invoice_allotments",[array("LEFT","stationaries","stationary_invoice_allotments","stationary_invoice_id","stationaries","id")],[array("stationary_invoice_allotments`.`user_type","=",$entityType),array("stationary_invoice_allotments`.`type_id","=",$id),array("stationary_invoice_allotments`.`number_status","!=","End")],"id","DESC","1");
    if($allotedInvoiceN != 0):
        $allotedInvoiceN = $allotedInvoiceN[0];
        if($allotedInvoiceN['number_status'] == "Not Started"):
            $invoice = $allotedInvoiceN['stationary_prefix'].$allotedInvoiceN['start_allotment_no'];
            $insertInvArr['type'] = 'Non Serial';
            $insertInvArr['invoice_allotment_id'] = $allotedInvoiceN['stationary_id'];
            $updinvN = $newquery->updateData("stationary_invoice_allotments",array("number_status"=>"Running"),"id",$allotedInvoiceN['stationary_id']);
            if(!$updinvN):
                unlink("assets/bill.pdf");
                echo "<script type='text/javascript' language='javascript'>alert('Someting went wrong! Contact with administrator');</script>";
            endif;
        elseif($allotedInvoiceN['number_status'] == "Running"):
            $validity = 1;
            $getinvoiceD = $newquery->getData('*','stationary_invoices','',array('invoice_allotment_id'=>$allotedInvoiceN['stationary_id']),'id','DESC','1');
            if(str_replace($allotedInvoiceN['stationary_prefix'], "", $getinvoiceD[0]['invoice_no']) == $allotedInvoiceN['end_allotment_no']):
                $validity = 0;
            elseif(str_replace($allotedInvoiceN['stationary_prefix'], "", $getinvoiceD[0]['invoice_no'])+1 <= $allotedInvoiceN['end_allotment_no']):
                $invoice = $allotedInvoiceN['stationary_prefix'].str_replace($allotedInvoiceN['stationary_prefix'], "", $getinvoiceD[0]['invoice_no'])+1;
                $insertInvArr['type'] = 'Non Serial';
                $insertInvArr['invoice_allotment_id'] = $allotedInvoiceN['stationary_id'];
            elseif(str_replace($allotedInvoiceN['stationary_prefix'], "", $getinvoiceD[0]['invoice_no'])+1 > $allotedInvoiceN['end_allotment_no']):
                $validity = 0;
            endif;
            if($validity == 0):
                $updinvN = $newquery->updateData("stationary_invoice_allotments",array("number_status"=>"End"),"id",$allotedInvoiceN['stationary_id']);
                if($updinvN):
                    echo "<script type='text/javascript' language='javascript'>window.location.reload();</script>";
                endif;
            endif;
        endif;
    else:
        $serial_invoice = $newquery->getData("*","stationary_invoices","",array("type"=>"Serial"),"id","DESC","1");
        $nonSerialInv = $newquery->getData("*","non_serial_invoice_prefix","","","id","DESC","1")[0];
        if($serial_invoice[0]['serial_prefix'] == $nonSerialInv['invoice_prefix']):
            if($serial_invoice != 0):
                $invoice = $nonSerialInv['invoice_prefix'].str_replace($nonSerialInv['invoice_prefix'], "", $serial_invoice[0]['invoice_no'])+1;
                $insertInvArr['type'] = 'Serial';
                $serial_prefix = $nonSerialInv['invoice_prefix'];
            else:
                $invoice = $nonSerialInv['invoice_prefix'].$nonSerialInv['invoice_number'];
                $insertInvArr['type'] = 'Serial';
                $serial_prefix = $nonSerialInv['invoice_prefix'];
            endif;
        else:
            $invoice = $nonSerialInv['invoice_prefix'].$nonSerialInv['invoice_number'];
            $insertInvArr['type'] = 'Serial';
            $serial_prefix = $nonSerialInv['invoice_prefix'];
        endif;
    endif;
    // $getinvoice = $newquery->getData('*','stationary_invoice_allotments','',array('user_type'=>$entityType,'type_id'=>$id),'id','DESC','1');
    // if($getinvoice != 0):
    //     $getinvoice = $getinvoice[0];
    //     $invPrefix = $entity['stationary_prefix'];
    //     $invAccessibility = 0;
    //     for($i = $getinvoice['start_allotment_no']; $i <= $getinvoice['end_allotment_no']; $i++):
    //         $invoice = $invPrefix.$i;
    //         if($newquery->getData('*','stationary_invoices','',array('invoice_no'=>$invoice),'id','DESC','1') == 0):
    //             $invAccessibility = 1;
    //         endif;
    //         break;
    //     endfor;
    //     if($invAccessibility == 0):
    //         unlink("assets/bill.pdf");
    //         $newfunc->alertRedirect('Stationary invoice number ended! Please allot new numbers '.trim(trim($entityType, 's'), 'es'), "billing");
    //     endif;
    // else:
    //     unlink("assets/bill.pdf");
    //     $newfunc->alertRedirect('Stationary invoice not alloted! Please allot numbers to this '.trim(trim($entityType, 's'), 'es'), "billing");
    // endif;
    $getstate = $newquery->getData('*','states','',array('id'=>$entity['state']),'id','DESC','1')[0];
    $lrsare = "(".implode(',', $lrs).")";
    $condReport[] = array("user_type","=",$entityType);
    $condReport[] = array( "type_id","=",$id);
    $condReport[] = array("lr","IN",$lrsare);
    $getreport = $newquery->getData("*","orders","",$condReport,"id","DESC","");
    
    foreach($getreport as $report){
        $totalQty = $newquery->getData("SUM(`qty`) AS 'tqty'","box_details","",array("order_id"=>$report['order_id']),"","","")[0]['tqty'];
        $actualTotalQty += $totalQty;
        $subTotalCost += ($report['total_charge'] - ($report['igst_amount']+$report['cgst_amount']+$report['sgst_amount']));
        $igst += $report['igst_amount'];
        $sgst += $report['cgst_amount'];
        $cgst += $report['sgst_amount'];
    }
    $grandTotal = $subTotalCost+$igst+$cgst+$sgst;
    if($entityType == "branches"){
        if($getreport[0]['payment_mode'] == "Prepaid" || $getreport[0]['payment_mode'] == "CoD"){
            $billGenerateFor = $newquery->getData("*","consigner_details","",array('order_id'=>$getreport[0]['order_id']),"id","DESC","1")[0];
        }else{
            $billGenerateFor = $newquery->getData("*","consignee_details","",array('order_id'=>$getreport[0]['order_id']),"id","DESC","1")[0];
        }
    }
    $inv_date = date("Y-m-d h:i:s");
    $insertLRs = implode(", ", $lrs);
    if($entityType == "users"){
        $insertName = $name;
        $insertAddress = $entity['address'];
    }else{
        $insertName = $billGenerateFor['name'];
        $insertAddress = $billGenerateFor['address'];
    }
    $insertInvArr = array('user_type'=>$entityType,'type_id'=>$id,'invoice_date'=>$inv_date,'stationary_prefix_id'=>$allotedInvoiceN['stationary_id'],'serial_prefix'=>$serial_prefix,'invoice_no'=>$invoice,'lrs'=>$insertLRs,'name'=>$insertName,'address'=>$insertAddress,'gst_before_amount'=>$subTotalCost,'igst'=>$igst,'sgst'=>$sgst,'cgst'=>$cgst,'grand_total'=>$grandTotal);
    if($entity['gst_type'] == "Regular" && $entityType == "users"){ 
        $insertInvArr['gst_number'] = $entity['gst_number'];
    }elseif($entityType == "branches" && !empty($getreport['consignee_gst_tin'])){ 
        $insertInvArr['gst_number'] = $getreport['consignee_gst_tin'];
    }
    $stationaryInvoiceInsert = $newquery->insertData('stationary_invoices',$insertInvArr);
    if($stationaryInvoiceInsert){
        $redirect = str_replace(",", "&", $redirect);
        $filename = 'bill.pdf';
        $file = 'assets/'.$filename;
        $content = file_get_contents($file);
        $content = chunk_split(base64_encode($content));
        $uid = md5(uniqid(time()));
        $file_name = basename($file);
        $replyto = 'noreply@kingfishlogistics.in';
        $from_name = 'Kingfish Logistics';
        $mailto = $emailId;
        $from_mail = $company['email_id'];
        $message = "Dear Sir/Madam,\nPlease find invoice from Kingfish Logistics (www.kingfishlogistics.in) for INR ".$grandTotal."/-\n\nKindly contact the undersigned if you have any queries or if we can be of any assistance.\n\nPlease find enclosed the attachment PDF copy for your records.\n\nThis is computer generated invoice and does not require any stamp or signature.";
        
        // header
        $header = "From: ".$from_name." <".$from_mail.">\r\n";
        $header .= "Reply-To: ".$replyto."\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
        
        // message & attachment
        $nmessage = "--".$uid."\r\n";
        $nmessage .= "Content-type:text/plain; charset=iso-8859-1\r\n";
        $nmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $nmessage .= $message."\r\n\r\n";
        $nmessage .= "--".$uid."\r\n";
        $nmessage .= "Content-Type: application/pdf; name=\"".$filename."\"\r\n";
        $nmessage .= "Content-Transfer-Encoding: base64\r\n";
        $nmessage .= "Content-Disposition: attachment; filename=\"".$file_name."\"\r\n\r\n";
        $nmessage .= $content."\r\n\r\n";
        $nmessage .= "--".$uid."--";
        $subject = "Invoice No. ".$invoice." for ".$insertName." from Kingfish Logistics";
        if(mail($mailto, $subject, $nmessage, $header)){
            if($credit == "TBB"):
                $billGenDate = date("Y-m-d");
                $getInvId = $newquery->getData("`id`","stationary_invoices","","","id","DESC","1")[0]['id'];
                $outStandingInsert = $newquery->insertData('outstanding_report',array("invoice_id"=>$getInvId,"user_type"=>$entityType,"type_id"=>$id,"outstanding_price"=>$grandTotal,"bill_generation_date"=>$billGenDate));
                if(!$outStandingInsert):
                    unlink("assets/bill.pdf");
                    $newfunc->alertRedirect("Something went wrong! Contact with administrator",$redirect);
                else:
                    unlink("assets/bill.pdf");
                    $newfunc->alertRedirect("Bill successfully send to the mail",$redirect);
                endif;
            else:
                unlink("assets/bill.pdf");
                $newfunc->alertRedirect("Bill successfully send to the mail",$redirect);
            endif;
        }
    }else{
        unlink("assets/bill.pdf");
        $newfunc->alertRedirect("Something went wrong! Contact with administrator",$redirect);
    }
}


// add credit
if(isset($_POST['addCredit'])):
    $amount = $newfunc->real_string(trim($_POST['credit_amount'], " "));
    $description = $newfunc->real_string(trim(str_replace("'", "\'", $_POST['description']), " "));
    $user_type = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($_POST['user_type'], " ")));
    $username = $newfunc->real_string(trim($_POST['username'], " "));
    $typeOfUsername = ($user_type == "users")? "username" : "branch_user_name";
    $personDetails = $newquery->getData("*",$user_type,"",array($typeOfUsername=>$username),"id","DESC","1")[0];
    $typeId = $personDetails['id'];
    $creditnumber = $newquery->getData("`credit_stationary_allotments`.*,`other_stationaries`.`stationary_prefix`","credit_stationary_allotments",[array("LEFT","other_stationaries","other_stationaries","id","credit_stationary_allotments","other_stationary_id")],[array("user_type","=",$user_type),array("type_id","=",$typeId),array("number_status","!=","End")],"id","DESC","1");
    if($creditnumber != 0):
        $lastTrans = $newquery->getData("*","transactions","",array("user_type"=>$user_type,"user_id"=>$typeId,"txn_id_type"=>"Non Serial"),"id","DESC","");
        if($lastTrans != 0):
            if($creditnumber[0]['last_used_number']+1 <= $creditnumber[0]['end_allotment_no']):
                $outstanding = $newquery->getData("*","outstanding_report","",array("user_type"=>$user_type,"type_id"=>$typeId,"status"=>"Not Clear"),"","","1");
                if($outstanding != 0):
                    $haveClearPrice = $outstanding[0]['outstanding_price'] - $outstanding[0]['cleared_price'];
                    if($haveClearPrice > $amount):
                        $clearPrice = $amount;
                        $clearStatus = "Not Clear";
                    elseif($haveClearPrice <= $amount):
                        $clearPrice = $outstanding[0]['outstanding_price'];
                        $clearStatus = "Cleared";
                    endif;
                    $updOurStand = $newquery->updateData("outstanding_report",array("cleared_price"=>$clearPrice,"clear_date"=>date("Y-m-d"),"status"=>$clearStatus),"id",$outstanding[0]['id']);
                    if(!$updOurStand):
                        $newfunc->alertRedirect("Something went wrong! Please Contact with administrator", $_SERVER['HTTP_REFERER']);
                    endif;
                endif;
                $txnId = $creditnumber[0]['stationary_prefix'].$creditnumber[0]['last_used_number']+1;
                $balance = $personDetails['wallet_balance']+$amount;
                $transaction = $newquery->insertData("transactions",array("date_time"=>date("Y-m-d H:i:s"),"user_type"=>$user_type,"user_id"=>$typeId,"amount"=>$amount,"balance"=>$balance,"details"=>$description,"txn_id"=>$txnId,"txn_id_type"=>"Non Serial","status"=>"Credit"));
                if($transaction):
                    $updWallet = $newquery->updateData($user_type,array("wallet_balance"=>$balance),"id",$typeId);
                    if($updWallet):
                        $stationaryupd = $newquery->updateData("credit_stationary_allotments",array("last_used_number"=>$creditnumber[0]['last_used_number']+1),"id",$creditnumber[0]['id']);
                        if($stationaryupd):
                            if($creditnumber[0]['last_used_number']+1 == $creditnumber[0]['end_allotment_no']):
                                $stationary = $newquery->updateData("credit_stationary_allotments",array("number_status"=>"End"),"id",$creditnumber[0]['id']);
                                if($stationary):
                                    $newfunc->alertRedirect("Amount successfully credited to ".trim(trim($user_type, "s"), "es")."'s wallet.", $_SERVER['HTTP_REFERER']);
                                else:
                                    $newfunc->alertRedirect("An error occurred while updating of wallet balance! Contact with administrator.", $_SERVER['HTTP_REFERER']);
                                endif;
                            else:
                                $newfunc->alertRedirect("Amount successfully credited to ".trim(trim($user_type, "s"), "es")."'s wallet.", $_SERVER['HTTP_REFERER']);
                            endif;
                        else:
                            $newfunc->alertRedirect("An error occurred while updating of stationary! Contact with administrator.", $_SERVER['HTTP_REFERER']);
                        endif;
                    else:
                        $newfunc->alertRedirect("An error occurred while updating of wallet balance! Contact with administrator.", $_SERVER['HTTP_REFERER']);
                    endif;
                else:
                    $newfunc->alertRedirect("An error occurred while transaction! Contact with administrator.", $_SERVER['HTTP_REFERER']);
                endif;
            else:
                $newfunc->alertRedirect("Alloted numbers are ended. Please! allot new numbers", $_SERVER['HTTP_REFERER']);
            endif;
        else:
            $txnId = $creditnumber[0]['stationary_prefix'].$creditnumber[0]['start_allotment_no'];
            $balance = $personDetails['wallet_balance']+$amount;
            $transaction = $newquery->insertData("transactions",array("date_time"=>date("Y-m-d H:i:s"),"user_type"=>$user_type,"user_id"=>$typeId,"amount"=>$amount,"balance"=>$balance,"details"=>$description,"txn_id"=>$txnId,"txn_id_type"=>"Non Serial","status"=>"Credit"));
            if($transaction):
                $updWallet = $newquery->updateData($user_type,array("wallet_balance"=>$balance),"id",$typeId);
                if($updWallet):
                    $stationary = $newquery->updateData("credit_stationary_allotments",array("last_used_number"=>$creditnumber[0]['start_allotment_no'],"number_status"=>"Running"),"id",$creditnumber[0]['id']);
                    if($stationary):
                        $newfunc->alertRedirect("Amount successfully credited to ".trim(trim($user_type, "s"), "es")."'s wallet.", $_SERVER['HTTP_REFERER']);
                    else:
                        $newfunc->alertRedirect("An error occurred while updating of wallet balance! Contact with administrator.", $_SERVER['HTTP_REFERER']);
                    endif;
                else:
                    $newfunc->alertRedirect("An error occurred while updating of wallet balance! Contact with administrator.", $_SERVER['HTTP_REFERER']);
                endif;
            else:
                $newfunc->alertRedirect("An error occurred while transaction! Contact with administrator.", $_SERVER['HTTP_REFERER']);
            endif;
        endif;
    else:
        $newfunc->alertRedirect("This hasn't any alloted numbers. Please! allot credit numbers.", $_SERVER['HTTP_REFERER']);
    endif;
endif;


// add debit
if(isset($_POST['addDebit'])):
    $amount = $newfunc->real_string(trim($_POST['debit_amount'], " "));
    $description = $newfunc->real_string(trim(str_replace("'", "\'", $_POST['description']), " "));
    $user_type = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($_POST['user_type'], " ")));
    $username = $newfunc->real_string(trim($_POST['username'], " "));
    $typeOfUsername = ($user_type == "users")? "username" : "branch_user_name";
    $personDetails = $newquery->getData("*",$user_type,"",array($typeOfUsername=>$username),"id","DESC","1")[0];
    $typeId = $personDetails['id'];
    $debitnumber = $newquery->getData("`debit_stationary_allotments`.*,`other_stationaries`.`stationary_prefix`","debit_stationary_allotments",[array("LEFT","other_stationaries","other_stationaries","id","debit_stationary_allotments","other_stationary_id")],[array("user_type","=",$user_type),array("type_id","=",$typeId),array("number_status","!=","End")],"id","DESC","1");
    if($debitnumber != 0):
        $lastTrans = $newquery->getData("*","transactions","",array("user_type"=>$user_type,"user_id"=>$typeId,"txn_id_type"=>"Non Serial"),"id","DESC","");
        if($lastTrans != 0):
            if($debitnumber[0]['last_used_number']+1 <= $debitnumber[0]['end_allotment_no']):
                $txnId = $debitnumber[0]['stationary_prefix'].$debitnumber[0]['last_used_number']+1;
                $balance = $personDetails['wallet_balance']-$amount;
                $transaction = $newquery->insertData("transactions",array("date_time"=>date("Y-m-d H:i:s"),"user_type"=>$user_type,"user_id"=>$typeId,"amount"=>$amount,"balance"=>$balance,"details"=>$description,"txn_id"=>$txnId,"txn_id_type"=>"Non Serial","status"=>"Debit"));
                if($transaction):
                    $updWallet = $newquery->updateData($user_type,array("wallet_balance"=>$balance),"id",$typeId);
                    if($updWallet):
                        $stationaryupd = $newquery->updateData("debit_stationary_allotments",array("last_used_number"=>$debitnumber[0]['last_used_number']+1),"id",$debitnumber[0]['id']);
                        if($stationaryupd):
                            if($debitnumber[0]['last_used_number']+1 == $debitnumber[0]['end_allotment_no']):
                                $stationary = $newquery->updateData("debit_stationary_allotments",array("number_status"=>"End"),"id",$debitnumber[0]['id']);
                                if($stationary):
                                    $newfunc->alertRedirect("Amount successfully debited to ".trim(trim($user_type, "s"), "es")."'s wallet.", $_SERVER['HTTP_REFERER']);
                                else:
                                    $newfunc->alertRedirect("An error occurred while updating of wallet balance! Contact with administrator.", $_SERVER['HTTP_REFERER']);
                                endif;
                            else:
                                $newfunc->alertRedirect("Amount successfully debited to ".trim(trim($user_type, "s"), "es")."'s wallet.", $_SERVER['HTTP_REFERER']);
                            endif;
                        else:
                            $newfunc->alertRedirect("An error occurred while updating of stationary! Contact with administrator.", $_SERVER['HTTP_REFERER']);
                        endif;
                    else:
                        $newfunc->alertRedirect("An error occurred while updating of wallet balance! Contact with administrator.", $_SERVER['HTTP_REFERER']);
                    endif;
                else:
                    $newfunc->alertRedirect("An error occurred while transaction! Contact with administrator.", $_SERVER['HTTP_REFERER']);
                endif;
            else:
                $newfunc->alertRedirect("Alloted numbers are ended. Please! allot new numbers", $_SERVER['HTTP_REFERER']);
            endif;
        else:
            $txnId = $debitnumber[0]['stationary_prefix'].$debitnumber[0]['start_allotment_no'];
            $balance = $personDetails['wallet_balance']+$amount;
            $transaction = $newquery->insertData("transactions",array("date_time"=>date("Y-m-d H:i:s"),"user_type"=>$user_type,"user_id"=>$typeId,"amount"=>$amount,"balance"=>$balance,"details"=>$description,"txn_id"=>$txnId,"txn_id_type"=>"Non Serial","status"=>"Debit"));
            if($transaction):
                $updWallet = $newquery->updateData($user_type,array("wallet_balance"=>$balance),"id",$typeId);
                if($updWallet):
                    $stationary = $newquery->updateData("debit_stationary_allotments",array("last_used_number"=>$debitnumber[0]['start_allotment_no'],"number_status"=>"Running"),"id",$debitnumber[0]['id']);
                    if($stationary):
                        $newfunc->alertRedirect("Amount successfully debited to ".trim(trim($user_type, "s"), "es")."'s wallet.", $_SERVER['HTTP_REFERER']);
                    else:
                        $newfunc->alertRedirect("An error occurred while updating of wallet balance! Contact with administrator.", $_SERVER['HTTP_REFERER']);
                    endif;
                else:
                    $newfunc->alertRedirect("An error occurred while updating of wallet balance! Contact with administrator.", $_SERVER['HTTP_REFERER']);
                endif;
            else:
                $newfunc->alertRedirect("An error occurred while transaction! Contact with administrator.", $_SERVER['HTTP_REFERER']);
            endif;
        endif;
    else:
        $newfunc->alertRedirect("This hasn't any alloted numbers. Please! allot debit numbers.", $_SERVER['HTTP_REFERER']);
    endif;
endif;


// change password for users or branches
if(isset($_POST['saveChangesofPassword'])):
    $password = $newfunc->real_string(trim($_POST['password'], " "));
    $confirmPassword = $newfunc->real_string(trim($_POST['confirmPassword'], " "));
    $user_type = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($_POST['user_type'], " ")));
    $username = $newfunc->real_string(trim($_POST['username'], " "));
    $usernameType = ($user_type == "users")? "username" : "branch_user_name";
    if(strlen($password) >= 6 && strlen($confirmPassword) >= 6):
        if($password === $confirmPassword):
            $newpassword = md5($confirmPassword);
            $updPass = $newquery->updateData($user_type,array("password"=>$newpassword),$usernameType,$username);
            if($updPass):
                $newfunc->alertRedirect("Password successfully changed for this ".trim(trim($user_type ,"s"), "es").".", $_SERVER['HTTP_REFERER']);
            else:
                $newfunc->alertRedirect("An error occurred while updating password! Contact with administrator.", $_SERVER['HTTP_REFERER']);
            endif;
        endif;
    endif;
endif;


// Default Invoice number Update
if(isset($_POST['saveChangeDefaultInvoice'])):
    $invoice_prefix = $newfunc->real_string(trim($_POST['invoice_prefix'], " "));
    $invoice_number = $newfunc->real_string(trim($_POST['invoice_start_number'], " "));
    $updDefinv = $newquery->updateData("non_serial_invoice_prefix",array("invoice_prefix"=>$invoice_prefix,"invoice_number"=>$invoice_number),"id","1");
    if($updDefinv):
        $newfunc->alertRedirect("You have successfully updated the default invoice setting",$_SERVER['HTTP_REFERER']);
    else:
        $newfunc->alertRedirect("Something went wrong! Contact with administrator",$_SERVER['HTTP_REFERER']);
    endif;
endif;


// add state
// if(isset($_POST['submitState'])){
//     extract($_POST);
//     $state = $newfunc->RemoveSpecialChar($newfunc->real_string(trim($state, " ")));
//     $arr = array('state'=>$state,'delete_status'=>'show');
//     $selret = $newquery->getData('*','states','',$arr,'','','');
//     if(strtolower($selret[0]['state']) != strtolower($state)){
//         $ret = $newquery->insertData('states',$arr);
//         if($ret){
//             echo '<script type="text/javascript" language="javascript">
//                     alert("You have successfully added a State");
//                     window.location = "zone-master-states";
//                   </script>';
//         }else{
//             echo '<script type="text/javascript" language="javascript">
//                     alert("Something went wrong! Please contact with administrator");
//                     window.location = "zone-master-states";
//                   </script>';
//         }
//     }else{
//         echo '<script type="text/javascript" language="javascript">
//                 alert("This item is already added");
//                 window.location = "zone-master-states";
//               </script>';
//     }
// }











