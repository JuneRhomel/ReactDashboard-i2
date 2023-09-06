<?php
$form = null;
if(count($args))
{
	$form_result = $ots->execute('form','get-form',['formid'=>$args[0]]);
	$form = json_decode($form_result,true);

	
}

?>

<div class="page-title"><?php echo $form ? $form['title'] : '';?></div>
<div class="bg-white p-2 rounded">
	<div class="row">
		<div class="col">
			<label>Content</label>
			<div><?php echo $form['content'];?></div>
		</div>
	</div>
	<div class="mt-3 mb-3">
	<a href="<?php echo $form['file_url'];?>" target="_blank">Download</div>
	</div>
</div>