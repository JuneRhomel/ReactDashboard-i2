<?php
$location = null;
if(count($args))
{
	$location_result = $ots->execute('location','get-location',['locationid'=>$args[0]]);
	$location = json_decode($location_result,true);
	$location_types_result =  $ots->execute('location','get-location-types');
	$location_types = json_decode($location_types_result);

	$location_uses_result =  $ots->execute('location','get-location-use');
	$location_uses = json_decode($location_uses_result);

	$location_statuses_result =  $ots->execute('location','get-location-statuses');
	$location_statuses = json_decode($location_statuses_result);
}
$location_tabs = [ 'Sub Location','Turnover','Punch List','Uploaded Form','Billing' ];
$tabid = $_GET['tabid'] ?? 'sub-location';
?>

<div class="page-title"><?=$location ? $location['location_name'] : '';?></div>
<div class="bg-white p-2 rounded">
	<div class="row">
		<div class="col">
			<label><b>Name</b></label>
			<div><?=$location['location_name'];?></div>
		</div>
		<div class="col">
			<label><b>Type</b></label>
			<div><?=$location['location_type'];?></div>
		</div>
		<div class="col">
			<label><b>Floor Area</b></label>
			<div><?=$location['floor_area'];?></div>
		</div>
		<div class="col">
			<label><b>User</b></label>
			<div><?=$location['location_use'];?></div>
		</div>
		<div class="col">
			<label><b>Status</b></label>
			<div><?=$location['location_status'];?></div>
		</div>
	</div>
</div>

<div class="mt-5">
	<ul class="tabs">
		<?php foreach($location_tabs as $tab): ?>
			<li class="">
				<a class="tab-link <?=$tabid == (strtolower(str_replace(" ","-",$tab))) ? 'active' : '';?>" aria-current="page" href="<?=WEB_ROOT;?>/location/view/<?=$location['id'];?>?tabid=<?=(strtolower(str_replace(" ","-",$tab)));?>"><?=$tab;?></a>
			</li>	
		<?php endforeach;?>
	</ul>

	<?php 
	if(file_exists(__DIR__ . "/locations-{$tabid}.php"))
		include_once(__DIR__ . "/locations-{$tabid}.php");
	?>
</div>