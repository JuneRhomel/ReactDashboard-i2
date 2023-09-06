<?php 
$result = $ots->execute('main', 'get-monthly-collection'); //Per month
$revenue = json_decode($result);


$collectibles = str_replace(',', '', $revenue[0]->total_collectibles);
$collectiblesNumber = floatval($collectibles); // Convert to float

$total_collected = str_replace(',', '', $revenue[0]->total_collected);
$total_collectedNumber = floatval($total_collected); // Convert to float

$total_unpaid = str_replace(',', '', $revenue[0]->total_unpaid);
$total_unpaidNumber = floatval($total_unpaid); // Convert to float


?>


<p class="text-required m-0">REVENUE</p>
<div class="dashboard-footer" style="color:#34495E;text-align:left"><span class="fa fa-dashboard"></span> <label class="text-required" style="font-size: 20px;">Monthly Collection</label></div>
<div class="d-flex justify-content-between ">
    <div class="">
        <div class="d-flex flex-column mt-5">
            <div class="d-flex gap-2 mt-0">
                <div class="">
                    <span><i class="bi bi-circle-fill" style="color:#6098E2"></i></span>
                </div>
                <div>
                    <label style="color:#1C5196" class="ytd-collection-text">COLLECTIBLES</label>
                    <p class="ytd-collection-text">
                    ₱ <?= $revenue[0]->total_collectibles;?>
                    </p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="">
                    <span><i class="bi bi-circle-fill" style="color:#19AF91"></i></span>
                </div>
                <div>
                    <label style="color:#1C5196" class="ytd-collection-text">COLLECTED AMOUNT</label>
                    <p class="ytd-collection-text"> 
                    ₱ <?=$revenue[0]->total_collected;?>
                    </p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="">
                    <span><i class="bi bi-circle-fill" style="color:#FFF385"></i></span>
                </div>
                <div>
                    <label style="color:#1C5196" class="ytd-collection-text">UNPAID AMOUNT</label>
                    <p class="ytd-collection-text">
                    ₱ <?=$revenue[0]->total_unpaid;?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <div class="" id="donut_single" style="width:100%;height:320px;padding:0!important"></div>   
    </div>
    
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Effort', 'Amount given'],
          ['Collectibles',  <?= $collectiblesNumber ?>],
          ['Collected Amount', <?=$total_collectedNumber?>],
          ['Unpaid Amount',      <?=$total_unpaidNumber?>],
        ]);

        var options = {
          pieHole: 0.5,
          pieSliceTextStyle: {
            color: 'black',
          },
          legend: 'none',
          slices: {
            0: { color: '#6098E2' }, // collectible
            1: { color: '#19AF91' }, // collected amount
            2: { color: '#FFF385' }, // unpaid amount 
          }
        };

        var chart = new google.visualization.PieChart(document.getElementById('donut_single'));
        chart.draw(data, options);
      }
</script>
