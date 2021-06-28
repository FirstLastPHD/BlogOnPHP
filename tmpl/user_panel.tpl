<div class="block">
	<div class="header"><?=$lang['User Panel']?></div>
	<div class="content">
		<p class="center"><?=$lang['Hello']?>,<br /><b><?=$user->name?></b>!</p>
		<p class="center">
			<img src="<?=$user->avatar?>" alt="<?=$user->login?>" class="big_avatar" />
		</p>
		<nav>
			<?php foreach ($items as $item) { ?>
				<div>
					<a <?php if ($item->link == $uri) { ?>class="active"<?php } ?> href="<?=$item->link?>"><?=$item->title?></a>
				</div>
			<?php } ?>
		</nav>
	</div>
</div>