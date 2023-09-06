<?php
$result =  $ots->execute('module','generate-report',$_POST);
$records = json_decode($result);
//vdump($records->data);
if (!$records->data) {
    echo "<h5>No record found.</h5>";
} else {
?>  
    <h4>Electricity</h4>
    <table class="table table-bordered table-striped border-table">
        <tr>
            <th>Meter Name</th>
            <th>Consumption (KwH)</th>
        </tr>
        <?php 
        $total = 0;
        foreach ($records->data as $val) { 
            if ($val->utility_type=="Electricity") {
        ?>
        <tr>
            <td><?=$val->meter_name?></td>
            <td><?=formatNumber($val->consumption)?></td>
        </tr>
        <?php 
                $total += floatval($val->consumption);
            }
        } 
        ?>
        <tr style="background-color:#e0e0e0">
            <td><b>TOTAL</b></td>
            <td><b><?=formatNumber($total)?></b></td>
        </tr>
    </table>
    <h4 class="mt-5">Water</h4>
    <table class="table table-bordered table-striped border-table">
        <tr>
            <th>Meter Name</th>
            <th>Consumption (CuM)</th>
        </tr>
        <?php 
        $total = 0;
        foreach ($records->data as $val) { 
            if ($val->utility_type=="Water") {
        ?>
        <tr>
            <td><?=$val->meter_name?></td>
            <td><?=formatNumber($val->consumption)?></td>
        </tr>
        <?php
                $total += floatval($val->consumption); 
            }
        } 
        ?>
        <tr style="background-color:#e0e0e0">
            <td><b>TOTAL</b></td>
            <td><b><?=formatNumber($total)?></b></td>
        </tr>
    </table>
<?php } // IF RECORDS ?>