<?php

$module = "visitorpass";
$table = "visitorpass";
$view = "vw_visitor_pass";
require_once('header.php');
include("footerheader.php");

$data = [
  'view' => 'users'
];
$user = apiSend('tenant', 'get-user', $data);
$user = json_decode($user);


$result = apiSend('tenant', 'get-list-sr', ['table' => 'vw_visitor_pass', 'condition' => 'created_by="' . $user->id . '" AND status = "Pending"']);
$vp_pendding = json_decode($result);
$pendingtotal = count($vp_pendding);

// var_dump($vp_pendding);

$result = apiSend('tenant', 'get-list-sr', ['table' => 'vw_visitor_pass', 'condition' => 'created_by="' . $user->id . '" AND status = "Approved"']);
$vp_approved = json_decode($result);
$approvedtotal = count($vp_approved);


$result = apiSend('tenant', 'get-list-sr', ['table' => 'vw_visitor_pass', 'condition' => 'created_by="' . $user->id . '" AND status = "Disapproved"']);
$vp_denied = json_decode($result);
$deniedtotal = count($vp_denied);


$result =  apiSend('tenant', 'get-allsr', ['condition' => 'name_id="' . $user->id . '"']);
$allsr = json_decode($result);
?>


<div class="d-flex">
  <div class="main">
    <?php include("navigation.php") ?>
    <div class="d-flex align-items-center px-3 mt-3">
      <button class="back-button-sr"
        style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; "><i
          class="fa-solid fa-chevron-left"></i></button>
      <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">
        Visitor's Pass</label>
    </div>
    <div style="background-color: #F0F2F5; padding: 20px 24px 106px 24px;">
      <div class="d-flex justify-content-center pt-3" style="background-color: #F0F2F5;">
        <div class="card mb-3" style="width: 100%">
          <div class="mb-0">
            <button class="d-flex align-items-center justify-content-between btn btn-status w-100"
              style="padding: 12px;">
              <div><label class="m-0" style="font-weight: 400; color:#1C5196;">Request form</label></div>
              <div><i id="down1" style="color:#1C5196" class="fa-solid fa-caret-down"></i><i id="up1"
                  style="color:#1C5196" class="fa-solid fa-caret-down fa-rotate-180"></i></div>
            </button>
          </div>
          <div id="collapse-status" class="collapse">

            <div class="card-body" style="margin-top:16px">
              <div class=" forms">
                <form action="<?= WEB_ROOT ?>/gatepass-save.php" method="post" id="form-main">
                  <input name="date" type="hidden" readonly value="<?= date('Y-m-d H:i:s') ?> ">
                  <input name="module" type="hidden" readonly value="<?= $module ?>">
                  <input name="table" type="hidden" readonly value="<?= $table ?>">
                  <input type="hidden" name="name_id" readonly value="<?= $user->id ?>">
                  <input type="hidden" name="unit_id" readonly value="<?= $user->unit_id ?>">
                  <div class="w-100">
                    <div class="w-100 form-group">
                      <input id="request-form" name="name" value="<?= $user->fullname ?>" disabled required
                        placeholder="text">
                      <label id="request-form">Requestor Name <span class="text-danger">*</span></label>
                    </div>
                  </div>

                  <div class="w-100">
                    <div class="w-100 form-group">
                      <input id="request-form" name="unit" type="text" disabled value="<?= $user->unit_name ?>" required
                        placeholder="text">
                      <label id="request-form">Unit # <span class="text-danger">*</span></label>
                    </div>
                  </div>
                  <div class="w-100">
                    <div class="w-100 form-group">
                      <input id="request-form" name="contact_no" type="text" value="<?= $user->contact_no ?>" required
                        placeholder="text">
                      <label id="request-form">Contact Number <span class="text-danger">*</span></label>
                    </div>
                  </div>
                  <div class="form-group">
                    <input id="request-form" type="text" name="visit_purpose" placeholder="text" required>
                    <label id="request-form">Visit Purpose <span class="text-danger">*</span></label>
                  </div>
                  <div class="">
                    <div class="form-group">
                      <input type="date" id="request-form" name="arrival_date" required placeholder="text">
                      <label for="" id="request-form" class="text-required">Date of Arrival <span
                          class="text-danger">*</span></label>
                    </div>
                  </div>
                  <div class="">
                    <div class="form-group">
                      <input type="time" name="arrival_time" id="request-form" required placeholder="text">
                      <label for="" id="request-form" class="text-required">Time of Arrival <span
                          class="text-danger">*</span></label>
                    </div>
                  </div>
                  <div class="">
                    <div class="w-100 form-group">
                      <input type="date" name="departure_date" id="request-form" required placeholder="text">
                      <label for="" id="request-form" class="text-required">Date of Departure <span
                          class="text-danger">*</span></label>
                    </div>
                  </div>
                  <div class="">
                    <div class="form-group">
                      <input type="time" id="request-form" name="departure_time" required placeholder="text">
                      <label for="" id="request-form" class="text-required">Time of Departure <span
                          class="text-danger">*</span></label>
                    </div>
                  </div>
                </form>
                <label style="font-weight: 400; font-size: 24px;  margin:27px 0;">Guest List</label>

                <div class="table-data add-ons" id="add-ons">

                </div>


                <input id="guest_id" type="hidden" readonly class="form-control">
                <form method="post" action="<?= WEB_ROOT ?>/gatepass-save.php" id="item-send">
                  <div>
                    <div id="visitorItem" class="input-items">
                      <div>
                        <div class="form-group">
                          <input id="request-form" type="text" name="guest_name[]" placeholder="text">
                          <label id="request-form">Name <span class="text-danger">*</span></label>
                        </div>
                        <div class="form-group">
                          <input id="request-form" type="number" name="guest_num[]" placeholder="text">
                          <label id="request-form">Contact # <span class="text-danger">*</span></label>
                        </div>
                        
                      </div>
                    </div>
                    <div class="d-flex justify-content-end">
                      <button type="button" id="btn-add-item" class="btn-add-item"> + Add Visitor</button>
                    </div>
                  </div>
                </form>
                <div class="terms-condition-text d-flex  gap-2 pt-3">
                  <!-- <input required type="checkbox"> I agree to the <a href="#">Terms and Condition</a> -->
                </div>

                <div class="w-100" style="margin-bottom: 34px;">
                  <div class="grp-btn">
                    <div class=" btn-settings">
                      <button type="submit"
                        class="btn main-submit btn-dark btn-primary settings-save d-block px-5 w-100">Submit</button>
                    </div>
                    <div class="btn-settings">
                      <button type="button"
                        class="close-btn  btn btn-light btn-cancel settings-cancel d-block px-5 w-100">Cancel</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>


      <div class="tab-service">
        <label for="">History</label>
        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
          <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
          <label id="btnSubmit" class="btn first-tab btn-tab-service btn-outline-primary" for="btnradio1">Pending <span>
              <?= $pendingtotal ?>
            </span></label>

          <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
          <label id="btnAcknowledged" class="btn btn-tab-service btn-outline-primary" for="btnradio2">Approved <span>
              <?= $approvedtotal ?>
            </span> </label>

          <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
          <label id="btnFinish" class="btn btn-tab-service btn-outline-primary" for="btnradio3">Denied<span>
              <?= $deniedtotal ?>
            </span> </label>
        </div>
      </div>

        <div class="history-container submitted">
          <?php
            $count = 0;
            foreach ($allsr as $key => $sr): ?>
              <?php if ($sr->type === "Visitor Pass"): ?>
                <?php
                $result = apiSend('tenant', 'get-listnew', ['table' => $sr->table, 'condition' => 'id="' . $sr->id . '" and approve_id = 3']);
                $data = json_decode($result)[0];
                if ($data->approve_id == 3) {
                  $count += 1;
                  if ($count > 5){
                    break;
                  }
                }
                if ($data) {
                  $result = apiSend('tenant', 'get-listnew', ['table' => "vp_guest", 'condition' => 'guest_id="' . $data->id . '"']);
                  $vp_g = json_decode($result);
                  $result = apiSend('tenant', 'get-listnew', ['table' => "comments", 'condition' => 'reference_id="' . $sr->id . '" and reference_table="' . $sr->main_table . '"', 'orderby' => 'id DESC', 'limit' => '1']);
                  $comment = json_decode($result);
                  ?>
                                <div class="p-2 ">
                                    <div class="requests-card flex-column gap-2  w-100">

                                        <div class="d-flex justify-content-between border-sr">
                                            <div class="d-flex  gap-1">
                                                <b class="id">#<?= $data->id ?></b>
                                                <p class="status  m-0
                                                    <?php if ($data->status === "Approved") {
                                                        echo "closed-status";
                                                    } elseif ($data->status === "Denied") {
                                                        echo "open-status";
                                                    } else {
                                                        echo "open-status acknowledged-btn";
                                                    } ?>"><?= $data->status ?></p>
                                            </div>
                                            <div class="date">
                                                <label><?= $data->date_upload ?></label>
                                            </div>
                                        </div>
                                        <div class="w-100 mt-3">
                                            <div class="row">
                                                <label class="fw-bold  col-6 label m-0 fs-6"><?= $sr->type ?></label><br>
                                            </div>
                                            <div class="row">
                                              <label class="fw-bold col-6 label m-0">Guest:</label><br>
                                              <label class="col-6 label m-0 ">
                                                <?php
                                                    echo implode(", ", array_column($vp_g, 'guest_name'));
                                                    ?>
                                                </label>
                                              </div>
                                              <div class="row">
                                                  <label class="fw-bold col-6 label m-0">Visit Purpose:</label><br>
                                                  <label class="col-6 label m-0 "><?= $data->visit_purpose ?> </label>
                                              </div>
                                            <div class="row">
                                                <label class="fw-bold col-6 label m-0">Arrival Date:</label><br>
                                                <label class="col-6 label m-0 "><?= $data->arrival_date ?> </label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-auto">
                                            <div class="w-100">

                                                <?php if ($comment[0]->comment) : ?>

                                                    <label class="label m-0" for="">Updates:</label>
                                                    <div class="comment">
                                                        <div>
                                                            <span class="date-comment">Date & Time: <?= formatDateTime($comment[0]->created_on) ?> </span>
                                                            <div>
                                                                <span class="from-comment">-from admin-</span>
                                                                <p class="text-comment"><?= $comment[0]->comment ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif ?>
                                                <div class="text-end mt-2">
                                                    <a href="myrequests-view.php?id=<?= $data->enc_id ?>&loc=<?= $sr->table ?>">View all</a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                <?php } ?>
            <?php endif ?>
          <?php endforeach; ?>
      </div>

      <div class="history-container acknowledged">
          <?php
            $count = 0;
            foreach ($allsr as $key => $sr): ?>
              <?php if ($sr->type === "Visitor Pass"): ?>
                <?php
                $result = apiSend('tenant', 'get-listnew', ['table' => $sr->table, 'condition' => 'id="' . $sr->id . '" and approve_id = 1']);
                $data = json_decode($result)[0];
                if ($data->approve_id == 1) {
                  $count += 1;
                  if ($count > 5)
                    break;
                }
                if ($data) {
                  $result = apiSend('tenant', 'get-listnew', ['table' => "vp_guest", 'condition' => 'guest_id="' . $data->id . '"']);
                  $vp_g = json_decode($result);
                  $result = apiSend('tenant', 'get-listnew', ['table' => "comments", 'condition' => 'reference_id="' . $sr->id . '" and reference_table="' . $sr->main_table . '"', 'orderby' => 'id DESC', 'limit' => '1']);
                  $comment = json_decode($result);
                  ?>
                                <div class="p-2 ">
                                    <div class="requests-card flex-column gap-2  w-100">

                                        <div class="d-flex justify-content-between border-sr">
                                            <div class="d-flex  gap-1">
                                                <b class="id">#<?= $data->id ?></b>
                                                <p class="status  m-0
                                                    <?php if ($data->status === "Approved") {
                                                        echo "closed-status";
                                                    } elseif ($data->status === "Denied") {
                                                        echo "open-status";
                                                    } else {
                                                        echo "open-status acknowledged-btn";
                                                    } ?>"><?= $data->status ?></p>
                                            </div>
                                            <div class="date">
                                                <label><?= $data->date_upload ?></label>
                                            </div>
                                        </div>
                                        <div class="w-100 mt-3">
                                            <div class="row">
                                                <label class="fw-bold  col-6 label m-0 fs-6"><?= $sr->type ?></label><br>
                                            </div>
                                            <div class="row">
                                              <label class="fw-bold col-6 label m-0">Guest:</label><br>
                                              <label class="col-6 label m-0 ">
                                                <?php
                                                echo implode(", ", array_column($vp_g, 'guest_name'));
                                                ?>
                                                </label>
                                              </div>
                                              <div class="row">
                                                  <label class="fw-bold col-6 label m-0">Visit Purpose:</label><br>
                                                  <label class="col-6 label m-0 "><?= $data->visit_purpose ?> </label>
                                              </div>
                                            <div class="row">
                                                <label class="fw-bold col-6 label m-0">Arrival Date:</label><br>
                                                <label class="col-6 label m-0 "><?= $data->arrival_date ?> </label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-auto">
                                            <div class="w-100">

                                                <?php if ($comment[0]->comment) : ?>

                                                    <label class="label m-0" for="">Updates:</label>
                                                    <div class="comment">
                                                        <div>
                                                            <span class="date-comment">Date & Time: <?= formatDateTime($comment[0]->created_on) ?> </span>
                                                            <div>
                                                                <span class="from-comment">-from admin-</span>
                                                                <p class="text-comment"><?= $comment[0]->comment ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif ?>
                                                <div class="text-end mt-2">
                                                    <a href="myrequests-view.php?id=<?= $data->enc_id ?>&loc=<?= $sr->table ?>">View all</a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                <?php } ?>
            <?php endif ?>
          <?php endforeach; ?>
      </div>
      <div class="history-container finishedwork">
      <?php
            $count = 0;
            foreach ($allsr as $key => $sr): ?>
              <?php if ($sr->type === "Visitor Pass"): ?>
                <?php
                  $result = apiSend('tenant', 'get-listnew', ['table' => $sr->table, 'condition' => 'id="' . $sr->id . '" and approve_id = 2']);
                $data = json_decode($result)[0];
                if ($data->approve_id == 2) {
                  $count += 1;
                  if ($count > 5)
                    break;
                }
                if ($data) {
                  $result = apiSend('tenant', 'get-listnew', ['table' => "vp_guest", 'condition' => 'guest_id="' . $data->id . '"']);
                  $vp_g = json_decode($result);
                  $result = apiSend('tenant', 'get-listnew', ['table' => "comments", 'condition' => 'reference_id="' . $sr->id . '" and reference_table="' . $sr->main_table . '"', 'orderby' => 'id DESC', 'limit' => '1']);
                  $comment = json_decode($result);
                  ?>
                                <div class="p-2 ">
                                    <div class="requests-card flex-column gap-2  w-100">

                                        <div class="d-flex justify-content-between border-sr">
                                            <div class="d-flex  gap-1">
                                                <b class="id">#<?= $data->id ?></b>
                                                <p class="status  m-0
                                                    <?php if ($data->approve_id === "1") {
                                                        echo "closed-status";
                                                    } elseif ($data->approve_id === "2") {
                                                        echo "open-status";
                                                    } else {
                                                        echo "open-status acknowledged-btn";
                                                    } ?>"><?= $data->status ?></p>
                                            </div>
                                            <div class="date">
                                                <label><?= $data->date_upload ?></label>
                                            </div>
                                        </div>
                                        <div class="w-100 mt-3">
                                            <div class="row">
                                                <label class="fw-bold  col-6 label m-0 fs-6"><?= $sr->type ?></label><br>
                                            </div>
                                            <div class="row">
                                              <label class="fw-bold col-6 label m-0">Guest:</label><br>
                                              <label class="col-6 label m-0 ">
                                                <?php
                                                echo implode(", ", array_column($vp_g, 'guest_name'));
                                                ?>
                                                </label>
                                              </div>
                                              <div class="row">
                                                  <label class="fw-bold col-6 label m-0">Visit Purpose:</label><br>
                                                  <label class="col-6 label m-0 "><?= $data->visit_purpose ?> </label>
                                              </div>
                                            <div class="row">
                                                <label class="fw-bold col-6 label m-0">Arrival Date:</label><br>
                                                <label class="col-6 label m-0 "><?= $data->arrival_date ?> </label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-auto">
                                            <div class="w-100">

                                                <?php if ($comment[0]->comment) : ?>

                                                    <label class="label m-0" for="">Updates:</label>
                                                    <div class="comment">
                                                        <div>
                                                            <span class="date-comment">Date & Time: <?= formatDateTime($comment[0]->created_on) ?> </span>
                                                            <div>
                                                                <span class="from-comment">-from admin-</span>
                                                                <p class="text-comment"><?= $comment[0]->comment ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif ?>
                                                <div class="text-end mt-2">
                                                    <a href="myrequests-view.php?id=<?= $data->enc_id ?>&loc=<?= $sr->table ?>">View all</a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                <?php } ?>
            <?php endif ?>
          <?php endforeach; ?>
      </div>
    </div>
  </div>

  <?php include('menu.php') ?>
