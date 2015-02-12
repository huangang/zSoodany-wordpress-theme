<?php get_header(); ?>
<!--------------Content---------------->
<section id="content">
	<div class="wrap-content">
		<div class="row block">
			<div id="main-content" class="col-full">
				<div class="wrap-col">
					<?php if(function_exists('cmp_breadcrumbs')) cmp_breadcrumbs();?>
					<article>
						<img src="<?php bloginfo('template_url'); ?>/images/404.jpg">
					</article>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>