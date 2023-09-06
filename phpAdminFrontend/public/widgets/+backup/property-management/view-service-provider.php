<?php
    $data = [
		'id'=>$args[0],
        'view'=>'service_providers_view'
	];
	$sp_result = $ots->execute('property-management','get-record',$data);
	$s_provider = json_decode($sp_result);

//PERMISSIONS
//get user role
$data = [	
	'view'=>'users'
];
$user = $ots->execute('property-management','get-record',$data);
$user = json_decode($user);

//check if has access
$data = [
	'role_id'=>$user->role_type,
	'table'=>'service_providers',
	'view'=>'role_rights'

];
$role_access = $ots->execute('form','get-role-access',$data);
$role_access = json_decode($role_access);
// var_dump($role_access);
?>

<style>

*{
    margin: 0;
    padding: 0;
}
.rate {
    float: left;
    height: 46px;
    padding: 0 10px;
}
.rate:not(:checked) > input {
    position:absolute;
    top:-9999px;
}
.rate:not(:checked) > label {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ccc;
}
.rate:not(:checked) > label:before {
    content: '★ ';
}
.rate > input:checked ~ label {
    color: #ffc700;    
}
.rate:not(:checked) > label:hover,
.rate:not(:checked) > label:hover ~ label {
    color: #deb217;  
}
.rate > input:checked + label:hover,
.rate > input:checked + label:hover ~ label,
.rate > input:checked ~ label:hover,
.rate > input:checked ~ label:hover ~ label,
.rate > label:hover ~ input:checked ~ label {
    color: #c59b08;
}

</style>



	<div class="d-flex justify-content-between mb-3">
		<a onclick="history.back()"><label class="data-title"  style="cursor: pointer;"><i class="fa-solid fa-arrow-left text-primary"></i> <?php echo $s_provider->company;?></label></a>
		<?php if($role_access->update == true): ?>	
			<a href='<?= WEB_ROOT ?>/property-management/form-edit-serviceprovider/<?= $args[0] ?>/Edit'  class='btn btn-sm btn-primary float-end btn-view-form px-5'>Edit</a>
		<?php endif; ?>
	</div>
	<table class="table table-data table-bordered property-management border-table text-capitalize" >
		<tr>
			<th>Company</th><td><?php echo $s_provider->company;?></td>
		</tr>
		<tr>
			<th>Contact Person</th><td><?php echo $s_provider->contact_person;?></td>
		</tr>
		<tr>
			<th>Username</th><td><?php echo $s_provider->username;?></td>
		</tr>
		<tr>
			<th>Email</th><td><?php echo $s_provider->email;?></td>
		</tr>
		<tr>
			<th>Contact Number</th><td><?php echo $s_provider->contact_number;?></td>
		</tr>
		<tr>
			<th>Company Address</th><td><?php echo $s_provider->company_address;?></td>
		</tr>
		<tr>
			<th>Scope of Service</th><td><?php echo $s_provider->scope_of_service;?></td>
		</tr>
		<tr>
			<?php
				$stars = $s_provider->vendor_score;
				$count = 1;
				$result = "";

				for($i = 1; $i <= 5; $i++){
					if($stars >= $count){
						$result .= "<span style='color:#ffc700; font-size: 20px;'>&#x2605</span>";
					} else {
						$result .= "<span style='font-size: 20px;'>&#x2606</span>";
					}
					$count++;
				}
			?>
			<th>Vendor Score</th><td><?php echo $result;?></td>
		</tr>
		
	</table>
	<div class="btn-group-buttons pull-right">
		<div class="d-flex flex-row-reverse" style="padding: 5px;">
			<button type="submit" class="btn btn-dark btn-primary btn-cancel px-5">Back</button>
		</div>
	</div>
	
	
<script>
	$(document).ready(function(){
		$("#form-location").off('submit').on('submit',function(e){
			e.preventDefault();
			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				data: $(this).serialize(),
				dataType: 'JSON',
				beforeSend: function(){
				},
				success: function(data){
					if(data.success == 1)
					{
						$(".notification-success-message").html(data.description);
						$(".notification-success").fadeIn('slow');
						<?php if(!$location):?>	
						$("#form-location")[0].reset();
						<?php endif;?>
					}	
				},
				complete: function(){
					
				},
				error: function(jqXHR, textStatus, errorThrown){
					
				}
			});
		});

		$('#datepicker').datepicker({
			format: 'yy-mm-d',
			timepicker: false,
			minDate: '+1D',
		});

		$('#datepicker1').datepicker({
			format: 'yy-mm-d',
			timepicker: false,
			minDate: '+1D',
		});


		$(".btn-cancel").on('click',function(){
			//loadPage('<?=WEB_ROOT;?>/location');
			window.location.href = '<?=WEB_ROOT;?>/property-management/serviceprovider?submenuid=serviceproviders';
		});

		$("input[id=parent_location]").autocomplete({
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
					url: '<?=WEB_ROOT;?>/location/search?display=plain',
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

		$("select[name=location_type]").on('change',function(){
			if($(this).val().toLowerCase() == 'property')
			{
				$(".location-container").addClass('d-none');
				$("input[name=parent_location]").val('');
				$("#parent_location_id").val(0);
			}else{
				$(".location-container").removeClass('d-none');
			}
		});
	});
</script>