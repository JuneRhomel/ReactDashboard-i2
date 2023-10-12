<?php
include("footerheader.php");
fHeader();

$id = initObj('id');
$tenant = initSession('tenant');

$api = apiSend('amenity','getlist',ARR_BLANK);
$list = json_decode($api,true);
foreach ($list as $key0=>$val0) {
    if ($val0['id']==$id)
        $val = $val0;
}

$arrHours = explode(" - ",$val['operating_hours']);
$start_ampm = substr($arrHours[0],-2);
$start_time = str_replace($start_ampm,":00".$start_ampm,$arrHours[0]);
$start_time = date("H:i",strtotime($start_time));
$end_ampm = substr($arrHours[1],-2);
$end_time = str_replace($end_ampm,":00".$end_ampm,$arrHours[1]);
$end_time = date("H:i",strtotime($end_time));

//vdump($start_time." | ".$end_time);
$start_dt = $end_dt = $remarks = "";
if (initObj('action')!="") {
    //$start_dt = $end_dt = date("Y-m-d H:i");
    $start_dt = "2022-07-08 10:00";
    $end_dt = "2022-07-08 13:00";
    $remarks = "personal use";
}
?>
<div class="col-12 d-flex align-items-center justify-content-between mt-4 mb-3">
    <div class="title">Reservations</div>
</div>
<form id="frm" name="frm" method="post" enctype="multipart/form-data" action="reservation-save.php">
    <div class="py-3 bg-white">
        <div class="container">
            <div class="mb-2">
                <div class="py-2">Amenity</div>
                <div>
                    <input name="amenity_name" type="text" class="form-control" value="<?=$val['amenity_name']?>" readonly />
                </div>
            </div>
            <div class="mb-2">
                <div class="py-2">Operating Hours</div>
                <div>
                    <input name="amenity_name" type="text" class="form-control" value="<?=$val['operating_hours']?>" readonly />
                </div>
            </div>
            <div class="mb-2">
                <div class="py-2">Start Date/Time</div>
                <div>
                    <input name="reserved_from" type="datetime-local" class="form-control" value="<?=$start_dt?>" required/>
                </div>
            </div>
            <div class="mb-2">
                <div class="py-2">End Date/Time</div>
                <div>
                    <input name="reserved_to" type="datetime-local" class="form-control" value="<?=$end_dt?>" required />
                </div>
            </div>
            <div class="mb-2">
                <div class="py-2">Tenant</div>
                <div>
                    <input type="text" class="form-control" value="<?=$tenant['tenant_name']?>" readonly />
                </div>
            </div>
            <div class="mb-2">
                <div class="py-2">Contact Number</div>
                <div>
                    <input type="text" class="form-control" value="<?=$tenant['mobile']?>" readonly />
                </div>
            </div>
            <div class="mb-2">
                <div class="py-2">Email Address</div>
                <div>
                    <input type="text" class="form-control" value="<?=$tenant['email']?>" readonly />
                </div>
            </div>
            <div class="mb-2">
                <div class="py-2">Remarks</div>
                <div>
                    <div class="form-group">
                        <textarea name="description" class="form-control" rows="3" required><?=$remarks?></textarea>
                    </div>
                </div>
            </div>
            <div class="row mt-3" style="padding: 0 15px">
                <div class="col-6">
                    <button class="btn btn-outline font-16 w-100" type="button" onclick="location='home.php'">Cancel</button>
                </div>
                <div class="col-6 d-block">
                    <button class="btn btn-primary px-3 w-100">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" value="<?php echo $_GET['id'];?>" name="amenity_id">
</form>
<?=fFooter();?>
<script>
$(document).ready(function(){
    $("#frm").on('submit',function(e){
        e.preventDefault();       
        
        reserved_from = $("input[name=reserved_from").val();
        arrFrom = reserved_from.split('T');
        from_time = arrFrom[1];
        reserved_to = $("input[name=reserved_to").val();
        arrTo = reserved_to.split('T');
        to_time = arrTo[1];

        if (from_time < '<?=$start_time?>' || (to_time < from_time || to_time > '<?=$end_time?>')) {
            swal('Reservation start/end time needs to be within operating hours');
        } else {
            swal({ title: "Save Confirmation", text: "Are you sure you want to save record?", icon: "warning", buttons: true, dangerMode: true })
            .then((ynConfirm) => {
              if (ynConfirm) {
                this.submit()
                swal("Record saved!", { icon: "success" });
              }
            });
        }
    });
});
</script>