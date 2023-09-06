<style>
	/* The switch - the box around the slider */
	.switch {
		position: relative;
		display: inline-block;
		width: 40px;
		height: 25px;
	}

	/* Hide default HTML checkbox */
	.switch input {
		opacity: 0;
		width: 0;
		height: 0;
	}

	/* The slider */
	.slider {
		position: absolute;
		cursor: pointer;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: #ccc;
		-webkit-transition: .4s;
		transition: .4s;
	}

	.slider:before {
		position: absolute;
		content: "";
		height: 16px;
		width: 16px;
		left: 4px;
		bottom: 4px;
		background-color: white;
		-webkit-transition: .4s;
		transition: .4s;
	}

	input:checked+.slider {
		background-color: #19AF91;
	}

	input:focus+.slider {
		box-shadow: 0 0 1px #2196F3;
	}

	input:checked+.slider:before {
		-webkit-transform: translateX(16px);
		-ms-transform: translateX(16px);
		transform: translateX(16px);
	}

	/* Rounded sliders */
	.slider.round {
		border-radius: 36px;
	}

	.slider.round:before {
		border-radius: 50%;
	}
</style>
<div class="main-container">



	<div class="">
		<?php $contract->id ?>
		<form action="<?= WEB_ROOT ?>/tenant/save-record?display=plain" method='post' id="tl-add" enctype="multipart/form-data">
			<input type="hidden" name='redirect' id='redirect' value='<?= WEB_ROOT ?>/tenant/tenant-list?submenuid=tenant_list'>
			<input type="hidden" name='table' id='id' value='tenant'>
			<input type="hidden" name='view_table' id='id' value='view_tenant'>
			<label class="required-field mt-4">* Please Fill in the required fields</label>

			<div class="row forms">
				<div class="col-12 col-sm-4 my-3">
					<div class="form-group input-box">
						<select name="" id="">
							<option value="">Choose</option>
						</select>
						<label for="" class="text-required">Service Request Category <span class="text-danger">*</span></label>
						<!-- <input type="text" class="form-control" name="owner_name" value="" required> -->
					</div>
				</div>
				<div class="col-12 col-sm-4 my-3" style="position:relative">
					<!-- Rounded switch -->

					<div class="form-group input-box">
						<!-- <div style="position:absolute;right:4%;bottom:69%;">
								<label class="switch" style="">
									<input type="checkbox">
									<span class="slider round"></span>
								</label>
								<span class="text-required">
									Primary Contact
								</span>
							</div> -->

						<label for="" class="text-required">Requestor Name <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='owner_contact' value='' required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-3">
					<div class="form-group input-box">
						<label for="" class="text-required">Email Address <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='owner_email' value='' required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-3">
					<div class="form-group input-box">

						<label for="" class="text-required">Unit # <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='owner_username' value='' required>
					</div>
				</div>

				<div class="col-12 col-sm-4 my-3">
					<div class="form-group input-box">

						<select name="" id="">
							<option value="" disabled selected>Choose</option>
						</select>
						<label for="" class="text-required">Priority Level*</label>
						<!-- <input type="text" class='form-control' name='owner_spouse' value=''> -->
					</div>
				</div>

				<div class="col-12 col-sm-4 my-3">
					<div class="form-group input-box">

						<label for="" class="text-required">Owner Spouse Contact#</label>
						<input type="text" class='form-control' name='owner_spouse_contact' value=''>
					</div>
				</div>


				<div class="col-12 col-sm-4 my-3">
					<div class="form-group input-box">

						<!-- <input type="text" class='form-control' name='unit_area' value='' required> -->
						<select name="" id="">
							<option value="" selected disabled >Choose</option>
						</select>
						<label for="" class="text-required">Priority Level <span class="text-danger">*</span></label>
					</div>
				</div>
				<div class="col-12  my-3">
					<div class="form-group input-box">

						<label for="" class="text-required">Description <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='' value='' required>
					</div>
				</div>
				<div class="col-12  my-3">
					<div class="form-group input-box">

						<label for="" class="text-required">Request Type* <span class="text-danger">*</span></label>
						<input type="text" class='form-control' name='' value='' required>
					</div>
				</div>
				<div class="col-12 my-3">
					<div class="form-group file-box">
						<input type="file" class='form-control' name='file' id="file"  required>
						<label for="file"><span class="material-icons">download</span> Upload</label>
						<span id="file-name">No file chosen</span>
					</div>
				</div>
			</div>
			<div class="btn-group-form pull-right mt-4">

				<div class="mb-3 d-flex justify-content-end gap-3">
					<button type="submit" class="btn main-btn">Submit</button>
					<button type="button" class="btn main-cancel btn-cancel ">Cancel</button>
				</div>
			</div>
			<input type="hidden" value="<?= $args[0] ?? ''; ?>" name="id">
		</form>
	</div>
