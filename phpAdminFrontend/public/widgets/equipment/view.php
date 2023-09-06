<?php
$equipment = null;
if(count($args))
{
	$equipment_result = $ots->execute('equipment','get-equipment',['equipmentid'=>$args[0]]);
	$equipment = json_decode($equipment_result,true);
	var_dump($equipment);

	$equipment_types_result =  $ots->execute('equipment','get-equipment-types');
	$equipment_types = json_decode($equipment_types_result);

	// $equipment_uses_result =  $ots->execute('equipment','get-equipment-use');
	// $equipment_uses = json_decode($equipment_uses_result);

	// $equipment_statuses_result =  $ots->execute('equipment','get-equipment-statuses');
	// $equipment_statuses = json_decode($equipment_statuses_result);
}

$equipment_tabs = [
	'PM Tickets','CM Tickets'
];

$tabid = $_GET['tabid'] ?? 'pm-tickets';
?>

<div class="page-title"><?php echo $equipment ? $equipment['equipment_name'] : '';?></div>
<div class="bg-white p-2 rounded">
	<div class="row">
		<div class="col">
			<label>Name</label>
			<div><?php echo $equipment['equipment_name'];?></div>
		</div>
		<div class="col">
			<label>Asset ID</label>
			<div><?php echo $equipment['asset_id'];?></div>
		</div>
		<div class="col">
			<label>Type</label>
			<div><?php echo $equipment['equipment_type'];?></div>
		</div>
		<div class="col">
			<label>Location</label>
			<div><?php echo $equipment['location_name'];?></div>
		</div>
		<div class="col">
			<label>Critical</label>
			<div><?php echo $equipment['is_critical'] == 1 ? 'Yes' : 'No';?></div>
		</div>
	</div>
</div>

<div class="mt-5">
	<ul class="tabs">
		<?php foreach($equipment_tabs as $tab):?>
			<li class="">
				<a class="tab-link <?php echo $tabid == (strtolower(str_replace(" ","-",$tab))) ? 'active' : '';?>" aria-current="page" href="<?php echo WEB_ROOT;?>/equipment/view/<?php echo $equipment['id'];?>?tabid=<?php echo (strtolower(str_replace(" ","-",$tab)));?>"><?php echo $tab;?></a>
			</li>	
		<?php endforeach;?>
	</ul>

	<?php 
	if(file_exists(__DIR__ . "/equipments-{$tabid}.php"))
		include_once(__DIR__ . "/equipments-{$tabid}.php");
	?>
</div>