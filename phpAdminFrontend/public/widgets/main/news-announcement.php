<?php

$result = $ots->execute('news', 'getlist', ['table' => 'news','orderby' => 'id', 'limit' => '4']);
$news = json_decode($result);

// var_dump($news);

?>

<div class="news-announce w-100  bg-theme">
	<div class="top-news">
		<div>
			<h1 class="dash-heading">News & Announcement</h1>
		</div>
		<div class="see-more">
			<a href="<?= WEB_ROOT ?>/news/">See more</a>
			<span class="material-icons">
				arrow_forward
			</span>
		</div>
	</div>
	

	<?php if ($news) { ?>
		<div class="row">
			<?php foreach ($news as $item) { ?>
				<article class="col-6 mb-2 news-card dash-card w-50">
					<div class="img-news">
					<img src="<?= $item->thumbnail??  " "?>">
					</div>
					<div class="d-flex w-100 justify-content-between ">
						<div class="w-100 ">
							<div class="title d-flex justify-content-between">
								<h3 class="m-0"><?= $item->title ?></h3>
								<h3 class="m-0"><?= date("F d, Y", strtotime($item->date))  ?></h3>
							</div>
							<div>
								<p class="m-0 text-limit"><?= $item->content ?></p>
							</div>
						</div>
					</div>
				</article>
			<?php } ?>


		</div>
	<?php }	?>
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