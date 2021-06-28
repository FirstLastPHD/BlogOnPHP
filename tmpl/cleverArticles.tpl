<div class="block">
	<div class="header">Adversistment</div>
	<div class="content">
		<div id="quote">
			  <?php foreach ($articles as $article) { ?>
		<section>
			<div class="article_img">
				<img src="<?=$article->img?>" alt="<?=$article->title?>" />
			</div>
			<h2><?=$article->title?></h2>
			<?=$article->intro?>
			<div class="clear"></div>
			
	
		</section>
	<?php } ?>
	<?php if ($more_articles) { ?>
		<hr />
		<h3>More Articles...</h3>
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
		</div>
	</div>
