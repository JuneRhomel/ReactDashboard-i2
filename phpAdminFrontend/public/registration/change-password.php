<?php include 'layout/header.php' ?>
<link href='//fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Montserrat:semibold' rel='stylesheet' type='text/css'>
<style>
    @media only screen and (max-width: 1609px) {
        .form-signup {
            max-width: 637px;
        }
    }


    @media only screen and (max-width: 1199px) {
        .log-in-body {
            flex-direction: column;
        }

        .signup-image {
            display: none;
        }

        .form-signup {
            width: 90%;
        }
    }
</style>

<div class="d-flex ">
    <div class="signup-image " style="width: 45% !important;">
        <div class="img-container">
            <img src="./assets/Frame 2381.png" alt="">
        </div>
    </div>
    <div class="form-signup mt-5" style="max-width: 900px;">
        <div class="h-100">
            <b class="fw-bold fs-3 mt-5 heading d-block text-black">Reset Password</b>
            <div class="d-flex gap-3 h-75 flex-column justify-content-center">
                <form id="frm" action="<?= WEB_ROOT; ?>/registration/change-password-save.php?display=plain" class="ms-3" method="post" style="width:100%;">
                    <div class="d-flex flex-column ">
                        <div>
                            <div class="col-12 mb-4">
                                <div class="input-box">
                                    <input style="height: 56px;" name="password" id="password" placeholder="text" type="password" value="" required>
                                    <label class="">Create New Password*</label>
                                </div>
                            </div>
                            <div class="col-12 mb-4">

                                <div class="input-box">
                                    <input name="confirm-password" id="confirm-password" placeholder="text" type="password" value="" required>
                                    <label class="">Confirm Password</label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="main-btn w-100 main-submit">Submit</button>
                            </div>
                            <input name="acctid" type="hidden" value="<?= $_GET['acctid'] ?>">
                            <input name="email" type="hidden" value="<?= $_GET['email'] ?>">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>





<!-- <div class="row main-div" style="background-color: #114486">
    <div class="col-lg-4 col-md-12 col-sm-12 forgot-password-backdrop">
        <div>
            <a href="<?= WEB_ROOT; ?>/" style="color: #FFFFFF">
                < Back </a>
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
        <form id="frm" action="<?= WEB_ROOT; ?>/registration/change-password-save.php?display=plain" class="ms-3" method="post" style="width:100%;">
            <h3 class="">Change Password</h3>
            <div class="form-group w-50">
                <label class="">Password</label>
                <input name="password" id="password" type="password" class="form-control" value="" required>
            </div>
            <div class="form-group w-50">
                <label class="">Confirm Password</label>
                <input name="confirm-password" id="confirm-password" type="password" class="form-control" value="" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <input name="acctid" type="hidden" value="<?= $_GET['acctid'] ?>">
            <input name="email" type="hidden" value="<?= $_GET['email'] ?>">
        </form>
    </div>
</div> -->
<?php include 'layout/footer.php' ?>
<script>
    $(document).ready(function() {
        $("#frm").on("submit", function(e) {
            e.preventDefault();

            if ($('#password').val() != $('#confirm-password').val()) {
                toastr.warning('Password and confirm password did not match.', 'WARNING', {
                    timeOut: 3000,
                    positionClass: 'toast-top-center',
                    onHidden: function() {}
                });
            } else {
                $.ajax({
                    url: $(this).prop('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.success) {
                            toastr.success('You have successfully changed your password', 'INFORMATION', {
                                timeOut: 3000,
                                positionClass: 'toast-top-center',
                                onHidden: function() {
                                    location = "<?= WEB_ROOT ?>";
                                }
                            });
                        }
                    },
                });
            }
        });
    });
</script>