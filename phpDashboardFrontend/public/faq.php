<?php
include("footerheader.php");
fHeader();
$faqs = [
   ["title"=>"How to Book Amenity", "faq"=>"1. Log in to Tenant Portal<br>
2. Click on 'Amenity Booking' on the side navigation. (Note: If this option is unavailable for you, it may not appear in the side navigation. Please contact property management.)<br>
3. Click on the 'Create Booking' tab, select the amenity, date and click on 'Book Now'<br>
4. Review the details of your booking and click on 'Book Now'<br>
Now you have completed booking an amenity"],
   ["title"=>"How to use Quick Service Request", "faq"=>"You create a service request record to document a service requirement.A service request record is a mechanism to track initial service contacts. Resolving a service request involves capturing relevant information from the party making the request and determining what, if any, further action is needed. If resolving the service request involves creating an incident, problem, or work order, you can create it directly from the service request. You can also relate existing records to the service request."],
   ["title"=>"How do I pay my bill", "faq"=>"1. Go to portal and enter your username and password.<br>2. Choose “Add Company/Biller” Icon<br>3. Fill in the required details:<br>4. Tick 'Online Banking' and click the 'Submit' button"],
];
?>
<div class="col-12 d-flex align-items-center justify-content-between mt-3 mb-3">
  <div class="title">Frequently Ask Questions</div>
</div>
<div class="container">
  <div class="accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
    <?php foreach ($faqs as $key=>$val) { ?> 
    <div class="card my-2">
      <div class="card-header" role="tab" id="heading<?=$key?>">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapse<?=$key?>" aria-expanded="true" aria-controls="collapse<?=$key?>" style="text-decoration:none; color:#34495e;">
          <h6 class="mb-0 faq-collapse"> <?=$val['title']?> <i class="fas fa-angle-down rotate-icon" style="float:right"></i></h6>
        </a>
      </div>
      <div id="collapse<?=$key?>" class="collapse<?=($key==0) ? "show" : ""?>" role="tabpanel" aria-labelledby="heading<?=$key?>" data-parent="#accordionEx">
        <div class="card-body font-12 clrDarkblue"> <?=$val['faq']?> </div>
      </div>
    </div>
    <?php } ?> 
  </div>
</div>
<?=fFooter();?>