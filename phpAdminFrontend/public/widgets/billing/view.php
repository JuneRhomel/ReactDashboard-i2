<?php
$billing = null;
if(count($args))
{
	$billing_result = $ots->execute('billing','get-billing',['billingid'=>$args[0]]);
	$billing = json_decode($billing_result,true);

	$payments_result = $ots->execute('billing','get-bill-payments',['billingid'=>$args[0]]);
	$payments = json_decode($payments_result,true);
}

?>

<div class="page-title">Billing #<?php echo $billing ? $billing['billing_number'] : '';?></div>
<div class="bg-white p-2 rounded">
	<div class="row">
		<div class="col-2">
			Resident
		</div>
		<div class="col-2">
			<?php echo $billing['tenant_name'];?>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-2">
			Amount
		</div>
		<div class="col-2">
			<?php echo number_format($billing['amount'],2);?>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-2">
			Payment
		</div>
		<div class="col-2">
			<?php echo number_format($billing['payment'],2);?>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-2">
			Balance
		</div>
		<div class="col-2">
			<?php echo number_format($billing['amount'] - $billing['payment'],2);?>
		</div>
	</div>
</div>


<?php if($billing['amount'] - $billing['payment'] > 0):?>
	<button class="btn btn-sm btn-primary float-end mt-3 me-3 btn-add-payment">Add Payment <span class="bi bi-plus-circle"></span></button>
<?php endif;?>

<div class="page-title mt-4">Payments</div>
<div class="bg-white p-2 rounded">
	<table class="table">
		<thead>
			<tr>
				<th>Date</th>
				<th>Amount</th>
				<th>Type</th>
			</tr>
		</thead>
		<?php foreach($payments as $payment):?>
			<tr>
				<td><?php echo date('M d, Y',$payment['created_on']);?></td>
				<td><?php echo number_format($payment['amount']);?></td>
				<td><?php echo $payment['payment_type'];?></td>
			</tr>
		<?php endforeach;?>
	</table>
</div>

<div class="modal modal-payment modal-theme" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<form method="post" action="<?php echo WEB_ROOT;?>/billing/add-payment" id="form-add-payment">
			<div class="modal-header">
				<h5 class="modal-title">Payment</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Amount</label>
					<input type="number" class="form-control" value="0.00" step="0.01" name="amount">
				</div>

				<div class="form-group">
					<label>Type</label>
					<select class="form-control" name="payment_type">
						<option>Cash</option>
						<option>Check</option>
						<option>Bank Transfer</option>
						<option>Online Payment</option>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Submit</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
			</div>

			<input type="hidden" name="billing_id" value="<?php echo $args[0] ?? '';?>">
		</form>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$(".btn-add-payment").on('click',function(){
			$(".modal-payment").modal('show');
		});


		$("#form-add-payment").on('submit',function(e){
			e.preventDefault();

			$.ajax({
				url: $(this).prop('action') + '?display=plain',
				type: 'POST',
				data: $(this).serialize(),
				dataType: 'JSON',
				beforeSend: function(){
				},
				success: function(data){
					if(data.success == 1)
					{
						showSuccessMessage(data.description,function(){
							window.location.reload();
						});
					}else{
						showErrorMessage(data.description);
					}
				},
				complete: function(){
					
				},
				error: function(jqXHR, textStatus, errorThrown){
					
				}
			});
		});
	});
</script>