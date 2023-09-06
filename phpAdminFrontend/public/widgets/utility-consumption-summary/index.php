<?php
$module = "utility-consumption-summary";
$table = "utility_consumption";
$view = "vw_utility_consumption";
$report = "uc-summary";

$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
$role_access = json_decode($result);

$month = date('m');
$month = 7;
?>
<div class="main-container">
	<?php if ($role_access->read != true) : ?>
		<div class="card mx-auto" style="max-width: 30rem;">
			<div class="card-header bg-danger">
				Unauthorized access
			</div>
			<div class="card-body text-center">
				You are not allowed to access this resource. Please check with system administrator.
			</div>
		</div>
	<?php else : ?>		
		<form method="post" action="<?=WEB_ROOT.'/'.$module?>/report?display=plain" id="form-main">
			<input name="view" type="hidden" value="<?=$view?>">
			<input name="report" type="hidden" value="<?=$report?>">
			<div class="gap-4 my-5 align-items-center py-4 billing-rates" style="border-top: 1px solid #B4B4B4; border-bottom: 1px solid #B4B4B4;">
				<label for="" class="text-required mb-2">Select month/year to be generated.</label>
				<div class="row">
					<div class="col-12 col-sm-3 col-lg-2 col-xl-2">
						<div class="form-group">
							<label for="" class="text-required">Month</label>
							<select name="month" id="month_select" class="form-select" required>
								<?php for($i='01'; $i<='12'; $i++) { ?>
								<option value="<?=$i?>" <?=($month==$i) ? 'selected':''?>><?=date("F",strtotime("2023-$i-01"))?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-12 col-sm-3 col-lg-2 col-xl-2">
						<div class="form-group">
							<label for="" class="text-required">Year</label>
							<select name="year" id="year_select" class="form-select" required>
								<?php 
								$year = intval(date('Y'));
								for($i=$year-2; $i<=$year; $i++) { 
								?>
								<option value="<?=$i?>" <?=(date('Y')==$i) ? 'selected':''?>><?=$i?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-12 col-sm-4 col-lg-2 col-xl-2 mt-3">
						<div class="form-group">
							<button name="btn-submit" type="submit" class="btn btn-primary btn-lg px-5 py-2 mt-2">Generate</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<div class=" pb-2 px-2 pt-0 rounded">
			<div class="container-table" style="background-color:#F6F6F6">
				<table id="jsdata"></table>
			</div>
		</div>
		
	<?php endif; ?>
</div>
<script>
$(document).ready(function(){
	$("#form-main").off('submit').on('submit',function(e){
		e.preventDefault();
		$.ajax({
			url: $(this).prop('action'),
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'html',
			success: function(data){
				$('#jsdata').html(data);
			},
		});
	});
});
</script>