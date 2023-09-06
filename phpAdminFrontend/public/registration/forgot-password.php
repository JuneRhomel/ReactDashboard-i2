<?php include 'layout/header.php'?>
<link href='//fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Montserrat:semibold' rel='stylesheet' type='text/css'>
<div class="row main-div" style="background-color: #114486">
    <div class="col-lg-4 col-md-12 col-sm-12 forgot-password-backdrop">
        <div>
            <a href="<?=WEB_ROOT;?>/" style="color: #FFFFFF">< Back </a>
        </div>
        <div class="inventi-logo ">
            <img src="assets/inventiLogoWhite.png" alt="">
        </div>
    </div>
    <div class="col-sm-12 inventi-logo-div">
        <div class="inventi-logo text-center">
            <img src="assets/inventiLogoWhite.png" alt="">
        </div>
    </div>
    <div class="col-md-8 col-sm-12 signup-forms">
        <form id="frm" action="<?=WEB_ROOT;?>/registration/check-email.php?display=plain" class="ms-3" method="post" style="width:100%;" >
            <h3 class="">Forgot Password?</h3>
            <div class="form-group w-50">
                <label class="">Email</label>
                <input name="email" type="email" class="form-control" placeholder="Enter here" value="" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
<?php include 'layout/footer.php'?>
<script>
$(document).ready(function(){      
    $("#frm").on("submit", function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).prop('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'JSON',
            success: function(data){ 
                if (data.success) {
                    toastr.success('Please check your email for link to change password','INFORMATION',
                        { timeOut:3000, positionClass:'toast-top-center', onHidden: function() { location.reload(); }
                    });
                } else {
                    toastr.warning('Sorry, email does not exist.','WARNING',
                        { timeOut:3000, positionClass:'toast-top-center', onHidden: function() { location.reload(); }
                    });
                }
            },
        });
    });
});
</script>