<?php
$units = json_decode($ots->execute('billing','generate',['type'=>$args[0]]),true);
?>
<table class="table">
	<thead>
		<tr>
			<th>Unit</th>
			<th>Resident</th>
			<th>Association Dues</th>
			<th>Unpaid Balance</th>
			<th>Interest (1%)</th>
			<th>Amount Due</th>
			<th>Rate</th>
		</tr>
	</thead>
<?php foreach($units as $unit):?>
	<tr>
		<td><?php echo $unit['location_name'];?></td>
		<td><?php echo $unit['tenant_name'];?></td>
		<td><?php echo $unit['asso_dues'];?></td>
		<td><?php echo $unit['unpaid_balance'];?></td>
		<td><?php echo $unit['interest'];?></td>
		<td><?php echo $unit['amount'];?></td>
		<td><?php echo $unit['info'];?></td>
	</tr>
<?php endforeach;?>
</table>