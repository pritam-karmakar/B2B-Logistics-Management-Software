<?php
include("database/db.php");
include("functions/all-functions.php");
$newquery = new query();
$newfunc = new allfunctions();
date_default_timezone_set("Asia/Kolkata");
$charges = $newquery->getData('*','charges','',array('id'=>'1'),'id','DESC','1')[0];


