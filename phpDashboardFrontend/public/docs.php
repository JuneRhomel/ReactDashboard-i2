<?php
include("footerheader.php");
$document_result = apiSend('document','getlist',[]);
$documents = json_decode($document_result,true);
fHeader();
?>
<div class="col-12 d-flex align-items-center justify-content-between mt-4 mb-5">
	<div class="title"> Documents </div>
</div>
<div class="container" style="margin-bottom: 0px">
	<div class="accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
		<?php foreach($documents as $document):?>
			<div class="card my-3">
				<div class="card-header" role="tab" id="heading1" style="padding: 0 0 0 60px; height:60px; background-image: url(resources/images/icoWord.png); background-repeat:no-repeat">
					<a href="docs-view.php?docid=<?php echo $document['id'];?>" style="text-decoration: none; color:#34495e">
						<h6><i class="fas fa-angle-right rotate-icon" style="margin: 15px 20px 0 0; float:right"></i></h6>
						<div>
							<span class="font-16"><?php echo $document['title'];?></span><br><small>Update last <?php echo date('d-F-Y',$document['created_on']);?></small>
						</div>
					</a>
				</div>
			</div>
		<?php endforeach;?>


		<!--div class="card my-3">
		<div class="card-header" role="tab" id="heading1" style="padding: 0 0 0 60px; height:60px; background-image: url(resources/images/icoWord.png); background-repeat:no-repeat">
			<a href="docs-view.php" style="text-decoration: none; color:#34495e">
				<h6><i class="fas fa-angle-right rotate-icon" style="margin: 15px 20px 0 0; float:right"></i></h6>
				<div>
					<span class="font-16">House Rules & Regulation</span><br><small>Update last 25-May-2022</small>
				</div>
			</a>
		</div>
		</div>
		<div class="card">
		<div class="card-header" role="tab" id="heading2" style="padding: 0 0 0 60px; height:60px; background-image: url(resources/images/icoPDF.png); background-repeat:no-repeat">
			<a href="docs-view.php" style="text-decoration: none; color:#34495e">
				<h6><i class="fas fa-angle-right rotate-icon" style="margin: 15px 20px 0 0; float:right"></i></h6>
				<div>
					<span class="font-16">Master Deed of Restrictions</span><br><small>Update last 25-May-2022</small>
				</div>
			</a>
		</div-->
	</div>
</div>
<?php
fFooter();
?>