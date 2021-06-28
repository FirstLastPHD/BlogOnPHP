<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-7656296081944722",
          enable_page_level_ads: true
     });
</script>
<div class="main">
	<?php if (count($articles)) { ?>
		<?php $number = 0; foreach ($articles as $article) { $number++; ?>
			<div class="category_item">
				<div><?=$number?>. <a href="<?=$article->link?>"><?=$article->title?></a></div>
				<div class="category_author">
					<img src="/images/icon_user.png" alt="" /> Jaroslav King</div>
				<div class="clear"></div>
			</div>
		<?php } ?>
	<?php } else { ?>
		<h2><?=$lang['No content yet']?>.</h2>
	<?php } ?>
</div>