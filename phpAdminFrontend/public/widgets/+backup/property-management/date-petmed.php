<?php
    include '../config.php';
    session_start();
    include '../../layouts/header.php';
	// include_once '../layouts/dashboardfluid.php';
// var_dump($_POST); die;
    // $Date = $_POST['date'];
	// $Product = $_POST['product'];
    print_R($_GET);
    ?>
<link rel="stylesheet" type="text/css"
    href="<?= PUBLICURL . 'js/datetimepicker/build/jquery.datetimepicker.min.css' ?>" />
<script src="<?= PUBLICURL . 'js/datetimepicker/build/jquery.datetimepicker.full.min.js' ?>"></script>

<script src="<?= PUBLICURL . 'js/moment.js' ?>"></script>

<script src="https://cdn.jsdelivr.net/gh/wrick17/calendar-plugin@master/calendar.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/wrick17/calendar-plugin@master/style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/wrick17/calendar-plugin@master/theme.css">

<?php
    // get provider details
	$Config = ['ver' => 1, 'cmd' => 'getuser', 'requestid' => 'ABCDE12345', 'sessionid' => ''];
	$Params = ['code' => $_GET['provider']];
    $Response = SendCommand(MAININDEX, $Config, $Params);
	$Response = json_decode($Response, TRUE);
    $Provider = $Response['data']['user'];

    // get provider reviews
	$Config = ['ver' => 1, 'cmd' => 'getproviderreviews', 'requestid' => 'ABCDE12345', 'sessionid' => ''];
	$Params = ['code' => $_GET['provider']];
    $Response = SendCommand(MAININDEX, $Config, $Params);
	$Response = json_decode($Response, TRUE);
    $Reviews = $Response['data']['reviews'];
    $Average = $Response['data']['average'];
    $TotalStars = $Response['data']['totalstars'];
    $TotalCount = $Response['data']['totalcount'];

    $DummyReviews = [];
    // DUMMY REVIEWS HERE
    if ($Provider['code']=='vetpawplifetest') {
        $DummyReviews = [
            [
                '__createtime' => '1658947403',
                'reviewcontent' => 'We tried PetMed last night (June 28) and consulted with Doc Rouchelle. We are so pleased with our experience. Doc Rouchelle is very knowledgeable, compassionate, and accommodating with all our questions. Her advice is practical.',
                'score' => 5
            ],
            [
                '__createtime' => '1656556242',
                'reviewcontent' => ' I just find Dr. Rouchelle very accommodating, warm and knowledgeable that’s why I also ask for her opinion everytime I have a concern with Tiny. (I also consider her as Tiny’s godmother haha!)',
                'score' => 5
            ],
            [
                '__createtime' => '1656556242',
                'reviewcontent' => 'Experience: Always a 10/10 experience whenever I book an online consultation with PetMed.',
                'score' => 5
            ],
        ];
    } else if ($Provider['code']=='keenoianmgmailcom'){
        $DummyReviews = [
            [
                '__createtime' => '1656556242',
                'reviewcontent' => 'Well recommended specially for those working people like me na hindi nman as in need emergency agad or malayo sa animal clinic hindi agad makapunta kasi gabi na, pero para makapante lang as furparent may malaman agad possible na sakit/opinion, remedy/solution & also prescription.  Kasi meron din sa gabi na scheds. With passionate & friendly doctors, I choose Dr. Keeno seeing his profile. Meeting via zoom, para ka din nagpacheck up talaga but this is online. Thank you naisip nyo \'to PetMed PH. ',
                'score' => 5
            ],
        ];
    }

    foreach($DummyReviews as $DummyReview) {
        $Reviews = array_merge($Reviews, [['reviewcontent' => $DummyReview['reviewcontent'], '__createtime' => $DummyReview['__createtime']]]);
        $TotalStars = ($TotalStars + $DummyReview['score']);
        ++$TotalCount;
    }
    
    if ($TotalCount)
        $Average = ($TotalStars / $TotalCount);
    // get provider next availabledate
	$Config = ['ver' => 1, 'cmd' => 'getprovidernextavailabledate', 'requestid' => 'ABCDE12345', 'sessionid' => ''];
	$Params = ['user_rowid' => $Provider['__rowid']];
    $Response = SendCommand(MAININDEX, $Config, $Params);
    $Response = json_decode($Response, TRUE);
    $NextDate = $Response['data']['date'];
    // call listavailableproviders to get ALL available vets with the given timeslot and concern
    // $Params = [
    //     'date' => date('Y/m/d', strtotime($Date)),
    //     'start' => $_POST['start'],
    //     'providertype' => 'vet',
    //     'concern' => $_POST['concern']
    // ];

    // $Config = ['ver' => 1, 'cmd' => 'listavailableproviders', 'requestid' => 'ABCDE12345', 'sessionid' => $_SESSION['sessionid']];
    // $Providers = SendCommand(MAININDEX, $Config, $Params);
    // $Providers = json_decode($Providers, TRUE);

    // $Providers = $Providers['data']['users'];
