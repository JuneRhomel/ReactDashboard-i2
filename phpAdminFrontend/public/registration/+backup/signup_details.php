<?php include 'layout/header.php' ?>

<div class="row  main-div">
    <div class="col-lg-4 col-md-12 col-sm-12 status-timeline">
        <img class="bg-overlay" src="<?php echo MAIN_URL ?>/assets/bg-login.png" alt="">
        <div class="text-login">

            <div>
                <a href="<?= WEB_ROOT; ?>/registration/login.php" style="color: #FFFFFF">
                    < Back </a>
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
        </div>
        <!-- <img src="<?php echo MAIN_URL ?>/assets/step-1.png" alt="" class='map-image'> -->
    </div>
    <!-- <div class="col-sm-12 inventi-logo-div mt-5">
            <div class="inventi-logo text-center">
                <img src="assets/inventiLogoWhite.png" alt="">
            </div>
        </div> -->
    <div class="col-lg-8 col-md-12 col-sm-12 signup-forms">

        <!-- <form class="details" action="signup_account.php?title=Credentials" method='get' id="sign_up"> -->
        <form class="details" action="signup_account.php?title=Credentials" method='get' id="sign_up">
            <h2 class="">Your personal details</h2>
            <label class="requride">*Please fill in the required field</label>
            <input type="hidden" name="step" value='1'>
            <div class="d-flex gap-3">
                <div class="form-group  w-50 input-box align-center">
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Type here" name="First Name">
                    <label for="exampleInputEmail1" class="control">First Name <span class="text-danger">*</span></label>
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                            else.</small> -->
                </div>
                <div class="form-group  w-50 input-box align-center">
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Type here" name="Last Name">
                    <label for="exampleInputEmail1" class="control">Last Name <span class="text-danger">*</span></label>
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                            else.</small> -->
                </div>


            </div>

            <div class="d-flex gap-3">
                <div class="form-group w-50 input-box">
                    <label for="">Property Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Property Name" name="company_name" required>
                </div>
                <div class="form-group w-50 input-box">
                    <label for="">Ownership <span cl ass="text-danger">*</span></label>
                    <select>
                        <option value="">Homeowner</option>
                        <option value="">Homeowner Association (HOA)</option>
                        <option value="">Single Owner</option>
            
                    </select>
                    <!-- <input type="text" class="form-control" placeholder="Ownership" name="designation" required> -->
                </div>
            </div>
            <div class="d-flex gap-3">
                <div class="form-group w-50 input-box">
                    <select name="" id="">
                        <option value="" disabled selected>Choose</option>
                        <option value="Residential">Residential</option>
                        <option value="Office">Office</option>
                        <option value="Commercial">Commercial</option>
                        <option value="Mixed Used">Mixed Used</option>
                        <option value="Other">Other</option>

                    </select>
                    <label for="">Property Type <span class="text-danger">*</span></label>

                </div>
                <div class="form-group w-50 input-box">
                    <label for="">Property Size <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" placeholder="" name="" required>
                </div>
            </div>
            <div class="d-flex gap-3">

                <div class="form-group w-50 input-box">
                    <label for="">Email <span class="text-danger">*</span></label>
                    <input type="Email" class="form-control" placeholder="XXXX" name="company_name" required>
                </div>
                <div class="form-group w-50  input-box">
                    <select name="" id="">
                   
                    <option value="" disabled selected>Choose</option>
                        <option value="">Owner</option>
                        <option value="">Property Manage</option>

                    </select>
                    <label for="">Your Role<span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="d-flex gap-3">
                <div class="form-group w-50 input-box">
                    <label for="">Password <span class="text-danger">*</span></label>
                    <input type="password" id="psw" name="psw" placeholder="Type Your Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                </div>
                <div class="form-group w-50 input-box">
                    <label for="">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" placeholder="Retype Your Password" name="designation" required>
                </div>
            </div>
            <!-- <div class="form-group input-box">
                    <label for="" >Type of Building <span class="text-danger">*</span></label>
                    <select name="" id="" class='form-select' name="company_portfolio">
                        <option value="commercial">Commercial</option>
                        <option value="residential">Residential</option>
                        <option value="retail">Retail</option>
                        <option value="mixed-use-development">Mixed-use Development</option>
                        <option value="others">Others</option>
                    </select>
                </div> -->
            <div class="d-flex justify-content-end">

                <button type="submit" id="signup" class="btn main-btn btn-primary">Submit</button>
            </div>
        </form>

        <!-- <div class='fill-div text-center' >
                <span class='fill-blue '></span>
                <span class='fill-grey'> &nbsp;</span>
                <span class='fill-grey'> &nbsp;</span>
            </div> -->
    </div>
</div>

<div class="modal-email d-none">
    <button class="close"><span class="material-icons">
close
</span></button>
    <div class="d-flex justify-content-center flex-column align-items-center text-center gap-2 w-75 m-auto">
    <span class="material-icons email">
email
</span>
        <h1>Please verify your email</h1>
        <p>You're almost there! We sent an email to <a href=""> angeli@inventi.ph</a>
            If you don't see it, you may need to check your
            spam folder.</p>
        <button class="main-btn ok">Ok</button>
    </div>
</div>

<?php include 'layout/footer.php' ?>
<script>
    $(function() {
        var txt = $("#account_code");
        var func = function() {
            txt.val(txt.val().replace(/\s/g, ''));
        }
        txt.keyup(func).blur(func);
    });

    $('.close').click(function() {
        $('.modal-email').toggleClass('d-none')
    })
    $('.ok').click(function() {
        $('.modal-email').toggleClass('d-none')
    })

    $(document).ready(function() {

        $('#sign_up').submit(function(e) {
            e.preventDefault();
            $.post({
                url: '<?= WEB_ROOT ?>/account/register?display=plain',
                data: $(this).serialize(),
                success: function(data) {
                    console.log(data);
                    data = JSON.parse(data);
                    console.log(data.success);
                    if (data.success == 1) {
                        $('.modal-email').toggleClass('d-none')

                    } else {
                        alert(data.description);
                    }
                }
            });
        });
        $('#account_code').keyup(function() {
            this_value = $(this).val();
            this_value = this_value.replace(" ", '_');
            console.log(this_value);
            $('.url').html(this_value + ".");
        });
    });
</script>