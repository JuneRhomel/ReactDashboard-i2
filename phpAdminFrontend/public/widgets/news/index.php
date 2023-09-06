<?php

$module = "news";
$table = "news";
$view = "news";


$result = $ots->execute('news', 'getlist', ['table' => $table]);
$news = json_decode($result);

// var_dump($news);

$result = $ots->execute('form', 'get-role-access', ['table' => $table]);
$role_access = json_decode($result);

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

		<div class="d-flex justify-content-end  mb-5">
			<button id="careate" class="main-btn px-3 w-auto"><span class="material-symbols-outlined">add</span> Create New </button>
		</div>
		<div class="d-flex  gap-3">

			<?php if ($news) { ?>
			<div class="d-flex w-100 flex-column  news-container gap-2">
					<?php foreach ($news as $item) { ?>

						<div class="d-flex align-items-center gap-3">
							<div class="d-flex gap-3 bg-body  w-100 p-3 rounded-3">
								<div class="d-flex align-items-center justify-content-center " style="width: 70px;">
									<img class="w-100 h-100"  style="object-fit: cover;" src="<?= $item->thumbnail??  " "?>">
								</div>
								<div class="">
									<div class="mb-1 d-flex">
										<h6 class="text-required fw-bolder m-0"><?= $item->title ?></h6>
										<label class="text-required px-3 justify-content-center align-items-end time-calendar d-flex "><?= $item->date ?></label>
									</div>
									<div class="d-flex align-items-center h-50">
										<label class="fw-bold content"><?= $item->content ?></label>
									</div>
								</div>
							</div>

							<div>
								<a href="<?= WEB_ROOT.'/'.$table.'/form/'.$item->enc_id ?>" class="main-btn">Edit</a>
							</div>

						</div>
					<?php } ?>
				</div>
				<?php } else { ?>
					<div class="w-75 d-flex justify-content-center align-items-center m-auto text-center fs-3" style="height: 224px">No News Announcement</div>
				<?php }	?>

		</div>
</div>
<?php endif; ?>
</div>

<script>
	$('#careate').click(function() {
		var url = '<?= $WEB_ROOT ?>/news/form/';
		window.location = url;
	})
</script>