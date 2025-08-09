<?php
if(!empty($_GET) && array_key_exists('page', $_GET)){
    $page = $_GET['page'];
}
include('menu/header.php');
include('menu/navbar.php');
?>


        <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-dark fw-bold">Tasks</span></h4>
            <!-- Responsive Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr class="text-nowrap">
                                    <th class="text-center">SL No.</th>
                                    <th class="text-center" >TASK TITLE	</th>
                                    <th class="text-center" >COMPLETION STATUS</th>
                                </tr>
                            </thead>
                            <tbody >
                                <?php
                                    const dataShow = 25;
                                    if(empty($page)){
                                        $page = 1;
                                    }else{
                                        $page = $page;
                                    }
                                    $offset = ($page - 1) * dataShow;
                                    $limit = $offset.','.dataShow;
                                    $sl = 1+$offset;
                                    $cond_index = array("assignee_type"=>'users',"assigned_id"=>$user_id);
                                    $get_task = $query->getData("*","tasks","",$cond_index,"id","DESC",$limit);
                                    $task_count = $query->getData("COUNT(`id`) as 'task_count'","tasks","",$cond_index,"id","DESC","")[0]['task_count'];
                                    if($get_task!=0)
                                    {
                                        foreach($get_task as $task)
                                        {
                                ?>
                                            <tr>
                                                <td class="text-center"><?= $sl; ?></td>
                                                <td class="text-center"><?= $task['task']; ?></td>
                                                <td class="text-center"><?php if($task['status']=='Created'){echo'<span class="badge bg-primary">Created</span>';}elseif($task['status']=='Working'){echo'<span class="badge bg-info">Working</span>';}else{echo'<span class="badge bg-success">Completed</span>';}  ?></td>
                                            </tr>
                                <?php
                                    $sl++;
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                        $pageCount = ceil($task_count/dataShow);
                        if($task_count != 0){
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
            <!--/ Responsive Table -->
        </div>
    </div>
<?php
include('menu/footer.php');
?>
