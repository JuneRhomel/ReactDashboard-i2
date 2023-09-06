<?php
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
	'table'=>'opex_report',
	'view'=>'role_rights'

];
$role_access = $ots->execute('form','get-role-access',$data);
$role_access = json_decode($role_access);
// var_dump($role_access);
?>
<div class="main-container">
	 
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
			<div class="d-flex">
	<div class="d-flex flex-row-reverse my-1" style="width: 100%;">
		<?php if($role_access->water_edit == true): ?>
			<button  class='main-btn edit-bill-water ' onclick="$('#bill-and-rates-modal').modal('show')"><svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M2.28627 12H0.5V10.2071L7.37333 3.33373L9.16606 5.12646L2.28627 12ZM11.4531 2.83974L10.5867 3.70618L8.79377 1.91329L9.66022 1.04684C9.72496 0.982107 9.82838 0.982107 9.89311 1.04684L11.4531 2.60684C11.5179 2.67158 11.5179 2.775 11.4531 2.83974Z" stroke="white"/>
</svg>
 Edit</button>
			<?php endif; ?>
		</div>
	</div>
	<div class="bg-white my-2 rounded">
		<table class="table table-data water-table text-primary">
			
			<tr>
				<th style="font-size: 15px">WATER</th><td></td>
			</tr>
			
			<tr>
				<th>Annual Budget</th><td class='billing-th' >12312321312</td>
			</tr>
			<tr>
				<th>Monthly Budget</th><td class='billing-consumption-th' >312</td>
			</tr>
			<tr>
				<th>Annual Actual YTD Consumption</th><td class='billing-rates-th'></td>
			</tr>
			<tr>
				<th>Monthly Actual YTD Consumption</th><td><?= $attachment->filename ?></a></td>
			</tr>
			<tr>
				<th>Does Consumption Exceeded The Budget?</th><td><?= $attachment->filename ?></a></td>
			</tr>
			<tr>
				<th>SLA Percentage</th><td><?= $attachment->filename ?></a></td>
			</tr>
		</table>
	</div>
	
	<div class="d-flex mt-3">
	<div class="d-flex flex-row-reverse my-1" style="width: 100%;">
		<?php if($role_access->elec_edit == true): ?>
        	<button  class='main-btn edit-bill-water ' onclick="$('#bill-and-rates-modal').modal('show')"><svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M2.28627 12H0.5V10.2071L7.37333 3.33373L9.16606 5.12646L2.28627 12ZM11.4531 2.83974L10.5867 3.70618L8.79377 1.91329L9.66022 1.04684C9.72496 0.982107 9.82838 0.982107 9.89311 1.04684L11.4531 2.60684C11.5179 2.67158 11.5179 2.775 11.4531 2.83974Z" stroke="white"/>
</svg>
 Edit</button>
			<?php endif; ?>
		</div>
	</div>
	
	<div class="bg-white my-2 rounded">
		<table class="table table-data electricity-table text-primary">
			
			<tr>
				<th style="font-size: 15px">ELECTRICITY</th><td></td>
			</tr>
			
			<tr>
				<th>Annual Budget</th><td class='billing-th' >12312321312</td>
			</tr>
			<tr>
				<th>Monthly Budget</th><td class='billing-consumption-th' >312</td>
			</tr>
			<tr>
				<th>Annual Actual YTD Consumption</th><td class='billing-rates-th'></td>
			</tr>
			<tr>
				<th>Monthly Actual YTD Consumption</th><td><?= $attachment->filename ?></a></td>
			</tr>
			<tr>
				<th>Does Consumption Exceeded The Budget?</th><td><?= $attachment->filename ?></a></td>
			</tr>
			<tr>
				<th>SLA Percentage</th><td><?= $attachment->filename ?></a></td>
			</tr>
		</table>
	</div>

