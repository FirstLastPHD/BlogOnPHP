<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-7656296081944722",
          enable_page_level_ads: true
     });
</script>
<?php function printComment($comment, &$comments, $childrens, $auth_user) { ?>
	<div class="comment" id="comment_<?=$comment->id?>">
		<img src="<?=$comment->user->avatar?>" alt="<?=$comment->user->name?>" />
		<span class="name"><?=$comment->user->name?></span>
		<span class="date"><?=$comment->date?></span>
		<p class="text"><?=$comment->text?></p>
		<div class="clear"></div>
		<p class="functions"><span <?php if (!$auth_user) { ?>onclick="alert('<?=$lang['To add comments, you need to login in our site']?>!')"<?php } else { ?>class="reply_comment"<?php } ?>>Reply</span>
			<?php if ($auth_user) { ?><?php if ($comment->accessEdit($auth_user, "text")) { ?><span class="edit_comment"><?=$lang['Edit']?></span> <?php } if ($comment->accessDelete($auth_user)) { ?><span class="delete_comment"><?=$lang['Remove']?></span><?php } ?><?php } ?>
		</p>
		<?php
			while (true) {
				$key = array_search($comment->id, $childrens);
				if (!$key) break;
				unset($childrens[$key]);
		?>
			<?php if (isset($comments[$key])) { ?>
				<?=printComment($comments[$key], $comments, $childrens, $auth_user)?>
			<?php } ?>
		<?php } ?>
	</div>
<?php } ?>
<div class="main">
	<?php if (isset($hornav)) { ?><?=$hornav?><?php } ?>
	<article>
		<h1><?=$article->title?></h1>
		<?php if ($article->img) { ?>
			<div class="article_img">
				<img src="<?=$article->img?>" alt="<?=$article->title?>" />
			</div>
		<?php } ?>
		<?=$article->full?>
		<div class="article_info">
			<ul>
				<li>
					<div>
						<img src="/images/date_article.png" alt="" />
					</div>
					<?=$lang['Created']?> <?=$article->date?>
				</li>
				<li>
					<img src="/images/icon_user.png" alt="" />
					Jaroslav King
				</li>
			</ul>
			<div class="clear"></div>
		</div>
	</article>
	<div id="article_pn">
		<?php if ($prev_article) { ?><a id="prev_article" href="<?=$prev_article->link?>"><?=$lang['Previous article']?></a><?php } ?>
		<?php if ($next_article) { ?><a id="next_article" href="<?=$next_article->link?>"><?=$lang['Next article']?></a><?php } ?>
		<div class="clear"></div>
	</div>
	<div id="article_copy">
		<p class="center"><i><?=$lang['Copying of materials is allowed only with the indication of the author (Jaroslav King) and an indexed direct link to the site']?> (<a href="<?=Config::ADDRESS?>"><?=Config::ADDRESS?></a>)!</i></p>
	</div>
	<div id="article_vk">
		<p><?=$lang['Be added to my friends']?><b>Facebook</b>: <a rel="external" href="https://www.facebook.com/profile.php?id=100009036120038">https://www.facebook.com/profile.php?id=100009036120038</a>.<br /><?=$lang['If you want to evaluate me and my work, then write it in my group']?>: <a rel="external" href="https://www.facebook.com/Datingfb-1562275107225896/">https://www.facebook.com/Datingfb-1562275107225896/</a>.</p>
	</div>
	<p><?=$lang['If you have any questions, or you have a desire to comment on this article, you can leave a comment at the bottom of the page']?>.</p>
	<div id="share">
		<p><?=$lang['Recommend this article to friends']?>:</p>
		<script type="text/javascript">getSocialNetwork("<?=Config::DIR_IMG?>", "");</script>
	</div>
	<p><?=$lang['If you liked the site, then post a link to it (on your site, on the forum, in facebook)']?>:</p>
	<ol id="recom">
		<li>
			<?=$lang['Button']?>:
			<br /><textarea name="" cols="50" rows="5">&lt;a href="<?=Config::ADDRESS?>" target="_blank"&gt;&lt;img src="<?=Config::ADDRESS.Config::DIR_IMG?>button.gif" style="border: 0; height: 31px; width: 88px;" alt="<?=$lang['How is to create Your website']?>" /&gt;&lt;/a&gt;</textarea>
			<p><?=$lang['It is look like this']?>: <a href="<?=Config::ADDRESS?>" rel="external"><img src="<?=Config::ADDRESS.Config::DIR_IMG?>button.gif" style="border: 0; height: 31px; width: 88px;" alt="<?=$lang['How is to create Your website']?>" /></a></p>
		</li>
		<li>
			<?=$lang['Text Link']?>:<br /><textarea name="" cols="50" rows="5">&lt;a href="<?=Config::ADDRESS?>" target="_blank"&gt;<?=$lang['How is to create Your website']?>&lt;/a&gt;</textarea>
			<p><?=$lang['It is look like this']?>: <a href="<?=Config::ADDRESS?>" rel="external"><?=$lang['How is to create Your website']?></a></p>
		</li>
		<li><?=$lang['BB-code links for forums (for example, you can put it in the signature)']?>:
			<br /><textarea name="" cols="50" rows="5">[URL="<?=Config::ADDRESS?>"]<?=$lang['How is to create Your website']?>[/URL]</textarea>
		</li>
	</ol>
	<div id="comments">
		<h2 class="h1"><?=$lang['Comments']?>(<span id="count_comments"><?=count($comments)?></span>):</h2>
		<input type="button" value="<?=$lang['Add Comment']?>" id="add_comment" <?php if (!$auth_user) { ?>onclick="alert('<?=$lang['To add comments, you need to login']?>!')"<?php } ?> />
		<?php foreach ($comments as $comment) { ?>
			<?php if ($comment->parent_id == 0) { ?><?=printComment($comment, $comments, $childrens, $auth_user)?><?php } ?>
		<?php } ?>
		<div class="clear"></div>
		<?php if ($auth_user) { ?>
			<div id="form_add_comment">
				<form name="form_add_comment" method="post" action="#">
					<div id="comment_cancel">
						<span>X</span>
					</div>
					<table>
						<tr>
							<td>
								<label for="text_comment"><?=$lang['Comment']?>:</label>
							</td>
							<td>
								<textarea cols="40" rows="5" name="text_comment" id="text_comment"></textarea>
							</td>
						</tr>
						<tr>
							<td colspan="2>
								<input type="hidden" value="0" name="comment_id" id="comment_id" />
								<input type="hidden" value="<?=$article->id?>" name="article_id" id="article_id" />
								<input type="hidden" value="0" name="parent_id" id="parent_id" />
								<input type="button" value="<?=$lang['Save']?>" class="button" />
							</td>
						</tr>
					</table>
				</form>
			</div>
		<?php } else { ?>
			<p class="center"><?=$lang['You must be logged in to add comments']?>.<br /><?=$lang['If you have not registered on the site, then first']?>... <a href="<?=$link_register?>"><?=$lang['register now']?>...</a>.</p>
		<?php } ?>
	</div>
</div>