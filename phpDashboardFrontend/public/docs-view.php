<?php
include("footerheader.php");
$document_result = apiSend('document','get-document',['documentid'=>$_GET['docid']]);
$document = json_decode($document_result,true);
fHeader();
?>
<div class="col-12 d-flex align-items-center justify-content-start mt-4 mb-5">
    <div>
        <a href="docs.php">
            <svg xmlns="http://www.w3.org/2000/svg" class="box-shadow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="transform: scaleX(-1)">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </a>
    </div>
    <div class="font-18 ml-2"> Back to Documents </div>
</div>
<div class="container" style="margin-bottom: 0px">
  <div class="my-2 mx-0 d-flex align-items-center justify-content-between">
      <h5><?php echo $document['title'];?></h5>
  </div>
  <div class="bg-white rounded">
    <div class="mt-2 font-16 m-2 p-3">
      <?php echo nl2br($document['content']);?>
    </div>
  </div>
  <!-- <div class="col-8">
    <button type="button" class="btn btn-primary btn-lg btn-block">
      <p class="mb-0 font-14"><i class="fa-solid fa-paperclip"></i> Download File</p>
    </button>
  </div> -->
</div>
<?php
fFooter();
?>