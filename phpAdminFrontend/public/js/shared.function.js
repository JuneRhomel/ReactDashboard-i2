/**
 * Function Show Delete Modal Will delete the id of the button
 *
 * @button_data array elements of the button - must use the attr('title') and ('del_url')
 *
 * Please
 *
 */

// UPDATE STATUS
function update_status(table, id, field, status, WEB_ROOT, email = '') {
  $.ajax({
    url: WEB_ROOT + "/module/update-status?display=plain",
    type: 'POST',
    data: { 'table': table, 'id': id, 'field': field, 'status': status, 'email': email },
    dataType: 'JSON',
    success: function (data) {
      popup({
        data: data,
        reload_time: 2000,
        redirect: location.href
      })
    },
  });
}

function show_delete_modal(button_data) {
  if ($(button_data).attr("role_access") == true) {
    Swal.fire({
      title: $(button_data).attr("title"),
      text:
        "You won't be able to revert this record ID #" +
        $(button_data).attr("rec_id"),
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Confirm",
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        window.location.href = $(button_data).attr("del_url");
      }
    });
  } else {
    Swal.fire({
      title: "Access Denied",
      text: "You don't have access to delete records.",
      icon: "warning"
    });
  }
}

function show_update_modal(button_data) {
  if ($(button_data).attr("role_access") == true) {
    Swal.fire({
      title: $(button_data).attr("title"),
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Confirm",
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        Swal.fire("Updated!", "Your record has been updated.", "success");
        window.location.href = $(button_data).attr("del_url");
      }
    });
  } else {
    Swal.fire({
      title: "Access Denied",
      text: "You don't have access to update this records.",
      icon: "warning"
    });
  }
}

function show_approval_modal(button_data) {
  // if($(button_data).attr("role_access") ==  true){
  Swal.fire({
    title: $(button_data).attr("title"),
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Confirm",
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      Swal.fire("Updated!", "Your record has been updated.", "success");
      window.location.href = $(button_data).attr("redirect_url");
    }
  });
  // }else{
  // Swal.fire({
  //   title: "Access Denied",
  //   text: "You don't have access to update this records.",
  //   icon: "warning"
  // });
  // }
}

function closeSwal() {
  window.location.reload();
  swal.close();
}

function show_success_modal(href) {
  // var_dump(button_data);
  Swal.fire({
    title: "Great!",
    text: "Your request has been created successfully.",
    confirmButtonText: "Okay",
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      window.location.href = href;
    }
  });
}

function show_success_reading(href) {
  // var_dump(button_data);
  Swal.fire({
    title: "Great!",
    text: "Your request has been created successfully.",
    confirmButtonText: "Okay",
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      window.location.href = href;
    }
  });
}

function show_success_paynow_modal(href) {
  // var_dump(button_data);
  Swal.fire({
    title: "Great!",
    text: "Paid Successfully.",
    confirmButtonText: "Okay",
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      window.location.reload();
    }
  });
}

function showModalRequired() {
  Swal.fire({
    title: "Error",
    text: "This field is required",
    icon: "error",
  });
}

function hideModalRequired() {
  Swal.close();
}

function show_success_modal_upload(href) {
  // var_dump(button_data);
  Swal.fire({
    title: "Great!",
    text: "Upload Successfully.",
    confirmButtonText: "Okay",
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      //window.location.href = href;
      $("#upload").modal("hide");
      location.reload();
    }
  });
}

function table_delete_records(ids, table, view, reload_, url_save) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this record!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Confirm",
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      $.ajax({
        url: url_save,
        type: "POST",
        dataType: "JSON",
        data: { ids: ids, table: table, view_table: view },
        success: function (data) {
          if (data.success == 1) {
            show_success_modal(reload_);
          }
        },
      });
    }
  });
}

function show_equipment_category_list(button_data) {
  Swal.fire({
    title: "Category List",
    html: "<ul style='text-align:left !important'><li>Mechanical</li><li>Electrical</li><li>Fire Protection</li><li>Plumbing & Sanitary</li><li>Civil</li><li>Structural</li></ul>",
    // showCancelButton: true,
    // confirmButtonText: 'Save',
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      // window.location.href = $(button_data).attr('del_url');
    }
  });
}

