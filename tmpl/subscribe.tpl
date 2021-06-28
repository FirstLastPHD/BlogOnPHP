<?php
if(isset($website_language)){
		$_SESSION['language'] = $website_language;
		}
		
		//$_SESSION['language'] = $website_language;
		//$language = $_SESSION['language'];
       if(!isset($_SESSION['language'])) {
	   $language = 'english';
        } else {
	   $language = $_SESSION['language'];
       }
      if(defined('IS_AJAX')) {
	   $path = '../languages/'.strtolower($language).'/language.php';
      } else {
	     $path = 'languages/'.strtolower($language).'/language.php';
       }
      require($path);
//Вызов ajax signup
if (isset($_GET['action'])){
if($_GET['action'] == 'signup'){
	
	$mysqli = new mysqli ('localhost','root','','jaroslav_king_DB');
	
	$email = $mysqli->real_escape_string($_POST['signup-email']);
	
	if(empty($email)){
		$status = "error";
		$message = $lang['You did not enter the email address!'];
	}
	else if(!preg_match('/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/', $email)){ //validate email address - check if is a valid email address
			$status = "error";
			$message = $lang['You entered an incorrect email address!'];
	}
	else {
		$existingSignup = $mysqli->query("SELECT * FROM `xyz_signups` WHERE `signup_email_address`='$email'");   
		if(mysqli_num_rows($existingSignup) < 1){
			
			$date = date('Y-m-d');
			$time = date('H:i:s');
			
			$insertSignup = $mysqli->query("INSERT INTO `xyz_signups` (`signup_email_address`, `signup_date`, `signup_time`) VALUES ('$email','$date','$time')");
			if($insertSignup){ //если вставка прошла успешно
				$status = "success";
				$message = $lang['You are subscribed!'];	
			}
			else { //если вставка прошла неудачно
				$status = "error";
				$message = $lang['Oh! There was a technical error!'];	
			}
		}
		else { //если пользователь уже подписан
			$status = "error";
			$message = $lang['This address is already registered!'];
		}
	}
	
	//возвращаем ответ json
	$data = array(
		'status' => $status,
		'message' => $message
	);
	
	echo json_encode($data);
	exit;
}
}
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#newsletter-signup').submit(function(){
		
		//Проверяем, не отправляется ли уже форма в текущий момент времени
		if($(this).data('formstatus') !== 'submitting'){
		
			//Устанавливаем переменные
			var form = $(this),
				formData = form.serialize(),
				formUrl = form.attr('action'),
				formMethod = form.attr('method'), 
				responseMsg = $('#signup-response');
			
			//Добавляем дату к форме
			form.data('formstatus','submitting');
			
			//Показываем соообщение с просьбой подождать
			responseMsg.hide()
					   .addClass('response-waiting')
					   .text('Please, wait...')
					   .fadeIn(200);
			
			//Отправляем данные на сервер для проверки
			$.ajax({
				url: formUrl,
				type: formMethod,
				data: formData,
				success:function(data){
					
					//Устанавливаем переменные
					var responseData = jQuery.parseJSON(data), 
						klass = '';
					
					//Состояния ответа
					switch(responseData.status){
						case 'error':
							klass = 'response-error';
						break;
						case 'success':
							klass = 'response-success';
						break;	
					}
					
					//Показываем сообщение ответа
					responseMsg.fadeOut(200,function(){
						$(this).removeClass('response-waiting')
							   .addClass(klass)
							   .text(responseData.message)
							   .fadeIn(200,function(){
								   //Устанавливаем таймаут для скрытия сообщения ответа
								   setTimeout(function(){
									   responseMsg.fadeOut(200,function(){
									       $(this).removeClass(klass);
										   form.data('formstatus','idle');
									   });
								   },3000)
								});
					});
				}
			});
		}
		
		//Предотвращаем отправку формы
		return false;
	});
});
</script>
<div class="block">
<div class="header"><?=$lang['Subscribe']?></div>
<div class="content">
    <form id="newsletter-signup" action="?action=signup" method="post">
    <fieldset>
        <label for="signup-email"><?=$lang['Subscribe to the newsletter by e-mail news, offers and events:']?></label>
        <input type="text" name="signup-email" id="signup-email" />
        <input type="submit" id="signup-button" value="<?=$lang["Subscribe"]?>!" />
        <p id="signup-response"></p>
    </fieldset>
</form>
</div>

</div>