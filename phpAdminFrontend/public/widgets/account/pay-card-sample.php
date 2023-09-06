<?php
$data = [    
    'view'=>'building_profile',
];
$building_profile = $ots->execute('admin','get-record',$data);
$building_profile = json_decode($building_profile);
//PERMISSIONS
//get user role
$data = [	
	'view'=>'users'
];
$user = $ots->execute('property-management','get-record',$data);
$user = json_decode($user);

//check if has access
$data = [
	'role_id'=>$user->role_type,
	'table'=>'building_profile',
	'view'=>'role_rights'

];
$role_access = $ots->execute('form','get-role-access',$data);
$role_access = json_decode($role_access);
// var_dump($role_access);
?>
<?php if($role_access->read != true): ?>
	<div class="card mx-auto" style="max-width: 30rem;">
		<div class="card-header bg-danger">
			Unauthorized access
		</div>
		<div class="card-body text-center">
			You are not allowed to access this resource. Please check with system administrator.
		</div>
	</div>
<?php else: ?>
<hr>
<div id="error-container">

</div>
<h3 class='h3 h3-title mt-2' >Building Profile</h3>
<div class="d-flex">
	<div class="d-flex flex-row-reverse my-1" style="width: 100%;">
        <?php if($role_access->update == true): ?>
            <?php if($building_profile) :?>
                <a  class='btn btn-sm btn-primary float-end btn-view-form px-5 edit-bill-water ' onclick="$('#bill-and-rates-modal').modal('show')">Edit</a>
            <?php else: ?>
                <a  class='btn btn-sm btn-primary float-end btn-view-form px-5 edit-bill-water ' onclick="$('#bill-and-rates-modal').modal('show')">Add</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<div class="bg-white my-2 rounded">
	<table class="table table-data water-table text-primary">
        <tr>
            <th>Building Name</th>
            <td class="td-border"> <?=($building_profile) ? $building_profile->building_name: '';?> </td>
        </tr>
        <tr>
            <th>Building Address</th>
            <td class="td-border"> <?=($building_profile) ? $building_profile->building_address: '';?> </td>
        </tr>
        <tr>
            <th>Year Built</th>
            <td class="td-border"> <?=($building_profile) ? $building_profile->year_built: '';?></td>
        </tr>
        <tr>
            <th>Gross Floor Area</th>
            <td class="td-border"> <?=($building_profile) ? $building_profile->gross_floor: '';?> </td>
        </tr>
        <tr>
            <th>Gross Leasable Area</th>
            <td class="td-border"> <?=($building_profile) ? $building_profile->gross_leasable: '';?> </td>
        </tr>
        <tr>
            <th>Use</th>
            <td class="td-border"> <?=($building_profile) ? $building_profile->building_use: '';?> </td>
        </tr>
        <tr>
            <th>Number of Building Floors (Ground and above)</th>
            <td class="td-border"> <?=($building_profile) ? $building_profile->ground_above: '';?> </td>
        </tr>
        <tr>
            <th>Number of Building Floors (Below ground)</th>
            <td class="td-border"> <?=($building_profile) ? $building_profile->below_ground: '';?> </td>
        </tr>
	</table>
</div>

