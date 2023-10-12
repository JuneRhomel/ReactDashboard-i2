<?php
include("footerheader.php");
fHeader();

$locinfo = getLocInfo();

$api = apiSend('tenant','me',[ 'unit_id'=>$locinfo['location_id'] ]);
$rec = json_decode($api,true);
//vdump($rec);
?>
<div class="col-12 d-flex align-items-center justify-content-start mt-4">
    <div class="">
        <a href="setting.php"><i class="fas fa-arrow-left circle"></i></a>
    </div>
    <div class="font-18 ml-2"><a href="setting.php">Back to Setting</a></div>
</div>
<div class="col-12 d-flex align-items-center justify-content-between mt-4 mb-3">
    <div class="title">My Profile</div>
</div>
<form id="frm" name="frm" method="post" enctype="multipart/form-data" action="setting-myprofile-save.php">
	<div class="bg-white">
		<div class="container">
			<div class="pt-3">
				<div class="d-block">
					<img src="<?=($rec['id_url']!=="") ? $rec['id_url'] : "resources/images/profilepic.jpg" ?>" class="user-image mr-4" alt="User Image"/><br>
					<b class="font-16 mt-5"><?=$rec['tenant_name']?></b><br>
					<label class="font-14 mb-3"><?=$rec['email']?></label><br>
					<div class="mb-2">
		                <div class="d-flex align-items-center justify-content-between">
		                    <div class="mb-2">Upload Profile Pic</div>
		                </div>
		                <div>
		                    <div>
		                        <div class="input-group mb-3">
		                            <div class="input-group-prepend">
		                                <button type="button" class="btn primary"><div><i class="fa-solid fa-paperclip text-white"></i></div></button>
		                            </div>
		                            <input name="upload_file" type="file" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon" />
		                        </div>
		                    </div>
		                </div>
		            </div>
				</div>
			</div>
		</div>
		<hr>
		<div class="container">
			<div class="row p-1">
				<div class="col-6">Unit Number</div>
				<div class="col-6">&nbsp;</div>
				<div class="col-6"><input type="text" value="<?=$rec['location_name']?>" class="form-control" readonly></div>
				<div class="col-6">&nbsp;</div>
				<div class="col-6">Turnover Date</div>
				<div class="col-6">Area SQM</div>
				<div class="col-6"><input type="date" value="<?=$rec['turnover_date']?>" class="form-control" readonly></div>
				<div class="col-6"><input type="text" size="3" value="<?=$rec['floor_area']?>" class="form-control" readonly></div>
			</div>
		</div>
		<hr>
		<div class="container mb-3">
			<div class="row p-1">
				<div class="col-6">Email Address</div>
				<div class="col-6">Secondary Email Address</div>
				<div class="col-6"><input type="email" value="<?=$rec['email']?>" class="form-control" readonly></div>
				<div class="col-6"><input name="email2" type="email" value="<?=$rec['email2']?>" class="form-control" placeholder="Enter secondary email"></div>
				<div class="col-12">&nbsp;</div>
				<div class="col-6">Mobile No.</div>
				<div class="col-6">&nbsp;</div>
				<div class="col-6"><input name="mobile" type="text" value="<?=$rec['mobile']?>" class="form-control" placeholder="Enter mobile number"></div>
			</div>
			<div class="row p-1 my-3">
				<div class="col-6"><button class="btn btn-secondary form-control" type="button" onclick="window.location='setting.php'">Cancel</button></div>
				<div class="col-6"><button class="btn btn-primary form-control pt-1 mb-4" type="submit" value="Save">Save</button></div>
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
            this.submit()
            swal("Record saved!", { icon: "success" });
          }
        });
    });
});
</script>