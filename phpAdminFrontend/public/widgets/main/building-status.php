<?php
$menus = [

	'electrical' => [
			'ok'=> WEB_ROOT . '/images/dashboard/building-status-electrical-ok.png' ,
			'warning'=> WEB_ROOT . '/images/dashboard/building-status-electrical-yellow.png' ,
            'failed'=> WEB_ROOT . '/images/dashboard/building-status-electrical-critical.png' ,
    ],
    'fire-protection' => [
        'ok'=> WEB_ROOT . '/images/dashboard/building-status-fire-protection-ok.png' ,
        'warning'=> WEB_ROOT . '/images/dashboard/building-status-fire-protection-yellow.png' ,
        'failed'=> WEB_ROOT . '/images/dashboard/building-status-fire-protection-critical.png' ,
    ],
    'mechanical' => [
        'ok'=> WEB_ROOT . '/images/dashboard/building-status-mechanical-ok.png' ,
        'warning'=> WEB_ROOT . '/images/dashboard/building-status-mechanical-yellow.png' ,
        'failed'=> WEB_ROOT . '/images/dashboard/building-status-mechanical-critical.png' ,
    ],
    'plumbing' => [
        'ok'=> WEB_ROOT . '/images/dashboard/building-status-plumbing-and-sanitary-ok.png' ,
        'warning'=> WEB_ROOT . '/images/dashboard/building-status-plumbing-and-sanitary-yellow.png' ,
        'failed'=> WEB_ROOT . '/images/dashboard/building-status-plumbing-and-sanitary-critical.png' ,
    ],
    'safety' => [
        'ok'=> WEB_ROOT . '/images/dashboard/building-status-safety-and-security-ok.png' ,
        'warning'=> WEB_ROOT . '/images/dashboard/building-status-safety-and security-yellow.png' ,
        'failed'=> WEB_ROOT . '/images/dashboard/building-status-safety-and-security-ok.png' ,
    ],
]

?>