?>

<!-- <form action="confirm.php" method="post">
        
        <input type="hidden" name="pet" value="<?= $_POST['pet'] ?>">
        <input type="hidden" name="product" value="<?= $_POST['product'] ?>">
        <input type="hidden" name="date" value="<?= $_POST['date'] ?>">
        <input type="hidden" name="start" value="<?= $_POST['start'] ?>">
        <input type="hidden" name="concern" value="<?= $_POST['concern'] ?>">
        <button type="submit">Submit</button>
    </form> -->

<section id="select-time" class="book-provider-dashboard">
    <div class="container-fluid">
        <?php includeBreadcrumbs(['which' => 'provider', 'file' => 'cart']); ?>
        <?php include_once '../layouts/messages.php'; ?>
        <div class="row d-flex align-items-stretch">
            <div class="col-12 col-md-12 col-lg-8 col-xl-8 h-auto">
                <div class="col-md-12 main-content"
                    style="padding: 15px; background-color: #ffffff; box-shadow: 0px 0px 30px #00000029;">
                    <div class="row">
                        <div class="col-md-3">
                            <img class='img-fluid lazy profile-photo'
                                src="<?=$Provider['profile']['profilephoto'] ?? PUBLICURL . 'images/default-photo.png' ?>" />
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="section-title" style="text-decoration:underline; font: 25px rubik-medium;">
                                    <?= $Provider['profile']['firstname'] ?> <?= $Provider['profile']['lastname'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <?php
                                    for($i=0; $i<$Average; $i++)
                                    {
                                        echo '<img class="lazy" src="'.PUBLICURL.'images/icons/icon-awesome-star.svg"> ';
                                    }
                                    ?>&nbsp;
                                <span class="change-password"
                                    style="font:20px; color: #F0A659"><?=number_format($Average, 1)?></span>&nbsp;
                                <span class="control-value" style="font:15px; color: #F0A659">(<?=count($Reviews)?>
                                    reviews)</span><br />
                            </div>
                            <div class="row">
                                <p class="notif-time" style="font: 17px inter-regular;">Veterinarian</p>
                            </div>
                            <div class="row">
                                <p class="notif-time"><span style="color:#99CEA2"><i class="fa fa-check"></i></span>
                                    <span style="font:25px rubik-medium">Licensed</span>
                                </p>
                            </div>
                            <div class="row professional-info">
                                <div class="section-title">Professional Information </div>
                            </div>
                            <div class="row professional-info">
                                <div class="col-lg-3 col-md-6 col-sm-12 card-left" style="font: 18px rubik-medium;">
                                    Licenses
                                </div>
                                <div class="col-lg-9 col-md-6 col-sm-12 card-right" style="font: 18px rubik-medium;">
                                    Veterinarian</div>
                            </div>
                            <div class="row professional-info">
                                <div class="col-lg-3 col-md-6 col-sm-12" style="font: 18px rubik-medium;">About Vet
                                </div>
                                <div class="col-lg-9 col-md-6 col-sm-12 card-right"
                                    style="font: 15px inter-regular; line-height: 30px;">
                                    <?= $Provider['profile']['bio'] ?? '' ?>
                                </div>
                            </div>
                            <?php if (isset($Provider['profile']['specialty']) && $Provider['profile']['specialty']!='') { ?>
                            <div class="row professional-info">
                                <div class="col-lg-3 col-md-6 col-sm-12" style="font: 18px rubik-medium;">Specialty
                                </div>
                                <div class="col-lg-9 col-md-6 col-sm-12 card-right"
                                    style="font: 15px inter-regular; line-height: 30px;">
                                    <?= $Provider['profile']['specialty'] ?? '' ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-12 col-lg-4 col-xl-4 calendar main-content h-100">
                <div class="col-md-12 main-content">
                    <div class="calendar-wrapper"></div>
                    <div id="timeslots-alert"></div>
                    <div id="timeslots"></div>

                    <div class="d-flex align-items-center justify-content-between my-3">
                        <div>
                            <span class="control-label">TOTAL</span>
                            <p class="control-label" style="font-size:15px">INCLUDED TAXES & FEES</p>
                        </div>
                        <div id="price-display" style="display:none">
                            <p class="section-title" style="color:#FCA347">
                                ₱ <span id="rate-display"><?=number_format($Provider['profile']['rate'], 2)?></span></p>
                        </div>
                    </div>

                    <form action="confirm.php" method="post">
                        <input type="hidden" name="start" value="" id="start">
                        <input type="hidden" name="date" value="<?= $_GET['date']?>" id="date">
                        <input type="hidden" name="provider" value="<?= $Provider['code']?>">
                        <input type="hidden" name="product" value="<?= $_GET['product']?>">
                        <!-- <input type="hidden" name="pet" value="<?= $_POST['pet']?>">
                            <input type="hidden" name="concern[]" value="<?= json_encode($_POST['concern'])?>">
                            <input type="hidden" name="otherconcern" value="<?= $_POST['otherconcern'] ?? ''?>">
                            <input type="hidden" name="currentfoodmedicine" value="<?= $_POST['currentfoodmedicine'] ?? ''?>"> -->
                        <button type="submit" class="bordered-button orange-button float-right" id="time-selected">Book
                            Now</button>
                    </form>
                </div>
            </div>
        </div>
        <br />
        <br />
        <div class="row" id="provider-reviews" style="margin-left: 1px;">
            <div class="col-md-12">
                <div class="mb-3">
                    <div>
                        <span class="review-title">Reviews</span>
                        <span class="review-count">(<?=count($Reviews)?>)</span>
                    </div>
                    <span class="review-average d-flex align-items-center my-2">
                        <?php for ($i=0; $i<$Average; $i++)
                            { ?>
                        <img class="star" src="<?=PUBLICURL?>images/icons/icon-awesome-star.svg">
                        <?php } ?>
                        <p class="ml-2 mb-0"> <?=number_format($Average, 2)?></p>
                    </span>
                </div>

                <div>
                    <?php foreach($Reviews as $Review) { ?>
                    <!-- <div>
                        <div class="review-initial float-left">
                            <span><?=chr(64+rand(0,26))?></span>
                        </div>
                        <div class="clearfix">
                            <p class="review-name"><?=str_repeat("*", rand(5,15))?></p>
                            <p class="review-date"><?=date('F Y', $Review['__createtime']);?></p>
                            <p class="review-content"><?=$Review['reviewcontent'];?></p>
                        </div>
                        <br class="clearfix">
                        <br>
                    </div> -->
                    <div class="d-flex">
                        <div>
                            <div class="review-initial float-left">
                                <span><?=chr(64+rand(0,26))?></span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="review-name mb-0"><?=str_repeat("*", rand(5,15))?></p>
                            <p class="review-date"><?=date('F Y', $Review['__createtime']);?></p>
                        </div>

                    </div>
                    <p class="review-content"><?=$Review['reviewcontent'] ?? '1';?></p>
                    <hr>
                    <?php } ?>
                </div>

            </div>

        </div>
    </div>
</section>

<?php include '../../layouts/footer.php'; ?>

<script>
$(document).ready(function() {
    const isToday = (someDate) => {
        const today = new Date()
        return someDate.getDate() == today.getDate() &&
            someDate.getMonth() == today.getMonth() &&
            someDate.getFullYear() == today.getFullYear()
    }

    function selectDate(date) {
        $('.calendar-wrapper').updateCalendarOptions({
            date: date
        });
        $('#timeslots-alert').empty();
        showLoader();
        $('#time-selected').attr('donotsend', 'true');
        var dateformatted = new Date(date);
        $('#date').val(moment(dateformatted).format('YYYY-MM-DD'));
        let provider = "<?= $Provider['__rowid'] ?>";
        let url = "<?= MAININDEX ?>";
        let sessionid = "<?= $_SESSION['sessionid'] ?? '' ?>";
        let parameters = {
            'ver': 1,
            'cmd': 'listavailabletimeslots',
            'requestid': '',
            'sessionid': sessionid,
            'params': {
                'date': moment(dateformatted).format('YYYY-MM-DD'),
                'provider': provider
            }
        };

        $.ajax({
            url: url,
            type: 'post',
            data: JSON.stringify(parameters),
            success: function(data) {
                parsed = JSON.parse(data);
            },
        });
    };

    var mindate = new Date();
    mindate.setDate(mindate.getDate() - 1);

    $('.calendar-wrapper').calendar({
        enableMonthChange: true,
        showTodayButton: false,
        prevButton: '<',
        nextButton: '>',
        onClickDate: selectDate,
        min: mindate
        // onClickDate: function(date) {
        //     showLoader();

        //     $('#time-selected').prop('disabled', true);
        //     let dateformatted = new Date(date);
        //     let provider = "<?= $Provider['__rowid'] ?>";
        //     let url = "<?= MAININDEX ?>";
        //     let sessionid = "<?= $_SESSION['sessionid'] ?? '' ?>";
        //     let parameters = { 
        //         'ver' : 1,
        //         'cmd' : 'listavailabletimeslots',
        //         'requestid' : '',
        //         'sessionid' : sessionid,
        //         'params' : {
        //             'date' : moment(dateformatted).format('YYYY-MM-DD'),
        //             'provider' : provider
        //         }
        //     };

        //     $.ajax({
        //         url: url,
        //         type: 'post',
        //         data: JSON.stringify(parameters),
        //         success: function (data) {
        //             parsed = JSON.parse(data);
        //             timeslots = parsed.data.timeslots;

        //             $("#timeslots").empty();
        //             $.each(timeslots, function(index, item) {
        //                 var html = `<div class="availabletimeslots my-auto text-center" data-start="`+item.start+`" data-end="'+item.end+'">`+item.start+`</div>`;
        //                 $("#timeslots").append(html);
        //             });
        //             hideLoader();
        //         },
        //     });
        // },
    });

    let date = "<?=$_GET['date']!='' ? $_GET['date'] : $NextDate?>";
    selectDate(date);

    $(document).on('click', 'div.valid-timeslot', function() {
        let start = $(this).data('start');
        let shift = $(this).data('shift');

        $('.valid-timeslot').removeClass('availabletimeslots-selected');
        $(this).addClass('availabletimeslots-selected');
        $('#time-selected').removeAttr('donotsend');

        if (shift == 'graveyard')
            $('#rate-display').html(
                "<?= number_format(($Provider['profile']['rate'] + $Provider['profile']['nightdifferential']), 2) ?>"
            );
        else
            $('#rate-display').html("<?= number_format($Provider['profile']['rate'], 2) ?>");

        $('#price-display').css('display', 'block');
        $('#start').val(start);
    });

    // $('.main-content').matchHeight();
    $('.day').each(function() {
        console.log($(this).data('date'));
        if (
            (new Date($('.selected').data('date')) > new Date($(this).data('date'))) ||
            ($(this).data('date') !== undefined && $(this).data('date').includes('Sun'))
        )
            $(this).addClass('disabled');
    });
    //added HasAttr function
    $.fn.hasAttr = function(name) {
        return this.attr(name) !== undefined;
    };
    //Validate if no time selected
    $(document).on('click', '#time-selected', function(e) {
        $('#timeslots-alert').empty();
        if ($(this).hasAttr('donotsend')) {
            e.preventDefault();
            $('#timeslots-alert').html('<b class="text-danger"><h3>Please Select Timeslot</h3></b>');
            if ($("#timeslots").html() == '') {
                $('#timeslots-alert').html(
                    '<b class="text-warning"><h3>No Time Slots Available</h3></b>');
            }
        } else {
            $('#timeslots-alert').empty();
        }
    });
});
</script>