<?php include 'layout/header.php' ?>

<div class="d-flex ">
    <div class="signup-image ">
        <div class="logo">
            <!-- <img src="./assets/logo.png" alt=""> -->
        </div>
        <div class="img-container">
            <img src="./assets/Frame.png" alt="">

        </div>
    </div>
    <div class="form-signup  ">
        <div class="h-100">
            <a href="http://i2-sandbox.inventiproptech.com/registration/signup_registration.php" class="d-flex gap-2 text-black fw-bold back ">
                <span class="material-icons">
                    arrow_back
                </span>
                Back
            </a>
            <div class="d-flex aligin-item-center align-items-center mt-4 justify-content-center w-100">
                <img src="./assets/s-2.png" alt="">
            </div>
            <div class="d-flex gap-3 flex-column  mt-5">
                <b>*Please fill in the required field</b>
                <form action="http://i2-sandbox.inventiproptech.com/registration/signup_subscription.php" class="row ">
                    <div class="col-6 mb-4">
                        <div class="input-box input-h  ">
                            <input type="text" class="" placeholder="test">
                            <label for="">Property Name</label>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="input-box input-h ">
                            <input type="text" placeholder="test" class="" clas>
                            <label for="">Property Size*</label>
                        </div>

                    </div>
                    <div class="col-6 mb-4">
                        <div class="input-box input-h ">
                            <select name="" id="" required>
                                <option value="" disabled="" selected=""></option>
                                <option value="Residential">Residential</option>
                                <option value="Office">Office</option>
                                <option value="Commercial">Commercial</option>
                                <option value="Mixed Used">Mixed Used</option>
                                <option value="Other">Other</option>

                            </select>
                            <label for="">Property Type*</label>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="input-box input-h ">
                            <select name="" id="" required>
                                <option value="" selected></option>
                                <option value="">Single Owner or Entity</option>
                                <option value="">Homeowners Association (HOA)</option>
                            </select>
                            <label for="">Ownership*</label>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="input-box input-h ">
                            <input type="text" placeholder="test" class="" clas>
                            <label for="">Property Size*</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button class="main-btn">Next</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>