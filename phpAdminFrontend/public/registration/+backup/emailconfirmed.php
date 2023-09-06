<?php include 'layout/header.php' ?>
<div class="row  main-div">
    <div class="col-lg-5 col-md-12 col-sm-12 status-timeline">
        <div class="inventi-logo ">
            <img src="assets/inventiLogoWhite.png" alt="">
        </div>
        <img src="<?php echo MAIN_URL ?>/assets/step-3.png" alt="" class='map-image'>
    </div>
    <div class="col-lg-7 col-md-12 col-sm-12 signup-forms">
        
        <!-- <form class="justify-left" action="signup_company_info.php?title=Company Info" id='sign_up'>
            <input type="hidden" name="step" value='3'>
            <input type="hidden" name="account_id" value='<?php echo $_GET['account'] ?>'>
            <input type="hidden" name="user_id" value='<?php echo $_GET['user'] ?>'>
            
            <button type="submit" class="btn btn-primary continue" onclick="">Continue</button>
        </form>
        <script>
            $(document).ready(function() {
                // $('form').submit(function(e) {
                //     e.preventDefault();
                //     $('.confirm-modal').modal('show');

                // });
            });
        </script>
        <div class='fill-div text-center'>
            <span class='fill-blue '></span>
            <span class='fill-blue '> &nbsp;</span>
            <span class='fill-blue '> &nbsp;</span>
        </div> -->
    </div>
    <div class="modal confirm-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                
                <div class="modal-body text-center">
                    <p>You will be automatically redirected to a login page in 5 second, or you can click log in below.</p>
                </div>
                <div class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo WEB_ROOT_PROTOCOL?>
<script>
    $(document).ready(function(){
        $('.confirm-modal').modal({
            backdrop:'static'
        });
        // $('.confirm-modal').modal('show');
        $.post({
            url : '<?= WEB_ROOT?>/account/register?display=plain&verify=1',
            data :{
                verify : '<?= $_GET['verify'] ?>',
                account_id : '<?= $_GET['acc'] ?>'
            },
            success:function(data){
                console.log(data);
                data = JSON.parse(data);
                console.log(data.success);
                if(data.success == 1)
                {   
                    var time = 5;

                    setInterval(function() {
                        $('span.sec').html(time);
                        $('span.sec').html(time= time-1);
                        if(time == 0){
                            window.location.href = '<?=WEB_ROOT?>/registration/login.php';
                        }   
                    }, 1000);

                    $('.confirm-modal').modal('show');
                    $('.confirm-modal .modal-body').html('<h4> Registration completed successfully ' + data.full_name + '</h4><p>You will be automatically redirected to a login page in <span class="sec">5</span> second, or you can click log in below.</p>');
                    // alert('Success');
                    // showSuccessMessage(data.description,function(){
                        //window.location.href = '<?=WEB_ROOT;?>/registration/signup_plans.php?account=' + data.account_id + '&user=' + data.user_id;
                    // });
                    
                }
                else{
                    $('.confirm-modal').modal('show');
                    $('.confirm-modal .modal-body').html('<p>Link not valid</p><p>You will be automatically redirected to a login page in <span class="sec">5</span> second, or you can click log in below.</p>');
                    var time = 5;

                    setInterval(() => {
                        $('span.sec').html(time);
                        $('span.sec').html(time= time-1);
                        if(time == 0){
                            window.location.href = '<?=WEB_ROOT;?>/registration/signup_details.php';
                        }
                    }, 1000);
                }
            }
        });
    });
</script>
<?php include 'layout/footer.php' ?>