<div class="d-flex justify-content-start flex-wrap">
    <div class="d-flex mb-4" style="overflow:auto;">
        <div class="dashboard-footer" style="color:#34495E;">
            <span class="fa fa-dashboard mb-4"></span> <label class="text-required" style="font-size: 20px;">Building Status</label>
            <label class="text-required text-primary px-2 mb-4"></label>
            <div class="d-flex justify-content-center gap-2">
                <div class="justify-content-center p-2" >
                    <?php
                         $data = [
                           'filters' => ['category_id'=>'Electrical'] 
                        ];
                            $result_electrical = $ots->execute('property-management','get-work-order',$data);//Per month and all electrical
                            $result_electrical = json_decode($result_electrical,true);
                            number_format($result_electrical['record_count']);
                            
                            // var_dump($result_electrical);
                        ?>

                    <div style="position:relative">
                        <?php if($result_electrical['record_count'] == 0): ?>
                            <div class="position-absolute" style="right:0">
                                <img src="<?php echo WEB_ROOT;?>/images/dashboard/building-status-check-circle.png">
                            </div>
                        <?php else: ?>
                            <div class="position-absolute" style="right:0;">
                                <img src="<?php echo WEB_ROOT;?>/images/dashboard/building-status-close-circle-red.png">
                            </div>
                        <?php endif; ?>
                       
                        <?php if($result_electrical['record_count'] == 0): ?>
                            <a href="<?= WEB_ROOT;?>/property-management/workorder?menuid=propman&submenuid=workorder&column=category_id&value='Electrical'" target="_blank" class="btn">
                                <center>
                                    <img src="<?php echo WEB_ROOT;?>/images/dashboard/building-status-electrical-ok-green.png">
                                </center>
                            </a>
                        <?php else: ?>
                            <a href="<?= WEB_ROOT;?>/property-management/workorder?menuid=propman&submenuid=workorder&column=category_id&value='Electrical'" target="_blank" class="btn">
                                <center>
                                    <img src="<?php echo WEB_ROOT;?>/images/dashboard/building-status-electrical-critical.png"  width="65" height="65">
                                </center>
                            </a>
                        <?php endif; ?>
                    </div>
                    <?php if($result_electrical['record_count'] == 0): ?>
                        <div class="pt-5 text-center">
                            <b class="">ELECTRICAL</b>
                        </div>
                    <?php else: ?>
                        <div class="pt-5 text-center">
                            <b class="text-danger">ELECTRICAL</b>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="justify-content-center p-2">
                    <div class="justify-content-center">
                        <?php
                            $data = [
                            'filters' => ['category_id'=>'Fire Protection'] 
                            ];
                            $result_fireprotection = $ots->execute('property-management','get-work-order',$data);//Per month and all fireprotection
                            $result_fireprotection = json_decode($result_fireprotection,true);
                            number_format($result_fireprotection['record_count']);
                        ?>
                        <div style="position:relative" class=" ">
                        <?php if($result_fireprotection['record_count'] == 0): ?>
                            <div class="position-absolute" style="left:70%" >
                                <img src="<?php echo WEB_ROOT;?>/images/dashboard/building-status-check-circle.png">
                            </div>
                        <?php else: ?>
                            <div class="position-absolute" style="left:70%" >
                                <img src="<?php echo WEB_ROOT;?>/images/dashboard/building-status-close-circle-red.png">
                            </div>
                        <?php endif; ?>
                        
                        <?php if($result_fireprotection['record_count'] == 0): ?>
                            <a href="<?= WEB_ROOT;?>/property-management/workorder?menuid=propman&submenuid=workorder&column=category_id&value='Fire Protection'" target="_blank" class="btn">
                                <center>
                                    <img src="<?php echo WEB_ROOT;?>/images/dashboard/building-status-fire-protection-ok-green.png">
                                </center>
                            </a>
                        <?php else: ?>
                            <a href="<?= WEB_ROOT;?>/property-management/workorder?menuid=propman&submenuid=workorder&column=category_id&value='Fire Protection'" target="_blank" class="btn">
                                <center>
                                    <img src="<?php echo WEB_ROOT;?>/images/dashboard/building-status-fire-protection-critical.png" width="65" height="65">
                                </center>
                            </a>
                        <?php endif; ?>
                            
                        </div>
                    </div>
                    <?php if($result_fireprotection['record_count'] == 0): ?>
                        <div class="pt-5 text-center">
                            <b class="">FIRE PROTECTION</b>
                        </div>
                    <?php else: ?>
                        <div class="pt-5 text-center">
                            <b class="text-danger">FIRE PROTECTION</b>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="justify-content-center p-2">
                    <div class="justify-content-center">
                        <?php
                            $data = [
                            'filters' => ['category_id'=>'Mechanical'] 
                            ];
                            $result_mechanical = $ots->execute('property-management','get-work-order',$data);//Per month and all mechanical
                            $result_mechanical = json_decode($result_mechanical,true);
                            number_format($result_mechanical['record_count']);
                        ?>
                        <div style="position:relative">
                            <?php if($result_mechanical['record_count'] == 0): ?>
                                <div class="position-absolute" style="left:70%" >
                                <img src="<?php echo WEB_ROOT;?>/images/dashboard/building-status-check-circle.png">
                            </div>
                            <?php else: ?>
                                <div class="position-absolute" style="left:70%" >
                                    <img src="<?php echo WEB_ROOT;?>/images/dashboard/building-status-close-circle-red.png">
                                </div>
                            <?php endif; ?>
                            
                            <?php if($result_mechanical['record_count'] == 0): ?>
                                <a href="<?= WEB_ROOT;?>/property-management/workorder?menuid=propman&submenuid=workorder&column=category_id&value='Mechanical'" target="_blank" class="btn">
                                <center>
                                    <img src="<?php echo WEB_ROOT;?>/images/dashboard/building-status-mechanical-ok-green.png" width="65" height="65">
                                </center>
                            </a>
                            <?php else: ?>
                                <a href="<?= WEB_ROOT;?>/property-management/workorder?menuid=propman&submenuid=workorder&column=category_id&value='Mechanical'" target="_blank" class="btn">
                                <center>
                                    <img src="<?php echo WEB_ROOT;?>/images/dashboard/building-status-mechanical-critical.png" width="65" height="65">
                                </center>
                            </a>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                    <?php if($result_mechanical['record_count'] == 0): ?>
                        <div class="pt-5 text-center">
                            <b class="">MECHANICAL</b>
                        </div>
                    <?php else: ?>
                        <div class="pt-5 text-center">
                            <b class="text-danger">MECHANICAL</b>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="justify-content-center p-2">
                    <div class="justify-content-center">
                        <?php
                            $data = [
                            'filters' => ['category_id'=>'Plumbing Sanitary'] 
                            ];
                            $result_plumbing = $ots->execute('property-management','get-work-order',$data);//Per month and all plumbing
                            $result_plumbing = json_decode($result_plumbing,true);
                            number_format($result_plumbing['record_count']);
                        ?>
                        <div style="position:relative">
                            <?php if($result_plumbing['record_count'] == 0): ?>
                                <div class="position-absolute" style="left:65%" >
                                    <img src="<?php echo WEB_ROOT;?>/images/dashboard/building-status-check-circle.png">
                                </div>
                            <?php else: ?>
                                <div class="position-absolute" style="left:70%" >
                                    <img src="<?php echo WEB_ROOT;?>/images/dashboard/building-status-close-circle-red.png">
                                </div>
                            <?php endif; ?>
                            
                            <?php if($result_plumbing['record_count'] == 0): ?>
                                <a href="<?= WEB_ROOT;?>/property-management/workorder?menuid=propman&submenuid=workorder&column=category_id&value='Plumbing Sanitary'" target="_blank" class="btn">
                                    <center>
                                        <img src="<?php echo WEB_ROOT;?>/images/dashboard/building-status-plumbing-and-sanitary-ok-green.png">
                                    </center>
                                </a>
                            <?php else: ?>
                                <a href="<?= WEB_ROOT;?>/property-management/workorder?menuid=propman&submenuid=workorder&column=category_id&value='Plumbing Sanitary'" target="_blank" class="btn">
                                    <center>
                                        <img src="<?php echo WEB_ROOT;?>/images/dashboard/building-status-plumbing-and-sanitary-critical.png" width="65" height="65">
                                    </center>
                                </a>
                            <?php endif; ?>
                           
                        </div>
                    </div>
                    <?php if($result_plumbing['record_count'] == 0): ?>
                        <div class="pt-5 text-center">
                            <b class="">PLUMBING & SANITARY</b>
                        </div>
                    <?php else: ?>
                        <div class="pt-5 text-center">
                            <b class="text-danger">PLUMBING & SANITARY</b>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="justify-content-center p-2">
                    <div class="justify-content-center">
                        <?php
                            $data = [
                            'filters' => ['category_id'=>'safetysecurity'] 
                            ];
                            $result_safety = $ots->execute('property-management','get-work-order',$data);//Per month and all safety
                            $result_safety = json_decode($result_safety,true);
                            number_format($result_safety['record_count']);
                        ?>
                        <div style="position:relative">
                            <?php if($result_safety['record_count'] == 0): ?>
                                <div class="position-absolute" style="left:65%" >
                                    <img src="<?php echo WEB_ROOT;?>/images/dashboard/building-status-check-circle.png">
                                </div>
                            <?php else: ?>
                                <div class="position-absolute" style="left:70%" >
                                    <img src="<?php echo WEB_ROOT;?>/images/dashboard/building-status-close-circle-red.png">
                                </div>
                            <?php endif; ?>
                            
                            <?php if($result_safety['record_count'] == 0): ?>
                                <a href="<?= WEB_ROOT;?>/property-management/workorder?menuid=propman&submenuid=workorder&column=category_id&value='safetysecurity'" target="_blank" class="btn">
                                    <center>
                                        <img src="<?php echo WEB_ROOT;?>/images/dashboard/building-status-safety-security-ok-green.png" width="70" height="70">
                                    </center>
                                </a>
                            <?php else: ?>
                                <a href="<?= WEB_ROOT;?>/property-management/workorder?menuid=propman&submenuid=workorder&column=category_id&value='safetysecurity'" target="_blank" class="btn">
                                    <center>
                                        <img src="<?php echo WEB_ROOT;?>/images/dashboard/building-status-safety-security-critical.png" width="70" height="70">
                                    </center>
                                </a>
                            <?php endif; ?>

                            
                        </div>
                    </div>
                    <?php if($result_safety['record_count'] == 0): ?>
                        <div class="pt-5 text-center">
                            <b class="">STRUCTURAL & CIVIL WORKS</b>
                        </div>
                    <?php else: ?>
                        <div class="pt-5 text-center">
                            <b class="text-danger">STRUCTURAL & CIVIL WORKS</b>
                        </div>
                    <?php endif; ?>
                </div>
  
         
                <div>
                </div>
                <div>
                </div>    
            </div>
        </div>
    </div>
</div>