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
    
<div class="d-flex justify-content-center overflow-auto">
    <div class="mt-3 text-center kpi-indicators" style="height:auto; max-width:173px">
        <canvas id="contracts"></canvas>
        <p>
        <?php   
            $data = [
                'kpi_type'=>'contracts_permit'
            ];
            $result = $ots->execute('property-management','get-kpi-count',$data);//Per month and all electrical
            $result = json_decode($result,true);

            if($result['data']['count'] != 0){
                $cp_data = ($result['data']['count'] / $result['data']['r_count']) * 100; //get percentage
                $cp_percent = 100 - $cp_data;

                echo number_format($cp_percent, 2, '.', '').'%';
            }else{
                $cp_data = 0;
                $cp_percent = 100;

                echo '100%';
            }
        ?>
        </p>
        <label class="text-required mt-4 kpi-text" style="font-size: 15px">Contracts</label>
    </div>
    <div class="mt-3 text-center kpi-indicators" style="height:auto; max-width:173px">
        <canvas id="operational-expenditure"></canvas>
        <p>
        <?php   
            $data = [
                'kpi_type'=>'contracts_permit'
            ];
            $result = $ots->execute('property-management','get-kpi-count',$data);//Per month and all electrical
            $result = json_decode($result,true);

            if($result['data']['count'] != 0){
                $op_data = ($result['data']['count'] / $result['data']['r_count']) * 100; //get percentage
                $op_percent = 100 - $cp_data;

                echo number_format($op_percent, 2, '.', '').'%';
            }else{
                $op_data = 0;
                $op_percent = 100;

                echo '100%';
            }
        ?>
        </p>
        <label class="text-required mt-4 kpi-text" style="font-size: 15px">Operational Expenditures</label>
    </div>
    <div class="mt-3 text-center kpi-indicators" style="height:auto; max-width:173px">
        <canvas id="legal-regulatory"></canvas>
        <p>
        <?php   
            $data = [
                'kpi_type'=>'contracts_permit'
            ];
            $result = $ots->execute('property-management','get-kpi-count',$data);//Per month and all electrical
            $result = json_decode($result,true);

            if($result['data']['count'] != 0){
                $lr_data = ($result['data']['count'] / $result['data']['r_count']) * 100; //get percentage
                $lr_percent = 100 - $lr_data;

                echo number_format($lr_percent, 2, '.', '').'%';
            }else{
                $lr_data = 0;
                $lr_percent = 100;

                echo '100%';
            }
        ?>
        </p>
        <label class="text-required mt-4 kpi-text" style="font-size: 15px">Legal and Regulatory</label>
    </div>
</div>

<script>

	var ctx = document.getElementById("contracts");
    var contracts = new Chart(ctx, {
        type: 'doughnut',
        data: {
            // labels: ["FAILED"],
            datasets: [{
                label: 'FAILED',
                data: [<?= $cp_percent;?>, <?= $cp_data;?>],
                backgroundColor: [
                    <?php if($cp_percent >= 95.00):?>
                        '#19AF91'
                    <?php elseif( $cp_percent >= 90.00 && $cp_percent <= 94.99):?>
                        '#fff385'
                    <?php elseif($cp_percent <= 89.99):?>
                        '#FF0000'
                    <?php endif?>
                ],
                borderColor: [
                    <?php if($cp_percent >= 95.00):?>
                        '#19AF91'
                    <?php elseif( $cp_percent >= 90.00 && $cp_percent <= 94.99):?>
                        '#fff385'
                    <?php elseif($cp_percent <= 89.99):?>
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

	var ctx = document.getElementById("operational-expenditure");
    var operationalExpenditure = new Chart(ctx, {
        type: 'doughnut',
        data: {
            // labels: ["Green"],
            datasets: [{
                label: 'PASSED',
                data:  [<?= $op_percent;?>, <?= $op_data;?>],
                backgroundColor: [
                    <?php if($op_percent >= 95.00):?>
                        '#19AF91'
                    <?php elseif( $op_percent >= 90.00 && $op_percent <= 94.99):?>
                        '#fff385'
                    <?php elseif($op_percent <= 89.99):?>
                        '#FF0000'
                    <?php endif?>
                ],
                borderColor: [
                    <?php if($op_percent >= 95.00):?>
                        '#19AF91'
                    <?php elseif( $op_percent >= 90.00 && $op_percent <= 94.99):?>
                        '#fff385'
                    <?php elseif($op_percent <= 89.99):?>
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


	var ctx = document.getElementById("legal-regulatory");
    var legalRegulatory = new Chart(ctx, {
        type: 'doughnut',
        data: {
            // labels: ['PASSED'],
            datasets: [{
                label: 'FAILED',
                data: [<?= $lr_percent;?>, <?= $lr_data;?>],
                backgroundColor: [
                    <?php if($lr_percent >= 95.00):?>
                        '#19AF91'
                    <?php elseif( $lr_percent >= 90.00 && $lr_percent <= 94.99):?>
                        '#fff385'
                    <?php elseif($lr_percent <= 89.99):?>
                        '#FF0000'
                    <?php endif?>
                ],
                borderColor: [
                    <?php if($lr_percent >= 95.00):?>
                        '#19AF91'
                    <?php elseif( $lr_percent >= 90.00 && $lr_percent <= 94.99):?>
                        '#fff385'
                    <?php elseif($lr_percent <= 89.99):?>
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
