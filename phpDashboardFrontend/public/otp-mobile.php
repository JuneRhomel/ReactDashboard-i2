<?php 
$root = ($_SERVER['SERVER_NAME']=="localhost") ? "/ots-condo" : "/";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Login</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous" />
        <link rel="stylesheet" href="custom.css?v=<?=time()?>" />
    </head>
    <body style="background-color: #f4f4f4">
        <!-- nav -->
        <div class="container">
            <div class="subtitle font-22 text-uppercase my-4 pt-5 pb-3 text-center"> <a href="<?=$root?>">TENANT PORTAL</a> </div>
        </div>
        <div class="py-3 bg-white">
            <div class="container d-flex justify-content-center">
                <div class="py-4"><h5>ONE-TIME PASSWORD</h5></div>
            </div>
            <div class="container d-flex justify-content-center">
                <div class="mb-2">
                    <div class="mb-2 font-14">Please enter OTP sent to your mobile phone</div>
                </div>
            </div>
            <div class="container">
                <div class="mb-2">
                    <div>
                        <input type="text" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row mt-5" style="padding: 0 15px">
                    <div class="col-6">
                        <button class="btn btn-outline-primary subtitle font-16 w-100">Resend OTP</button>
                    </div>
                    <div class="col-6 d-block">
                        <button class="btn btn-primary px-3 w-100" onclick="location='dashboard.php'">Login</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- bottom tabs -->
        <div class="" style="background-color: white; padding:200px 0">
            <div class="row m-0 d-flex justify-content-center">
                <div class="col p-0" style="border-radius: 6px">
                    <div class="col-12 d-flex align-items-center">
                        <div class="mx-auto mt-auto">
                            <b style="font-color:#34495E; opacity:60%">P O W E R E D&nbsp;&nbsp;&nbsp;&nbsp;B Y</b>
                        </div>
                    </div>
                    <div class="col-12 d-flex mt-2">
                        <div class="mx-auto mb-auto">
                            <img class="mx-auto" src="resources/images/Inventi_Horizontal-Blue-01.png" alt="" width="100" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    </body>
</html>