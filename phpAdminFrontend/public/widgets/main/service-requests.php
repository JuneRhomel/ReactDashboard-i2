<?php






// $result =  $ots->execute('main', 'get-allsr', ['table' => 'vw_workpermit']);
// $allsr = json_decode($result);

$result =   $ots->execute('main', 'get-allsr', ['limit' => '4']);
$allsr = json_decode($result);
// var_dump($allsr);

$result =  $ots->execute('main', 'get-list', ['table' => 'vw_workpermit']);
$workpermit = json_decode($result);
// var_dump($workpermit);


?>

<div class="news-announce w-100  bg-theme">
	<div class="top-news">
		<div>
			<h1 class="dash-heading">Service Requests</h1>
		</div>
		<!-- <div class="see-more">
			<a href="<?= WEB_ROOT . '/workpermit/' ?>">See more</a>
			<span class="material-icons">
				arrow_forward
			</span>
		</div> -->
	</div>
	<?php if ($allsr) { ?>
		<div class="list">
			<?php foreach ($allsr as $key => $value) : ?>
				<?php

				$result =  $ots->execute('module', 'get-listnew', ['table' => 'work_details', 'condition' => 'id="' . $value->work_details_id . '"']);
				$work_detail = json_decode($result);
				?>
				<a href="<?= WEB_ROOT . "/" . $value->module . '/view/' . $value->enc_id ?>" class="dash-card sr-card-list w-100">
					<div class="">
						<b class="highlight px-3 ml-auto"><?= $value->category ?></b>
					</div>
					<div class="d-flex w-100 justify-content-between ">
						<div>
							<div class="title">
								<h3 class="m-0"><?= $value->location_name ?></h3>

								<?php
								if ($value->status === "Open" || $value->status === "Approved") {
									echo '<b class="open">' . $value->status . '</b>';
								} else if ($value->status === "Closed" || $value->status === "Denied") {
									echo '<b class="close">' . $value->status . '</b>';
								} else {
									echo '<b class="ongoing">' . $value->status . '</b>';
								}
								?>

							</div>
							<div>
								<p class="m-0"><?= $value->fullname ?></p>
							</div>
						</div>
						<div class="d-flex  align-items-center  gap-2">
							<div>
								<h3 class="m-0">Request #<?= $value->id ?></h3>
								<p class="m-0"><?= $value->date_upload ?></p>
							</div>
							<div <?php if ($value->status === "Closed" || $value->status === "Denied") {
										echo 'class="closed-arrow"';
									} ?>>
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
									<path d="M11.231 4.56667L12.191 5.52667L8.93771 8.78L6.74438 6.58667C6.48438 6.32667 6.06437 6.32667 5.80438 6.58667L1.80437 10.5933C1.54438 10.8533 1.54438 11.2733 1.80437 11.5333C2.06437 11.7933 2.48437 11.7933 2.74437 11.5333L6.27104 8L8.46437 10.1933C8.72437 10.4533 9.14437 10.4533 9.40437 10.1933L13.131 6.47333L14.091 7.43333C14.2977 7.64 14.6577 7.49333 14.6577 7.2V4.33333C14.6644 4.14667 14.5177 4 14.331 4H11.471C11.171 4 11.0244 4.36 11.231 4.56667Z" <?php
																																																																																																																													if ($value->status === "Open" || $value->status === "Approved") {
																																																																																																																														echo "fill='#3BBB7F'";
																																																																																																																													} else if ($value->status === "Closed" || $value->status === "Denied") {
																																																																																																																														echo "fill='#FF6B6B'";
																																																																																																																													} else {
																																																																																																																														echo "fill='#fff175'";
																																																																																																																													}
																																																																																																																													?> />
								</svg>
							</div>

						</div>
					</div>
				</a>

			<?php endforeach ?>
		</div>
	<?php } else { ?>
		<div class="w-100 h-75 d-flex justify-content-center align-items-center">
			<span>No Service Requests </span>

		</div>
	<?php } ?>



</div>
<script>
	// const currentDate = new Date();

	// // Get the month, year, and day
	// const monthLong = currentDate.toLocaleString('default', {
	// 	month: 'long'
	// });
	// const year = currentDate.getFullYear();
	// const day = currentDate.getDate();

	// // Set the innerHTML of the element with ID "month-year"
	// document.getElementById("month-day-year").innerHTML = `${monthLong} ${day}, ${year}`;
</script>