<?php
$result =  $ots->execute('module','generate-report',$_POST);
$records = json_decode($result);
//vdump($records->data);
if (!$records->data) {
    echo "<h5>No record found.</h5>";
} else {
?>
<table class="table table-bordered table-striped border-table bg-white">
    <tr>
        <th>Type</th>
        <th>ID</th>
        <th>Date</th>
        <th>Requestor</th>
        <th>Status</th>
    </tr>
    <?php foreach ($records->data as $val) { ?>
    <tr>
        <td><?=$val->type?></td>
        <td><?=$val->id?></td>
        <td><?=formatDate($val->trans_date)?></td>
        <td><?=$val->requestor?></td>
        <td><?=$val->status?></td>
    </tr>
    <?php } ?>
</table>
<?php } // IF RECORDS ?>