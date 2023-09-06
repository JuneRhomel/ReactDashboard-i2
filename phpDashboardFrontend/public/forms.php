<?php
include("footerheader.php");
fHeader();

$type = initObj('type');

$form_result = apiSend('form','getlist',[]);
$forms = json_decode($form_result,true);
//vdump($forms);

$api = apiSend('form','get-uploaded',[]);
$uploaded_forms = json_decode($api,true);
//vdump($uploaded_forms);
?>
<div class="col-12 my-4">
	<div class="title">Forms</div>
</div>
<div>
  <ul>
	<li>Download form</li>
	<li>Upload form anytime</li>
	<li>Better experience in Web/Desktop view</li>
  </ul>
</div>
<div class="col-12 mb-4">
	<nav>
		<div class="nav nav-tabs" id="nav-tab" role="tablist" style="border-bottom:solid 1px transparent">
			<button class="nav-link <?=($type=="") ? "active" : ""?>" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true" style="border-bottom:solid 2px var(--clrBlue);" onclick="location='<?=$scriptname?>'"> Forms </button>
			<button class="nav-link <?=($type!="") ? "active" : ""?>" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false" style="border-bottom:solid 2px var(--clrBlue);" onclick="location='<?=$scriptname?>?type=upload'"> Upload Form </button>
		</div>
	</nav>
</div>
<?php if ($type=="") { ?>
<div class="container" style="margin-bottom: 0px">
	<div class="accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
		<?php foreach($forms as $form):?>
		<div class="card my-1">
			<div class="card-header" role="tab" id="heading1" style="padding: 0 0 0 60px; height:60px; background-image: url(resources/images/icoPDF.png); background-repeat:no-repeat">
				<a href="form-view.php?formid=<?php echo $form['id'];?>" style="text-decoration: none; color:#34495e">
					<h6><i class="fas fa-download box-shadow" style="margin: 15px 20px 0 0; float:right"></i></h6>
					<div>
						<span class="font-16"><?php echo $form['title'];?></span><br><small>Update last <?php echo date('d-F-Y',$form['created_on']);?></small>
					</div>
				</a>
			</div>
		</div>
		<?php endforeach;?>
	</div>
</div>	
<?php } else { ?>
<form id="frm" name="frm" method="post" enctype="multipart/form-data" action="form-save.php">
	<div class="container bg-white p-4">
		<select name="form_id" class="form-control">
			<?php foreach($forms as $form):?>
			<option value="<?=$form['id']?>"><?=$form['title']?></option>
			<?php endforeach;?>
		</select>
	    <div class="input-group my-3">
	        <div class="input-group-prepend">
	            <button type="button" class="btn primary"><div><i class="fa-solid fa-arrow-right text-white"></i></div></button>
	        </div>
	        <input name="upload_file" type="file" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon" required/>
	    </div>
	    <div class="d-block">
	        <button type="submit" class="btn btn-primary w-100">Upload</button>
	    </div>
	</div>
</form>
<div class="container p-3 mb-5">
	<?php foreach($uploaded_forms as $key=>$val) { ?>
	<div class="bg-white rounded p-2 mb-3">
		<div class="d-inline-block">#<?=$key+1?></div>
		<div class="d-inline-flex flex-column ml-1 p-0">
			<span class="font-16"><b><?=$val['title']?></b></span>
			<label class="font-10">Date Uploaded <b><?=formatDateUnix($val['uploaded_on'])?></b></label>
		</div>
		<div class="badge badge-pill badge-warning float-right badge-label"><?=$val['status']?></div>
	</div>
	<?php } ?>
</div>
<?php } ?>
<?=fFooter();?>
<script>
$(document).ready(function(){
    $("#frm").on('submit',function(e){
        e.preventDefault();       
        swal({ title: "Save Confirmation", text: "Are you sure you want to save record?", icon: "warning", buttons: true, dangerMode: true })
        .then((ynConfirm) => {
          if (ynConfirm) {
            this.submit()
            swal("Record saved!", { icon: "success" });
          }
        });
    });
});
</script>