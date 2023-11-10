/**
 * Function Show Delete Modal Will delete the id of the button
 *
 * @button_data array elements of the button - must use the attr('title') and ('del_url')
 *
 * Please
 *
 */


function popup(e) {
    const data = e.data
    //alert-error
    //alert-warning
    $('html').append(`
  <div class="alert-card ${data.success != 1 ? 'alert-warning' : ''} ">
	<div>
		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
			<path d="M12 7.5C12.55 7.5 13 7.95 13 8.5V12.5C13 13.05 12.55 13.5 12 13.5C11.45 13.5 11 13.05 11 12.5V8.5C11 7.95 11.45 7.5 12 7.5ZM11.99 2.5C6.47 2.5 2 6.98 2 12.5C2 18.02 6.47 22.5 11.99 22.5C17.52 22.5 22 18.02 22 12.5C22 6.98 17.52 2.5 11.99 2.5ZM12 20.5C7.58 20.5 4 16.92 4 12.5C4 8.08 7.58 4.5 12 4.5C16.42 4.5 20 8.08 20 12.5C20 16.92 16.42 20.5 12 20.5ZM13 17.5H11V15.5H13V17.5Z"  fill="${data.success != 1 ? '#663000' : '#10513F'}" />
		</svg>
	</div>
	<div>
		<p>${e.title ? e.title : data.description}</p>
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
            if (data.success === 1) {
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


function table_data(props) {

    let currentPage = 1;
    const itemsPerPage = 3; // Adjust as needed
    let data = {}; // Declare the data variable

    function goToPage(page) {
        if (page === 'prev' && currentPage > 1) {
            currentPage--;
        } else if (page === 'next' && currentPage) {
            currentPage++;
        }
        // Update UI and fetch data for the new page
        updatePageUI();
        fetchOccupantsData();
    }

    function updatePageUI() {
        const pageInfo = document.querySelector('.page-info');
        if (data.max) {
            pageInfo.textContent = `Page ${currentPage} of ${data.max}`;
        } else {
            pageInfo.textContent = 'Loading...';
        }
    }

    function fetchOccupantsData() {
        $.ajax({
            url: props.url,
            method: 'POST',
            data: {
                page: currentPage,
                table: props.table,
                unitowner: props.unitowner,
                limit: itemsPerPage
            },
            success: function (response) {
                data = JSON.parse(response);

                html(data.data);
                updatePageUI();
            },
            error: function (xhr, status, error) {

            }
        });
    }

    function html(param) {
        $('.table-data').html('');

        if (param.length != 0) {
            param.forEach((item) => {


                $('.table-data').append(`
              <div class="col-12">
                  <a href="${location.origin}/${props.view}?id=${item.enc_id}" class="occupant">
                      <div class="d-flex gap-2 w-100">
                          <img src="${item.profile_pic ? item.profile_pic : './assets/icon/profile.png'}" alt="">
                          <div class="d-flex flex-column gap-2 w-100">
                              <b class="${item.status === 'Active' || item.status === 'Approved' ? 'green' : 'red'}">${item.status}</b>
                              <div>
                                  <h1 class="m-0">${item.fullname}</h1>
                                  <p class="m-0">${item.unit_name ? item.unit_name : ''}</p>
                              </div>
  
                          </div>
                      </div>
                  </a>
              </div>
          `);

            });
        } else {
            $('.table-data').append(`
          <div class="text-left"><b> No data </b>
          </div>
          `);

        }

        // Disable "Next" button if there is no more data to load
        const nextBtn = document.querySelector('.next-btn');
        if (data.max && currentPage >= data.max) {
            nextBtn.disabled = true;
        } else {
            nextBtn.disabled = false;
        }
    }

    function btn() {
        $('.table-data').after(`
          <div class="pagination-table">
              <button class="prev-btn main-btn" style="font-size: 15px;">Previous</button>
              <span class="page-info" style="font-size: 12px;">Loading...</span>
              <button class="next-btn main-btn" style="font-size: 15px;">Next</button>
          </div>
      `);
    }

    btn();
    fetchOccupantsData();

    $('.prev-btn').click(function () {
        goToPage('prev');
    });

    $('.next-btn').click(function () {
        goToPage('next');
    });

    // Initial data fetch on page load
}

// Call the table_data function to start everything
table_data();


function update_status(table, id, field, status, WEB_ROOT, email = '') {
    console.log(table)
    $.ajax({
        url: WEB_ROOT + "/update-status.php",
        type: 'POST',
        data: {
            table: table,
            id: id,
            field: field,
            status: status,
            email: email
        },
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


// Function to handle image compression
function compressImage(file, maxSize, callback) {
    const reader = new FileReader();
    reader.onload = function (event) {
        const img = new Image();
        img.onload = function () {
            const canvas = document.createElement('canvas');
            let width = img.width;
            let height = img.height;

            // Check if the image size exceeds the maximum size
            if (file.size > maxSize) {
                const aspectRatio = width / height;
                if (width > height) {
                    width = Math.sqrt(maxSize * aspectRatio);
                    height = width / aspectRatio;
                } else {
                    height = Math.sqrt(maxSize / aspectRatio);
                    width = height * aspectRatio;
                }
            }

            canvas.width = width;
            canvas.height = height;

            const ctx = canvas.getContext('2d');
            ctx.drawImage(img, 0, 0, width, height);

            canvas.toBlob(function (blob) {
                callback(blob);
            }, file.type);
        };
        img.src = event.target.result;
    };
    reader.readAsDataURL(file);
}

function remove_notif(id, WEB_ROOT) {
    $.ajax({
        url: WEB_ROOT + "/save.php",
        type: 'POST',
        data: {
            table: 'notif',
            id: id,
            post_portal: 1,
        },
        dataType: 'JSON',
        success: function (data) {
            $('#notif-'+ id).remove()
        },
    });
}


function redirect(event,id,enc_ref_id,reference_table,WEB_ROOT){
    const clickedElement = event.target;
    if (clickedElement.tagName === "BUTTON") {
        return
    }
    if(reference_table === 'workpermit') {
        location.href = `${WEB_ROOT}/myrequests-view.php?id=${enc_ref_id}&loc=vw_workpermit`
    } else if (reference_table === 'report_issue') {
        location.href = `${WEB_ROOT}/myrequests-view.php?id=${enc_ref_id}&loc=vw_report_issue`
    } else if (reference_table === 'visitorpass') {
        location.href = `${WEB_ROOT}/myrequests-view.php?id=${enc_ref_id}&loc=vw_visitor_pass`
    } else if (reference_table === 'gatepass') {
        location.href = `${WEB_ROOT}/myrequests-view.php?id=${enc_ref_id}&loc=vw_gatepass`
    } 
  
}