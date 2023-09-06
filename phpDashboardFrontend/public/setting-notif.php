<?php
include("footerheader.php");
fHeader();

$tenant = initSession('tenant');
$locinfo = getLocInfo();

$api = apiSend('tenant','me',[ 'unit_id'=>$locinfo['location_id'] ]);
$rec = json_decode($api,true);
//vdump($rec);
?>
<body style="color:var(--clrDarkBlue);">
<div class="col-12 d-flex align-items-center justify-content-start mt-4">
    <div class="">
        <a href="setting.php"><i class="fas fa-arrow-left circle"></i></a>
    </div>
    <div class="font-18 ml-2"><a href="setting.php">Back to Setting</a></div>
</div>
<div class="col-12 d-flex align-items-center justify-content-between mt-4 mb-3">
    <div class="title">Notifications</div>
</div>
<form id="frm" name="frm" method="post" enctype="multipart/form-data" action="setting-notif-save.php">
	<div>
		<div class="container mb-3">
			<div class="d-flex align-items-center justify-content-between p-3 bg-white rounded">
				<div>
					<b class="font-16 mt-5">Receive thru email</b><br>
					<label class="font-14"><?=$tenant['email']?></label>
				</div>
				<label class="switch">
					<input name="notify_email" type="checkbox" <?=($rec['notify_email']=="Yes") ? "checked" : ""?>>
					<span class="slider round"></span>
				</label>
			</div>
		</div>
		<div class="container mb-3">
			<div class="d-flex align-items-center justify-content-between p-3 bg-white rounded">
				<div>
					<b class="font-16 mt-5">Receive thru viber</b><br>
					<label class="font-14"><?=$tenant['mobile']?></label>
				</div>
				<label class="switch">
					<input name="notify_viber" type="checkbox" <?=($rec['notify_viber']=="Yes") ? "checked" : ""?>>
					<span class="slider round"></span>
				</label>
			</div>
		</div>
		<div class="container mb-3">
			<div class="d-flex align-items-center justify-content-between p-3 bg-white rounded">
				<div>
					<b class="font-16 mt-5">Allow push notification</b><br>
				</div>
				<label class="switch">
					<input name="allow_push" type="checkbox" <?=($rec['allow_push']=="Yes") ? "checked" : ""?>>
					<span class="slider round"></span>
				</label>
			</div>
		</div>
		<div class="container mb-3">
			<div class="row p-1 my-3">
				<div class="col-6"><button class="btn btn-secondary form-control" type="button" onclick="window.location='setting.php'">Cancel</button></div>
				<div class="col-6"><button class="btn btn-primary form-control pt-1 mb-4" type="submit" value="Update">Update</button></div>
			</div>
		</div>
	</div>
</form>
</body>
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