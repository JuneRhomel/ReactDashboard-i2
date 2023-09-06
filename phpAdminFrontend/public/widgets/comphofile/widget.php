<div class="d-flex justify-content-evenly text-center">
	<div data-cpf="comment" class="w-full p-2 cursor-pointer border-0 border-b-2 h5 text-primary bg-gray btn-cpf">Comments</div>
	<div data-cpf="photo" class="w-full p-2 cursor-pointer h5 btn-cpf">Photo</div>
	<div data-cpf="file" class="w-full p-2 cursor-pointer h5 btn-cpf">Files</div>
</div>
<div class="cpf-container cpf-comment">
	<div class="infocontainer p-2 mb-3"></div>
	<div class="p-2 rounded text-sm">
		<form method="post" action="<?=WEB_ROOT;?>/<?=$widgetname;?>/send-data?display=json" id="form-cpf">
		<div class="d-flex">
			<input name="comment" id="comment" class="form-control d-flex-1 focus:border-transparent" placeholder="Enter comment...">
			<button class="btn main-btn"><!-- <i class="fa fa-paper-plane"></i> -->Post</button>
		</div>
		<input type="hidden" value="<?=$_GET['reference'];?>" name="reference_id">
		<input type="hidden" value="<?=$_GET['source'];?>" name="reference_table">
		<input type="hidden" name="module" value="comphofile">
		<input type="hidden" name="command" value="comment-add">
		</form>
	</div>
</div>
<div class="cpf-container cpf-photo">
	<div class="infocontainer p-2 mb-3"></div>
	<form method="post" action="<?=WEB_ROOT;?>/<?=$widgetname;?>/send-file?display=json" id="form-cpf-photo" enctype="mulitpart/form-data">
		<div class="file-upload">
			<input id="upload-photo" name="file" type="file" class="d-none d-flex-1 bg-purplishGray border-transparent focus:border-transparent focus:ring-0 focus:outline-0" accept="image/*"required>
			<label for="upload-photo"><button id="btn-photo" >Choose Photo</button></label>	
		</div>	
		<div class="d-flex mt-2">
			<input type="text" name="description" class="form-control d-flex-1 p-2 bg-white" placeholder="Add description">
			<button class="btn main-btn">Upload</button>
		</div>
		<input type="hidden" value="<?=$_GET['reference'];?>" name="reference_id">
		<input type="hidden" value="<?=$_GET['source'];?>" name="reference_table">
		<input type="hidden" name="module" value="comphofile">
		<input type="hidden" name="command" value="photo-add">
	</form>
</div>
<div class="cpf-container cpf-file">
	<div class="infocontainer p-2 mb-3"></div>
	<form method="post" action="<?=WEB_ROOT;?>/<?=$widgetname;?>/send-file?display=json" id="form-cpf-file" enctype="mulitpart/form-data">
		<div class="file-upload">
			<input id="upload-file" name="file" type="file" class="d-none d-flex-1 bg-purplishGray border-transparent focus:border-transparent focus:ring-0 focus:outline-0" required>
			<label for="upload-file"><button id="btn-file">Choose File</button></label>
		</div>	
		<div class="d-flex mt-2">
			<input type="text" name="description" class="form-control d-flex-1 p-2 bg-white" placeholder="Add description">
			<button class="btn main-btn">Upload</button>
		</div>
		<input type="hidden" value="<?=$_GET['reference'];?>" name="reference_id">
		<input type="hidden" value="<?=$_GET['source'];?>" name="reference_table">
		<input type="hidden" name="module" value="comphofile">
		<input type="hidden" name="command" value="file-add">		
	</form>
