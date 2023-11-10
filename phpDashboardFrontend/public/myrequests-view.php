<?php
require_once("header.php");
$location_menu = "my-request";
include("footerheader.php");

$id = initObj('id');
$table = initObj('loc');
$module = str_replace("vw_", "", $table);
$module = str_replace("_", "", $module);
$result = apiSend('module', 'get-record', ['id' => decryptData($id), 'view' => $table]);
$record = json_decode($result);
if($module == "reportissue") $module = "report_issue";


$result =  apiSend('tenant', 'get-listnew', ['table' => "comments", 'condition' => 'reference_id="' . $record->id . '" and reference_table="' . $module . '"']);
$comment = json_decode($result);
?>
<div class="d-flex">
  <div class="main">
    <?php include("navigation.php") ?>
    <div style="background-color: #F0F2F5;padding: 10px 20px 100px 25px">
      <div class="d-flex align-items-center px-3 mt-3">
        <button class="back-button-sr" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; "><i class="fa-solid fa-chevron-left"></i></button>
        <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">Back</label>
      </div>
      <div class=" mt-4">
        <div class="">
          <div class="requests-card flex-column gap-2 w-100 mt-3 ">
            <div class="d-flex justify-content-between border-sr">
              <div>
                <p class="status  m-0
                      <?php if ($record->status === "Open" || $record->status === "Approved") {
                        echo "closed-status";
                      } elseif ($record->status === "Closed" || $record->status === "Denied") {
                        echo "open-status";
                      } else {
                        echo "open-status acknowledged-btn";
                      } ?>"><?= $record->status ?>
                </p>
              </div>
              <div class="date">
                <label><?= $record->date_upload ?></label>
              </div>
            </div>
            <?php if ($module === "report_issue") : ?>
              <div class="d-flex justify-content-between">
                <div class="w-100 mt-3">
                  <div class="row">
                    <label class="fw-bold col-6 label mb-2 fs-5">Report Issue</label><br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0">Unit :</label><br>
                    <label class="col-6 label m-0 "><?= $record->location_name ?> </label></br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0">Category :</label><br>
                    <label class="col-6 label m-0 "><?= $record->issue_name ?> </label></br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0">Issue:</label><br>
                    <label class="col-6 label m-0 "><?= $record->description ?></label></br>
                  </div>
                  <div class="">
                    <label class="fw-bold col-6 label m-0 p-0">Attachment:</label><br>
                    <?php if ($record->attachments) : ?>
                      <img src="<?= $record->attachments ?>" class="v-img" style="border-radius: 5px;">
                    <?php endif ?>
                  </div>
                </div>
              </div>
              <?php if ($comment) : ?>
                <div class="d-flex flex-column gap-2">
                  <label class="label m-0 mt-3" for="">Updates:</label>
                  <?php foreach ($comment as $item) : ?>
                    <div class="comment">
                      <div>
                        <span class="date-comment">Date & Time: <?= formatDateTime($item->created_on) ?> </span>
                        <div>
                          <span class="from-comment">-from admin-</span>
                          <p class="text-comment"><?= $item->comment ?></p>
                        </div>
                      </div>
                    </div>
                  <?php endforeach ?>
                </div>
              <?php endif ?>

            <?php elseif ($module === "visitorpass") : ?>
              <?php
              $result =  apiSend('tenant', 'get-listnew', ['table' => "vp_guest", 'condition' => 'guest_id="' . $record->id . '"']);
              $guest = json_decode($result);
              ?>
              <div class="">
                <div class="w-100 mt-3">
                  <div class="row">
                    <label class="fw-bold col-6 label mb-2 fs-5">Visitor Pass</label><br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0">Contact Number :</label><br>
                    <label class="col-6 label m-0 "><?= $record->contact_no ?> </label></br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0">Visit Purpose :</label><br>
                    <label class="col-6 label m-0 "><?= $record->visit_purpose ?> </label></br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0">Arrival Date :</label><br>
                    <label class="col-6 label m-0 "><?= formatDate($record->arrival_date) ?> </label></br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0">Arrival Time:</label><br>
                    <label class="col-6 label m-0 "><?= $record->arrival_time ?> </label></br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0">Departure Date:</label><br>
                    <label class="col-6 label m-0 "><?= formatDate($record->departure_date) ?> </label></br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0">Departure Time :</label><br>
                    <label class="col-6 label m-0 "><?= $record->departure_time ?> </label></br>
                  </div>
                </div>
                <div class="w-100 mt-3">
                  <div class="row">
                    <label class=" col-6 label m-0 ">Guest</label><br>
                  </div>

                </div>
              </div>
              <table class="table-sr">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Contact Number</th>
                    
                  </tr>
                </thead>
                <?php foreach ($guest as $item) : ?>
                  <tbody>
                    <tr>
                      <td><?= $item->guest_name ?></td>
                      <td><?= $item->guest_no ?></td>
                      
                    </tr>
                  </tbody>
                <?php endforeach ?>
              </table>
              <?php if ($comment) : ?>
                <div class="d-flex flex-column gap-2">
                  <label class="label m-0 mt-3" for="">Updates:</label>
                  <?php foreach ($comment as $item) : ?>
                    <div class="comment">
                      <div>
                        <span class="date-comment">Date & Time: <?= formatDateTime($item->created_on) ?> </span>
                        <div>
                          <span class="from-comment">-from admin-</span>
                          <p class="text-comment"><?= $item->comment ?></p>
                        </div>
                      </div>
                    </div>
                  <?php endforeach ?>
                </div>
                <div>

                </div>
              <?php endif ?>
            <?php elseif ($module === "gatepass") : ?>
              <?php
              $result =  apiSend('tenant', 'get-listnew', ['table' => "gatepass_items", 'condition' => 'gatepass_id="' . $record->id . '"']);
              $items = json_decode($result);
              $result =  apiSend('tenant', 'get-listnew', ['table' => "gatepass_personnel", 'condition' => 'gatepass_id="' . $record->id . '"']);
              $personnel = json_decode($result)[0];
              ?>
              <div class="">
                <div class="w-100 mt-3">
                  <div class="row">
                    <label class="fw-bold col-6 label mb-2 fs-5">Gate pass</label><br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0">Unit :</label><br>
                    <label class="col-6 label m-0 "><?= $record->unit ?> </label></br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0">Contact Number :</label><br>
                    <label class="col-6 label m-0 "><?= $record->contact_no ?> </label></br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0"> Type :</label><br>
                    <label class="col-6 label m-0 "><?= $record->type ?> </label></br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0">Date :</label><br>
                    <label class="col-6 label m-0 "><?= formatDate($record->gp_date) ?> </label></br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0">Time :</label><br>
                    <label class="col-6 label m-0 "><?= $record->gp_time ?> </label></br>
                  </div>
                </div>

                <div class="w-100 mt-3">
                  <div class="row">
                    <label class="fw-bold col-6 label m-0 ">Personnel</label><br>
                  </div>
                  <?php if ($personnel) : ?>
                    <div class="row">
                      <label class="fw-bold col-6 label m-0">Personnel Name :</label><br>
                      <label class="col-6 label m-0 "><?= $personnel->personnel_name ?> </label></br>
                    </div>
                    <div class="row">
                      <label class="fw-bold col-6 label m-0"> Company Name :</label><br>
                      <label class="col-6 label m-0 "><?= $personnel->company_name ?> </label></br>
                    </div>
                    <div class="row">
                      <label class="fw-bold col-6 label m-0"> Contact Number :</label><br>
                      <label class="col-6 label m-0 "><?= $personnel->personnel_no ?> </label></br>
                    </div>
                  <?php endif ?>



                </div>

                <div class="w-100 mt-3">
                  <div class="row">
                    <label class="fw-bold col-6 label m-0 ">Items</label><br>
                  </div>

                  <table class="table-sr">
                    <thead>
                      <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Description</th>
                      </tr>
                    </thead>
                    <?php foreach ($items as $item) : ?>
                      <tbody>
                        <tr>
                          <td><?= $item->item_name ?></td>
                          <td><?= $item->item_qty ?></td>
                          <td><?= $item->description ?></td>
                        </tr>
                      </tbody>
                    <?php endforeach ?>
                  </table>

                </div>
              </div>
              <?php if ($comment) : ?>
                <div class="d-flex flex-column gap-2">
                  <label class="label m-0 mt-3" for="">Updates:</label>
                  <?php foreach ($comment as $item) : ?>
                    <div class="comment">
                      <div>
                        <span class="date-comment">Date & Time: <?= formatDateTime($item->created_on) ?> </span>
                        <div>
                          <span class="from-comment">-from admin-</span>
                          <p class="text-comment"><?= $item->comment ?></p>
                        </div>
                      </div>
                    </div>
                  <?php endforeach ?>
                </div>
              <?php endif ?>
            <?php elseif ($module === "workpermit") : ?>
              <?php
              $result =  apiSend('tenant', 'get-listnew', ['table' => "work_details", 'condition' => 'id="' . $record->work_details_id . '"']);
              $work_details = json_decode($result)[0];
              $result =  apiSend('tenant', 'get-listnew', ['table' => "workers", 'condition' => 'workpermit_id="' . $record->id . '"']);
              $personel = json_decode($result);
              $result =  apiSend('tenant', 'get-listnew', ['table' => "work_materials", 'condition' => 'workpermit_id="' . $record->id . '"']);
              $work_materials = json_decode($result);
              $result =  apiSend('tenant', 'get-listnew', ['table' => 'work_tools', 'condition' => 'workpermit_id="' . $record->id . '"']);
              $work_tools = json_decode($result);
              ?>
              <div>
                <div class="w-100 mt-3">
                  <div class="row">
                    <label class="fw-bold col-6 label mb-2 fs-5">Work Permit</label><br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0">Nature of Work:</label><br>
                    <label class="col-6 label m-0 "><?= $record->category_name ?> </label></br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0">Contact Number:</label><br>
                    <label class="col-6 label m-0 "><?= $record->contact_no ?> </label></br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0">Unit:</label><br>
                    <label class="col-6 label m-0 "><?= $record->location_name ?> </label></br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0">Start Date: </label><br>
                    <label class="col-6 label m-0 "><?= formatDate($record->start_date) ?> </label></br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0">End Date: </label><br>
                    <label class="col-6 label m-0 "><?= formatDate($record->end_date) ?> </label></br>
                  </div>
                </div>
                <div class="w-100 mt-3">
                  <div class="row">
                    <label class="fw-bold col-6 label mb-2 fs-6">Work Details</label><br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0">Name of Contractor:</label><br>
                    <label class="col-6 label m-0 "><?= $work_details->name_contractor ?> </label></br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0"> Scope of Work:</label><br>
                    <label class="col-6 label m-0 "><?= $work_details->scope_work ?> </label></br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0"> Name of Person-In-Charge</label><br>
                    <label class="col-6 label m-0 "><?= $work_details->person_charge ?> </label></br>
                  </div>
                  <div class="row">
                    <label class="fw-bold col-6 label m-0">Contact Number:</label><br>
                    <label class="col-6 label m-0 "><?= $work_details->contact_number ?> </label></br>
                  </div>
                </div>
                <div class="w-100 mt-3">
                  <div class="row">
                    <label class="fw-bold col-6 label mb-2 fs-6">List of Workers/Personnel</label><br>
                  </div>
                  <table class="table-sr">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Description</th>
                      </tr>
                    </thead>
                    <?php foreach ($personel as $item) : ?>
                      <tbody>
                        <tr>
                          <td><?= $item->personnel_name ?></td>
                          <td><?= $item->personnel_description ?></td>
                        </tr>
                      </tbody>
                    <?php endforeach ?>
                  </table>

                </div>
                <div class="w-100 mt-3">
                  <div class="row">
                    <label class="fw-bold col-6 label mb-2 fs-6">List of Tools</label><br>
                  </div>

                  <table class="table-sr">
                    <thead>
                      <tr>
                        <th>Tool Name</th>
                        <th>Quantity</th>
                        <th>Description</th>
                      </tr>
                    </thead>
                    <?php foreach ($work_tools as $item) : ?>
                      <tbody>
                        <tr>
                          <td><?= $item->tools_name ?></td>
                          <td><?= $item->quantity_tools ?></td>
                          <td><?= $item->description_tools ?></td>
                        </tr>
                      </tbody>
                    <?php endforeach ?>
                  </table>
                </div>
                <div class="w-100 mt-3">
                  <div class="row">
                    <label class="fw-bold col-6 label mb-2 fs-6">List of Materials</label><br>
                  </div>

                  <table class="table-sr">
                    <thead>
                      <tr>
                        <th>Materials Name</th>
                        <th>Quantity</th>
                        <th>Description</th>
                      </tr>
                    </thead>
                    <?php foreach ($work_materials as $item) : ?>
                      <tbody>
                        <tr>
                          <td><?= $item->materials_name ?></td>
                          <td><?= $item->quantity_materials ?></td>
                          <td><?= $item->description_materials ?></td>
                        </tr>
                      </tbody>
                    <?php endforeach ?>
                  </table>
                </div>
              </div>

              <?php if ($comment) : ?>
                <div class="d-flex flex-column gap-2">
                  <label class="label m-0 mt-3" for="">Updates:</label>
                  <?php foreach ($comment as $item) : ?>
                    <div class="comment">
                      <div>
                        <span class="date-comment">Date & Time: <?= formatDateTime($item->created_on) ?> </span>
                        <div>
                          <span class="from-comment">-from admin-</span>
                          <p class="text-comment"><?= $item->comment ?></p>
                        </div>
                      </div>
                    </div>
                  <?php endforeach ?>
                </div>
              <?php endif ?>

            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include('menu.php') ?>
</div>
</div>
</div>


<script>
  $('.back-button-sr').click(function() {
    window.location = 'my-requests_new.php'
  })
</script>