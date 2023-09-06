<?php
$module = "soa";
$table = "soa_detail";

$id = $args[0];

$result =  $ots->execute('module','get-listnew',[ 'table'=>'soa_detail','condition'=>'(amount_bal>0) and soa_id="'.decryptData($id).'"','orderby'=>'id asc' ]);
$soa_detail = json_decode($result);
//vdump($soa_detail);
?>
<style>input { color:black; }</style>
<div class="main-container">
	<div class="mt-2 mb-4"><label class="data-title">Payment</label></div>
	<div class="grid lg:grid-cols-1 grid-cols-1 title">
		<div class="rounded-sm">
			<form method="post" action="<?=WEB_ROOT;?>/module/save?display=plain" id="form-main">
				<div class="row forms">
					<div class="d-inline-flex col-12 col-sm-4 mb-3">
						<div class="form-check">
							<input name="payment_type" id="payment_type1" class="form-check-input" type="radio" value="Check" checked>
							<label class="">Check</label>
						</div>
						<div class="form-check ms-3">
							<input name="payment_type" id="payment_type2" class="form-check-input" type="radio" value="Cash">
							<label class="">Cash</label>
						</div>						
					</div>
					<div class="col-12 col-sm-8 mb-6"></div>

					<div class="col-12 col-sm-4 mb-3 div-check">
						<div class="form-group input-box">
							<input name="check_no" placeholder="Enter here" type="text" class="form-control check-input" value="" required>
							<label>Check No.</label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-3 div-check">
						<div class="form-group input-box">
							<input name="check_date" placeholder="Enter here" type="date" class="form-control check-input" value="" required>
							<label>Check Date</label>
						</div>
					</div>
					<div class="col-12 col-sm-4 mb-6 div-check"></div>

					<div class="col-12 col-sm-4 mb-3 div-check">
						<div class="form-group input-box">
							<input name="check_amount" placeholder="Enter here" type="text" class="form-control check-input" value="" required>
							<label>Check Amount</label>
						</div>
					</div>
					<div class="col-12 col-sm-8 mb-6 div-check"></div>

					<h5>Unpaid Charge(s)</h5>
					<?php 
					$ct = 1; $total = 0;
					foreach ($soa_detail as $val) { 
						if ($ct % 3 == 0) {
							echo '<div class="col-12 col-sm-4 mb-3"></div>';
							$ct++;
						}
					?>
					<div class="col-12 col-sm-4 mb-3">
						<div class="form-group input-box">
							<input name="amount[<?=$val->id?>]" type="hidden" value="<?=$val->amount?>">
							<input name="payment[<?=$val->id?>]" placeholder="<?=$val->amount?>" type="number" class="form-control" max="<?=$val->amount?>" value="<?=$val->amount?>">
							<label><?=$val->particular?></label>
						</div>
					</div>
					<?php
						$total += $val->amount;
						$ct++;						
					} // FOREACH
					?>
					<div class="col-12 mb-2">
						<h5><b>Total Amount: </b><?=formatPrice($total)?></h5>
					</div>

					<div class="d-flex gap-3 justify-content-start">
						<button class="main-btn btn">Submit</button>
						<button class="main-cancel btn-cancel btn" type="button">Cancel</button>
					</div>					
					<input name="id" type="hidden" value="<?=$args[0] ?? '';?>">
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
		$.ajax({
			url: $(this).prop('action'),
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'JSON',
			beforeSend: function(){
				$('.btn').attr('disabled','disabled');
			},
			success: function(data){					
				if(data.success == 1) {
					toastr.success(data.description,'Information',{ timeOut:2000, onHidden: function() { location="<?=WEB_ROOT."/$module/"?>"; }});
				}	
			},
		});
	});


	$("#payment_type1").click(function(){
		$(".div-check").show();
		$(".check-input").prop('required',true);
	});

	$("#payment_type2").click(function(){
		$(".div-check").hide();
		$(".check-input").prop('required',false);
	});

	$(".btn-cancel").click(function(){
		location = '<?=WEB_ROOT."/$module/"?>';
	});
});
</script>
