<div class="dashboard-content" style="color:#34495E;font-size:2em;text-align:center">
        <!-- <a href="/tenant/turnovers?submenuid=turnover"><?=number_format($turnovers['cnt'],0);?></a> -->
</div>
<div class="row mb-4">
    <div class="col-6 dashboard-footer" style="color:#34495E;text-align:left"><span class="fa fa-dashboard"></span> <label class="text-required" style="font-size: 20px;">KPI Indicator</label></div>
    <div class="col-6">
        <div class="d-flex align-items-end flex-column">
            <div class="">
                <span class="text-required"> <i class="bi bi-circle-fill" style="color:#19AF91"></i>  PASSED</span>
            </div>
            <div class="p-1"> 
                <span class="text-required"> <i class="bi bi-circle-fill" style="color:#FF0000"></i>  FAILED</span>
            </div>
        </div>
    </div> 
</div>

   
<div class="d-flex justify-content-center overflow-auto" style="position: relative;margin:auto;">
    <div class="mt-3 text-center kpi-indicators" style="height:auto; max-width:173px">
        <canvas id="service-request"></canvas>
        <p>
            <?php   
                $data = [
                    'kpi_type'=>'service_request'
                ];
                $result = $ots->execute('property-management','get-kpi-count',$data);//Per month and all electrical
                $result = json_decode($result,true);

                if($result['data']['count'] != 0){
                    $sr_data = ($result['data']['count'] / $result['data']['r_count']) * 100; //get percentage
                    $sr_percent = 100 - $sr_data;

                    echo number_format($sr_percent, 2, '.', '').'%';
                }else{
                    $sr_data = 0;
                    $sr_percent = 100;

                    echo '100%';
                }
            ?>
        </p>

        <label class="text-required mt-4 kpi-text" style="font-size: 15px">Service Request</label>
    </div>
    <div class="mt-3 text-center kpi-indicators" style="height:auto; max-width:173px">
        <canvas id="equipment-availability"></canvas>
        <p>
            <?php   
                $data = [
                    'kpi_type'=>'equipments'
                ];
                $result = $ots->execute('property-management','get-kpi-count',$data);//Per month and all electrical
                $result = json_decode($result,true);

                if($result['data']['count'] != 0){
                    $eq_data = ($result['data']['count'] / $result['data']['r_count']) * 100; //get percentage
                    $eq_percent = 100 - $eq_data;

                    echo number_format($eq_percent, 2, '.', '').'%';
                }else{
                    $eq_data = 0;
                    $eq_percent = 100;

                    echo '100%';
                }
            ?>
        </p>

        <label class="text-required mt-4 kpi-text" style="font-size: 15px">Equipment Availability</label>
    </div>
    <div class="mt-3 text-center kpi-indicators" style="height:auto; max-width:173px">
        <canvas id="collections-efficiency"></canvas>
        <p>
            <?php   
                $data = [
                    'kpi_type'=>'bills'
                ];
                $result = $ots->execute('property-management','get-kpi-count',$data);//Per month and all electrical
                $result = json_decode($result,true);

                if($result['data']['count'] != 0){
                    $bills_data = ($result['data']['count'] / $result['data']['r_count']) * 100; //get percentage
                    $bills_percent = 100 - $bills_data;

                    echo number_format($bills_percent, 2, '.', '').'%';
                }else{
                    $bills_data = 0;
                    $bills_percent = 100;

                    echo '100%';
                }
            ?>
        </p>

        <label class="text-required mt-4 kpi-text" style="font-size: 15px">Collections Efficiency</label>
    </div>
</div>

<script>
var ctx = document.getElementById("service-request");
    var serviceRequest = new Chart(ctx, {
        type: 'doughnut',
        data: {
            // labels: ["PASSED"],
            datasets: [{
                label: 'PASSED',
                data:  [<?= $sr_percent;?>, <?= $sr_data;?>],
                backgroundColor: [
                    <?php if($sr_percent >= 95.00):?>
                        '#19AF91'
                    <?php elseif( $sr_percent >= 90.00 && $sr_percent <= 94.99):?>
                        '#fff385'
                    <?php elseif($sr_percent <= 89.99):?>
                        '#FF0000'
                    <?php endif?>
                ],
                borderColor: [
                    <?php if($sr_percent >= 95.00):?>
                        '#19AF91'
                    <?php elseif( $sr_percent >= 90.00 && $sr_percent <= 94.99):?>
                        '#fff385'
                    <?php elseif($sr_percent <= 89.99):?>
                        '#FF0000'
                    <?php endif?>
                ],
                borderWidth: 1
            }]

        },
        options: {
            rotation: 1 * Math.PI,
            circumference: 1 * Math.PI,
            legend: {
                display: true
            },
            tooltip: {
                enabled: false
            },
            cutoutPercentage: 85
        }
    });

	var ctx = document.getElementById("equipment-availability");
    var serviceRequest = new Chart(ctx, {
        type: 'doughnut',
        data: {
            // labels: ["PASSED"],
            datasets: [{
                label: 'FAILED',
                data:  [<?= $eq_percent;?>, <?= $eq_data;?>],
                backgroundColor: [
                    <?php if($eq_percent >= 95.00):?>
                        '#19AF91'
                    <?php elseif( $eq_percent >= 90.00 && $eq_percent <= 94.99):?>
                        '#fff385'
                    <?php elseif($eq_percent <= 89.99):?>
                        '#FF0000'
                    <?php endif?>
                ],
                borderColor: [
                    <?php if($eq_percent >= 95.00):?>
                        '#19AF91'
                    <?php elseif( $eq_percent >= 90.00 && $eq_percent <= 94.99):?>
                        '#fff385'
                    <?php elseif($eq_percent <= 89.99):?>
                        '#FF0000'
                    <?php endif?>
                ],
                borderWidth: 1
            }]

        },
        options: {
            rotation: 1 * Math.PI,
            circumference: 1 * Math.PI,
            legend: {
                display: true
            },
            tooltip: {
                enabled: false
            },
            cutoutPercentage: 85
        }
    });


	var ctx = document.getElementById("collections-efficiency");
    var collectionsEfficiency = new Chart(ctx, {
        type: 'doughnut',
        data: {
            // labels: ["FAILED"],
            datasets: [{
                label: 'FAILED',
                data: [<?= $bills_percent;?>, <?= $bills_data;?>],
                backgroundColor: [
                    <?php if($bills_percent >= 95.00):?>
                        '#19AF91'
                    <?php elseif( $bills_percent >= 90.00 && $bills_percent <= 94.99):?>
                        '#fff385'
                    <?php elseif($bills_percent <= 89.99):?>
                        '#FF0000'
                    <?php endif?>
                ],
                borderColor: [
                    <?php if($bills_percent >= 95.00):?>
                        '#19AF91'
                    <?php elseif( $bills_percent >= 90.00 && $bills_percent <= 94.99):?>
                        '#fff385'
                    <?php elseif($bills_percent <= 89.99):?>
                        '#FF0000'
                    <?php endif?>
                ],
                borderWidth: 1
            }]

        },
        options: {
            rotation: 1 * Math.PI,
            circumference: 1 * Math.PI,
            legend: {
                display: true
            },
            tooltip: {
                enabled: false
            },
            cutoutPercentage: 85
        }
    });

	

</script>
