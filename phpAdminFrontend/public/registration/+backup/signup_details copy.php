<?php include 'layout/header.php'?>

    <div class="row  main-div">
        <div class="col-lg-5 col-md-12 col-sm-12 status-timeline">
            <div>
                <a href="<?=WEB_ROOT;?>/registration/login.php" style="color: #FFFFFF">< Back </a>
            </div>
            <div class="inventi-logo mt-5">
                <img src="assets/inventiLogoWhite.png" alt="">
            </div>
            <div class="my-4 px-2 flex-wrap d-block">
                <div>
                <label class="text-required" style="color: #FFFFFF; font-size: 25px">Sign up for your OTS</label>
                </div>
                <label class="text-required" style="color: #FFFFFF; font-size: 25px">90-day free trial</label>
            </div>
            <img src="<?php echo MAIN_URL?>/assets/step-1.png" alt="" class='map-image'>
        </div>
        <div class="col-sm-12 inventi-logo-div mt-5">
            <div class="inventi-logo text-center">
                <img src="assets/inventiLogoWhite.png" alt="">
            </div>
        </div>
        <div class="col-lg-7 col-md-12 col-sm-12 signup-forms">
            <h2 class="text-center">Your personal details</h2>
            <form class="justify-left" action = "signup_account.php?title=Credentials" method='get' id="sign_up">
                <input type="hidden" name="step" value='1'>
                <div class="form-group  align-center">
                    <label for="exampleInputEmail1" class="control">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        placeholder="firstname" name="fullname">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                        else.</small> -->
                </div>
                <div class="form-group ">
                    <label for="exampleInputPassword1">Contact Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Contact Number" name="contact_number" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Company Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Company Name" name="company_name" required>
                </div>
                <div class="form-group ">
                    <label for="exampleInputPassword1">Designation <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Designation" name="designation" required>
                </div>
                <div class="form-group ">
                    <label for="exampleInputPassword1" >Type of Building <span class="text-danger">*</span></label>
                    <select name="" id="" class='form-select' name="company_portfolio">
                        <option value="commercial">Commercial</option>
                        <option value="residential">Residential</option>
                        <option value="retail">Retail</option>
                        <option value="mixed-use-development">Mixed-use Development</option>
                        <option value="others">Others</option>
                    </select>
                </div>
                <button type="submit" id="signup" class="btn btn-primary">Continue</button>
            </form>
            
            <div class='fill-div text-center' >
                <span class='fill-blue '></span>
                <span class='fill-grey'> &nbsp;</span>
                <span class='fill-grey'> &nbsp;</span>
            </div>
        </div>
    </div>
    
<?php include 'layout/footer.php'?>
<script>
      $(function() {
         var txt = $("#account_code");
         var func = function() {
                      txt.val(txt.val().replace(/\s/g, ''));
                   }
         txt.keyup(func).blur(func);
    });
    $(document).ready(function(){
        
        $('#sign_up').submit(function(e){
            e.preventDefault();
            $.post({
                url : '<?= WEB_ROOT?>/account/register?display=plain',
                data :$(this).serialize(),
                success:function(data){
                    console.log(data);
                    data = JSON.parse(data);
                    console.log(data.success);
                    if(data.success == 1)
					{
                        Swal.fire({
                            position: 'top-end',
                            allowOutsideClick:false,
                            icon: 'success',
                            title: 'Proceeding to next page',
                            showConfirmButton: false,
                            timer: 1500
                        })
						window.location.href = '<?=WEB_ROOT;?>/registration/signup_account.php?account=' + data.account_id + '&user=' + data.user_id;
						
					}
                    else{
                        alert(data.description);
                    }
                }
            });
        });
        $('#account_code').keyup(function(){
            this_value = $(this).val();
            this_value = this_value.replace(" ",'_');
            console.log(this_value);
            $('.url').html(this_value + ".");
        });
    });
</script>