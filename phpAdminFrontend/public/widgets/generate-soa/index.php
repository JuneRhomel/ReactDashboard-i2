<?php
$module = "generate-soa";
$table = "soa";

$result = $ots->execute('form', 'get-role-access', [ 'table'=>$table ]);
$role_access = json_decode($result);

$month_now = date('m');
//$month_now = 7;
?>
<div class="main-container">
	<div class="grid lg:grid-cols-1 grid-cols-1 title">
		<div class="rounded-sm">
			<form method="post" action="<?=WEB_ROOT;?>/<?=$module?>/generate-soa?display=plain" id="form-main">
				<div class="row forms">
					<div class="col-12 col-sm-4 my-4">
						<div class="form-group input-box">
							<select name="month_of" class="form-control form-select" required>
								<?php for($i=1; $i<=12; $i++) { ?>
								<option value="<?=$i?>" <?=($i==$month_now) ? 'selected':''?>><?=date("F",strtotime("2023-$i-01"))?></option>
								<?php } ?>
							</select>
							<label>Month</label>
						</div>
					</div>
					<div class="col-12 col-sm-4 my-4">
						<div class="form-group input-box">
							<input name="year_of" placeholder="Enter here" type="text" class="form-control" value="<?=date("Y")?>" required>
							<label>Year</label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-6"></div>

					<div class="d-flex gap-3 justify-content-start">
						<button class=" main-btn">Generate</button>
					</div>					
					<input name="id" type="hidden" value="">
					<input name="module" type="hidden" value="<?=$module?>">
					<input name="table" type="hidden" value="<?=$table?>">
				</div>
			</form>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$("#form-main").off('submit').on('submit',function(e){
		e.preventDefault();
		// GENERATE SOA
		$.ajax({
			url: $(this).prop('action'),
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'JSON',
			success: function(data){					
				if(data.success == 1) {

					popup({
                        data: data,
                        reload_time: 2000,
                        redirect: "<?= WEB_ROOT . "/soa/" ?>"
                    })
				}	
			},
		});
	});
});
</script>