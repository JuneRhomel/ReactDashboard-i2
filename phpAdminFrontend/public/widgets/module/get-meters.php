<?php
header('Content-Type: application/json; charset=utf-8');
$records = $ots->execute('meter','get-meters',$_POST);
echo $records;
$jrecords = json_decode($records);

//vdump($jrecords);
foreach ($jrecords as $record) {
?>
	<tr>
		<td class="text-nowrap"><?=$record->meter_name?></td>
		<td>
			<div>Date: <?=$record->last_reading_date?></div>
			<div>Reading: <?=$record->last_reading?></div>
			<div>Consumption: <?=$record->last_consumption?></div>
		</td>
		<td>
			<input name="meters[<?=$meter->id?>]" data-meterid="<?=$meter->id?>" data-multiplier="<?=$meter->multiplier ?? 1;?>" data-lastreading="<?=$meter->last_reading ?? 0;?>" data-metertype="<?=$meter->meter_type;?>" type="text" class="form-control form-control-sm text-right meters" style="width:100px" value="100">
			<div class="new-consumption-label"></div>
			<input type="hidden" name="consumption[<?=$meter->id?>]" class="new-consumption" style="width:50px" value="10">
		</td>
		<td>
			<input name="amount[<?=$meter->id?>]" type="text" class="form-control form-control-sm text-right amount" style="width:100px" <?=($meter->mmother_id==0) ? "" : "disabled"?> value="1000">
		</td>
		<!-- <td class="text-center">
			<input name="billings[<?=$meter->id;?>]" type="checkbox" class="billing" value="1" <?=($checked[$meter->meter_type] ?? false)  ? 'checked' : '';?>>
		</td> -->
		<td>
			<input type="file" name="files[<?=$meter->id;?>]" class="files">
			<progress class="progress-bar mt-2 d-none" value="0" max="100" style="width:100%;height:5px"></progress>
		</td>
		<td>
			<input type="text" name="notes[<?=$meter->id;?>]" class="form-control" style="width:100%">
			<input type="hidden" name="meter_types[<?=$meter->id;?>]" value="<?=$meter->meter_type?>">
		</td>
	</tr>
<?php
}
?>