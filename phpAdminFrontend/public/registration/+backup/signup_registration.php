<?php include 'layout/header.php' ?>

<div class="d-flex">
    <div class="signup-image ">
        <div class="logo">
            <!-- <img src="./assets/logo.png" alt=""> -->
        </div>
        <div class="img-container">
            <img src="./assets/Frame.png" alt="">

        </div>
    </div>
    <div class="form-signup">
        <div class="h-100">
            <a href="http://i2-sandbox.inventiproptech.com/" class="d-flex gap-2 text-black fw-bold back ">
                <span class="material-icons">
                    arrow_back
                </span>
                Back
            </a>
            <div class="d-flex aligin-item-center align-items-center mt-4 justify-content-center w-100">
                <img src="./assets/s-1.png" alt="">
            </div>
            <div class="d-flex gap-3 flex-column  mt-5">
                <b>*Please fill in the required field</b>
                <form action="http://i2-sandbox.inventiproptech.com/registration/signup_property_details.php" class="row ">
                    <div class="col-6 mb-4">
                        <div class="input-box input-h  ">
                            <input type="email" class="" placeholder="test" required>
                            <label for="">Email*</label>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="input-box input-h ">
                            <input type="password" placeholder="test" required class="" clas>
                            <label for="">Password*</label>
                        </div>

                    </div>
                    <div class="col-6 mb-4">
                        <div class="input-box input-h ">
                            <input type="name" placeholder="test" required class="">
                            <label for="">Your Name*</label>
                        </div>

                    </div>
                    <div class="col-6 mb-4">
                        <div class="input-box input-h  ">
                            <select name="" id="" required>

                                <option value="" disabled selected></option>
                                <option value="">Owner</option>
                                <option value="">Property Manage</option>

                            </select>
                            <label for="">Your Role*</label>
                        </div>

                    </div>
                    <div>
                        <input type="checkbox" name="" required id="check" class="c1">
                        <label for="check" class="fw-bold">I agree to the <a href="">terms and conditions.</a> </label>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="main-btn">Next</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>