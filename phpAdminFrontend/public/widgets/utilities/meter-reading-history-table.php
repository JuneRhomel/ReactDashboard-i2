<?php 

$_POST['month']= number_format($_POST['month'],0);
$month_selected=$_POST['month'];
if($_POST['utility_type'] == 'electrical' ){
$utility_type = 'Electricity';
}else{
$utility_type = ucfirst($_POST['utility_type']);
}

$data = [
    'view'=> 'view_meters',
    'filters'=>[
        'utility_type'=>ucfirst($utility_type),
        'meter_type'=>'Submeter'
    ]
];

$meters = $ots->execute('utilities', 'get-records',$data);
$meters = json_decode($meters);

$data = [
    'utility_type'=>$utility_type,
    'month'=> ($_POST['month'] < 10)? '0'. $_POST['month'] : $_POST['month'],
    'year'=>$_POST['year'],
];
// print_r($data);
$rates = $ots->execute('utilities', 'get-billing-rates',$data);
$rates = json_decode($rates)->billing_data->rates;
?>
<input type="hidden" name='table' value= 'meter_readings'>
<input type="hidden" name='view_table' value= 'view_meter_readings'>
<input type="hidden" name='month' value= '<?= $_POST['month'] ?>'>
<input type="hidden" name='year' value= '<?= $_POST['year'] ?>'>
<table class="table table-data water-table" style="box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.2);">
    <thead class="header-design">
        <tr>
            <th >Meter Name/ID</th>
            <th >Last Reading</th>
            <th >New Reading</th>
            <th >Consumption</th>
            <th >Amount</th>
            <th >Sparklines</th>
            <th >Actions</th>
        </tr>
    </thead>
    
    
    <tbody class="table-body">     
        <?php 
        $ctr = 0;
        $total_con = 0;
        $total_amount = 0;
        foreach($meters as $meter){
            $data = [
                'meter_id' => decryptData($meter->id),
                'month'=> $_POST['month'],
                'year'=>date('Y'),
            ];
            
            $meter_reading = $ots->execute('utilities', 'get-last-meter-readings',$data);
            $meter_reading = json_decode($meter_reading)->reading;

            $data = [
                'meter_id' => decryptData($meter->id),
                'month'=> $_POST['month'],
                'year'=>date('Y'),
            ];

            $current_reading = $ots->execute('utilities', 'get-current-reading',$data);
            $current_reading = json_decode($current_reading);
            // print_r($current_reading);

            $data = [
                'meter_id' => decryptData($meter->id),
                'month'=> $_POST['month'],
                'year'=>date('Y'),
            ];

            $current_reading = $ots->execute('utilities', 'get-current-reading',$data);
            $current_reading = json_decode($current_reading);
            if($_POST['utility_type'] == 'electrical' )
                $utility_type = 'Electricity';
            else
                $utility_type = ucfirst($_POST['utility_type']);

            
            $data = [
                'utility_type'=>$utility_type,
                'month'=> ($_POST['month'] < 10)? '0'. $_POST['month'] : $_POST['month'],
                'year'=>date('Y'),
            ];
            // print_r($data);
            $rates = $ots->execute('utilities', 'get-billing-rates',$data);
            $rates = json_decode($rates)->billing_data->rates;
            var_dump($rates);
            $rates = number_format($rates,2);

            $amount = ($current_reading->reading - $meter_reading) * $rates;
            
            
        ?>
        
            <tr class="tr-data">
                <td>
                    <input type="hidden"  class='utility_type' name="utility_type[]" value="<?= ucfirst($_POST['utility_type'])?>">
                    <input type="hidden" class='id' name="id[]" value="<?= decryptData($meter->id)?>">
                    <?= $meter->meter_name?>
                </td>
                <td>
                    <input type="hidden" class='last-reading' id="meter_last_reading_<?= $ctr ?>" name="last_readiing[]" value='<?= $meter_reading?>'>
                    <span><?= $meter_reading?></span>
                </td>
                <td>
                    <?= $current_reading->reading ?>
                    <span class='er'></span>
                </td>
                <td>
                    <input type="hidden" class='consumption_<?= $ctr ?>'  value='<?= ($current_reading->reading - $meter_reading)?>' name='consumption[]'>
                    <span class='span-consumption_<?= $ctr ?>'><?= (($current_reading->reading - $meter_reading) > 0 )?$current_reading->reading - $meter_reading : ''?></span>
                </td>
                <td>
                    <span class='amount'><?= number_format($amount,2)?></span> 
                </td>
                <td style='padding:5px'>
                <canvas id="reading-chart-<?= $ctr ?>" style="width:100%;max-width:700px;min-width:200px;max-height:50px"></canvas>
                </td>
                <td>
                    <a class="btn btn-sm text-primary btn-delete" onclick="show_delete_modal(this)" rec_id="<?php echo decryptData($meter->id); ?>" title="Delete ID <?php echo decryptData($meter->id); ?>" del_url="<?=WEB_ROOT?>/tenant/delete-record/<?php echo decryptData($meter->id); ?>?display=plain&table=meters&view_table=view_meters&redirect=/utilities/meter-reading-history?submenuid=meter_reading_history"><i class="bi bi-trash-fill"></i></a>
                </td>
            </tr>	
            <?php
            $ctr++;
        }
        ?>
    </tbody>
</table>

<?php 
$ctr = 0;
foreach($meters as $meter){
    // p_r($meter);
    $meter_id = decryptData($meter->id);
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
        // array_push($consumption_array,[
        //     'month'=>$reading->month,
        //     'consumption'=>$consumption
        // ]);
        $consumption_array[$reading->month] = $consumption;
        
            
        $m++;

        
    }
    // p_r($consumption_array);
    $consumption_string = '';
    for($x= 1; $x <=12 ; $x++){
        $consumption_string .= ($consumption_array[$x] ?? 0) . "," ;
    }
    // echo $consumption_string;
    
    
    ?>
    <script>
        var xValues_<?= $ctr ?> = [<?= $consumption_string ?>];
        var yValues_<?= $ctr ?> = [<?= $consumption_string ?>];

        new Chart("reading-chart-<?= $ctr?>", {
            type: "line",
            data: {
                labels: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sept',
                    'Oct',
                    'Nov',
                    'Dec',
                ],
                datasets: [{
                // backgroundColor: "rgba(0,0,0,1.0)",
                    borderColor: "rgb(0, 105, 197)",
                    data: yValues_<?=  $ctr?>
                }]
            },
            options: {
                legend: {display: false},
                scales: {
                    
                },
                scales: {
                    yAxes: [{
                        display:false
                    }],
                    xAxes: [{
                        display:false
                    }]
			    },
                
            }
        });
    </script>
    <?php
$ctr++;
}
?>