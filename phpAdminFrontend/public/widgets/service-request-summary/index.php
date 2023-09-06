<?php
$module = "service-request-summary";
$table = "service_request";
$view = "vw_service_request";
$report = "sr-summary";

$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
$role_access = json_decode($result);

$month = date('m');
//$month = 7;
$from_date = $to_date = date();
//$from_date = "2023-06-01"; $to_date = "2023-08-15";
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
				<div class="row">
					<div class="col-12 col-sm-3 col-lg-4 col-xl-4 mb-3">
						<div class="form-group">
							<label class="text-required">Generate By: </label>
							<input name="generated_by" id="generated_by1" class="ms-4" type="radio" value="monthyear" checked> Month/Year
							<input name="generated_by" id="generated_by2" class="ms-2" type="radio" value="daterange"> Date Range
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-3 col-lg-2 col-xl-2 monthyear">
						<div class="form-group">
							<label class="text-required">Month</label>
							<select name="month" id="month_select" class="form-select" required>
								<?php for($i='01'; $i<='12'; $i++) { ?>
								<option value="<?=$i?>" <?=($month==$i) ? 'selected':''?>><?=date("F",strtotime("2023-$i-01"))?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-12 col-sm-3 col-lg-2 col-xl-2 monthyear">
						<div class="form-group">
							<label class="text-required">Year</label>
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
					<div class="d-none col-12 col-sm-3 col-lg-2 col-xl-2 daterange">
						<div class="form-group">
							<label for="" class="text-required">From Date</label>
							<input name="from_date" type="date" class="form-control" value="<?=$from_date?>">
						</div>
					</div>
					<div class="d-none col-12 col-sm-3 col-lg-2 col-xl-2 daterange">
						<div class="form-group">
							<label for="" class="text-required">To Date</label>
							<input name="to_date" type="date" class="form-control" value="<?=$to_date?>">
						</div>
					</div>
					<div class="col-12 col-sm-3 col-lg-2 col-xl-2">
						<div class="form-group">
							<label class="text-required">Service Request Type</label>
							<select name="sr_type" id="year_select" class="form-select" required>
								<option value="ALL" selected>ALL</option>
								<?php 
								$types = [ "Gate Pass","Visitor Pass","Work Permit","Reported Issue" ];
								foreach ($types as $type)  {
								?>
								<option value="<?=$type?>"><?=$type?></option>
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
	$("#generated_by1").on('click', function() {
		$(".monthyear").removeClass('d-none');
		$(".daterange").addClass('d-none');
	});
	$("#generated_by2").on('click', function() {
		$(".monthyear").addClass('d-none');
		$(".daterange").removeClass('d-none');
	});
	/*$("#generated_by1").click();*/

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