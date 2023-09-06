<?php
$equipment = null;
if(count($args))
{
	$equipment_result = $ots->execute('equipment','get-equipment',['equipmentid'=>$args[0]]);
	$equipment = json_decode($equipment_result,true);

	$equipment_types_result =  $ots->execute('equipment','get-equipment-types');
	$equipment_types = json_decode($equipment_types_result);

	// $equipment_uses_result =  $ots->execute('equipment','get-equipment-use');
	// $equipment_uses = json_decode($equipment_uses_result);

	// $equipment_statuses_result =  $ots->execute('equipment','get-equipment-statuses');
	// $equipment_statuses = json_decode($equipment_statuses_result);
}

// $equipment_tabs = [
// 	'PM Tickets','CM Tickets'
// ];

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
