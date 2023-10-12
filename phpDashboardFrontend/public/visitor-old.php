<?php
include("footerheader.php");
fHeader();

$arrival_date = date("Y-m-d");
$visitor_name = "";
if (initObj('action')!="") {
    $arrival_date = "2022-06-01"; $visitor_name = "john doe - ".DATETIME;
}
?>
<div class="col-12 my-4">
    <div class="title">Visitor Registration</div>
</div>
<form id="frm" name="frm" method="post" enctype="multipart/form-data" action="visitor-save.php">
    <div class="pt-3 pb-5 bg-white">
        <div class="container">
            <div class="mb-3">
                <div class="mb-2 clrDarkBlue">Date of Arrival</div>
                <div>
                    <input name="arrival_date" type="date" class="form-control" value="<?=$arrival_date?>" min="<?=date("Y-m-d")?>" required/>
                </div>
            </div>
            <div class="mb-3"">
                <div class="mb-2 clrDarkBlue">Full Name</div>
                <div>
                    <input name="visitor_name" type="text" class="form-control" value="<?=$visitor_name?>" required/>
                </div>
            </div>
            <div class="mb-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="mb-2 clrDarkBlue">Upload ID</div>
                    <div style="opacity: 60%">OPTIONAL</div>
                </div>
                <div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <button class="btn primary"><div><i class="fa-solid fa-paperclip text-white"></i></div></button>
                        </div>
                        <input name="upload_file" type="file" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1" />
                    </div>
                </div>
            </div>
            <div class="mt-5 d-flex">
                <div class="col-4 p-0">
                    <button type="button" class="btn btn-outline font-16 w-100 d-block  " onclick="location='home.php'">Cancel</button>
                </div>
                <div class="col-8 p-0">
                    <button type="submit" class="btn btn-primary ml-2 w-100 d-block">Submit</button>
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