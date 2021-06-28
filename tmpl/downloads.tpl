<div class="main">
	<h2 class="h1"><?=$lang['Files']?></h2>
	<?php foreach ($articlesone as $article) { ?>
		<section>
			<div class="article_img">
				<img src="<?=$article->img?>" alt="<?=$article->title?>" />
			</div>
			<h2><?=$article->title?></h2>
			<?=$article->intro?>
			<div class="clear"></div>
			<a class="more" href="<?=$article->link?>"><?=$lang['Download']?></a>
			<br />
			<div class="article_info">
				
				<div class="clear"></div>
			</div>
		</section>
	<?php } ?>
	<?php if ($more_articles) { ?>
		<hr />
		<h3><?=$lang['More Articles']?>...</h3>
		<ul>
			<?php foreach ($more_articles as $article) { ?>
				<li>
					<a href="<?=$article->link?>"><?=$article->title?></a>
				</li>
			<?php } ?>
		</ul>
	<?php } else { ?>
		<?=$pagination?>
	<?php } ?>
</div>