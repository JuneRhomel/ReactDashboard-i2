<?php
require_once ("header.php");
?>
<style>
    .slick-dots {
    position: absolute;
    display: flex;
    width: 100%;
    padding: 0;
    margin: 0;
    list-style: none;
}
.slick-dots li.slick-active button:before {
    opacity: .75;
    color: #1C5196;
    font-size: 20px;
}
.slick-dots li button:before {
    font-family: 'slick';
    font-size: 6px;
    line-height: 20px;
    position: absolute;
    top: 0;
    left: 0;
    width: 20px;
    height: 20px;
    content: '•';
    text-align: center;
    opacity: .25;
    color: black;
    -webkit-font-smoothing: antialiased;
    font-size: 20px;
}
    .onboarding-container {
    padding: 24px 25px 25px 25px; 
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    gap: 34px
    
    
    }
    .onboarding-container .text-center {
        
    }
  </style>
<body>
    <div class="onboarding-container">
    <div class="d-flex flex-column" style="gap: 24px;height: 100%;">
    <div>
        <img src="assets/images/inventi-logo-blue.png" style="width: 30%;height: 100%; object-fit: contain;" >
    </div >
    <div class="d-flex gap-2 your-class "style="height: 100%;">
        <div >
            <img src="assets/images/onboarding-screen-image.png" style="width: 100%">
           <h3 class="my-4" style="font-family: 'Montserrat'; font-weight: 700;font-size: 24px;">Forms made easy to apply</h3>
           <p style="color: black; margin: 0;font-size: 16px;">Lorem ipsum dolor sit amet. Et perspiciatis laudantium quo ipsa similique quo dolor veniam. Eos sunt reiciendis non neque quas ut sunt aliquid et nulla culpa! Et eveniet eaque id quasi suscipit eum nulla explicabo sed voluptas aliquam est ipsum aliquam sed nemo saepe.</p>
        </div>
        
        <div>           
           
            <img src="assets/images/onboarding-screen-image.png" style="width: 100%">
           <h3 class="my-4" style="font-family: 'Montserrat'; font-weight: 700;font-size: 24px;">Tracking Bills and Payment</h3>
           <p style="color: black; margin: 0;font-size: 16px;">Lorem ipsum dolor sit amet. Et perspiciatis laudantium quo ipsa similique quo dolor veniam. Eos sunt reiciendis non neque quas ut sunt aliquid et nulla culpa! Et eveniet eaque id quasi suscipit eum nulla explicabo sed voluptas aliquam est ipsum aliquam sed nemo saepe.</p>
        </div>
        <div>         
           
            <img src="assets/images/onboarding-screen-image.png" style="width: 100%">
           <h3 class="my-4" style="font-family: 'Montserrat'; font-weight: 700;font-size: 24px;">Service Request</h3>
           <p style="color: black; margin: 0;font-size: 16px;">Lorem ipsum dolor sit amet. Et perspiciatis laudantium quo ipsa similique quo dolor veniam. Eos sunt reiciendis non neque quas ut sunt aliquid et nulla culpa! Et eveniet eaque id quasi suscipit eum nulla explicabo sed voluptas aliquam est ipsum aliquam sed nemo saepe.</p>
        </div>
    </div>
    </div>
    <div class="text-center">
        <button type="button" class="get-started px-5 py-3" style="width: 100%; border: none; border-radius: 5px; background-color:#1C5196; color: white;">Get started</button>
    </div>
    </div>

</body>
</html>
<script>
    $('.your-class').slick({
        dots: true,
    });
    $('.get-started').on('click', function(){
        window.location.href = '<?=WEB_ROOT ?>/register.php';
    });
</script>
