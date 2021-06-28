<div id="auth">
	<?php if ($message) { ?><span class="message"><?=$message?></span><?php } ?>
	<form name="auth" action="<?=$action?>" method="post">
		<div>
			<input type="text" name="login" placeholder="<?=$lang['Login']?>" />
			<input type="password" name="password" placeholder="<?=$lang['Password']?>" />
			<input type="submit" name="auth" value="<?=$lang['Come in']?>" />
		</div>
	</form>
	<img src="/images/bg_item.png" alt="" id="top_sep" />
	<img src="/images/icon_registr.png" alt="" id="icon_register" />
	<a href="<?=$link_register?>" id="link_register"><?=$lang['Registr']?></a>
	<img src="/images/bg_item.png" alt="" />
	<div id="links_reset">
		<a href="<?=$link_reset?>"><?=$lang['Forgot Password']?>?</a>
		<a href="<?=$link_remind?>"><?=$lang['Forgot Login']?>?</a>
	</div>
</div>