<div class="modal" tabindex="-1" role="dialog" id='bill-and-rates-modal'>
		<div class="modal-dialog  modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" onclick='$("#bill-and-rates-modal").modal("hide")' aria-label="Close">
                        </button>
				</div>
				<div class="modal-body">
                    <form class="bg-white" disabled id='building_profile_edit'>
                    <input type="hidden" name='redirect' id='redirect' value= '<?= WEB_ROOT?>/admin/building-profile?submenuid=building_profile' >
                    <input type="hidden" name='table' value='building_profile'>
                    <input type="hidden" name='id' value='<?=($building_profile) ? $building_profile->id: '';?>'>

                        <table class="table table-data water-table text-primary">
                            <tr>
                                <th>Building Name</th>
                                <td><input type='text' id='building_name' name='building_name' class='form-control' value='<?=($building_profile) ? $building_profile->building_name: '';?>'></td>
                            </tr>
                            <tr>
                                <th>Building Address</th>
                                <td><input type='text' id='building_address' name='building_address' class='form-control' value='<?=($building_profile) ? $building_profile->building_address: '';?>'></td>
                            </tr>
                            <tr>
                                <th>Year Built</th>
                                <td class='billing-rates-th'><input type='text' id='year_built' name='year_built' class='form-control' value='<?=($building_profile) ? $building_profile->year_built: '';?>'></td>
                            </tr>
                            <tr>
                                <th>Gross Floor Area</th>
                                <td><input type='text' id='gross_floor' name='gross_floor' class='form-control' value='<?=($building_profile) ? $building_profile->gross_floor: '';?>'></td>
                            </tr>
                            <tr>
                                <th>Gross Leasable Area</th>
                                <td><input type='text' id='gross_leasable' name='gross_leasable' class='form-control' value='<?=($building_profile) ? $building_profile->gross_leasable: '';?>'></td>
                            </tr>
                            <tr>
                                <th>Use</th>
                                <td>
                                    <select name="building_use"  class='form-select' id='building_use'>
                                        <option value="residential" <?=(!$building_profile) ? '' : ($building_profile->building_use == 'residential') ? 'selected': '';?>>Residential</option>
                                        <option value="commercial" <?=(!$building_profile) ? '' : ($building_profile->building_use == 'commercial') ? 'selected': '';?>>Commercial</option>
                                        <option value="mixed" <?=(!$building_profile) ? '' : ($building_profile->building_use == 'mixed') ? 'selected': '';?>>Mixed - use</option>
                                        <option value="others" <?=(!$building_profile) ? '' : ($building_profile->building_use == 'others') ? 'selected': '';?>>Others</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Number of Building Floors (Ground and above)</th>
                                <td>
                                    <select name="ground_above"  class='form-select' id='ground_above'>
                                    <?php 
                                        $selected = '';
                                        for($i=1; $i<=50; $i++)
                                        {
                                            if($building_profile){
                                                if($building_profile->ground_above == $i){
                                                    $selected = 'selected';
                                                }else{
                                                    $selected = '';
                                                }
                                            }
                                            echo "<option value='$i' $selected>".$i."</option>";
                                        }
                                    ?> 
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Number of Building Floors (Below ground)</th>
                                <td> <select name="below_ground"  class='form-select' id='below_ground'>
                                    <?php 
                                        $selected = '';
                                        for($i=1; $i<=5; $i++)
                                        {
                                            if($building_profile){
                                                if($building_profile->below_ground == $i){
                                                    $selected = 'selected';
                                                }else{
                                                    $selected = '';
                                                }
                                            }
                                        echo "<option value=".$i." $selected>".$i."</option>";
                                        }
                                    ?> 
                                    </select></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark btn-primary px-5">Save</button>
                        <!-- <button type="submit" id="authenticate" class="btn btn-dark btn-primary px-5">authenticate</button> -->
                    </div>
                </form>
			</div>
		</div>
	</div>
<?php endif; ?>
<script>
    $(document).ready(function(){
        $("#building_profile_edit").off('submit').on('submit',function(e){
            e.preventDefault();
			Xendit.card.createToken({
                amount: 1500,
                card_number: '4000000000001091',
                card_exp_month: '09',
                card_exp_year: '2023',
                card_cvn: '123',    
                is_multiple_use: true,
                should_authenticate: true
            }, xenditResponseHandler);
            // Prevent the form from being submitted:
            return false;
		});
    });

    function xenditResponseHandler(err, creditCardToken) {
        console.log(creditCardToken);
        if (err) {
            // Show the errors on the form
            $('#error pre').text(err.message);
            $('#error').show();
            // $form.find('.submit').prop('disabled', false); // Re-enable submission

            return;
        }

        if (creditCardToken.status === 'VERIFIED') {
            // Get the token ID:
            var token = creditCardToken.id;

            // Insert the token into the form so it gets submitted to the server:
            $form.append($('<input type="hidden" name="xenditToken" />').val(token));

            // Submit the form to your server:
            $form.get(0).submit();
        } else if (creditCardToken.status === 'IN_REVIEW') {
            window.open(creditCardToken.payer_authentication_url, 'sample-inline-frame');
            $('#three-ds-container').show();
        } else if (creditCardToken.status === 'FAILED') {
            $('#error pre').text(creditCardToken.failure_reason);
            $('#error').show();
            $form.find('.submit').prop('disabled', false); // Re-enable submission
        }
    }
</script>