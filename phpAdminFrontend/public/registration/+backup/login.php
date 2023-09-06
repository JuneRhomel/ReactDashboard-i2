<?php include 'layout/header.php'?>
<script>
    $(document).ready(function(){
        $('title').html('Login');
    });
</script>
<link href='//fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Montserrat:semibold' rel='stylesheet' type='text/css'>
    <div class="row  main-div">
        <div class="col-lg-4 col-md-12 col-sm-12 login-backdrop">
            <div class="inventi-logo ">
                <img src="assets/inventiLogoWhite.png" alt="">
            </div>
        </div>
        <div class="col-sm-12 inventi-logo-div">
            <div class="inventi-logo text-center">
                <img src="assets/inventiLogoWhite.png" alt="">
            </div>
        </div>
        <div class="col-lg-8 col-md-12 col-sm-12 signup-forms " style="position:relative" >
            <img src="assets/90-day-inverted.png" class="ninetydays" alt="">
            <br>
            
            <form class="justify-left" action='<?php echo WEB_ROOT;?>/auth/authorize?display=plain' method='post'>
                <?php if(($_GET['error'] ?? '') != ''):?>
                    <div class="form-group">
                        <label for="exampleInputPassword1">
                            <div class="text-danger align-center"><i class="bi bi-exclamation-diamond"></i> <?php echo $_GET['error'] ?? '';?></div>
                        </label>
                        
                    </div>
                    
                    <?php endif;?>
                    <h2 class="text-center welcome">Welcome back.</h2>
                <div class="form-group required">
                    <label for="exampleInputPassword1">Email</label>
                    <input type="email" class="form-control" id="exampleInputPassword1" placeholder="email" name='username'>
                </div>
                <div class="form-group required">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="password" name='password'>
                    <div class="mt-3">
                        <a href="<?php echo WEB_ROOT;?>/registration/forgot-password.php" class="forgot-pass my-2">forgot password?</a>
                    </div>
                </div><br>
                <button type="submit" class="btn btn-primary">Sign in</button>
                <div class='text-center sign-up-div'>
                    <span class='dont-have'>Don't have an account? <span class='sign-up-link'><a href='<?= MAIN_URL?>signup_registration.php' class="sign-up-btn"> Sign up </a></span></span>
                </div>
            </form>
        </div>
    </div>
<?php include 'layout/footer.php'?>