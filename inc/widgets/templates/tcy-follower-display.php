<?php
if ( !empty(	$widget_title ) ) {
	echo $before_title . $widget_title . $after_title;
}
?>
<div class="sharing_plus_followers sharing-plus-social-simple-round">
	<ul class="sharing_plus_follower_list">
		<?php if( $display == $show_facebook ):?>
			<li><a class="sharing_plus_button sharing-plus-social-fb-follow" rel="noopener" href="https://facebook.com/<?php echo  $facebook_id;?>"  target="_blank"><span class="simplesocialtxt"><?php echo $facebook_text;?> </span><span class="widget_counter"> <?php echo ( $display == $facebook_show_counter)? $fb_likes: '' ;?> </span></a></li>
		<?php endif;
		if( $display == $show_twitter ):   ?>
			<li><a class="sharing_plus_button sharing-plus-social-twt-follow" rel="noopener" href="https://twitter.com/<?php echo  $twitter_id;?>" target="_blank"><span class="simplesocialtxt"><?php echo $twitter_text;?> </span><span class="widget_counter"> <?php echo ( $display ==  $twitter_show_counter)? $twitter_follower: '';?> </span></a></li>
		<?php endif;
		if ( $display == $show_google_plus ):?>
			<li><a class="sharing_plus_button sharing-plus-social-gplus-follow" rel="noopener" href="https://plus.google.com/<?php echo $google_id;?>" target="_blank"><span class="simplesocialtxt"><?php echo  $google_text;?> </span><span class="widget_counter"> <?php echo ( $display == $google_show_counter )? $google_follower: '';?> </span></a></li>
		<?php endif;
		if( $display == $show_youtube):
			?>
			<li><a class="sharing_plus_button sharing-plus-social-yt-follow" rel="noopener" href="https://youtube.com/<?php echo $youtube_type ?><?php echo $youtube_id ?>" target="_blank"><span class="simplesocialtxt"><?php echo  $youtube_text?> </span><span class="widget_counter"> <?php echo ( $display == $youtube_show_counter)?$youtube_subscriber:" ";?> </span></a></li>
		<?php endif;?>
		<?php if ( $display == $show_pinterest ):?>
			<li><a class="sharing_plus_button sharing-plus-social-pinterest-follow" rel="noopener" href="https://pinterest.com/<?php echo $pinterest_id;?>" target="_blank"><span class="simplesocialtxt"><?php echo  $pinterest_text;?> </span><span class="widget_counter"> <?php echo ( $display == $pinterest_show_counter )? $pinterest_follower: '';?> </span></a></li>
		<?php endif;?>

		<?php if ( $display == $show_instagram ):?>
			<li><a class="sharing_plus_button sharing-plus-social-instagram-follow" rel="noopener" href="https://www.instagram.com/<?php echo $instagram_id;?>" target="_blank"><span class="simplesocialtxt"><?php echo  $instagram_text;?> </span><span class="widget_counter"> <?php echo ( $display == $instagram_show_counter )? $instagram_follower: '';?> </span></a></li>
		<?php endif;?>
		<?php if ( $display == $show_whatsapp ):?>
			<li><a class="sharing_plus_button sharing-plus-social-whatsapp-follow" rel="noopener" href="https://api.whatsapp.com/send?phone=<?php echo $whatsapp;?>" target="_blank"><span class="simplesocialtxt"><?php echo  $whatsapp_text;?> </span></a></li>
		<?php endif;?>
	</ul>
</div>
<?php echo $after_widget;?>