function show_equipment_type_list(category) {
  allowed_type = {
    Mechanical: [
      "Air-conditioning",
      "Elevator",
      "Fire Detection & Alarm System",
      "Pumps",
      "Generator",
      "building Management System",
      "CCTV",
      "Pressurization Blower /  Fan",
      "Exhaust Fan",
      "Gondola",
      "Others",
    ],
    Electrical: [
      "Transformers",
      "UPS",
      "Automatic Transfer Switch",
      "Control Gear",
      "Switch Gear",
      "Capacitor",
      "Breakers / Panel Boards",
      "Meters",
      "Others",
    ],
    Fire_Protection: [
      "Sprinklers",
      "Smoke Detectors",
      "Manual Pull Stations",
      "Fire Alarm",
      "FDAS Panel",
      "Others",
    ],
    Fire_Protection_Plumbing: ["Others"],
    Civil: ["Others"],
    Structural: ["Others"],
  };

  allowed = allowed_type[category];
  li = "";
  $(allowed).each(function () {
    li += "<li>" + this + "</li>";
  });
  category = category.replace("_", " ");
  Swal.fire({
    html:
      "<b>" +
      category +
      " Type List </b> <ul style='text-align:left !important'>" +
      li +
      "</ul>",
    // showCancelButton: true,
    // confirmButtonText: 'Save',
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      // window.location.href = $(button_data).attr('del_url');
    }
  });
}


function popup(e) {
  const data = e.data
  //alert-error
  //alert-warning
  $('body').append(`
  <div class="alert-card ${data.success != 1 ? 'alert-warning' : ''} ">
	<div>
		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
			<path d="M12 7.5C12.55 7.5 13 7.95 13 8.5V12.5C13 13.05 12.55 13.5 12 13.5C11.45 13.5 11 13.05 11 12.5V8.5C11 7.95 11.45 7.5 12 7.5ZM11.99 2.5C6.47 2.5 2 6.98 2 12.5C2 18.02 6.47 22.5 11.99 22.5C17.52 22.5 22 18.02 22 12.5C22 6.98 17.52 2.5 11.99 2.5ZM12 20.5C7.58 20.5 4 16.92 4 12.5C4 8.08 7.58 4.5 12 4.5C16.42 4.5 20 8.08 20 12.5C20 16.92 16.42 20.5 12 20.5ZM13 17.5H11V15.5H13V17.5Z"  fill="${data.success != 1 ? '#663000' : '#10513F'}" />
		</svg>
	</div>
	<div>
		<p>${e.title? e.title :  data.description}</p>
	</div>
	<div class="close">
		<button class="close-alert">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
				<path d="M18.3 6.21022C17.91 5.82022 17.28 5.82022 16.89 6.21022L12 11.0902L7.10997 6.20021C6.71997 5.81021 6.08997 5.81021 5.69997 6.20021C5.30997 6.59021 5.30997 7.22022 5.69997 7.61022L10.59 12.5002L5.69997 17.3902C5.30997 17.7802 5.30997 18.4102 5.69997 18.8002C6.08997 19.1902 6.71997 19.1902 7.10997 18.8002L12 13.9102L16.89 18.8002C17.28 19.1902 17.91 19.1902 18.3 18.8002C18.69 18.4102 18.69 17.7802 18.3 17.3902L13.41 12.5002L18.3 7.61022C18.68 7.23022 18.68 6.59022 18.3 6.21022Z" fill="${data.success != 1 ? '#663000' : '#10513F'}" />
			</svg>

		</button>
	</div>
</div>
  `)


  const alertCard = $('.alert-card');
  let hideTimer;

  $('.close-alert').click(function () {
    alertCard.fadeOut(); 
  });

  // Set a timer to hide the alert card after a certain duration with a fade-out effect.
  const hideDuration = e.reload_time; 

  function startHideTimer() {
    hideTimer = setTimeout(function () {
      alertCard.fadeOut();
      if(data.success === 1 ) {
        if (e.redirect) {
          location.href = e.redirect
        }
      } 
    }, hideDuration);
  }
  startHideTimer();



  // Pause the timer when the alert-card is hovered
  alertCard.hover(
    function () {
      clearTimeout(hideTimer);
    },
    function () {
      startHideTimer();
    }
  );
}