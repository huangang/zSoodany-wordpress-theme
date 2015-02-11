<!--------------Footer---------------->
<footer>
	<div class="wrap-footer">
		<div class="row">
			<div class="col-1-3">
				<div class="wrap-col">
					<div class="box">
						<div class="heading"><h2>Hot post</h2></div>
						<div class="content gallery">
						<?php  
						$query_posts = new WP_Query(); 
						$query_posts->query(get_most_viewed_format()); 
						while( $query_posts->have_posts() ) { $query_posts->the_post(); ?> 
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo get_thumbnail(); ?>" width="120"/></a>
						<?php } wp_reset_query();?> 
						</div>
					</div>
				</div>
			</div>
			<div class="col-1-3">
				<div class="wrap-col">
					<div class="box">
						<div class="heading"><h2>About Us</h2></div>
						<div class="content">
							<img src="<?php bloginfo('template_url'); ?>/images/logo.jpg" style="border: 0px;"/>
							<p><?php echo get_option('aboutus');?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-1-3">
				<div class="wrap-col">
					<div class="box">
						<div class="heading"><h2>Contact Us</h2></div>
						<div class="content">
							<?php echo get_option('contactus');?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="copyright">
		<?php date_default_timezone_set('prc'); ?>
		<p>&copy; Copyright <?php echo date('Y-m-d H:i:s',time());?></p>
		<p>Power by <a target="_blank" href="http://cn.wordpress.org/">wordpress<a><i class="fa fa-heart-o fa-2x"></i><a target="_blank" href="http://www.huangang.net">zorro_ku_o</a></p>
	</div>
</footer>

</div>
</body>
</html>