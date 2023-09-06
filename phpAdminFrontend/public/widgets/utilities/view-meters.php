<?php
    $data = [
		'id'=>$args[0],
        'view'=>'view_meters'
	];
	
	$meter = $ots->execute('utilities','get-record',$data);
	$meter = json_decode($meter);


//PERMISSIONS
//get user role
$data = [	
	'view'=>'users'
];
$user = $ots->execute('property-management','get-record',$data);
$user = json_decode($user);

//check if has access
$data = [
	'role_id'=>$user->role_type,
	'table'=>'meters',
	'view'=>'role_rights'

];
$role_access = $ots->execute('form','get-role-access',$data);
$role_access = json_decode($role_access);
// var_dump($role_access);
?>

<!-- <div class="page-title float-right">View Building Personnel</div> -->


	<div class="d-flex justify-content-between mb-3">
		<a onclick="history.back()"><label class="data-title"  style="cursor: pointer;"><i class="fa-solid fa-arrow-left text-primary"></i> <?php echo $meter->meter_name;?></label></a>
		<?php if($role_access->update == true): ?>
			<a href='<?= WEB_ROOT ?>/utilities/form-edit-meter/<?= $args[0] ?>/Edit'  class='btn btn-sm btn-primary float-end btn-view-form px-5'>Edit</a>
		<?php endif; ?>
	</div>
	<table class="table table-data table-bordered property-management border-table" >
		<tr>
			<th>Meter Name</th><td><?php echo $meter->meter_name;?></td>
		</tr>
		<tr>
			<th>Utility Type</th><td><?php echo $meter->utility_type;?></td>
		</tr>
		<tr>
			<th>Meter Type</th><td><?php echo $meter->meter_type;?></td>
		</tr>
		<tr>
			<th>Serial Number</th><td><?php echo $meter->serial_number;?></td>
		</tr>
		<tr>
			<th>Meter Location</th><td><?php echo $meter->meter_location;?></td>
		</tr>
		<tr>
			<th>Unit</th><td><?php echo $meter->unit;?></td>
		</tr>
		<tr>
			<th>Use</th><td><?php echo $meter->meter_use;?></td>
		</tr>
		<tr>
			<th>Tenant</th><td><?php echo $meter->owner_name;?></td>
		</tr>
		<tr>
			<th>Tenant</th><td><?php echo $meter->tenant_type;?></td>
		</tr>
		<tr>
			<th>Below Threshold</th><td><?php echo $meter->below_threshold;?></td>
		</tr>
		<tr>
			<th>Max Threshold</th><td><?php echo $meter->max_threshold;?></td>
		</tr>
		<tr>
			<th>Mulitiplier</th><td><?php echo $meter->multiplier;?></td>
		</tr>
		
	</table>
	<br>
	<canvas id="reading-chart" style="position: relative; height:25vh; width:80vw"></canvas>
	<br>
	<h3>History</h3>
	<br>
	<table class="table table-data table-bordered property-management border-table" >
		<tr>
			<th>Month</th>
			<th>Reading</th>
			<th>Consumption</th>
			<th>Note</th>
			<th>Billing</th>
			<th>Picture</th>
		</tr>
		<?php 
		$meter_id =$meter->id;
		$consumption_array = [];
		$m = 1;
		foreach($meter->meter_readings as $reading){
			// p_r($reading);
			$data = [
				'meter_id'=>$meter_id,
				'month'=>$reading->month,
				'year'=>date('Y')
			];
			$result = $ots->execute('utilities','get-last-meter-readings',$data);
			$result = json_decode($result);
	
			$last_reading = $result->reading;
			$current_reading = $reading->reading;
			$consumption = $current_reading - $last_reading;
			if($last_reading == null){
				$consumption = 0;
			}

			$monthNum  = $reading->month;
			$dateObj   = DateTime::createFromFormat('!m', $monthNum);
			$monthName = $dateObj->format('F'); 

			
			?>
			<tr>
				<td><?= $monthName ?></td>
				<td><?= $current_reading?></td>
				<td><?= $consumption?></td>
				<td><?= $note ?? ''?></td>
				<td><?= $note ?? ''?></td>
				<td><?= $note ?? ''?></td>
			</tr>
			<?php
			$consumption_array[$reading->month] = $consumption;
			
				
			$m++;
		}
		// p_r($consumption_array);
		$consumption_string = '';
		for($x= 1; $x <=12 ; $x++){
			$consumption_string .= ($consumption_array[$x] ?? 0) . "," ;
		}
		$consumption_string;
		?>
	</table>
	<div class="d-flex justify-content-between my-4">
		<span style='font-size:20px'>Attachments</span>
		<?php if($role_access->upload == true): ?>
			<button class='btn btn-lg btn-primary px-5' onclick="show_modal_upload(this)" update-table='meter_updates' reference-table='meter' reference-id='<?php echo $args[0]; ?>' id='<?php echo $args[0]; ?>'>Upload</button>
		<?php endif; ?>
	</div>
<?php

$data = [
	'reference_table' => 'meter',
	'reference_id' => $args['0']
];
$attachments = $ots->execute('files','get-attachments',$data);
$attachments = json_decode($attachments);

?>
<table class="table table-data table-bordered property-management border-table" >
		<tr>
			<th>Create By</th>
			<th>Document</th>
			<th>Created By</th>
		</tr>
		<?php 

			foreach($attachments as $attachment){
				?>
				<tr>
					<td><?= $attachment->created_by_full_name?></td>
					<td><a href='<?= $attachment->attachment_url ?>' ><?= $attachment->filename ?></a></td>
					<td><?= date('Y-m-d', $attachment->created_on);?></td>
					
				</tr>
				<?php
			}
		?>
	</table>
	<!-- <?= 'GRACE' ?> -->

	<div class="btn-group-buttons pull-right">
		<div class="d-flex flex-row-reverse" style="padding: 5px;">
			<button type="submit" class="btn btn-dark btn-primary btn-cancel px-5">Back</button>
		</div>
	</div>
<script>

	$(".btn-cancel").on('click',function(){
		//loadPage('<?=WEB_ROOT;?>/location');
		window.location.href = '<?=WEB_ROOT;?>/utilities/meter-list?submenuid=meter_list';
	});

	var xValues= [<?= $consumption_string ?>];
	var yValues= [<?= $consumption_string ?>];
 	var unit_of_measurement = '<?= $meter->unit_of_measurement?>'
	chart = new Chart("reading-chart", {
		type: "bar",
		data: {
			labels: [
				'Jan <?= date('Y')?>',
				'Feb <?= date('Y')?>',
				'Mar <?= date('Y')?>',
				'Apr <?= date('Y')?>',
				'May <?= date('Y')?>',
				'Jun <?= date('Y')?>',
				'Jul <?= date('Y')?>',
				'Aug <?= date('Y')?>' ,
				'Sep <?= date('Y')?>',
				'Oct <?= date('Y')?>',
				'Nov <?= date('Y')?>',
				'Dec <?= date('Y')?>',
			],
			datasets: [{
			// backgroundColor: "rgba(0,0,0,1.0)",
				label : unit_of_measurement,
				
				backgroundColor: "rgb(0, 105, 197)",
				data: yValues,
			}]
		},
		options: {
			legend: {display: false},
			scales: {
				yAxes: [{
					fontSize:100
					
				}],
				xAxes: [{
					fontSize:20
				}]
			},
			
		}
	}).chart.canvas.parentNode.style.width = '128px';
	// canvas.parentNode.style.height = '128px';
	// chart.canvas.parentNode.style.height = '128px';
	
</script>

	