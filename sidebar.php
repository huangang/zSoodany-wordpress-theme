<div id="sidebar" class="col-1-3">
	<div class="wrap-col">
			<?php // 如果没有使用 Widget 才显示以下内容, 否则会显示 Widget 定义的内容
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) :
			?>
				<!-- widget -->
				<div class="box">
				<div class="heading"><h2>Widget</h2></div>
				<div class="content">
					<ul>
						<li><a href="#">Please add Widget</a></li>
					</ul>
				</div>
				</div>
			 <?php endif; ?>
	</div>
</div>