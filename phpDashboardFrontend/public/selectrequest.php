<?php
include("footerheader.php");
$document_result = apiSend('document','getlist',[]);
$documents = json_decode($document_result,true);
fHeader();
?>
<div class="col-12 d-flex align-items-center justify-content-between mt-4">
	<div class="title">Forms</div>
</div>
<div class="container mt-2">
	<div class="row">
		<div class="col-3 mt-3">
			<div>
				<a href="gatepass.php">
					<center>
						<img class="mx-auto mb-2" src="resources/images/icoGatePass.png" alt="" width="50" />
						<span class="btn-label">Gate Pass</span>
					</center>
				</a>
			</div>
		</div>
		<div class="col-3 mt-3">
			<div>
				<a href="servicerequest.php">
					<center>
						<img class="mx-auto mb-2" src="resources/images/icoServiceRequest.png" alt="" width="50" />
						<span class="btn-label">Service Request</span>
					</center>
				</a>
			</div>
		</div>
		<div class="col-3 mt-3">
			<div>
				<a href="reservation.php">
					<center>
						<img class="mx-auto mb-2" src="resources/images/icoReservation.png" alt="" width="50" />
						<span class="btn-label">Reservation</span>
					</center>
				</a>
			</div>
		</div>
		<div class="col-3 mt-3">
			<div>
				<a href="movein.php">
					<center>
						<img class="mx-auto mb-2" src="resources/images/icoMoveInOut.png" alt="" width="50" />
						<span class="btn-label" style="width:100px; margin-left:-10px">Move In</span>
					</center>
				</a>
			</div>
		</div>
		<div class="col-3 mt-3">
			<div>
				<a href="moveout.php">
					<center>
						<img class="mx-auto mb-2" src="resources/images/icoMoveInOut.png" alt="" width="50" />
						<span class="btn-label" style="width:100px; margin-left:-10px">Move Out</span>
					</center>
				</a>
			</div>
		</div>
		<div class="col-3 mt-3">
			<div>
				<a href="forms.php">
					<center>
						<img class="mx-auto mb-2" src="resources/images/icoForms.png" alt="" width="50" />
						<span class="btn-label">Forms</span>
					</center>
				</a>
			</div>
		</div>
	</div>
</div>
<?php
fFooter();
?>