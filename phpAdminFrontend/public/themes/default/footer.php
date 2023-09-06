				</div> <!--main-display-->
			</div>  <!--main-display-container-->
		</section>
			</div>


		<div class="notification notification-success" style="position: fixed;
    right: 10px;
    top: 10px;
    z-index: 9999;
    background: #FFF;
    border-radius: 5px;
    box-shadow: 0 0 15px 5px #ccc;
    padding: 5px 10px 5px 10px;
    border-left: 5px solid #49AB95;	display: none;width: 300px	">
		<div class="d-flex align-items-center">
			<i class="bi bi-check-circle-fill" style="font-size: 2em;
    color: #49AB95;"></i>
			<div style="padding: 10px;	" class="flex-grow-1">
				<div style="font-size: 1.2em;
    font-weight: 500;">Success!</div>
				<div class="notification-success-message">Hello</div>
			</div>

			<i class="bi bi-x notification-close" style="font-size: 2em;
    color: #c0c0c0;"></i>
			</div>
		</div>

		<div class="notification notification-error" style="position: fixed;
    right: 10px;
    top: 10px;
    z-index: 9999;
    background: #FFF;
    border-radius: 5px;
    box-shadow: 0 0 15px 5px #ccc;
    padding: 5px 10px 5px 10px;
    border-left: 5px solid rgb(220,53,69);	display: none;width: 300px	">
		<div class="d-flex align-items-center">
			<i class="bi bi-exclamation-diamond-fill" style="font-size: 2em;
    color:rgb(220,53,69);"></i>
			<div style="padding: 10px;	" class="flex-grow-1">
				<div style="font-size: 1.2em;
    font-weight: 500;">Error!</div>
				<div class="notification-error-message">Hello</div>
			</div>

			<i class="bi bi-x notification-close" style="font-size: 2em;
    color: #c0c0c0;"></i>
			</div>
		</div>

		<script>
			let menus = <?php echo json_encode($accountdetails['menus']);?>;
			$(document).ready(function(){			
				$(".notification-close").on('click',function(){
					$(this).closest('.notification').fadeOut('slow');	
				});
				
				$(".toggle-menu").on('click',function(){					
					$.ajax({
						url: '<?php echo WEB_ROOT;?>/system/set-session?key=menuopen&value=' + $(".sidebar").hasClass('close') +'&display=plain',
						type: 'GET',
						dataType: 'html'
					});
					

					$(".sidebar").toggleClass('open');
					$(".home").toggleClass('ps-2');
					$(".toggle-menu").toggleClass('d-none');
					
					$(".content_logo").toggleClass('d-none');
					$(".menu_logo").toggleClass('d-none');
				});

				$("a.nav-link").on('click',function(e){
					$.ajax({
						url: '<?php echo WEB_ROOT;?>/system/set-session?key=menuid&value=' + $(this).data('menuindex') +'&display=plain',
						type: 'GET',
						dataType: 'html'
					});

					// e.preventDefault();

					// $(".module-title").html($(this).prop('title'));

					// $(".sub-menu-list").empty();
					// var submenu_ctr = 0;
					// $.each(menus[$(this).data('menuindex')]['submenus'],function(){
					// 	if( this.target)
					// 	{
					// 		$(".sub-menu-list").append('<li class="nav-sub-link' + (submenu_ctr == 0 ? ' active' : '') + '"><a class="nav-sub-link' + (submenu_ctr == 0 ? ' active' : '') + '" href="<?php echo WEB_ROOT;?>'  +  this.target + '">' + this.label +'</a></li>');
					// 		submenu_ctr++;
					// 	}
					// });
					// if(submenu_ctr == 0)
					// {
					// 	$(".sub-menu-container").addClass('d-none');
					// }else{
					// 	$(".sub-menu-container").removeClass('d-none');
					// }

					// $("a.nav-link").removeClass('active');
					// $(this).addClass('active');
					
					// loadPage( $(this).prop('href'));
					
				});

				$(document).on('click',"a.nav-sub-link",function(e){
					$.ajax({
						url: '<?php echo WEB_ROOT;?>/system/set-session?key=submenuid&value=' + $(this).data('menuindex') +'&display=plain',
						type: 'GET',
						dataType: 'html'
					});
					// e.preventDefault();

					// $("a.nav-sub-link").removeClass('active');
					// $(this).addClass('active');

					// $(this).closest('ul').find('li').removeClass('active');
					// $(this).closest('li').addClass('active');
					
					// loadPage( $(this).prop('href'));
					
				});
			});

			function loadPage(url)
			{
				$.ajax({
					url: url + (url.indexOf("?") == -1 ? '?' : '') + '&display=plain',
					type: 'GET',
					dataType: 'html',
					beforeSend: function(){
					},
					success: function(data){
						$(".main-display").empty().html(data);
					},
					complete: function(){
						
					},
					error: function(jqXHR, textStatus, errorThrown){
						
					}
				});
			}

			function showSuccessMessage(message,callback)
			{
				$(".notification-success-message").html(message);
				$(".notification-success").fadeIn('slow',function(){
					if(callback)
					{
						callback.apply();
					}else{
						setTimeout(() => {
							$(".notification-success").fadeOut('slow');
						}, 2000); 
					}
				});	
			}

			function showErrorMessage(message,callback)
			{
				$(".notification-error-message").html(message);
				$(".notification-error").fadeIn('slow',function(){
					if(callback)
					{
						callback.apply();
					}else{
						setTimeout(() => {
							$(".notification-error").fadeOut('slow');
						}, 2000); 
					}
				});	
			}

			function time2date(unix_timestamp)
			{
				var date = new Date(unix_timestamp * 1000);
				let month = date.getMonth() + 1;
				let day =  date.getDate();
				let year = date.getFullYear();
				return (month < 10 ? '0' : '') + month + '/' +  (day < 10 ? '0' : '') + day + '/' + year; 
			}
		</script>
	</body>
</html>