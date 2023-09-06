<?php
$module = "contract";
$role_table = "import_contract";
$table = "contract";
$view = "vw_contract";
//$error_redirect = "/admin/import-contract/";
//$unique = ['contract Name'=>'contract_name','contract Type'=>'contract_type'];

$result = $ots->execute('form', 'get-role-access', [ 'table'=>$role_table ]);
$role_access = json_decode($result);

$result = $ots->execute('module', 'get-ownership', []);
$ownership = json_decode($result);

$filename = ($ownership=="SO") ? "SO Contract Template.xlsx" : "HOA Contract Template.xlsx";
?>
<style>ol li { list-style:decimal; } ul li { list-style:disc; }</style>
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
    <div class="alert alert-warning error-container" role="alert">
        <h5 id="h5"></h5>
        <ul></ul>
    </div>
    <div class="p-2">
        <hr>
        <h4>Instructions</h4>
        <ol>
            <li>Download Template File</li>
            <li>Open Template In Excel</li>
            <li>Add Records
                <ul>
                    <li>Do Not Change The Headers</li>
                    <li>New Record Starts At Row 3 </li>
                </ul>
            </li>
            <li>Upload the Excel File</li>
            <li>After uploading, create contract template and manually select the template for each contract</li>
        </ol>
        <a href="<?=WEB_ROOT?>/template-files/<?=$filename?>" class="btn btn-link"><i class="bi bi-download text-primary" style="margin-right:10px; font-size:20px"></i> Download Template</a>
        <form  id="form-import" action="<?=WEB_ROOT?>/admin/read-excelfile?display=plain" class='ml-3' method="post" enctype="multipart/form-data">
            <div class="form-group">
                <p class="attachment-admin"> Attachment: </p> 
                <input type="file" class="form-control-file m-2 inputfile" id="file-input" name="upload_file" required>
                <label class="inputfile-label" for="file-input">Choose a file</label>        
                <input name="table" type="hidden" value="<?=$table?>">
                <input name="view" type="hidden" value="<?=$view?>"> 
                <?php foreach ($unique as $key=>$val)  echo '<input name="unique[]" type="hidden" value="'.$key.'|'.$val.'"/>'; ?>
            </div>
            <?php if($role_access->upload == true): ?>
                <button class="btn main-btn m-2 upload-admin-btn w-25" type="submit">Upload Now</button>
            <?php endif; ?>
        </form>
    </div>
<?php endif; ?>
</div>

<script>
$(document).ready(function(){
    $(".error-container").hide();

    $("#form-import").on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).prop('action'),
            type: 'POST',
            dataType: 'JSON',
            data: new FormData($(this)[0]),
            contentType: false,
            processData: false,
            success: function(data){
                if(data.success==1) {
                    //contract.reload();
                    popup({
                        data: data,
                        reload_time: 2000,
                        redirect: "<?= WEB_ROOT . "/$module/" ?>"
                    })
                } else {
                    $(".error-container li").empty();
                    $("#h5").text(data.description)
                    $.each(data.excel_errors, function(){
                        $(".error-container").append("<li>" + this + "</li>");
                    });
                    $(".error-container").show();
                }
            },
        });
    });
});
</script>