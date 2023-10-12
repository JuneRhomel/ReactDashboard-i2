<?php
include("footerheader.php");
fHeader();
?>
<div class="col-12 d-flex align-items-center justify-content-between mt-4 mb-3">
    <div class="title">Setting</div>
</div>
<div class="">
	<div class="container mb-3">
		<a href="setting-myprofile.php">
		<div class="d-flex align-items-center justify-content-between p-3 bg-white rounded">
			<div>
				<div><i class="fa fa-user circle"></i><label class="font-16 pl-3">My Profile</label></div>
			</div>
			<div>
				<i class="fas fa-arrow-right circle"></i>
			</div>
		</div>
		</a>
	</div>
	<div class="container mb-3">
		<a href="setting-notif.php">
		<div class="d-flex align-items-center justify-content-between p-3 bg-white rounded">
			<div>
				<div><i class="fa fa-user circle"></i><label class="font-16 pl-3">Notifications</label></div>
			</div>
			<div>
				<i class="fas fa-arrow-right circle"></i>
			</div>
		</div>
		</a>
	</div>
	<div class="container mb-3">
		<a href="setting-password.php">
		<div class="d-flex align-items-center justify-content-between p-3 bg-white rounded">
			<div>
				<div><i class="fa fa-user circle"></i><label class="font-16 pl-3">Change Password</label></div>
			</div>
			<div>
				<i class="fas fa-arrow-right circle"></i>
			</div>
		</div>
		</a>
	</div>
	<!-- <div class="container">
		<div class="d-flex align-items-center justify-content-between p-3 bg-white rounded">
			<div class="d-flex flex-row">
				<div><i class="fa fa-user circle"></i></div>
				<div class="d-flex flex-column pl-3" style="margin-top:-5px">
					<label class="font-16 m-0">Themes and Appearance</label>
					<lable class="font-9 font-weight-bold">This feature is currentliy under construction</label>
				</div>
			</div>
			<div>
				<i class="fas fa-arrow-right circle"></i>
			</div>
		</div>
	</div>	 -->
</div>
<?php
fFooter();
?>