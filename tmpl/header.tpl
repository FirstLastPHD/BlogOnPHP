<head>
	<title><?=$title?></title>
	<?php foreach ($meta as $m) { ?>
		<meta <?php if ($m->http_equiv) { ?>http-equiv<?php } else { ?>name<?php } ?>="<?=$m->name?>" content="<?=$m->content?>" />
	<?php } ?>
	<?php if ($favicon) { ?>
		<link href="<?=$favicon?>" rel="shortcut icon" type="image/x-icon" />
	<?php } ?>
	<?php foreach ($css as $href) { ?>
		<link type="text/css" rel="stylesheet" href="<?=$href?>" />
	<?php } ?>
	<?php foreach ($js as $src) { ?>
		<script type="text/javascript" src="<?=$src?>"></script>
	<?php } ?>
	
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

</head>