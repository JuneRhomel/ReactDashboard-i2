<?php
$records = json_decode($ots->execute('billing','get-collection-list',[]),true);

?>
<div class="page-title">Billing - Overdue</div>

<div class="bg-white p-2 rounded">
<table class="table">
	<tr>
		<th>Tenant</th>
		<th>Amount</th>
		<th>Due Date</th>
	</tr>
	<?php foreach($records['data'] as $record):?>
		<tr>
			<td><?php echo $record['tenant_name'];?></td>
			<td><?php echo number_format($record['amount']);?></td>
			<td><?php echo $record['due_date'];?></td>
		</tr>
	<?php endforeach;?>
</table>
</div>