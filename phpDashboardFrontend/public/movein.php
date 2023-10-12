<?php
include("footerheader.php");
fHeader();

$tenant = initSession('tenant');
$locinfo = getLocInfo();

$description = "";
if (initObj('action')!="") {
    $description = "description ".date("m/d/Y H:i:s");
}
?>
<div class="col-12 my-4">
    <div class="title">Move In Request</div>
</div>
<form id="frm" name="frm" method="post" enctype="multipart/form-data" action="moveinout-save.php">
    <div class="py-3 bg-white">
        <div class="container">
            <input name="move_type" value="Move In" type="hidden">
            <!--div class="py-2">Type</div>
            <div class="d-none">
                <select name="move_type" class="form-control">
                    <option>Move In</option>
                    <option>Move Out</option>
                </select>
            </div-->
            <div class="mb-2">
                <div class="py-2">Date</div>
                <div>
                    <input name="move_date" type="date" class="form-control" value="" min="<?=date('Y-m-d')?>" required />
                </div>
            </div>
        </div>
        <hr />
        <div class="container">
            <div class="mb-2">
                <div class="mb-2">Tenant</div>
                <div>
                    <input type="text" class="form-control" placeholder="" value="<?=$tenant['tenant_name']?>" readonly />
                    <input name="tenant_id" type="hidden" value="<?=$tenant['tenant_id']?>" />
                </div>
            </div>
        </div>
        <div class="container">
            <div class="mb-2">
                <div class="mb-2">Unit</div>
                <div>
                    <input type="text" class="form-control" placeholder="" value="<?=$locinfo['location_name']?>" readonly />
                    <input name="location_id" type="hidden" value="<?=$locinfo['location_id']?>" />
                </div>
            </div>
        </div>
        <hr />
        <div class="container">            
            <div class="mb-2">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="mb-2">Attachment</div>
                </div>
                <div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <button type="button" class="btn primary"><div><i class="fa-solid fa-paperclip text-white"></i></div></button>
                        </div>
                        <input name="upload_file" type="file" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1" />
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <div class="mb-2">Description</div>
                <div>
                    <div class="form-group">
                        <textarea name="description" class="form-control" rows="3" required><?=$description?></textarea>
                    </div>
                </div>
            </div>
            <div class="row mt-3" style="height:100px;">
                <div class="col-6">
                    <button type="button" class="btn btn-outline font-16 w-100" onclick="location='home.php'">Cancel</button>
                </div>
                <div class="col-6 d-block">
                    <button class="btn btn-primary px-3 w-100">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?=fFooter();?>
<script>
$(document).ready(function(){
    $("#frm").on('submit',function(e){
        e.preventDefault();       
        swal({ title: "Save Confirmation", text: "Are you sure you want to save record?", icon: "warning", buttons: true, dangerMode: true })
        .then((ynConfirm) => {
          if (ynConfirm) {
            this.submit();
          }
        });
    });
});
</script>