<?php

$result =  $ots->execute('module','get-listnew',[ 'table'=>'location','condition'=>'id=1' ]);
$building = json_decode($result);
?>

<div class="building  bg-theme">
    <div class="d-flex align-items-center gap-2">
        <h1 class="dash-heading">Building Status</h1>
        <b class="highlight"><?= $building[0]->location_name  ?></b>
    </div>
    <div class="d-flex justify-content-between h-100 align-items-center">
        <div id="c1"></div>
        <div id="c2"></div>
        <div id="c3"></div>
        <div id="c4"></div>
        <div id="c5"></div>
    </div>
</div>

<script>
    $(document).ready(function() {




        $('#c1').append(
            circlePersentage({
                title: 'Electrical',
                id: 'c1',
                start: 0,
                end: 100,
                speed: 10,
                icon: '<?= WEB_ROOT?>/images/icon/electric.svg',
            })
        );

        $('#c2').append(
            circlePersentage({
                title: 'Fire </br> Protection',
                id: 'c2',
                start: 0,
                end: 70,
                speed: 10,
                icon: '<?= WEB_ROOT?>/images/icon/fire.svg',
            })
        );
        $('#c3').append(
            circlePersentage({
                title: 'Mechanical',
                id: 'c3',
                start: 0,
                end: 80,
                speed: 10,
                 icon: '<?= WEB_ROOT?>/images/icon/mechanical.svg',
            })
        );
        $('#c4').append(
            circlePersentage({
                title: 'Plumbing </br>& Sanitary',
                id: 'c4',
                start: 0,
                end: 90,
                speed: 10,
                 icon: '<?= WEB_ROOT?>/images/icon/plumbing.svg',
            })
        );
        $('#c5').append(
            circlePersentage({
                title: 'Security',
                id: 'c5',
                start: 0,
                end: 9,
                speed: 10,
                 icon: '<?= WEB_ROOT?>/images/icon/security.svg',
            })
        );

    });
</script>