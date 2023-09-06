<?php
include("footerheader.php");
fHeader();

$arrival_date = $item_description = $personnel_name = $personnel_name2 = "";
if (initObj('action')!="") {
    $arrival_date = "2022-06-01"; $item_description = "aircon ".DATETIME; $personnel_name = "john doe"; $personnel_name2 = "jane doe";
}
?>
<div class="col-12 my-4">
    <div class="title">Gate Pass Request</div>
</div>
<form id="frm" name="frm" method="post" enctype="multipart/form-data" action="gatepass-save.php">
    <div class="pt-3 pb-5 bg-white">
        <div class="container">
            <div class="py-2">Category</div>
            <div>
                <select name="category" class="form-control">
                    <option>Delivery</option>
                    <option>Maintenance and Construction Works</option>
                </select>
            </div>
        </div>
        <hr />
        <div class="container">
            <div class="mb-2">
                <div class="mb-2">Date of Arrival</div>
                <div>
                    <input name="arrival_date" type="date" class="form-control" value="<?=$arrival_date?>" min="<?=date('Y-m-d')?>" required/>
                </div>
            </div>
            <div class="mb-2">
                <div class="mb-2">Item Description</div>
                <div>
                    <div class="form-group">
                        <textarea name="item_description" class="form-control" rows="3" required><?=$item_description?></textarea>
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <div class="mb-2">Name (Delivery Personnel or Company)</div>
                <div>
                    <input name="personnel_name" type="text" class="form-control" value="<?=$personnel_name?>" required/>
                </div>
            </div>
            <div class="mb-2">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="mb-2">Additional Personnel Name</div>
                    <div style="opacity: 60%">OPTIONAL</div>
                </div>
                <div>
                    <input name="personnel_name2" type="text" class="form-control" value="<?=$personnel_name2?>" />
                </div>
            </div>
            <div class="mb-2">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="mb-2">Upload File</div>
                    <div style="opacity: 60%">OPTIONAL</div>
                </div>
                <div>
                    <div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button type="button" class="btn primary"><div><i class="fa-solid fa-paperclip text-white"></i></div></button>
                            </div>
                            <input name="upload_file" type="file" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5" style="padding: 0 15px">
                <div class="col-6">
                    <button type="button" class="btn btn-outline font-16 w-100" onclick="location='home.php'">Cancel</button>
                </div>
                <div class="col-6 d-block">
                    <button type="submit" class="btn btn-primary px-3 w-100">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <input name="accountcode" type="hidden" value="<?=ACCOUNT_CODE?>">
</form>
<?=fFooter();?>
<script>
$(document).ready(function(){
    $("#frm").on('submit',function(e){
        e.preventDefault();       
        swal({ title: "Save Confirmation", text: "Are you sure you want to save record?", icon: "warning", buttons: true, dangerMode: true })
        .then((ynConfirm) => {
          if (ynConfirm) {
            this.submit()
            swal("Record saved!", { icon: "success" });
          }
        });
    });
});
</script>