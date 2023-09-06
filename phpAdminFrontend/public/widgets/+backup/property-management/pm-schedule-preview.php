<?php
// p_r($_POST);
// exit();

$sched_frequency = $_POST['frequency'];

$schedules = [];
$month_start = strtotime('first day of this month',strtotime($_POST['pm_start_date']));

$futureDate = date('Y-m-d', strtotime('+1 year', strtotime($_POST['pm_start_date'])));
$year_later = $futureDate;





$dates = [];
$dates2 = [];



function weeks($month, $year)
{
    $firstday = date("w", mktime(0, 0, 0, $month, 1, $year)); 
    $lastday = date("t", mktime(0, 0, 0, $month, 1, $year));
    $count_weeks = 1 + ceil(($lastday-8+$firstday)/7);
    return $count_weeks  - ($firstday > 1 ? 1 : 0);
}

?>

<style>
table.calendar52 td
{
    border: 1px solid #c0c0c0;
    padding: 2px;
}

table.calendar52 td.start
{
    border-left: 2px solid #c0c0c0;
}

table.calendar52 td.monthname
{
    background-color: #1178ca;
    color: #ffffff;
}

td.schedule
{
    background-color: #d0772c;
    color: #ffffff;
}

</style>

<div class="mt-2">
    <?php 
        function weekOfMonth($date) {
            // estract date parts
            list($y, $m, $d) = explode('-', date('Y-m-d', strtotime($date)));
            
            // current week, min 1
            $w = 1;
            
            // for each day since the start of the month
            for ($i = 1; $i < $d; ++$i) {
                // if that day was a sunday and is not the first day of month
                if ($i > 1 && date('w', strtotime("$y-$m-$i")) == 0) {
                    // increment current week
                    ++$w;
                }
            }
            
            // now return
            return $w;
        }


        $dates = [];
        $now = time(); // or your date as well
        $exp_date = strtotime($_POST['pm_start_date']);
        $datediff = $exp_date - $now;
        $days_before_start_date = round($datediff / (60 * 60 * 24)) + 1;
        $start_month = 1;
        if(strtotime($_POST['pm_start_date']." " . $_POST['pm_start_time']) > strtotime(date('Y-m-d h:i')))
            $start_month = 0;

        $ctr = 1;

        if($_POST['frequency'] == 'monthly')
            $ctr = 1;
        if($_POST['frequency'] == 'quarterly')
            $ctr = 3;            
        if($_POST['frequency'] == 'semi-annual')
            $ctr = 6;
        if($_POST['frequency'] == 'annual')
            $ctr = 12;            
        
        $monts_to_display = [];
        
        if($_POST['repeat_notif']){
            for($m = $start_month ; $m <= 12;$m = $m + $ctr){
                
                $month = date('M', strtotime("+{$m} months", strtotime($_POST['pm_start_date'] . " " . $_POST['pm_start_time'])));
                $fmonth = date('F', strtotime("+{$m} months", strtotime($_POST['pm_start_date'] . " " . $_POST['pm_start_time'])));
                array_push($monts_to_display,$fmonth);


                $active_start_date_orig_format = date('Y-m-d', strtotime("+{$m} months", strtotime($_POST['pm_start_date']." " . $_POST['pm_start_time'])));
                $day = date('D',strtotime($active_start_date_orig_format));
                $notify = date('Y-m-d',strtotime("-{$_POST['notify_days_before_next_schedule']} days",strtotime($active_start_date_orig_format)));

                $active_start_date = date('M d Y @ h:i', strtotime("+{$m} months", strtotime($_POST['pm_start_date']." " . $_POST['pm_start_time'])));;

                $active_end_date = date('M d Y @ h:i', strtotime("+{$m} months", strtotime($_POST['pm_end_date']." " . $_POST['pm_end_time'])));
                array_push($dates,[
                    'day' =>$day,
                    'week_number' =>weekOfMonth($active_start_date_orig_format),
                    'starts'=>$active_start_date,
                    'ends'=>$active_end_date,
                    'notify'=>$notify
                ]);
            }
        }
        else{
            $active_start_date = date('M d Y @ h:i',strtotime($_POST['pm_start_date']." " . $_POST['pm_start_time']));;
            $active_start_date_orig_format = date('Y-m-d', strtotime("+{$m} months", strtotime($_POST['pm_start_date']." " . $_POST['pm_start_time'])));
            $day = date('D',strtotime($active_start_date_orig_format));
            $active_end_date = date('M d Y @ h:i', strtotime($_POST['pm_end_date']." " . $_POST['pm_end_time']));
            array_push($dates,[
                'day' =>$day,
                'week_number' => weekOfMonth($active_start_date_orig_format),
                'starts'=>$active_start_date,
                'ends'=>$active_end_date,
                'notify'=>$notify
            ]);
        }
    ?>
    <div class="calendar row">
        <?php
        foreach($monts_to_display as $index=>$month){
            ?>
            <div class="col" >
                <div class="card bg-light mb-3" style="width:100px">
                    <div class="card-header"><?= $month ?></div>
                    <div class="card-body">
                        Week # <?php echo $dates[$index]['week_number']?>
                        <?php echo $dates[$index]['day']?> <?php echo explode(' ',$dates[$index]['starts'])[1]?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <table class="table table-striped">
    <thead>
            <tr>
                <th>Start</th>
                <th>End</th>
                <th>Notify</th>
            </tr>
    </thead>
    <?php foreach($dates as $date):?>
        <tr>
            <td><?php echo $date['starts'];?></td>
            <td><?php echo $date['ends'];?></td>
            <td><?php echo $date['notify'];?></td>
        </tr>
    <?php endforeach;?>

    </table>
</div>


<?php


 ?>
 