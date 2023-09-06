<?php
$module = "meter";  
$table = "meters";
$view = "view_meters"; 

$record = null;
if(count($args)) {
	$result = $ots->execute('module','get-record',['id'=>$args[0],'view'=>$view]);
	$record = json_decode($result,true);
}
$arrMeterType = [ "Water","Electricity" ];
$arrReadingType = [ "Continuous","Gauge" ];
?>
<div class="page-title">Meter Input </div>
<div class="col-12 bg-white p-3">
	<div class="col-12">
		<form method="post" action="<?=WEB_ROOT;?>/meter/save-reading" id="frm" enctype="multipart/form-data">
			<b><I class="bi bi-funnel-fill"></I> FILTER</b>
			<div class="form-inline">
				<!-- <div class="form-group mr-2">
					<label>Meter Name</label>
					<input name="meter-id" type="hidden" value="" required>
					<input id="meter-id" type="text" class="form-control" value="" placeholder="Search Meter..">
				</div>
				<div class="form-group mx-2"><label>OR</label></div>
				<div class="form-group mx-2">
					<label>Resident</label>
					<input name="tenant-id" type="hidden" value=">" required>
					<input id="tenant-id" type="text" class="form-control" value="" placeholder="Search resident..">
				</div> -->
				<div class="form-group mx-2">
					<label>Type</label>
					<select class="form-control form-select meter-type">
						<!-- <option value="">--SELECT--</option> -->
						<option value="ALL">ALL</option>
						<?php foreach ($arrMeterType as $val) { ?>
						<option value="<?=$val?>"><?=$val?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group mx-2">
					<button class="btn btn-primary btn-search mt-4" type="button">Show</button>
				</div>
				<div class="form-group">
					<button class="btn btn-secondary btn-reset mt-4" type="button">Reset</button>
				</div>
			</div>
			<div class="table-list" style="display:none">
				<hr>
				<div class="form-inline">
					<div class="form-group">
						<label>Reading Date</label>
						<input name="reading_date" type="date" class="mr-2 form-control reading-date" value="<?=date('Y-m-d');?>" size="12">
					</div>
				</div>			
				<table class="table table-meters">
					<thead>
						<tr class="text-nowrap">
							<th>Meter</th>
							<th class="text-center">Last Reading</th>
							<th class="text-center">New Reading</th>
							<th class="text-center">Total Amount</th>
							<!-- <th class="text-center"><input type="checkbox" class="check-all"> Billing</th> -->
							<!-- <th>File/Photo</th> -->
							<th>Note</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
				<hr>
				<button class="btn btn-primary">Save</button>
			</div>
		</form>		
	<div>
	<div class="modal modal-saved modal-success" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Saved</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Meter readings saved!</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
search_handle = 0;
meters_count = 0;
meter_date = 0;
$(document).ready(function(){
	$(".btn-search").on('click',function(){
		searchnow();
	});

	$(".btn-reset").on('click',function(){
		window.location.reload();
	});	

	function searchnow() {
		$.ajax({
			url: '<?=WEB_ROOT;?>/meter/get-meters?display=plain',
			type: 'POST',
			data: { 'meter_id':$(".meter-id").val(),'tenant_id':$(".tenant-id").val(),'meter_type':$(".meter-type").val() },
			dataType: 'html',
			beforeSend: function(){
				$(".meter-list").html('Loading...');
				$(".table-meters tbody").html('<tr><td>Loading...</td></tr>');
			},
			success: function(data){
				$(".table-list").show();
				$(".table-meters tbody").html(data);
			},
			complete: function(){},
			error: function(jqXHR, textStatus, errorThrown){}
		});
	}

	$("#frm").on('submit',function(e){
		e.preventDefault();

		$zeros = 0;
		if($zeros) {
			$.overlay({
                message: '<div class="card"><div class="card-header">Required</div><div class="card-body">Invalid new meter reading for Continuous type meter.</div></div>',
                buttons:[ { label: "Ok", class: 'btn-primary' } ]
		    }).show();
            return false;
		}

		$(".meters").each(function(){
			var fd = new FormData();
			var meter_id = $(this).data('meterid');
			fd.append('reading_date',$('input[name=reading_date]').val());
			fd.append('reading',$(this).val());
			fd.append('amount',$(this).closest('tr').find('.amount').val());
			fd.append('note',$(this).closest('tr').find('.note').val());
			fd.append('meter_type',$(this).data('meter_type'));
			fd.append('multiplier',$(this).data('multiplier'));
			fd.append('consumption',$(this).data('consumption'));
			fd.append('meter_id',$(this).data('meter_id'));

			var progress_bar = $(this).closest('tr').find('.progress-bar');
			var tr =  $(this).closest('tr');
			/*if ($(this).closest('tr').find('.files')[0].files.length)
				progress_bar.removeClass('d-none');	
			else
				progress_bar.addClass('d-none');*/

			$.ajax({
				/*xhr: function() {
					var xhr = new window.XMLHttpRequest();

					xhr.upload.addEventListener("progress", function(evt) {
						if (evt.lengthComputable) {
							var percentComplete = evt.loaded / evt.total;
							percentComplete = parseInt(percentComplete * 100);					
							progress_bar[0].value = percentComplete;
							if (percentComplete === 100) {
								meters_count++;
								if(meters_count == $(".meters").length) {
									$(".modal-saved").modal('show');
								}
							}
						}
					}, false);
					return xhr;
				},*/
				url: '<?=WEB_ROOT;?>/meter/save-reading?display=plain',
				type: "POST",
				data: fd,
				contentType: false,
				dataType: "json",
				processData: false,
				cache: false,
				success: function(result) {									
				}
			});
		});
		toastr.success('Meter input saved.','Success',{timeOut:3000});
		$(".table-list").hide();
	});

	$("input[id=meter-id").autocomplete({
			autoSelect : true,
			autoFocus: true,
			search: function(event, ui) { $('.spinner').show();	},
			response: function(event, ui) {	$('.spinner').hide(); },
			source: function( request, response ) {
				$.ajax({
					url: '<?=WEB_ROOT;?>/module/search-meters?display=plain',
					dataType: "json",
					type: 'post',
					data: {	term: request.term, ynmother: 1	},
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
				if(ui.item == null)	{
					$(event.target).prev('input').val(0);
				}
			}
		});

	$("input[id=tenant-id]").autocomplete({
		autoSelect : true,
		autoFocus: true,
		search: function(event, ui) { $('.spinner').show();	},
		response: function(event, ui) {	$('.spinner').hide(); },
		source: function( request, response ) {
			$.ajax({
				url: '<?=WEB_ROOT;?>/module/search-tenants?display=plain',
				dataType: "json",
				type: 'post',
				data: {	term: request.term	},
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
			if(ui.item == null)	{
				$(event.target).prev('input').val(0);
			}
		}
	});

	/*$(".check-all").on('change',function(){
		$(".billing").prop('checked',$(this).is(':checked'));
	});

	$(document).on('keyup','.meters',function(){
		var obj = this;
		if(parseFloat($(this).val())  < parseFloat($(this).data('lastreading')))
		{
			//$(obj).closest('tr').find('.new-consumption-label').css({'color':'#ff0000'});
			$(obj).closest('tr').find('.new-consumption-label').css({'background-color':'#FFDD33'});
			new_reading = Math.pow(10,5) - parseFloat($(this).data('lastreading')) + parseFloat($(this).val());
		}else{
			new_reading = parseFloat($(this).val()) - parseFloat($(this).data('lastreading'));
			$(obj).closest('tr').find('.new-consumption-label').css({'color':'#000000'});
			$(obj).closest('tr').find('.new-consumption-label').css({'background-color':'#FFFFFFF'});
		}
		
		new_reading = new_reading * parseFloat($(this).data('multiplier'));
		
		if(isNaN(new_reading)) {
			$(this).closest('tr').find('.new-consumption').val('');
			$(this).closest('tr').find('.new-consumption-label').html();
		}else{
			$(this).closest('tr').find('.new-consumption').val(new_reading.toFixed(2));
			$(this).closest('tr').find('.new-consumption-label').html(numberWithCommas(new_reading.toFixed(2)));
		}

		$.ajax({
			url: '<?=APP_ROOT;?>/<?=$page['Controller'];?>/check-meter-outlier/' + $(this).data('meterid') + '/' + $(this).closest('tr').find('.new-consumption').val().replace(',',''),
			type: 'GET',
			data: {},
			dataType: 'JSON',
			beforeSend: function(){},
			success: function(data){
				if(data.outlier)
				{
					$(obj).closest('tr').find('.new-consumption-label').css({'color':'#ff0000'});
				}else{
					$(obj).closest('tr').find('.new-consumption-label').css({'color':'#000000'});
				}
			},
			complete: function(){},
			error: function(jqXHR, textStatus, errorThrown){}
		});
	});

	$(document).on('keydown','.meters',function (event) {
		if (event.shiftKey == true) {
			event.preventDefault();
		}
		if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
			event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {
		} else {
			event.preventDefault();
		}
		if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
			event.preventDefault(); 
	});
	
	$(document).on('keydown','.amount',function (event) {
		if (event.shiftKey == true) {
			event.preventDefault();
		}
		if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 
			||	event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {
		} else {
			event.preventDefault();
		}
		if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
			event.preventDefault(); 
	});*/
});	
</script>