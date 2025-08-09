<?php
include('menu/header.php');
include('menu/navbar.php');
?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-dark fw-bold">Bulk Order</span></h4>
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 col-lg-8 col-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6 text-start">
                                    <h4 class="text-dark fw-bold">Upload Excel File</h4>
                                </div>
                                <div class="col-6 text-end">
                                    <a href="" download type="button" class="btn btn-info">Download Sample</a>
                                </div>
                            </div>
                        </div>
                        <form action="act" method="POST" enctype="multipart/form-data" class="card-body">
                            <div class="form-group mt-3">
                                <select class="form-control" name="warehouse" required>
                                    <option value="" hidden>Choose a Warehouse</option>
                                    <?php
                                        $selware = $query->getData("*","warehouses","",array("type"=>"users","type_id"=>$user_id),"id","DESC","");
                                        foreach($selware as $ware){
                                    ?>
                                        <option value="<?= $ware['id']; ?>"><?= $ware['warehouse_name']; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <input type="file" class="form-control" name="upload_order_file">
                            </div>
                            <div class="form-group text-end mt-3">
                                <button type="submit" name="uploadSubmit" class="btn btn-primary">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
           </div>
        </div>
    </div>
<?php
include('menu/footer.php');
?>