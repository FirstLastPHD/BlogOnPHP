<!DOCTYPE html>
<html lang="en">
<?=$header?>
<body>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-7656296081944722",
          enable_page_level_ads: true
     });
</script>
	<div id="container">
		<header>
			<h1><img src="images/logo.png" alt="" /></h1>
			<?=$top?>
		</header>
		<div id="top">
			<div class="clear"></div>
			<div id="search">
				<form name="search" action="<?=$link_search?>" method="get">
					<table>
						<tr>
							<td>
								<input type="text" name="query" placeholder="Search" />
							</td>
							<td>
								<input type="submit" value="" />
							</td>
						</tr>
					</table>
				</form>
			</div>
			<?=$auth?>
		</div>
		<?=$slider?>
		<div id="content">
			<div id="left"><?=$left?></div>
			<div id="right"><?=$right?></div>
			<div id="center"><?=$center?></div>
			<div class="clear"></div>
		</div>
		<footer>
			<div class="sep"></div>
			 <div class="counter">
			 <?php
             echo $lang['On-line'].": ".sizeof($file)." ".$lang['users']; 
             ?>
			 </div>
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
          <script>
         (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-7656296081944722",
          enable_page_level_ads: true
          });
        </script>
		    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
     <script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-7656296081944722",
          enable_page_level_ads: true
     });
    </script>
			<p><?=$lang['Copyright']?> &copy; 2017-<?=date("Y")?> <?=$lang['All Rights Reserved']?>.</p>
		</footer>
	</div>
</body>
</html>