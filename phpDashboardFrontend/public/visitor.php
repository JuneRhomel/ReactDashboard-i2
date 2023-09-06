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


$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_visitor_pass', 'condition' => 'created_by="' . $user->id . '" AND status = "Pending"']);
$vp_pendding = json_decode($result);
$pendingtotal = count($vp_pendding);

// var_dump($vp_pendding);

$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_visitor_pass', 'condition' => 'created_by="' . $user->id . '" AND status = "Approved"']);
$vp_approved = json_decode($result);
$approvedtotal = count($vp_approved);


$result =  apiSend('tenant', 'get-list-sr', ['table' => 'vw_visitor_pass', 'condition' => 'created_by="' . $user->id . '" AND status = "Denied"']);
$vp_denied = json_decode($result);
$deniedtotal = count($vp_denied);

?>


<div class="d-flex">


  <div class="main">
    <?php include("navigation.php") ?>
    <div class="d-flex align-items-center px-3 mt-3">
      <button class="back-button-sr" style="width: 30px; height: 29px; background-color: transparent; border-radius: 10px; border: 1px solid #1C5196;color: #1C5196;font-size: 10px; "><i class="fa-solid fa-chevron-left"></i></button>
      <label class="heading-page px-2 m-0" style="font-weight: 600; font-size: 22px; color: #1C5196;">
        Visitor's Pass</label>
    </div>
    <div style="background-color: #F0F2F5; padding: 20px 24px 106px 24px;">
      <div class="d-flex justify-content-center pt-3" style="background-color: #F0F2F5;">
        <div class="card mb-3" style="width: 100%">
          <div class="mb-0">
            <button class="d-flex align-items-center justify-content-between btn btn-status w-100" style="padding: 12px;">
              <div><label class="m-0" style="font-weight: 400; color:#1C5196;">Request form</label></div>
              <div><i id="down1" style="color:#1C5196" class="fa-solid fa-caret-down"></i><i id="up1" style="color:#1C5196" class="fa-solid fa-caret-down fa-rotate-180"></i></div>
            </button>
          </div>
          <div id="collapse-status" class="collapse">

            <div class="card-body" style="margin-top:16px">
              <div class=" forms">
                <form action="http://portali2.sandbox.inventiproptech.com/gatepass-save.php" method="post" id="form-main">
                  <input name="date" type="hidden" readonly value="<?= date('Y-m-d H:i:s') ?> ">
                  <input name="module" type="hidden" readonly value="<?= $module ?>">
                  <input name="table" type="hidden" readonly value="<?= $table ?>">
                  <input type="hidden" name="name_id" readonly value="<?= $user->id ?>">
                  <input type="hidden" name="unit_id" readonly value="<?= $user->def_unit_id ?>">
                  <div class="w-100">
                    <div class="w-100 form-group">
                      <input id="request-form" name="name" value="<?= $user->fullname ?>" disabled required placeholder="text">
                      <label id="request-form">Requestor Name <span class="text-danger">*</span></label>
                    </div>
                  </div>

                  <div class="w-100">
                    <div class="w-100 form-group">
                      <input id="request-form" name="unit" type="text" disabled value="<?= $user->default_unit ?>" required placeholder="text">
                      <label id="request-form">Unit # <span class="text-danger">*</span></label>
                    </div>
                  </div>
                  <div class="w-100">
                    <div class="w-100 form-group">
                      <input id="request-form" name="contact_no" type="text" value="<?= $user->contact_no ?>" required placeholder="text">
                      <label id="request-form">Contact Number <span class="text-danger">*</span></label>
                    </div>
                  </div>
                  <div class="">
                    <div class="form-group">
                      <input type="date" id="request-form" name="arrival_date" required placeholder="text">
                      <label for="" id="request-form" class="text-required">Date of Arrival <span class="text-danger">*</span></label>
                    </div>
                  </div>
                  <div class="">
                    <div class="form-group">
                      <input type="time" name="arrival_time" id="request-form" required placeholder="text">
                      <label for="" id="request-form" class="text-required">Time of Arrival <span class="text-danger">*</span></label>
                    </div>
                  </div>
                  <div class="">
                    <div class="w-100 form-group">
                      <input type="date" name="departure_date" id="request-form" required placeholder="text">
                      <label for="" id="request-form" class="text-required">Date of Departure <span class="text-danger">*</span></label>
                    </div>
                  </div>
                  <div class="">
                    <div class="form-group">
                      <input type="time" id="request-form" name="departure_time" required placeholder="text">
                      <label for="" id="request-form" class="text-required">Time of Departure <span class="text-danger">*</span></label>
                    </div>
                  </div>
                </form>
                <label style="font-weight: 400; font-size: 24px;  margin:27px 0;">Guest List</label>

                <div class="table-data add-ons" id="add-ons">

                </div>


                <input id="guest_id" type="hidden" readonly class="form-control">
                <form method="post" action="http://portali2.sandbox.inventiproptech.com/gatepass-save.php" id="item-send">
                  <div>
                    <div id="visitorItem" class="input-items">
                      <div>
                        <div class="form-group">
                          <input id="request-form" type="text" name="guest_name[]" placeholder="text">
                          <label id="request-form">Name</label>
                        </div>
                        <div class="form-group">
                          <input id="request-form" type="number" name="guest_num[]" placeholder="text">
                          <label id="request-form">Contact #</label>
                        </div>
                        <div class="form-group">
                          <input id="request-form" type="text" name="guest_add[]" placeholder="text">
                          <label id="request-form">Vist Purpose</label>
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
                      <button type="submit" class="btn main-submit btn-dark btn-primary settings-save d-block px-5 w-100">Submit</button>
                    </div>
                    <div class="btn-settings">
                      <button type="button" class="close-btn  btn btn-light btn-cancel settings-cancel d-block px-5 w-100">Cancel</button>
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
          <label id="btnSubmit" class="btn first-tab btn-tab-service btn-outline-primary" for="btnradio1">Pending <span><?= $pendingtotal ?></span></label>

          <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
          <label id="btnAcknowledged" class="btn btn-tab-service btn-outline-primary" for="btnradio2">Approved <span><?= $approvedtotal ?></span> </label>

          <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
          <label id="btnFinish" class="btn btn-tab-service btn-outline-primary" for="btnradio3">Denied<span><?= $deniedtotal ?></span> </label>
        </div>
      </div>

      <div>
        <div class="history-container submitted">
          <?php
          $limit = 4; // Set the initial limit here
          $totalItems = count($vp_pendding);
          $showItems = min($limit, $totalItems);

          for ($i = 0; $i < $showItems; $i++) {
            $item = $vp_pendding[$i];

            $result = apiSend('module', 'get-listnew', ['table' => 'vp_guest', 'condition' => 'guest_id="' . $item->id . '"']);
            $personel = json_decode($result);
          ?>
            <div class="card-history">
              <div class="w-100">
                <div class="head w-100">
                  <div class="d-flex gap-2">
                    <span>#<?= $item->id ?></span>
                    <div><?= $item->status ?></div>
                  </div>
                  <label><?= $item->date_upload ?></label>
                </div>
                <div>
                  <p>Name: <?= $item->fullname ?></p>
                  <p>Unit: <?= $item->location_name ?></p>
                  <p class="">Visitor Name:
                    <?php

                    foreach ($personel as $vp_g) {
                      echo $vp_g->guest_name . ',';
                    };
                    ?>
                  </p>
                </div>
              </div>
            </div>
          <?php
          }
          ?>
        </div>

        <div class="history-container acknowledged">
          <?php
          $limit = 4; // Set the initial limit here
          $totalItems = count($vp_approved);
          $showItems = min($limit, $totalItems);

          for ($i = 0; $i < $showItems; $i++) {
            $item = $vp_approved[$i];

            $result = apiSend('module', 'get-listnew', ['table' => 'vp_guest', 'condition' => 'guest_id="' . $item->id . '"']);
            $personel = json_decode($result);
          ?>
            <div class="card-history">
              <div class="w-100">


                <div class="head w-100">
                  <div class="d-flex gap-2">
                    <span>#<?= $item->id ?></span>
                    <div><?= $item->status ?></div>
                  </div>

                  <label><?= $item->date_upload ?></label>
                </div>
                <div>
                  <p>Name: <?= $item->fullname ?></p>
                  <p>Unit: <?= $item->unit ?></p>
                  <p class="">Visitor Name:
                    <?php

                    foreach ($personel as $vp_g) {
                      echo $vp_g->guest_name . ',';
                    };
                    ?>
                  </p>
                </div>
              </div>
            </div>
          <?php
          }
          ?>
        </div>
        <div class="history-container finishedwork">
          <?php
          $limit = 4; // Set the initial limit here
          $totalItems = count($vp_denied);
          $showItems = min($limit, $totalItems);

          for ($i = 0; $i < $showItems; $i++) {
            $item = $vp_denied[$i];


            $result = apiSend('module', 'get-listnew', ['table' => 'vp_guest', 'condition' => 'guest_id="' . $item->id . '"']);
            $personel = json_decode($result);
          ?>
            <div class="card-history">
              <div class="w-100">


                <div class="head w-100">
                  <div class="d-flex gap-2">
                    <span>#<?= $item->id ?></span>
                    <div><?= $item->status ?></div>
                  </div>

                  <label><?= $item->date_upload ?></label>
                </div>
                <div>
                  <p class="">Visitor Name:
                    <?php

                    foreach ($personel as $vp_g) {
                      echo $vp_g->guest_name . ',';
                    };
                    ?>
                  </p>
                  <p>Name: <?= $item->fullname ?></p>
                  <p>Unit: <?= $item->unit ?></p>

                </div>
              </div>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
    </div>

  </div>
  <?php include('menu.php') ?>
</div>

</body>

</html>
<script>
  $('.main-submit').click(function() {
    // Check if inputs and selects have values
    var isFormValid = true;
    $('.main input[required], .main select[required]').each(function() {
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
      $('.main input[required], .main select[required]').each(function() {
        this.reportValidity();
      });
    }
  });

  $("#form-main").off('submit').on('submit', function(e) {

    // Check if any required fields are empty
    $(this).find('[required]').css('border', ''); // Reset border color
    var isFormValid = true;
    $(this).find('[required]').each(function() {
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
      success: function(data) {
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
  $('#btn-add-item').on('click', function(e) {
    e.preventDefault();
    const name = $('input[name="guest_name[]"]').val()
    const number = $('input[name="guest_num[]"]').val()
    const add = $('input[name="guest_add[]"]').val()

    if (name && number && add) {
      $('.table-data').append(`
    <div class="description-form">
        <div class="description-label">
                <p>Name</p>
                <p>Contact #</p>
                <p>Address</p>
            </div>
            <div class="description-value">
                <p>${name}</p>
                <p>${number}</p>
                 <p>${add}</p>
            </div>
    </div>
    `);
      var item = {
        guest_name: name,
        guest_no: number,
        guest_purpose: add,
      };

      items.push(item);

      $('input[name="guest_name[]"]').val('')
      $('input[name="guest_num[]"]').val('')
      $('input[name="guest_add[]"]').val('')
    }
  });



  $('#item-send').submit(function(e) {
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
        success: function(data) {
          console.log(data)
          // if (data.success == 1) {
          //   toastr.success(data.description, 'Information', {
          //     timeOut: 2000,
          //     onHidden: function() {
          //       location.reload()
          //     }
          //   });
          // }
        },
        error: function(xhr, status, error) {

          console.error(error);
        }
      });
    })



  });



  $('.acknowledged').hide();
  $('.finishedwork').hide();
  $("#btnSubmit").on('click', function() {
    $('.submitted').show();
    $('.acknowledged').hide();
    $('.finishedwork').hide();
  })
  $("#btnAcknowledged").on('click', function() {
    $('.submitted').hide();
    $('.acknowledged').show();
    $('.finishedwork').hide();
  })
  $("#btnFinish").on('click', function() {
    $('.submitted').hide();
    $('.acknowledged').hide();
    $('.finishedwork').show();
  })

  var i = 1;


  $('.btn-status').off('click').on('click', function() {
    $('#collapse-status').collapse('toggle');
  });
  $('#up1').hide();

  $('#collapse-status').on('hidden.bs.collapse', function() {
    $('#up1').hide();
    $('#down1').show();
    $('.add-ons').remove()
  });


  $('#collapse-status').on('show.bs.collapse', function() {
    $('#up1').show();
    $('#down1').hide();
    $('.main input:not([readonly]):not([disabled]):not([name="contact_no"]), .main select:not([readonly]):not([disabled]), .main textarea').each(function() {
      $(this).val('');
    });
    items = []

    $('.description-form').remove();
  });
  $(".close-btn").on('click', function() {
    $('#collapse-status').collapse('toggle');
  });

  $('.back-button-sr').on('click', function() {
    history.back();
  });
</script>