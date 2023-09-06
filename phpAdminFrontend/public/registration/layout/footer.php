</div> 
</body>
<script>
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
</script>
</html>