<?php
include("footerheader.php");
fHeader();

$tenant_name = $unit = $email = $mobile = "";
if (initObj('action')!="") {
	$tenant_name = "john doe - ".DATETIME;  $email = "john.doe@gmail.com"; $mobile = "0917-1234567";
}

$locinfo = getLocInfo();
$location_id = $locinfo['location_id']; 
$location_name = $locinfo['location_name'];

$tenant = initSession('tenant');
$email = $tenant['email'];
$mobile = $tenant['mobile'];
?>
<div class="col-12 my-4">
	<div class="title">Tenant Registration</div>
</div>
<form id="frm" name="frm" method="post" enctype="multipart/form-data" action="tenant-save.php">
	<div class="py-3 bg-white">
		<div class="container">
			<div class="mb-2">
				<div class="mb-2">Full Name</div>
				<div>
					<input name="tenant_name" type="text" class="form-control" value="<?=$tenant_name?>" required />
				</div>
			</div>
			<div class="mb-2">
				<div class="mb-2">Unit</div>
				<div>
					<select name="location_id" class="form-control" required>
						<?php foreach($_SESSION['tenant']['locations'] as $location):?>
							<option value="<?php echo $location['location_id'];?>"><?php echo $location['location_name'];?></option>
						<?php endforeach;?>
					</select>
					<!--input type="text" class="form-control" value="<?=$location_name?>" required />
					<input name="location_id" type="hidden" class="form-control" value="<?=$location_id?>" required /-->
				</div>
			</div>
			<div class="mb-2">
				<div class="mb-2">Email Address</div>
				<div>
					<input name="email" type="text" class="form-control" value="" required />
				</div>
			</div>
			<div class="mb-2">
				<div class="mb-2">Mobile Number</div>
				<div>
					<input name="mobile" type="text" class="form-control" value="<?=$mobile?>" required />
				</div>
			</div>

			<div class="mb-2">
				<div class="d-flex align-items-center justify-content-between">
					<div class="mb-2">Upload ID</div>
					<!--div style="opacity: 60%">OPTIONAL</div-->
				</div>
				<div>
					<div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<button type="button" class="btn primary"><div><i class="fa-solid fa-paperclip text-white"></i></div></button>
							</div>
							<input name="upload_file" type="file" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1" required/>
						</div>
					</div>
				</div>
			</div>

			<div class="mb-2">
				<div class="d-flex align-items-center justify-content-between">
					<div class="mb-2">Contract</div>
					<!--div style="opacity: 60%">OPTIONAL</div-->
				</div>
				<div>
					<div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<button type="button" class="btn primary"><div><i class="fa-solid fa-paperclip text-white"></i></div></button>
							</div>
							<input name="upload_file_contract" type="file" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1" required/>
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