<div class="d-flex mt-5">
	<div class="d-flex align-items-center justify-content-between my-1" style="width: 100%;">
        <h3>Corrective Maintenance</h3>
		<?php if($role_access->elec_edit == true): ?>
        	<button  class='main-btn edit-bill-water ' onclick="$('#bill-and-rates-modal').modal('show')"><svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M2.28627 12H0.5V10.2071L7.37333 3.33373L9.16606 5.12646L2.28627 12ZM11.4531 2.83974L10.5867 3.70618L8.79377 1.91329L9.66022 1.04684C9.72496 0.982107 9.82838 0.982107 9.89311 1.04684L11.4531 2.60684C11.5179 2.67158 11.5179 2.775 11.4531 2.83974Z" stroke="white"/>
</svg>
 Edit</button>
			<?php endif; ?>
		</div>
	</div>
	
	<div class="bg-white my-2 rounded">
		<table class="table table-data cm-table text-primary">
			
			<tr>
				<th>Annual Budget</th><td class='billing-th' >12312321312</td>
			</tr>
			<tr>
				<th>Monthly Budget</th><td class='billing-consumption-th' >312</td>
			</tr>
			<tr>
				<th>Annual Actual YTD Consumption</th><td class='billing-rates-th'></td>
			</tr>
			<tr>
				<th>Monthly Actual YTD Consumption</th><td><?= $attachment->filename ?></a></td>
			</tr>
			<tr>
				<th>Does Consumption Exceeded The Budget?</th><td><?= $attachment->filename ?></a></td>
			</tr>
			<tr>
				<th>SLA Percentage</th><td><?= $attachment->filename ?></a></td>
			</tr>
		</table>
	</div>
	
	<div class="modal" tabindex="-1" role="dialog" id='bill-and-rates-modal'>
		<div class="modal-dialog  modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M2.28627 12H0.5V10.2071L7.37333 3.33373L9.16606 5.12646L2.28627 12ZM11.4531 2.83974L10.5867 3.70618L8.79377 1.91329L9.66022 1.04684C9.72496 0.982107 9.82838 0.982107 9.89311 1.04684L11.4531 2.60684C11.5179 2.67158 11.5179 2.775 11.4531 2.83974Z" stroke="white"/>
</svg>
 Edit</h5>
					<button type="button" class="btn-close" data-dismiss="modal" onclick='$("#bill-and-rates-modal").modal("hide")' aria-label="Close">
						
				</button>
			</div>
			<div class="modal-body">
				
				<!-- <h3 class="text-primary align-center">Renew</h3> -->
				<table class="table table-data water-table text-primary">
					<tr>
						<th>Annual Budget</th><td><input type='number' id='bill_amount' min="0" name='bill_amount' class='form-control' style="background-color: #FFF385; box-shadow: 0pt 3pt 6pt #00000029; border-radius: 5pt 5pt 5pt 5pt; max-width: 100%; max-height: 100%"></td>
                        </tr>
                        <tr>
							<th class='uom'>Monthly Budget</th><td><input type='number' id='consumption' name='consumption' class='form-control' style="background-color: #FFF385; box-shadow: 0pt 3pt 6pt #00000029; border-radius: 5pt 5pt 5pt 5pt; max-width: 100%; max-height: 100%"></td>
                        </tr>
                        <tr>
							<th>Annual Actual YTD Consumption</th><td class='billing-rates-th'></td>
                        </tr>
                        <tr>
							<th>Monthly Actual YTD Consumption</th><td><?= $attachment->filename ?></a></td>
                        </tr>
                        <tr>
							<th>Does Consumption Exceeded The Budget?</th><td><?= $attachment->filename ?></a></td>
                        </tr>
                        <tr>
							<th>SLA Percentage</th><td><?= $attachment->filename ?></a></td>
                        </tr>
                    </table>
                    <div  class='d-flex flex-row-reverse'><button class='btn btn-primary px-5'>Save</button></div>
				</div>
				<div class="modal-footer">
					
					</div>
				</div>
			</div>
			
		</div>
		<?php endif; ?>
	</div>