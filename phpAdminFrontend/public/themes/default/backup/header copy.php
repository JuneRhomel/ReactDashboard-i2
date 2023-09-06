<!doctype html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta charset="UTF-8">
		<title><?php echo ($title ?? TITLE);?></title>
		<link rel="icon" type="image/png" href="<?php echo WEB_ROOT;?>/images/favicon.png">
		<!-- font-family: 'Manrope'; -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
		<link href="<?php echo WEB_ROOT;?>/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
		<link href="<?php echo WEB_ROOT;?>/themes/default/style.css?a=1" rel="stylesheet">

		<script src="<?php echo WEB_ROOT;?>/js/bootstrap.min.js"></script>
	</head>
	<body>
		<!-- //container-->
		<div class="container-fluid h-100">
			<div class="h-100 d-flex flex-column">
				<!-- //header logo, icons, picture-->
				<div class="row justify-content-center">
					<div class="p-2 bg-white d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
						<ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
							<li>
								<i class="bi bi-list pe-2 site-menu-icon"></i>
							</li>
						</ul>

						<a href="/" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
						<?php if(isset($accountdetails['settings']['content_logo']['value'])):?>
							<img src="<?php echo $accountdetails['settings']['content_logo']['value'];?>" style="max-height:80px;max-width:100%">
						<?php else:?>
							<img src="<?php echo WEB_ROOT;?>/images/Inventi_Horizontal-Blue-01.png" style="max-height:40px;max-width:100%">
						<?php endif;?>
						</a>

						<ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
							<li>
								<div class="pe-4 pt-2">
									<i class="bi bi-envelope sile-notification-icon ps-2"></i> 
									
									<i class="ps-2 bi bi-bell sile-notification-icon"></i>
									<a href="<?php echo WEB_ROOT;?>/auth/logout" class="sile-notification-icon"><i class="ps-2 bi bi-door-closed sile-notification-icon"></i></a>
								</div>
							</li>
							<li>
								<div class="vertical-line"></div>
							</li>
							<li>
								<div class="ps-2 pt-2 user-name"><span class="login-name"><?php echo $ots->session->getUserName();?></span></div>
								<div class="ps-2 user-role"><span class="login-role"><?php echo implode(", ",$ots->session->getUserRoles());?></span></div>
							</li>
							<li class="ps-2">
								<img src="<?php echo WEB_ROOT;?>/images/user-img-anon.png" class="user-img">
							</li>
						</ul>
					</div>
				</div>
				<!-- header logo, icons, picture// -->

				<!-- //main display container 1-->
				<div class="row justify-content-center flex-grow-1">
					<!-- //main display container 2-->
					<div class="h-100 d-flex flex-row p-0">
						<!--//menu-->
						<?php $current_menu_id = ($_GET['menuid'] ?? '');?>

						<div class="d-flex flex-grow-0 justify-content-center bg-white p-3">
							<ul class="nav flex-column">
								<?php foreach($accountdetails['menus'] as $index=>$menu):?>
								<li class="nav-item">
									<a class="nav-link <?php echo ($_GET['menuid'] ?? '') == $index ? 'active' : '';?>" href="<?php echo WEB_ROOT . $menu['target'];?>?menuid=<?php echo $index;?>"><i class="<?php echo $menu['icon'];?> nav-icon"></i> <?php echo $menu['label'];?></a>
								</li>
								<?php endforeach;?>
							</ul>

							<div class="d-flex flex-grow-1 justify-content-center" style="border-left: 1px solid #efefef">
								<ul class="nav flex-column">
									<?php 
									if(($_GET['menuid'] ?? '') != '' && isset($accountdetails['menus'][$_GET['menuid']]))
									{
										$submenus = $accountdetails['menus'][$_GET['menuid']]['submenus'];
									}else{
										$accountdetails_menus = array_values($accountdetails['menus']);
										$first_accountdetails_menus = array_shift($accountdetails_menus);
										$submenus = $first_accountdetails_menus['submenus'];
									}
									?>
									<?php foreach($submenus as $index=>$submenu):?>
										<li class="nav-item">
										<a class="nav-link" href="<?php echo WEB_ROOT . $submenu['target'];?>?menuid=<?php echo $index;?>"><?php echo $submenu['label'];?></a>
										</li>
									<?php endforeach;?>
								</ul>	
							</div>
						</div>
						<!--menu//-->

						<!-- //main display-->
						<div class="d-flex flex-grow-1 p-2">
							
						
			
			