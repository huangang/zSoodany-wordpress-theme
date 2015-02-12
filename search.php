<?php get_header(); ?>
<!--------------Content---------------->
<section id="content">
	<div class="wrap-content">
		<div class="row block">
			<div id="main-content" class="col-full">
				<div class="wrap-col">
					<?php if(function_exists('cmp_breadcrumbs')) cmp_breadcrumbs();?>
					<?php if (have_posts()) : ?>
					<?php while (have_posts()) : the_post(); ?>
					<article>
						<div class="">
							<h2><a href="<?php the_permalink() ?>"><?php the_title_attribute(); ?></a></h2>
							<p>By<i class="fa fa-heart"></i><?php the_author_posts_link(); ?> on <i class="fa fa-calendar"></i><?php the_time('F d, Y') ?>
								<i class="fa fa-folder"></i><?php the_category(', ')?>&nbsp;<a href="<?php the_permalink() ?>#comments"><i class="fa fa-comments"></i><?php comments_number('No Comment', '1 Comment', '% Comments' );?></a>
							</p>
						</div>
					</article>
					<?php endwhile; ?>
			        <?php else : ?>
			        <article>
						<div class="">
						<h2><a><?php _e( '没有找到该文章', 'zSoodany' ); ?></a></h2>
						</div>
						<p><?php _e( '抱歉没有找到该文章', 'zSoodany' ); ?></p>
					</article>
		            <?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>