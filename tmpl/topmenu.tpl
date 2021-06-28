<nav>
	<ul id="topmenu">
		<?php foreach ($items as $item) { ?>
			<li>
				<a <?php if ($item->link == $uri) { ?>class="active"<?php } ?> <?php if ($item->external) { ?>rel="external"<?php } ?> href="<?=$item->link?>"><?=$item->title?></a>
			</li>
		<?php } ?>
	</ul>
	           <form action="" method="post">
	            <div class="form-group">
									<label><?=$lang['Language']?></label>
									<select name="website_language" class="chosen">
										<?php
										  unset($_SESSION['language']);
										$lang_dir = scandir('languages');
											foreach($lang_dir as $file) { 
											if(file_exists('languages/'.$file.'/language.php')) {
												if($this->language == $file) {
													echo '<option value="'.$file.'" selected>'.ucfirst($file).'</option>';
													

												} else {
													echo '<option value="'.$file.'">'.ucfirst($file).'</option>';
													
												}
											} 
										}
										?>
									
									</select>
									<button type="submit" name="save" class="btn btn-theme"> <?=$lang['Save']?> </button>
								</div>
                                </form>
</nav>