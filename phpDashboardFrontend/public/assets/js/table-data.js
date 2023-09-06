const table_data = (props) => {

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
            url: props.url, // Replace with your server-side script URL
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

        if (param.length != 0 ) {
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
