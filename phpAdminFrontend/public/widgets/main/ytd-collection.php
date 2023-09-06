<style>
    .slect {
        -webkit-appearance: none;
        -moz-appearance: none;
        text-indent: 1px;
        text-overflow: '';
    }
</style>
<?php
$months_arr = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

$collectibles = str_replace(',', '', $revenue[0]->total_collectibles);
$collectiblesNumber = floatval($collectibles); // Convert to float

$total_collected = str_replace(',', '', $revenue[0]->total_collected);
$total_collectedNumber = floatval($total_collected); // Convert to float

$total_unpaid = str_replace(',', '', $revenue[0]->total_unpaid);
$total_unpaidNumber = floatval($total_unpaid); // Convert to float


?>
<p class="text-required m-0">EARNINGS</p>
<div class="dashboard-footer" style="color:#34495E;text-align:left"><span class="fa fa-dashboard"></span> <label class="text-required" style="font-size: 20px;">YTD Collection Report</label></div>
<div class="d-flex justify-content-between ">
    <div class="">
        <div class="d-flex flex-column">
            <div class="d-flex gap-2 mt-5">
                <div class="">
                    <span><i class="bi bi-circle-fill" style="color:#BCE0FD"></i></span>
                </div>
                <div>
                    <label style="color:#1C5196" class="ytd-collection-text">COLLECTIBLES</label>
                    <p id="collectibles" class="ytd-collection-text"></p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="">
                    <span><i class="bi bi-circle-fill" style="color:#1C5196"></i></span>
                </div>
                <div>
                    <label style="color:#1C5196" class="ytd-collection-text">COLLECTED AMOUNT</label>
                    <p id="collected" class="ytd-collection-text"></p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="">
                    <span><i class="bi bi-circle-fill" style="color:#FFF385"></i></span>
                </div>
                <div>
                    <label style="color:#1C5196" class="ytd-collection-text">UNPAID AMOUNT </label>
                    <p id="unpaid" class="ytd-collection-text"></p>
                </div>
            </div>
            <!-- <div class="d-flex gap-2">
                <div class="">
                    <span><i class="bi bi-circle-fill" style="color:#FFF385"></i></span>
                </div>
                <div>
                    <label style="color:#1C5196">TOTAL UNPAID AMOUNT</label>
                    <p>

                    </p>
                    
                </div>
            </div> -->
        </div>
    </div>
    <div class="" style="position:relative">
        <div class="" style="position:absolute;z-index:10000;left:35%;top: -15px;">
            <center>
                <button type="button" class="bttn btn btn-sm" id="prev"><i class="bi bi-caret-left-fill"></i></button>
                <select class="ytd-select" id="months" disabled style="border:none; text-align:center; appearance: none;">
                    <?php foreach ($months_arr as $key => $month) : ?>
                        <option value="<?= $key + 1 ?>" <?= $key + 1 == date('m') ? "selected" : ""  ?>><?= $month ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="button" class="bttn btn btn-sm" id="next"><i class="bi bi-caret-right-fill"></i></button>
            </center>

        </div>

        <div class="" id="donut_single2" style="width:100%;min-height:320px;padding:0!important"></div>
    </div>
</div>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    $(document).ready(function() {
        var currentMonth = $('#months').val();
        var collectibles = 0;
        var collected = 0;
        var unpaid = 0;
        var overdue = 0;

        // if (currentMonth === 12) {
        //     $('#next').prop("disabled", true);
        // }
        // if (currentMonth === 1) {
        //     $('#prev').prop("disabled", true);
        // }

        var currentMonth = new Date().getMonth() + 1; // Get current month, adding 1 to match your month indexing
        var collectibles, collected, unpaid;

        $('#prev').on('click', function() {
            currentMonth--;
            if (currentMonth < 1) currentMonth = 12;
            $('#months').val(currentMonth);
            get_ytd_collection();
        });

        $('#next').on('click', function() {
            currentMonth++;
            if (currentMonth > 12) currentMonth = 1;
            $('#months').val(currentMonth);
            get_ytd_collection();
        });

        get_ytd_collection();

        function get_ytd_collection() {
            $.ajax({
                url: "<?= WEB_ROOT . '/main/get-ytd-collection?display=plain' ?>",
                type: 'POST',
                data: {
                    month: parseInt(currentMonth) // No need for square brackets
                },
                success: function(data) {
                    var parsedData = JSON.parse(data)[0];
                    collectibles = parsedData.total_collectibles;
                    $('#collectibles').text(collectibles ? "₱"+collectibles.toLocaleString() : '₱ 0');

                    collected = parsedData.total_collected;
                    $('#collected').text(collected ? "₱"+collected.toLocaleString() : '₱ 0');

                    unpaid = parsedData.total_unpaid;
                    $('#unpaid').text(unpaid ? "₱"+unpaid.toLocaleString() : '₱ 0');

                    google.charts.load('current', {
                        'packages': ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawChart);
                }
            });
        }

        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            if(collectibles || collected || unpaid) {
                var data = google.visualization.arrayToDataTable([
                    ['Effort', 'Amount given'],
                    ['Collectibles', collectibles? parseFloat(collectibles.replace(/,/g, '')): 0 ],
                    ['Collected Amount',   collected? parseFloat(collected.replace(/,/g, '')): 0 ],
                    ['Unpaid Amount',   unpaid? parseFloat(unpaid.replace(/,/g, '')): 0 ],
                ]);
            } else {
                var data = google.visualization.arrayToDataTable([
                    ['Effort', 'Amount given'],
                    ['No Data', 100 ]
                ]);
            }


            var options = {
                pieHole: 0.5,
                pieSliceTextStyle: {
                    color: 'black',
                },
                legend: 'none',
                slices: {
                    0: {
                        color: '#BCE0FD'
                    },
                    1: {
                        color: '#1C5196'
                    }, // collected amount
                    2: {
                        color: '#FFF385'
                    },
                }
            };

            var chart = new google.visualization.PieChart(document.getElementById('donut_single2'));
            chart.draw(data, options);
        }

        const monthsArr = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    });
</script>