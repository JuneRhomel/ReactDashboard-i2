<?php
$records = json_decode($ots->execute('pdc','get-pdcs-uncleared',[]),true);

?>
<div class="page-title">Checks for the month</div>

<div class="bg-white p-2 rounded">
<table class="table">
	<tr>
		<th>Tenant</th>
		<th>Check #</th>
		<th>Amount</th>
		<th>Date</th>
		<th>Status</th>
	</tr>
	<?php foreach($records as $record):?>
		<tr>
			<td><?php echo $record['tenant_name'];?></td>
			<td><?php echo $record['check_number'];?></td>
			<td><?php echo number_format($record['check_amount']);?></td>
			<td><?php echo $record['check_date'];?></td>
			<td><?php echo $record['status'];?></td>
		</tr>
	<?php endforeach;?>
</table>
</div>