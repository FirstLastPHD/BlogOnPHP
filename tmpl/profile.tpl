<div class="main">
	<?php if (isset($hornav)) { ?><?=$hornav?><?php } ?>	
	<div id="profile">
		<h1><?=$lang['Edit avatar']?></h1>
		<div class="center">
			<img src="<?=$avatar?>" alt="<?=$lang['Avatar']?>" />
		</div>
		<div class="avatar_info">
			<p><?=$lang['Acceptable formats']?> - <b>GIF</b>, <b>JPG</b>, <b>PNG</b></p>
			<p><?=$lang['The image size must be']?> <b><?=$lang['no more']?> <?=$max_size?> KB</b>!</p>
			<p><?=$lang['The image should be square (otherwise proportions may not be observed)']?>!</p>
		</div>
		<?=$form_avatar?>
		<?=$form_name?>
		<?=$form_password?>
	</div>
</div>