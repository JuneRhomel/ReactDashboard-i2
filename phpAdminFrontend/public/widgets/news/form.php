<?php
$module = "news";
$table = "news";
$view = "news";

$id = $args[0];
if ($id != "") {
	$result = $ots->execute('module', 'get-record', ['id' => $id, 'view' => $view]);
	$record = json_decode($result);
}
// var_dump($record);

$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
$role_access = json_decode($result);

$result = $ots->execute('module', 'get-listnew', ['table' => 'list_residenttype', 'field' => 'residenttype']);
$list_residenttype = json_decode($result);
?>
<div class="main-container">
	<a href="<?= WEB_ROOT . '/' . $module . '/' ?>" class="back">
		<span class="material-icons">
			arrow_back
		</span>
		Back
	</a>
	<div class="mt-2 mb-4">
		<h1 class="text-black mt-3 fw-bold"><?= ($id == '') ? 'Add' : 'Edit'; ?> <?= $page_title ?></h1>
		<h1 class="text-black fw-bold mt-2">*Please fill in the required field </h1>
	</div>
	<div class="grid lg:grid-cols-1 grid-cols-1 title">
		<div class="rounded-sm">
			<form method="post" action="<?= WEB_ROOT; ?>/news/save?display=plain" id="form-main">
				<div class="row forms">
					<div>
						<div class="form-group file-box">
							<input type="file" class="form-control" name="thumbnail" id="file">
							<label for="file"><span class="material-icons">download</span> Thumbnail</label>
							<span id="file-name">No file chosen</span>
						</div>
					</div>
					<div class="d-flex gap-3">

						<div class="mt-3 w-50 ">
							<div class="form-group input-box">
								<input name="title" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record->title : '' ?>" required>
								<label>Title<b class="text-danger">*</b></label>
							</div>
						</div>
						<!-- <div class="mt-3  w-50">
							<div class="form-group input-box">
								<input name="subtitle" placeholder="Enter here" type="text" class="form-control" value="<?= ($record) ? $record->subtitle : '' ?>" required>
								<label>Subtitle<b class="text-danger">*</b></label>
							</div>
						</div> -->
					</div>
					<div class="mt-3">
						<div class="form-group input-box">
							<textarea name="content" required id="" cols="30" rows="10" class="w-100" value="<?= ($record) ? $record->content : '' ?>"><?= ($record) ? $record->content : '' ?></textarea>
							<label>Content<b class="text-danger">*</b></label>
						</div>
					</div>

					<div class=" mt-3 d-flex gap-3 justify-content-start">
						<button type="submit" class="main-submit main-btn">Submit</button>
						<button type="button" class="main-cancel btn-cancel">Cancel</button>
					</div>
					<input name="id" type="hidden" value="<?= $args[0] ?? ''; ?>">
					<input name="date" type="hidden" value="<?= $record->date ?? date('Y-m-d') ?>">
					<input name="module" type="hidden" value="<?= $module ?>">
					<input name="table" type="hidden" value="<?= $table ?>">
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {


		$('#file').on('change', function() {
			// Get the file name
			var fileName = this.files[0].name;
			// Set the file name element text to the file name
			$('#file-name').text(fileName);
		});


		$("#form-main").off('submit').on('submit', function(e) {
			e.preventDefault();
			// Function to handle image compression
			var formData = new FormData(this);
			const fileInput = $('#file').prop('files')[0];

			// Add the file input to the form data
			<?php if (!$id) { ?>
				if (fileInput) {
					formData.append('thumbnail', fileInput);

					console.log(formData)
					$.ajax({
						url: $(this).prop('action'),
						type: 'POST',
						data: formData,
						dataType: 'JSON',
						processData: false,
						contentType: false,
						beforeSend: function() {
							$("#form-main").find('.main-btn').prop('disabled', true);
						},
						success: function(data) {
							console.log(data)
							// Handle the response data
							popup({
								data: data,
								reload_time: 2000,

							})

						},
						error: function(jqXHR, textStatus, errorThrown) {
							console.log(errorThrown);
						}
					});
				} else {
					$('#file-name').css("color", "red")
					$('#file-name').text("Please upload an image.")
				}
			<?php } else { ?>
				formData.append('thumbnail', fileInput);

				console.log(formData)
				$.ajax({
					url: $(this).prop('action'),
					type: 'POST',
					data: formData,
					dataType: 'JSON',
					processData: false,
					contentType: false,
					success: function(data) {
						console.log(data)
						// Handle the response data
						popup({
							data: data,
							reload_time: 2000,
							redirect: "<?= WEB_ROOT . "/$module/" ?>"
						})

					},
					error: function(jqXHR, textStatus, errorThrown) {
						console.log(errorThrown);
					}
				});

			<?php } ?>
		});
		$(".btn-cancel").click(function() {
			location = '<?= WEB_ROOT . "/$module/" ?>';
		});
	});
</script>