</div>
<script>
	$(document).ready(function() {
	$('#file').on('change', function() {
		var fileName = $(this).val().split('\\').pop();
		$('#file-name').text(fileName || 'No file chosen');
	});


		$("#sameasowner_chkbox").on('change', function(e) {
			if ($(this).is(":checked")) {
				$('input[name=tenant_name]').val($('input[name=owner_name]').val());
				$('input[name=tenant_contact]').val($('input[name=owner_contact]').val());
				$('input[name=tenant_email]').val($('input[name=owner_email]').val());
				$('input[name=tenant_username]').val($('input[name=owner_username]').val());
			} else {
				$('input[name=tenant_name]').val('');
				$('input[name=tenant_contact]').val('');
				$('input[name=tenant_email]').val('');
				$('input[name=tenant_username]').val('');
			}
		});

		$("#tl-add").off('submit').on('submit', function(e) {
			e.preventDefault();
			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				data: $(this).serialize(),
				dataType: 'JSON',
				beforeSend: function() {},
				success: function(data) {
					if (data.success == 1) {
						show_success_modal($('input[name=redirect]').val());
					}
				},
				complete: function() {

				},
				error: function(jqXHR, textStatus, errorThrown) {

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


		$(".btn-cancel").off('click').on('click', function() {
			Swal.fire({
				text: "This information will be deleted once you exit, are you sure you want to exit?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Yes',
			}).then((result) => {
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed) {
					window.location.href = '<?php echo WEB_ROOT; ?>/tenant/tenant-list?submenuid=tenant_list';
				}
			})
			// window.location.href = '<?php echo WEB_ROOT; ?>/property-management/pm';
		});

		$("input[id=parent_location]").autocomplete({
			autoSelect: true,
			autoFocus: true,
			search: function(event, ui) {
				$('.spinner').show();
			},
			response: function(event, ui) {
				$('.spinner').hide();
			},
			source: function(request, response) {
				$.ajax({
					url: '<?= WEB_ROOT; ?>/location/search?display=plain',
					dataType: "json",
					type: 'post',
					data: {
						term: request.term,
					},
					success: function(data) {
						response(data);
					}
				});
			},
			minLength: 2,
			select: function(event, ui) {

				$(event.target).prev().val(ui.item.value);
				$(event.target).val(ui.item.label);

				return false;
			},
			change: function(event, ui) {
				if (ui.item == null) {
					$(event.target).prev('input').val(0);
				}
			}
		});

		$("select[name=location_type]").on('change', function() {
			if ($(this).val().toLowerCase() == 'property') {
				$(".location-container").addClass('d-none');
				$("input[name=parent_location]").val('');
				$("#parent_location_id").val(0);
			} else {
				$(".location-container").removeClass('d-none');
			}
		});

		$('#add_tenant').submit(function(e) {
			e.preventDefault();
			console.log(new FormData($(this)[0]));
			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				dataType: 'JSON',
				data: new FormData($(this)[0]),
				cache: false,
				contentType: false,
				processData: false,
				success: function(data) {
					if (data.success == 1) {
						location.reload();
					}
				},
				complete: function() {

				},
				error: function(jqXHR, textStatus, errorThrown) {

				}
			});

		});
	});
</script>