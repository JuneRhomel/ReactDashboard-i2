<style>
    tr:nth-child(odd) {
        background-color: #F6F6F6;
    }

    tr:nth-child(even) {
        background-color: #BCE0FD;
    }

    .table thead>tr>th {
        vertical-align: bottom;
        border-bottom: 2px solid hsl(0, 0%, 87%);
    }

    .table thead>tr>th,
    .table tbody>tr>th,
    .table tfoot>tr>th,
    .table thead>tr>td,
    .table tbody>tr>td,
    .table tfoot>tr>td {
        padding: 8px;
        line-height: 1.428571429;
        vertical-align: top;
        border-top: 1px solid #ddd
    }

    .table thead>tr>th {
        background: #6098E2 !important;
    }
</style>
<?php
$result = $ots->execute('main', 'get-consumption'); //Per month
$consumption = json_decode($result);
// var_dump($consumption);
?>

<div class="dashboard-footer" style="color:#34495E;text-align:left"><span class="fa fa-dashboard"></span> <label class="text-required" style="font-size: 20px;">Electricity Monitoring</label></div>
<div class="d-flex row mt-3 justify-content-start flex-wrap overflow-auto" style="width: 100%">
    <div class="col-6 col-xl-6 col-md-6">
        <table class="table table-bordered">
            <thead class="" style="">
                <tr>
                    <th>Month</th>
                    <th><?= date('Y'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consumption as $item) {

                ?>
                    <tr>
                        <td><?= $item->MonthName ?></td>
                        <td><?= number_format($item->ElectricityConsumption , 2, '.', ','); ?></td>
                    </tr>
                <?php

                } ?>

            </tbody>
        </table>
    </div>
    <div class="col-1">
        <img class="mt-5" src="<?php echo WEB_ROOT; ?>/images/dashboard/consumption.png" width="15">
    </div>

    <div class="text-center col-5">
        <div style="width:280px">
            <canvas id="electricity-bar-chart" width="100%" height="100%"></canvas>
        </div>
    </div>
</div>

<script>
    var ctx = document.getElementById('electricity-bar-chart').getContext('2d');
    var electricitybarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                <?php foreach ($consumption as $item) { ?> "<?= $item->MonthName ?>",
                <?php }  ?>
            ],
            datasets: [{
                label: "<?= date('Y') ?>",
                data: [
                    <?php foreach ($consumption as $item) { ?>
                        <?= $item->ElectricityConsumption . ',' ?>
                    <?php } ?>
                ],
                backgroundColor: 'rgba(25, 175, 145)'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>