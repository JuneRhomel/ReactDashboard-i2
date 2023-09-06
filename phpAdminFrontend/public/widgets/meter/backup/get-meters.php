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
			<input name="reading[<?=$record->id?>]" data-meter_id="<?=$record->id?>" data-multiplier="<?=$record->multiplier ?? 1;?>" data-lastreading="<?=$record->last_reading ?? 0;?>" data-meter_type="<?=$record->meter_type;?>" data-consumption="" type="text" class="form-control form-control-sm text-right meters" style="width:100px" value="">
		</td>
		<td>
			<input name="amount[<?=$record->id?>]" type="text" class="form-control form-control-sm text-right amount" style="width:100px" <?=($record->mmother_id==0) ? "" : "disabled"?> value="">
		</td>
		<!-- <td class="text-center">
			<input name="billings[<?=$record->id;?>]" type="checkbox" class="billing" value="1" <?=($checked[$record->meter_type] ?? false)  ? 'checked' : '';?>>
		</td> -->
		<!-- <td>
			<input type="file" name="files[<?=$record->id;?>]" class="files">
			<progress class="progress-bar mt-2 d-none" value="0" max="100" style="width:100%;height:5px"></progress>
		</td> -->
		<td>
			<input name="note[<?=$record->id;?>]" type="text" class="form-control note" value="">
		</td>
	</tr>
<?php
}
?>