<?php get_header(); ?>
<!--------------Content---------------->
<section id="content">
	<div class="wrap-content">
		<div class="row block">
			<div id="main-content" class="col-2-3">
				<div class="wrap-col">
					<?php if(function_exists('cmp_breadcrumbs')) cmp_breadcrumbs();?>
					<?php if (have_posts()) : ?>
					<?php while (have_posts()) : the_post(); ?>
					<article>
						<div class="heading">
							<h2><a href="<?php the_permalink() ?>"><?php the_title_attribute(); ?></a></h2>
						</div>
						<div class="content">
							<?php
			                    echo '<img alt="' . get_the_title() . '" src="' . get_thumbnail() . '" style="width:100%;height: 300px;" /> '; 
			                 ?>
			                 <?php the_content("Read More..."); ?>
						</div>
						<div class="info">
							<p>By <i class="fa fa-heart"></i><?php the_author_posts_link(); ?> on <i class="fa fa-calendar"></i><?php the_time('F d, Y') ?></p>
						</div>
					</article>
					<?php endwhile; ?>
			        <?php else : ?>
		            <?php endif; ?>
				</div>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>