
<?php

$con = "`date_upload` LIKE '%" . date('F d, Y') . "%'";

$result =  $ots->execute('main', 'get-newrequest', ['table' => 'vw_workpermit', 'condition' => $con]);
$workpermittoday = json_decode($result);

$result =  $ots->execute('main', 'get-newrequest', ['table' => 'vw_gatepass', 'condition' => $con]);
$gptoday = json_decode($result);
$result =  $ots->execute('main', 'get-newrequest', ['table' => 'vw_visitor_pass', 'condition' => $con]);
$vptoday = json_decode($result);
$result =  $ots->execute('main', 'get-newrequest', ['table' => 'vw_report_issue', 'condition' => $con]);
$issuetoday = json_decode($result);

// var_dump($issuetoday);

$approvaltoday = $vptoday[0]->count + $gptoday[0]->count;

$con = '`status` = "Pending"';
$result =  $ots->execute('main', 'get-newrequest', ['table' => 'vw_gatepass', 'condition' => $con]);
$gatepass = json_decode($result);
$result =  $ots->execute('main', 'get-newrequest', ['table' => 'vw_visitor_pass', 'condition' => $con]);
$vp = json_decode($result);
$allapproval =  $vp[0]->count + $gatepass[0]->count;


$con = "`status` LIKE '%Open%'";
$result =  $ots->execute('main', 'get-newrequest', ['table' => 'vw_workpermit', 'condition' => $con]);
$workpermit = json_decode($result);
$result =  $ots->execute('main', 'get-newrequest', ['table' => 'vw_report_issue', 'condition' => $con]);
$issue = json_decode($result);
$open =  $issue[0]->count + $workpermit[0]->count;
$issue_open = $issuetoday[0]->count + $workpermittoday[0]->count;
?>
<div class="sr-card  gap-3 w-100">
    <div class="d-flex gap-3 h-50">
        <div class="bg-theme border border-2 border-primary dash-card">
            <div>
                <label class="" for="">Request for Approval</label>
                <h1 class="m-0 ">
                    <?php if ($allapproval) {
                        echo  $allapproval;
                    } else {
                        echo '0';
                    } ?>
                </h1>
                <div class="d-flex gap-2">
                    <div>
                        <a  href="<?= WEB_ROOT . '/visitorpass/?filter=true' ?>" class="fw-bold <?= $vp[0]->count ==0 ? "text-dark-gray" : "text-primary"  ?> ">Visitor pass</a>
                        <b class="  text-light px-1 rounded-3 <?= $vp[0]->count ==0 ? "bg-dark-gray" : "bg-blue"  ?> "><?= $vp[0]->count  ?></b>
                    </div>
                    <div>
                        <a  href="<?= WEB_ROOT . '/gatepass/?filter=true' ?>" class="fw-bold <?= $gatepass[0]->count ==0 ? "text-dark-gray" : "text-primary"  ?>">Gate Pass</a>
                        <b class="bg-dark-gray px-1 rounded-3 <?= $gatepass[0]->count ==0 ? "bg-dark-gray" : "bg-blue"  ?> "><?= $gatepass[0]->count ?></b>
                    </div>
                </div>
            </div>
        </div>
        <div class="dash-card border-green bg-theme ">
            <div>
                <label for="" >Request for Approval for Today</label>
                <h1 class="m-2">
                    <?php if ($approvaltoday) {
                        echo $approvaltoday;
                    } else {
                        echo '0';
                    }
                    ?>
                </h1>
                <div class="d-flex gap-2">
                    <div>
                        <a  href="<?= WEB_ROOT . '/visitorpass/?filter=true' ?>" class="fw-bold <?= $vptoday[0]->count == 0 ? "text-dark-gray" : " text-green"  ?> ">Visitor pass</a>
                        <b class="bg-green px-1 text-light rounded-3 <?= $vptoday[0]->count == 0 ? "bg-dark-gray" : "bg-green"  ?>"><?=  $vptoday[0]->count  ?></b>
                    </div>
                    <div>
                        <a href="<?= WEB_ROOT . '/gatepass/?filter=true' ?>" class="fw-bold <?= $gptoday[0]->count == 0 ? "text-dark-gray" : " text-green"  ?>  ">Gate Pass</a>
                        <b class=" px-1 text-light rounded-3 <?= $gptoday[0]->count == 0 ? "bg-dark-gray" : "bg-green"  ?>  "><?= $gptoday[0]->count ?></b>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="d-flex gap-3 h-50">
        <div  class="dash-card bg-theme border-red">
            <div>
                <label for="" class="">Open Request</label>
                <h1 class="m-2 ">
                    <?php if ($open) {
                        echo  $open;
                    } else {
                        echo '0';
                    } ?>
                </h1>
                <div class="d-flex gap-2">
                    <div>
                        <a  href="<?= WEB_ROOT . '/workpermit/?filter=true' ?>"  class="fw-bold   <?= $workpermit[0]->count == 0 ? "text-dark-gray" : " text-danger"  ?>  ">Work Permit</a>
                        <b  class="bg-red text-light px-1 rounded-3 <?= $workpermit[0]->count == 0 ? "bg-dark-gray" : "bg-red"  ?>"><?= $workpermit[0]->count ?></b>
                    </div>
                    <div>
                        <a href="<?= WEB_ROOT . '/reportissue/?filter=true' ?>" class="fw-bold  <?= $issue[0]->count == 0 ? "text-dark-gray" : " text-danger"  ?>  ">Report An Issue</a>
                        <b class="text-light px-1 rounded-3 <?= $issue[0]->count == 0 ? "bg-dark-gray" : "bg-red"  ?> "><?= $issue[0]->count ?></b>
                    </div>
                </div>
            </div>

        </div>
        <div  class="bg-theme border border-2 border-warning dash-card">
            <div>
                <label for="" class="">Open Request for Today</label>
                <h1 class="m-2 ">
                    <?php if ($issue_open) {
                        echo  $issue_open;
                    } else {
                        echo '0';
                    } ?>
                </h1>
                <div class="d-flex gap-2">
                    <div>
                        <a  href="<?= WEB_ROOT . '/workpermit/?filter=true' ?>"  class="fw-bold   <?= $workpermittoday[0]->count == 0 ? "text-dark-gray" : " text-warning"  ?>" >Work Permit</a>
                        <b class=" px-1 rounded-3 text-light <?= $workpermittoday[0]->count == 0 ? "bg-dark-gray" : "bg-red bg-warning"  ?>"><?=  $workpermittoday[0]->count ?></b>
                    </div>
                    <div>
                        <a href="<?= WEB_ROOT . '/reportissue/?filter=true' ?>" class="fw-bold   <?= $issuetoday[0]->count == 0 ? "text-dark-gray" : "text-warning"  ?>">Report An Issue</a>
                        <b class="bg-dark-gray px-1 rounded-3 <?= $issuetoday[0]->count == 0 ? "bg-dark-gray" : "bg-red bg-warning"  ?>"><?= $issuetoday[0]->count ?></b>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>




<script>
    // if ($result['data']['count'] == 0) {
    //     $("total-label-aging").hide();
    //     $(".total-label").show();
    // } else if ($result['data']['count'] >= 1) {
    //     $(".total-label-aging").hide();
    //     $(".text-danger.total-label").show();

    // }

    // function saveRAccess(a_data) {
    //     title = $(a_data).attr("title")
    //     icon = $(a_data).attr("icon")

    //     $.ajax({
    //         url: "<?= WEB_ROOT ?>/dashboard/save-record?display=plain",
    //         type: 'POST',
    //         dataType: 'JSON',
    //         data: {
    //             module_name: title,
    //             module_icon: icon
    //         },
    //         beforeSend: function() {},
    //         success: function(data) {
    //             console.log(data);
    //             // if(data.success == 1)
    //             // {
    //             // 	show_success_modal($('input[name=redirect]').val());
    //             // }	
    //         },
    //         complete: function() {

    //         },
    //         error: function(jqXHR, textStatus, errorThrown) {

    //         }
    //     });
    // }
</script>