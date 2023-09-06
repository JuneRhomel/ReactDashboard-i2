<?php
$document = null;
if(count($args))
{
	$document_result = $ots->execute('document','get-document',['documentid'=>$args[0]]);
	$document = json_decode($document_result,true);

	
}

?>

<div class="page-title"><?php echo $document ? $document['title'] : '';?></div>
<div class="bg-white p-2 rounded">
	<div class="row">
		<div class="col">
			<label>Content</label>
			<div><?php echo $document['content'];?></div>
		</div>
	</div>
	<div class="mt-3 mb-3">
	<a href="<?php echo $document['file_url'];?>" target="_blank">Download</div>
	</div>
</div>