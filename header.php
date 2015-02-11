<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="zh-cn"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="zh-cn"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="zh-cn"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!- --><html lang="zh-cn"> <!--<![endif]-->
<head>

    <!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title><?php if (is_home()||is_search()) { bloginfo('name'); print "-"; bloginfo('description');} else { wp_title(''); print "-"; bloginfo('name'); } ?></title>
	<meta name="description" content="<?php echo get_option('description'); ?>">
	<meta name="author" content="www.huangang.net">
	
    <!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    <!-- CSS
  ================================================== -->
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
  	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/zerogrid.css">
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/responsive.css">
    <!-- font-awesome
  ================================================== -->
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/font-awesome-4.2.0/css/font-awesome.min.css">
	<!-- JS
  ================================================== -->
   <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.min.js"></script>
	<!--[if lt IE 8]>
       <div style=' clear: both; text-align:center; position: relative;'>
         <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
           <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
        </a>
      </div>
    <![endif]-->
    <!--[if lt IE 9]>
		<script src="<?php bloginfo('template_url'); ?>/js/html5.js"></script>
		<script src="<?php bloginfo('template_url'); ?>/js/css3-mediaqueries.js"></script>
	<![endif]-->
	
	<link href='<?php bloginfo('template_url'); ?>/images/favicon.ico' rel='icon' type='image/x-icon'/>
    
</head>
<body>
<div class="wrap-body zerogrid">
<!--------------Header---------------->
<header>
	<div class="wrap-header">
		
		<div class="top">
			<div class="socials">
				<ul>
					<li><a href="#" title="github"><i class="fa fa-github-alt fa-2x"></i></a></li>
					<li><a href="#" title="drupal"><i class="fa fa-drupal fa-2x"></i></a></li>
					<li><a href="#" title="google"><i class="fa fa-google fa-2x"></i></a></li>
					<li><a href="#" title="wordpress"><i class="fa fa-wordpress fa-2x"></i></a></li>
					<li><a href="#" title="linux"><i class="fa fa-linux fa-2x"></i></a></li>
				</ul>
			</div>
			<div id="search">
				<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
				<button class="button-search" type="submit"></button>
				<input type="text" value="Search..." name="s" onfocus="if (this.value == &#39;Search...&#39;) {this.value = &#39;&#39;;}" onblur="if (this.value == &#39;&#39;) {this.value = &#39;Search...&#39;;}">
			    </form> 
			</div>
		</div>
		
		<div id="logo">
			<h1><?php bloginfo('name'); ?></h1>
		</div>
		
		<nav>
			<div class="wrap-nav">
				<div class="menu">
					<ul>
						<?php /*列出顶部导航菜单，菜单名称为topmenu，只列出一级菜单*/
						wp_nav_menu( array( 'menu' => 'topmenu', 'depth' => 1) );?>
					</ul>
				</div>
			</div>
		</nav>
		
	</div>
</header>