</div>
<script>
$(document).ready(function(){
	$("#form-cpf").on('submit',function(e){
		e.preventDefault();
		if($('#comment').val().trim() == ""){
			toastr.error('Blank comment not allowed','Information',{timeOut:2000});
		}else{
			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				data: $(this).serialize(),
				dataType: 'JSON',
				beforeSend: function(){},
				success: function(data){
					getComments();
					$("#form-cpf")[0].reset();
				},
			});
		}
	});

	$("#form-cpf-photo").on('submit',function(e){
		e.preventDefault();
		var extension = $("#upload-photo").val().split('.').pop().toLowerCase();
		if(jQuery.inArray(extension, ['jpg', 'jpeg','png','avif','webp']) == -1){
			toastr.error('Invalid File Type.','Information',{timeOut:2000});
		}else{
			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				data: new FormData($(this)[0]),
				dataType: 'JSON',
				contentType: false,
				processData: false,
				beforeSend: function(){},
				success: function(data){
					getPhotos();
					$("#form-cpf-photo")[0].reset();
					$("#btn-photo").text('Choose Photo');
				},
				complete: function(){},
				error: function(jqXHR, textStatus, errorThrown){}
			});
		}
	});

	$("#form-cpf-file").on('submit',function(e){
		e.preventDefault();
		var extension = $("#upload-file").val().split('.').pop().toLowerCase();
		if(jQuery.inArray(extension, ['doc', 'pdf','xls','xlsx','csv']) == -1){
			toastr.error('Invalid File Type.','Information',{timeOut:2000});
		}else{
			
			$.ajax({
				url: $(this).prop('action'),
				type: 'POST',
				data: new FormData($(this)[0]),
				dataType: 'JSON',
				contentType: false,
				processData: false,
				beforeSend: function(){},
				success: function(data){
					getFiles();
					$("#form-cpf-file")[0].reset();
					$("#btn-file").text('Choose File');
				},
				complete: function(){},
				error: function(jqXHR, textStatus, errorThrown){}
			});
		}
		
	});
	
	$(".btn-cpf").on('click',function(){
		$(".btn-cpf").removeClass('text-primary');
		$(".btn-cpf").removeClass('bg-gray');
		$(this).addClass('text-primary');
		$(this).addClass('bg-gray');
		$(".cpf-container").hide();
		$(".cpf-" + $(this).data('cpf')).show();
	});

	$('#upload-photo').change(function() {	
		var fileName = $(this).val().split('\\').pop(); // get the name of the file
		$(this).siblings('label').find('button').text(fileName); // update the text of the button element with the file name
	});

	$('#upload-file').change(function() {
		var fileName = $(this).val().split('\\').pop();
		$(this).siblings('label').find('button').text(fileName);
	});

	function getComments(){
		$.ajax({
			url: '<?=WEB_ROOT;?>/<?=$widgetname;?>/send-data?display=json',
			type: 'POST',
			data: {'reference_id':'<?=$_GET['reference'];?>','reference_table':'<?=$_GET['source'];?>','module':'comphofile','command':'comment-list'},
			dataType: 'JSON',
			beforeSend: function(){},
			success: function(response){
				$(".cpf-comment").find(".infocontainer").empty();
				$.each(response['data'],function(){
					$(".cpf-comment").find(".infocontainer").append('<div"><h6><b>' + (this.created_by ? this.full_name : 'Anonymous') + '</b> <small>' + this.created_on + '</small><h6>' + this.comment +  '</div>');
				});
			},
			complete: function(){},
			error: function(jqXHR, textStatus, errorThrown){}
		});
	}

	function getPhotos(){
		$.ajax({
			url: '<?=WEB_ROOT;?>/<?=$widgetname;?>/send-data?display=json',
			type: 'POST',
			data: {'reference_id':'<?=$_GET['reference'];?>','reference_table':'<?=$_GET['source'];?>','module':'comphofile','command':'photo-list'},
			dataType: 'JSON',
			beforeSend: function(){},
			success: function(response){
				$(".cpf-photo").find(".infocontainer").empty();
				$.each(response['data'],function(){
					$(".cpf-photo").find(".infocontainer").append('<div"><h6><b>' + (this.created_by ? this.full_name : 'Anonymous') + '</b> <small>' + this.created_on + '</small><a href="' + this.attachment_url + '" target="_blank"><img class="image-widget" src="' + this.attachment_url + '" alt="' + this.filename +  '"></a><br>' + this.description + '</div>');
				});
			},
		});
	}

	function getFiles(){
		$.ajax({
			url: '<?=WEB_ROOT;?>/<?=$widgetname;?>/send-data?display=json',
			type: 'POST',
			data: {'reference_id':'<?=$_GET['reference'];?>','reference_table':'<?=$_GET['source'];?>','module':'comphofile','command':'file-list'},
			dataType: 'JSON',
			beforeSend: function(){},
			success: function(response){
				$(".cpf-file").find(".infocontainer").empty();
				$.each(response['data'],function(){
					$(".cpf-file").find(".infocontainer").append('<div"><h6><b>' + (this.created_by ? this.full_name : 'Anonymous') + '</b> <small>' + this.created_on + '</small><br><a href="' + this.attachment_url + '" target="_blank">' + this.filename + '</a><br>' + this.description + '</div>');
				});
			},
			complete: function(){},
			error: function(jqXHR, textStatus, errorThrown){}
		});
	}

	getComments();
	getPhotos();
	getFiles();
	$(".cpf-photo").hide();
	$(".cpf-file").hide();
});
</script>