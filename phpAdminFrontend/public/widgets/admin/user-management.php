<?php
$title = "";
$menu = "";
$module = "";
$table = "locations";
$view = "";
$fields = rawurlencode(json_encode([
	"ID" => "rec_id",
	"Name" => "location_name",
	"Parent Location" => "parent_location_name",
	"Location Type" => "location_type",
	"Location Use" => "location_use",
	"Floor Area" => "floor_area",
	"Status" => "location_status",
]));

$role_access = $ots->execute('form', 'get-role-access', [ 'table'=>$table ]);
$role_access = json_decode($role_access);
$menuid = "propman";
$submenuid = "locationlibrary";
?>

<div class="main-container">
    <div class="container-table">
        <div class="dropdown-menu-filter dropdown-menu " style="width: 22%" id="dropdownmenufilter">
            <div class="dropdown-menu-filter-fields"></div>

            <div class="btn-group-buttons mt-3">
                <div class="d-flex justify-content-between  mb-3 gap-2" style="padding: 5px;">

                    <button class="btn-close-now btn btn-light btn-cancel">Close</button>
                    <div>
                        <button class="btn-reset-now btn-cancel btn mx-2">Reset</button>
                        <button type="button" class="btn btn-dark btn-primary btn-filter-now px-5">Filter</button>
                    </div>
                </div>
            </div>
        </div>


        <table id="jsdata"></table>

    </div>
</div>


<script>
    t<?= $unique_id; ?> = $("#jsdata").JSDataList({
        ajax: {
            url: "<?= WEB_ROOT . "/utilities/get-list/{$view}?display=plain" ?>"
        },
        // rowLink: {
        // 	url: '<?= WEB_ROOT; ?>/property-management/view-equipment/',
        // 	params : [
        // 		{
        // 			"key":"id",
        // 			"value": "encryptedid"
        // 		}
        // 	],
        // },
        rowClass: 'hover:bg-gray-100',
        titleClass: 'text-rentaPageTitle',
        filterBoxID: 'dropdownmenufilter',
        buttons: [{
                icon: `<span class="material-symbols-outlined">add</span>`,
                title: "Create New",
                class: "btn-add btn-blue",
                id: "edit",

            },
            //
            // <?php if ($role_access->delete == true) : ?> {
            // 	icon: `<span class="material-symbols-outlined">delete</span>`,
            // 		title: "Delete",
            // 		class: "btn-delete-filter",
            // 		id: "delete",
            // 	},
            // <?php endif; ?>
            //
            <?php if ($role_access->download == true) : ?> {
                    icon: `<span class="material-symbols-outlined">arrow_downward</span>`,
                    title: "Download",
                    class: "btn-download",
                    href: "<?= WEB_ROOT; ?>/module/download/?display=csv&module=<?= $module ?>&table=<?= $table ?>&view=<?= $view ?>&fields=<?= $fields ?>",
                    id: "download",
                },
            <?php endif; ?> 

        ],
        columns: [{
                data: "id",
                label: "ID #",
                class: ' table-id',
                datatype: "none",
                render: function(data, row) {
                    return row.data_id
                    // return '<input class="" type="checkbox" id="' + row.id + '" name="check_box" table="tenant" view_table="view_soa" reload="<?= WEB_ROOT; ?>/tenant/tenant-billing?submenuid=tenant_billing"> ' + row.data_id;
                }
            },
            {
                data: "remaining_balance",
                label: "First Name",
                class: '',
                datatype: "select",
                list: ["0|Paid", "1|Unpaid"],


            },
            {
                data: 'tenant_name',
                label: "Surname",
                class: '',
                datatype: "none",
            },
            {
                data: 'remaining_balance_formated',
                label: "Outstanding Balance",
                class: ' ',
                datatype: "none",


            },
            {
                data: 'total_amount_due',
                label: 'Email',
                class: '',
                datatype: "none",

            },
            {
                data: null,
                label: "Property Access",
                class: ' ',
                datatype: "none",


            },
            {
                data: null,
                label: "Action",
                class: '',
                datatype: "none",
            }
        ],
        order: [
            [0, 'asc']
        ],
        // colFilter: {'status':'Active'}
    });
</script>