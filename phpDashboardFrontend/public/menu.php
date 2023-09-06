<?php

$result = apiSend('module', 'get-listnew', ['table' => 'system_info']);
$info = json_decode($result);

// var_dump($info[0]->ownership);
?>

<nav class="menu-bottom">
    <div class="menu-container">
        <a class="menu-card <?= $location_menu === 'dashboard' ? 'active-menu' : '' ?> " href="http://portali2.sandbox.inventiproptech.com/home.php">
            <div><span class="material-icons">dashboard</span></div>
            <label>Dashboard</label>
        </a>
        <a class="menu-card  <?= $location_menu === 'billing' ? 'active-menu' : '' ?>" href="http://portali2.sandbox.inventiproptech.com/billing.php">
            <div><span class="material-icons">ballot</span></div>
            <label>SOA</label>
        </a>
        <a class="menu-card  <?= $location_menu === 'my-request' ? 'active-menu' : '' ?>" href="http://portali2.sandbox.inventiproptech.com/my-requests_new.php">
            <div><span class="material-icons">receipt</span></div>
            <label>My Request</label>
        </a>
        <a class="menu-card  <?= $location_menu === 'news&announcement' ? 'active-menu' : '' ?>" href="http://portali2.sandbox.inventiproptech.com/news-announcement.php">
            <div><span class="material-icons">insert_chart</span></div>
            <label>News & Announcement</label>
        </a>
        <a class="menu-card burger ">
            <div><span class="material-icons">menu</span></div>
            <label>Menu</label>
        </a>
    </div>
</nav>
<div class="menu-side-bar">
    <div class="nav-menu  <?= $location_menu === 'dashboard' ? 'active-menu' : '' ?> ">
        <a class="color-black" href="http://portali2.sandbox.inventiproptech.com/home.php">
            <span class="material-icons">dashboard</span> Dashboard
        </a>
    </div>
    <div class="nav-menu  <?= $location_menu === 'billing' ? 'active-menu' : '' ?> ">
        <a class="color-black" href="http://portali2.sandbox.inventiproptech.com/billing.php"><span class="material-icons">ballot</span>
            SOA
        </a>
    </div>
    <div class="nav-menu  <?= $location_menu === 'my-request' ? 'active-menu' : '' ?> ">
        <a class="color-black" href="http://portali2.sandbox.inventiproptech.com/my-requests_new.php"><span class="material-icons">receipt</span>
            My Request
        </a>
    </div>
    <div class="nav-menu  <?= $location_menu === 'news&announcement' ? 'active-menu' : '' ?> ">
        <a class="color-black" href="http://portali2.sandbox.inventiproptech.com/news-announcement.php"><span class="material-icons">insert_chart</span>
            News & Announcement
        </a>
    </div>

    <?php if($info[0]->ownership === 'HOA') { if ($user->type === "Owner" || $user->type === "Unit Owner") { ?>
        <div class="nav-menu  <?= $location_menu === 'occupant' ? 'active-menu' : '' ?> ">
            <a class="color-black" href="http://portali2.sandbox.inventiproptech.com/occupant.php"><span class="material-icons">insert_chart</span>
                Occupant
            </a>
        </div>
        <div class="nav-menu  <?= $location_menu === 'occupant-reg' ? 'active-menu' : '' ?> ">
            <a class="color-black" href="http://portali2.sandbox.inventiproptech.com/occupant-reg.php"><span class="material-icons">insert_chart</span>
                Occupant Regstration
            </a>
        </div>
        <div class="nav-menu  <?= $location_menu === 'send-invite' ? 'active-menu' : '' ?> ">
            <a class="color-black" href="http://portali2.sandbox.inventiproptech.com/send-invite.php"><span class="material-icons">insert_chart</span>
                Send Invite
            </a>
        </div>
    <?php }} ?>

    <!-- <div class="nav-menu  <?= $location_menu === 'dashboard' ? 'active-menu' : '' ?> ">
                <a href class="color-black"="http://portali2.sandbox.inventiproptech.com/building-directory_new.php" >
                Building Directory
                </a>
            </div> -->
    <div class="nav-menu   <?= $location_menu === 'profile' ? 'active-menu' : '' ?> ">
        <a class="color-black" href="http://portali2.sandbox.inventiproptech.com/my-profile_new.php">
            My Profile
        </a>
    </div>
    <button onclick="location='http://portali2.sandbox.inventiproptech.com/logout.php'">Logout</button>
    <div class="menu-logo">
        <img src="./assets/images/navlogo1.png" alt="">
    </div>
</div>

<script>
    $(".notification").click(function() {
        $(".sidenav").addClass("show-notf")
        $(".overlay-nav-notif").show()
    })
    $(".overlay-nav-notif").click(function() {
        $(".sidenav").removeClass("show-notf")
        $(".overlay-nav-notif").hide()
    })

    $("#select-lang-btn").click(function() {
        $(".lang-select").slideToggle();
    })


    $(".overlay-nav").click(function() {
        $(".navigation-links").removeClass("show-nav");
        $(".overlay-nav").hide();
    })
    $(".burger").click(function() {
        $(".navigation-links").addClass("show-nav");
        $(".overlay-nav").show();
    })
</script>