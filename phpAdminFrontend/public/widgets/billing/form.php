<?php
	$location_id = (isset($_REQUEST['location_id'])) ? $_REQUEST['location_id'] : 0;
	$billing = null;
	if(count($args))
	{
		$billing_result = $ots->execute('billing','get-billing',['billingid'=>$args[0]]);
		$billing = json_decode($billing_result,true);
	}
	$units =  json_decode($ots->execute('location','get-unit-list-restricted',[]),true);
?>

<div class="page-title"><?=count($args) ? 'Edit' : 'Add';?> Billing</div>
<div class="col-12 col-sm-6 bg-white p-3">
	<form method="post" action="<?=WEB_ROOT;?>/billing/save?display=plain" class="bg-white" id="billing-form" enctype="multipart/form-data">
		<div class="form-group mb-2">
			<label for="" class="text-required">Date</label>
			<input type="text" class="form-control date" name="billing_date" value="<?=$billing ? $billing['billing_date'] : date('Y-m-d');?>" required>
		</div>
		<div class="form-group mb-2">
			<label for="" class="text-required">Type</label>
			<?php $billing_types = ['SOA','Association Dues','Interest','Past Due','Water','Electricity'];?>
			<select class="form-control" name="billing_type">
				<?php foreach($billing_types as $billing_type):?>
				<option <?=$billing && $billing['billing_type'] == $billing_type ? 'selected' : '';?>><?=$billing_type;?></option>
				<?php endforeach;?>
			</select>
		</div>
		<div class="form-group mb-2">
			<label for="" class="text-required">Due Date</label>
			<input type="text" class="form-control date" name="due_date" value="<?=$billing ? $billing['due_date'] : date('Y-m-d',strtotime("+30 days"));?>" required>
		</div>
		<div class="form-group mb-2">
			<label for="" class="text-required">Amount</label>
			<input type="number" step="0.01" class="form-control" name="amount" value="<?=$billing ? $billing['amount'] : '0.00';?>" required>
		</div>
		<?php if($billing):?>
		<div class="form-group mb-2">
			<label for="" class="text-required">Payment</label>
			<input type="number" step="0.01" class="form-control" name="payment" value="<?=$billing ? $billing['payment'] : '0.00';?>" required>
		</div>
		<?php endif;?>
		<div class="form-group mb-2">
			<label for="" class="text-required">Resident</label>
			<input type="text" style="opacity:0;width:0px;height:0px" name="tenant_id" value="<?=$billing ? $billing['tenant_id'] : '0';?>" required>
			<input type="text" class="form-control" id="tenant_id" value="<?=$billing ? $billing['tenant_name'] : '';?>" required>
		</div>
		<div class="form-group mb-2">
			<label for="" class="text-required">Unit</label>
			<select class="form-control form-select" name="location_id">
				<?php foreach($units as $unit):?>
					<option value="<?=$unit['id'];?>" <?=(($billing && $billing['location_id']==$unit['id']) || $unit['id']==$location_id) ? 'selected' : '';?>><?=$unit['location_name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
		<button type="button" class="btn btn-light btn-cancel" <?=($location_id!=0) ? "onclick='window.close();'" : ""?>>Cancel</button>
		<button class="btn btn-primary">Submit</button>
		<input type="hidden" value="<?=$args[0] ?? '';?>" name="id">
	</form>
</div>

<script>
	$(document).ready(function(){
		$(".date").datetimepicker({'format':'Y-m-d','timepicker':false});

		$("#billing-form").off('submit').on('submit',function(e){
			e.preventDefault();

			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				data: new FormData($(this)[0]),
				dataType: 'JSON',
				contentType: false,
				processData: false,
				beforeSend: function(){
				},
				success: function(data){
					if(data.success == 1)
					{
						$(".notification-success-message").html(data.description);
						$(".notification-success").fadeIn('slow');	
						//$("#billing-form")[0].reset();
						location = "/billing?submenuid=billing";
					}	
				},
				complete: function(){
					
				},
				error: function(jqXHR, textStatus, errorThrown){
					
				}
			});
		});

		$(".btn-cancel").off('click').on('click',function(){
			//loadPage('<?=WEB_ROOT;?>/form');
			window.location.href = '<?=WEB_ROOT;?>/billing';
		});

		$("input[id=tenant_id]").autocomplete({
			autoSelect : true,
			autoFocus: true,
			search: function(event, ui) { 
				$('.spinner').show();
			},
			response: function(event, ui) {
				$('.spinner').hide();
			},
			source: function( request, response ) {
				$.ajax({
					url: '<?=WEB_ROOT;?>/tenant/search?display=plain',
					dataType: "json",
					type: 'post',
					data: {
						term: request.term,
					},
					success: function( data ) {
						response( data );
					}
				});
			},
			minLength: 2,
			select: function( event, ui ) {

				$(event.target).prev().val(ui.item.value);
				$(event.target).val(ui.item.label);

				return false;
			},
			change: function(event, ui){
				if(ui.item == null)
				{
					$(event.target).prev('input').val(0);
				}
			}
		});
	});
</script>