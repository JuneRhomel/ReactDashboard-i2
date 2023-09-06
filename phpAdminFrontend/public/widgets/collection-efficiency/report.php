<?php
$result =  $ots->execute('module','generate-report',$_POST);
$records = json_decode($result);

foreach ($records->data as $record) {
    $val[$record->month_of] = $record;
}
//vdump($val);
if (!$records->data) {
    echo "<h5>No record found.</h5>";
} else {
?>
<table class="table table-bordered table-striped border-table bg-white">
    <tr>
        <th>Month</th>
        <th>Collectibles</th>
        <th>Collected Amount</th>
        <th>Unpaid Amount</th>
        <th>Collection Efficiency</th>
    </tr>
    <?php 
    $ttl_collectibles = $ttl_collected_amount = $ttl_unpaid_amount = $ttl_efficiency = 0;
    for ($i=1; $i<=12; $i++) { 
        $collectibles = $collected_amount = $unpaid_amount = $efficiency = "";
        if ($val[$i]) {
            $collectibles = $val[$i]->collectibles;
            $collected_amount = $val[$i]->collectibles-$val[$i]->unpaid_amount;
            $unpaid_amount = $val[$i]->unpaid_amount;
            $efficiency = number_format(100 - ($val[$i]->unpaid_amount/$val[$i]->collectibles) * 100 ,2)." %";
            $ttl_collectibles += $collectibles;
            $ttl_collected_amount += $collected_amount;
            $ttl_unpaid_amount += $unpaid_amount;
        }
    ?>
    <tr>
        <td><?=date("F",strtotime("2023-$i-01"))?></td>
        <td><?=formatNumber($collectibles)?></td>
        <td><?=($collected_amount==0 && $collectibles>0) ? 0 : formatNumber($collected_amount)?></td>
        <td><?=formatNumber($unpaid_amount)?></td>
        <td><?=$efficiency?></td>
    </tr>
    <?php 
    } 
    $ttl_efficiency = number_format(100 - ($ttl_unpaid_amount/$ttl_collectibles) * 100,2)." %";
    ?>
    <tr style="background-color:#e0e0e0">
        <td><b>TOTAL</b></td>
        <td><b><?=formatNumber($ttl_collectibles)?></b></td>
        <td><b><?=formatNumber($ttl_collected_amount)?></b></td>
        <td><b><?=formatNumber($ttl_unpaid_amount)?></b></td>
        <td><b><?=$ttl_efficiency?></b></td>
    </tr>
</table>
<?php } // IF RECORDS ?>