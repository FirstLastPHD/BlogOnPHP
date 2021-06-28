Registration on the site <?=Config::SITENAME?>

Hello, <?=$user->name?>!

You registered on the site <b><?=Config::SITENAME?></b>!

However, your account needs to be activated. To activate your account, please go to the following link or copy and paste it into your browser's address bar:
<a href="<?=$link?>"><?=$link?></a>

Your login: <b><?=$user->login?></b>

<i>Sincerely, the site <?=Config::SITENAME?>!</i>