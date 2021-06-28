<div>
	<label for="<?=$input->name?>"><?=$lang['Enter the code from the image']?>:</label>
	<input type="text" name="<?=$input->name?>" id="<?=$input->name?>" <?php include "jsv.tpl"; ?> />
</div>
<div class="captcha">
	<img src="/images/update.png" alt="Update" />
	<img src="captcha.php" alt="Capcha" />
</div>