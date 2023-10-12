<?php
include("footerheader.php");
fHeader();

$tenant = initSession('tenant');
$locinfo = getLocInfo();

$details = "";
if (initObj('action')!="") {
    $details = "details ".date("m/d/Y H:i:s");
}
?>
<div class="col-12 my-4">
    <div class="title"> Service Request </div>
</div>
<form id="frm" name="frm" method="post" enctype="multipart/form-data" action="servicerequest-save.php">
    <div class="pt-3 pb-5 bg-white">
        <div class="container">
            <div class="py-2">Type</div>
            <div>
                <select name="sr_type" class="form-control">
                    <option>Repair</option>
                </select>
            </div>
        </div>
        <hr />
        <div class="container">        
            <div class="mb-2">
                <div class="mb-2">Details</div>
                <div>
                    <div class="form-group">
                        <textarea name="details" class="form-control" rows="3" required><?=$details?></textarea>
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <div class="mb-2">Tenant</div>
                <div>
                    <input type="text" class="form-control" placeholder="Tenant Name" value="<?=$tenant['tenant_name']?>" readonly />
                </div>
            </div>
            <div class="mb-2">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="mb-2">Location</div>
                </div>
                <div>
                    <input type="text" class="form-control" value="<?=$locinfo['location_name']?>" readonly />
                    <input name="location_id" type="hidden" value="<?=$locinfo['location_id']?>" />
                </div>
            </div>
            <div class="mb-2">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="my-2">Attach file</div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <button type="button" type="button"  class="btn primary"><div><i class="fa-solid fa-camera text-white"></i></div></button>
                    </div>
                    <input name="upload_pic" type="file" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1" />
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <button type="button" type="button" class="btn primary"><div><i class="fa-solid fa-paperclip text-white"></i></div></button>
                    </div>
                    <input name="upload_file" type="file" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1" />
                </div>
            </div>
            <div class="row mt-5" style="padding: 0 15px">
                <div class="col-6">
                    <button class="btn btn-outline font-16 w-100" onclick="location='home.php'">Cancel</button>
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