</div>


</body>

</html>
<script>
  $("input[name=departure_date]").change(function() {
			if ($("input[name=arrival_date]").val() === "") {
				popup({
					title: "Please enter arrival date first.",
					data: {
						success: 0
					},
					reload_time: 3000,
					
				});
				$("input[name=arrival_date]").focus();
				$(this).val('');
			} else if ($("input[name=departure_date]").val() < $("input[name=arrival_date]").val()) {
				popup({
					title: "Departure date cannot be before arrival date. Please change.",
					data: {
						success: 0
					},
					reload_time: 3000,
					
				});
				$("input[name=departure_date]").val(''); // Clear the invalid end date
				$("input[name=departure_date]").focus();
			}
		});
  $('.main-submit').click(function () {
    // Check if inputs and selects have values
    var isFormValid = true;
    $('.main input[required], .main select[required]').each(function () {
      if (!$(this).val()) {
        isFormValid = false;
        // $(this).addClass('error');
        console.log($(this));
      }
    });

    if (isFormValid) {
      $("#form-main").submit();
    } else {
      // Trigger HTML built-in validation pop-up for all elements
      $('.main input[required], .main select[required]').each(function () {
        this.reportValidity();
      });
    }
  });

  $("#form-main").off('submit').on('submit', function (e) {

    // Check if any required fields are empty
    $(this).find('[required]').css('border', ''); // Reset border color
    var isFormValid = true;
    $(this).find('[required]').each(function () {
      if ($(this).val() === '') {
        isFormValid = false;
        $(this).css('border', '1px solid red');
        return false; // Exit the loop early
      }
    });

    if (!isFormValid) {
      // Display an error message or perform any other desired action

      e.preventDefault();
      return;
    }
    e.preventDefault();
    $.ajax({
      url: $(this).prop('action'),
      type: 'POST',
      data: $(this).serialize(),
      dataType: 'JSON',
      success: function (data) {
        const res = JSON.parse(data)
        $('#guest_id').val(res.id)
        $('#item-send').submit();
        popup({
          data: res,
          reload_time: 2000,
          redirect: location.href
        })
      },
    });
  });

  let items = []
  $('#btn-add-item').on('click', function (e) {
    e.preventDefault();
    const name = $('input[name="guest_name[]"]').val()
    const number = $('input[name="guest_num[]"]').val()

    if (name && number) {
      $('.table-data').append(`
    <div class="description-form">
        <div class="description-label">
                <p>Name</p>
                <p>Contact #</p>
            </div>
            <div class="description-value">
                <p>${name}</p>
                <p>${number}</p>
            </div>
    </div>
    `);
      var item = {
        guest_name: name,
        guest_no: number,
      };

      items.push(item);

      $('input[name="guest_name[]"]').val('')
      $('input[name="guest_num[]"]').val('')
    }
  });



  $('#item-send').submit(function (e) {
    e.preventDefault(); // Prevent the form from submitting normally
    items = items.map(obj => ({
      ...obj,
      guest_id: $('#guest_id').val(),
      table: 'vp_guest'
    }));

    items.forEach(i => {
      $.ajax({
        url: $(this).prop('action'),
        method: 'POST',
        data: i,
        success: function (data) {
        },
        error: function (xhr, status, error) {
          console.error(error);
        }
      });
    })



  });



  $('.acknowledged').hide();
  $('.finishedwork').hide();
  $("#btnSubmit").on('click', function () {
    $('.submitted').show();
    $('.acknowledged').hide();
    $('.finishedwork').hide();
  })
  $("#btnAcknowledged").on('click', function () {
    $('.submitted').hide();
    $('.acknowledged').show();
    $('.finishedwork').hide();
  })
  $("#btnFinish").on('click', function () {
    $('.submitted').hide();
    $('.acknowledged').hide();
    $('.finishedwork').show();
  })

  var i = 1;


  $('.btn-status').off('click').on('click', function () {
    $('#collapse-status').collapse('toggle');
  });
  $('#up1').hide();

  $('#collapse-status').on('hidden.bs.collapse', function () {
    $('#up1').hide();
    $('#down1').show();
    $('.add-ons').remove()
  });

  $('#collapse-status').on('show.bs.collapse', function () {
    $('#up1').show();
    $('#down1').hide();
    $('.main input:not([readonly]):not([disabled]):not([name="contact_no"]), .main select:not([readonly]):not([disabled]), .main textarea').each(function () {
      $(this).val('');
    });
    items = []
    $('.description-form').remove();
  });
  $(".close-btn").on('click', function () {
    $('#collapse-status').collapse('toggle');
  });

  $('.back-button-sr').on('click', function () {
    history.back();
  });
</script>