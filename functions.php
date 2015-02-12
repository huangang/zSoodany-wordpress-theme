<?php
// 注册菜单
register_nav_menus();
// 匹配出css、js、图片地址
function replace_url($str){
    $regexp = "/<(link|script|img)([^<>]+)>/i";
    $str = preg_replace_callback( $regexp, "replace_callback", $str );
    return $str;
}

// 匹配需要替换掉的链接地址
function replace_callback($matches) {
  $str = $matches[0];

  $patterns = array();
  $replacements = array();

  // 匹配谷歌CDN链接
  $patterns[0] = '/\.googleapis\.com/';

  // 匹配头像链接
  $patterns[1] = '/http:\/\/[0-9]\.gravatar\.com\//';
  $patterns[2] = '/http%3A%2F%2F[0-9]\.gravatar\.com%2F/';

  // 使用中科大CDN地址
  $replacements[0] = '.lug.ustc.edu.cn';

  // 目前使用https可以访问到头像图片
  $replacements[1] = 'https://secure.gravatar.com/';
  $replacements[2] = 'https%3A%2F%2Fsecure.gravatar.com%2F';

  return preg_replace($patterns, $replacements, $str);
}

function replace_start() {
   //开启缓冲
  ob_start("replace_url");
}

function replace_end() {
  // 关闭缓冲
  ob_end_flush();
}

/**
 * 分别将开启和关闭缓冲添加到wp_loaded和shutdown动作
 * 也可以尝试添加到其他动作，只要内容输出在两个动作之间即可
 * 参考链接：http://codex.wordpress.org/Plugin_API/Action_Reference
 */
add_action('wp_loaded', 'replace_start');
add_action('shutdown', 'replace_end');



add_theme_support( "post-thumbnails" );  // 开启文章缩略图即特色图片

//定义获取特色图片地址
function get_thumbnail(){
	$timthumb_src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()) ,'full');
	if ( has_post_thumbnail() )
		$timthumb = $timthumb_src[0]; 
	elseif(get_field('thumbnail'))
		$timthumb = get_field('thumbnail'); 
	else
		$timthumb = trailingslashit( get_stylesheet_directory_uri() ) . 'images/br.jpg'; 
	return $timthumb;
}


/**
 * 评论表单
 */
function comments_form() {
  $args = array(
    'title_reply'          => 'Welcome to Comment',
    'title_reply_to'       => __( 'Reply %s' ),
    'cancel_reply_link'    => __( 'Cancel reply' ),
    'fields'               => array(
                        'author' => '<label><input id="author" name="author" value="Author"/></label>',
                        'email'  => '<label><input id="email" name="email" value="Email" /></label>',
                        'url'    => '<label><input id="url" name="url" value="Url" /></label>'
    ),
    'comment_field'        => '<textarea id="comment" placeholder="Leave a Comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>',
    'comment_notes_before' => '<div id="commentform-error" class="alert hidden"></div>',
    'comment_notes_after'  => '',
    'id_submit'            => '',
  );
  return comment_form($args);
}


//更换登录logo图片 
function custom_loginlogo() { 
echo '<style type="text/css"> 
h1 a {background-image: url('.get_bloginfo('template_directory').'/images/logo.jpg) !important; } 
</style>'; 
echo '<link rel="shortcut icon" href="'.get_bloginfo('template_directory').'/images/favicon.ico" type="images/x-icon" />';//更换了登录ico图标

} 
add_action('login_head', 'custom_loginlogo');
//更换登录logo链接 
add_filter("login_headerurl", create_function(false,"return get_bloginfo('siteurl');"));
//更换登录logo描述 
add_filter("login_headertitle", create_function(false,"return get_bloginfo('description');"));


//分页代码
function theme_echo_pagenavi(){
    global $wp_query;
    global $request, $posts_per_page, $wpdb, $paged;
    $maxButtonCount = 9; //显示的最多链接数目

    $current_page = $paged;

    $current_page = $paged;
    if(empty($current_page)) {
        $current_page = 1;
    }

    $numposts = $wp_query->found_posts;
    $max_page = $wp_query->max_num_pages;

    $start = max(1, $current_page - intval($maxButtonCount/2));
    $end = min($start + $maxButtonCount - 1, $max_page);
    $start = max(1, $end - $maxButtonCount + 1);

    if($current_page <= 1){
        echo '<i class="fa fa-chevron-left fa-lg"></i>';
        echo '<i class="fa fa-angle-left fa-lg"></i>';
    }else{
        echo '<a href="'.get_pagenum_link().'"><i class="fa fa-chevron-left fa-lg"></i>';
        echo '<a href="'.get_pagenum_link($current_page-1).'"><i class="fa fa-angle-left fa-lg"></i>';
    }
    for($i=$start; $i<=$end; $i++){
        if($i == $current_page) {
            echo "<span class=\"page_num on\">$i</span>";
        } else {
            echo '<a href="'.get_pagenum_link($i).'"><span class="page_num">'.$i.'</span></a>';
        }
    }
    if($current_page >= $max_page){
        echo '<i class="fa fa-angle-right fa-lg"></i>';
        echo '<i class="fa fa-chevron-right fa-lg"></i>';
    }else{
        echo '<a href="'.get_pagenum_link($current_page+1).'"><i class="fa fa-angle-right fa-lg"></i>';
        echo '<a href="'.get_pagenum_link($max_page).'"><i class="fa fa-chevron-right fa-lg"></i>';
    }

    echo " {$current_page}/{$max_page}页, {$numposts}篇文章.";
}

add_theme_support( 'title-tag' );
// Add default posts and comments RSS feed links to head.
add_theme_support( 'automatic-feed-links' );

if( function_exists('register_sidebar') ) {
  register_sidebar(array(
    'name' => 'right sidebar', // 默认侧边栏
    'before_widget' => '<div class="box">', // widget 的开始标签
    'after_widget' => '</div>', // widget 的结束标签
    'before_title' => '<div class="heading"><h2>', // 标题的开始标签
    'after_title' => '</h2></div>' // 标题的结束标签
  ));
}

//自定义小工具
include_once 'widget.php';


/* 访问计数 */
function record_visitors()
{
  if (is_singular()) 
  {
    global $post;
    $post_ID = $post->ID;
    if($post_ID) 
    {
      $post_views = (int)get_post_meta($post_ID, 'views', true);
      if(!update_post_meta($post_ID, 'views', ($post_views+1))) 
      {
      add_post_meta($post_ID, 'views', 1, true);
      }
    }
  }
}
add_action('wp_head', 'record_visitors');  
 
/// 函数名称：post_views 
/// 函数作用：取得文章的阅读次数
function post_views($before = '(点击 ', $after = ' 次)', $echo = 1)
{
  global $post;
  $post_ID = $post->ID;
  $views = (int)get_post_meta($post_ID, 'views', true);
  if ($echo) echo $before, number_format($views), $after;
  else return $views;
}
/// get_most_viewed_format 
/// 函数作用：取得阅读最多的文章
function get_most_viewed_format($mode = '', $limit = 6, $show_date = 0, $term_id = 0, $beforetitle= '(', $aftertitle = ')', $beforedate= '(', $afterdate = ')', $beforecount= '(', $aftercount = ')') {
  global $wpdb, $post;
  $output = '';
  $mode = ($mode == '') ? 'post' : $mode;
  $type_sql = ($mode != 'both') ? "AND post_type='$mode'" : '';
  $term_sql = (is_array($term_id)) ? "AND $wpdb->term_taxonomy.term_id IN (" . join(',', $term_id) . ')' : ($term_id != 0 ? "AND $wpdb->term_taxonomy.term_id = $term_id" : '');
  $term_sql.= $term_id ? " AND $wpdb->term_taxonomy.taxonomy != 'link_category'" : '';
  $inr_join = $term_id ? "INNER JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id) INNER JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)" : '';
 
  // database query
  $most_viewed = $wpdb->get_results("SELECT ID, post_date, post_title, (meta_value+0) AS views FROM $wpdb->posts LEFT JOIN $wpdb->postmeta ON ($wpdb->posts.ID = $wpdb->postmeta.post_id) $inr_join WHERE post_status = 'publish' AND post_password = '' $term_sql $type_sql AND meta_key = 'views' GROUP BY ID ORDER BY views DESC LIMIT $limit");
  if ($most_viewed) {
   foreach ($most_viewed as $viewed) {
    $post_ID    = $viewed->ID;
    $post_views = number_format($viewed->views);
    $post_title = esc_attr($viewed->post_title);
    $get_permalink = esc_attr(get_permalink($post_ID));
    $output .= "<li>$beforetitle$post_title$aftertitle";
    if ($show_date) {
      $posted = date(get_option('date_format'), strtotime($viewed->post_date));
      $output .= "$beforedate $posted $afterdate";
    }
    $output .= "$beforecount $post_views $aftercount</li>";
   }   
  } else {
   //$output = "<li>N/A</li>\n";
  }
  echo $output;
}

//theme options
$option['description'] = get_option('description');//获取选项 
$option['aboutus'] = get_option('aboutus');
$option['contactus'] = get_option('contactus');
if( $option['description'] == '' ){   
    //设置默认数据   
    $option['description'] = 'zSoodany wordpress theme';   
    update_option('description', $option['description']);//更新选项   
}
if( $option['aboutus'] == '' ){   
    //设置默认数据   
    $option['aboutus'] = 'You can use and modify the template for both personal and commercial use. You must keep all copyright information and credit links in the template and associated files.';   
    update_option('aboutus', $option['aboutus']);//更新选项   
}  
if( $option['contactus'] == '' ){   
    //设置默认数据   
    $option['contactus'] = '<p>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue.</p>
              <p>Website : <a href="http://www.huangang.net" target="_blank">www.huangang.net</a></p>
              <p>+1 (123) 444-5677 <br/> +1 (123) 444-5678</p>
              <p>Address: 123 TemplateAccess Rd1</p>';   
    update_option('contactus', $option['contactus']);//更新选项   
}     
if(isset($_POST['option_save'])){   
    //处理数据   
    $option['description'] = stripslashes($_POST['description']);   
    update_option('description', $option['description']);//更新选项  
    $option['aboutus'] = stripslashes($_POST['aboutus']);   
    update_option('aboutus', $option['aboutus']);//更新选项   
    $option['contactus'] = stripslashes($_POST['contactus']);   
    update_option('contactus', $option['contactus']);//更新选项    
}   
function theme_options(){   
    add_theme_page( 'zSoodany', 'theme options', 'administrator', 'zSoodany_theme_options','theme_options_display');   
}   
add_action('admin_menu', 'theme_options');   
  
function theme_options_display(){ ?>   
    <form method="post" name="zSoodany_form" id="zSoodany_form">   
    <h1>zSoodany 主题设置</h1>   
    <p>   
    <label>
    <h3>网站关键词</h3> 
    <input name="description" size="80" value="<?php echo get_option('description'); ?>"/>   
    </label>
    <label>
    <h3>关于我们</h3> 
    <textarea name="aboutus" rows="8" cols="79"><?php echo get_option('aboutus'); ?></textarea>   
    </label>
    <label>
    <h3>联系我们</h3> 
    <textarea name="contactus" rows="8" cols="79"><?php echo get_option('contactus'); ?></textarea>   
    </label>    
    </p>   
    <p class="submit">   
        <input type="submit" class="button" name="option_save" value="<?php _e('保存设置'); ?>" />   
    </p>    
    </form>   
<?php } 


//自定义字段
include_once('advanced-custom-fields/acf.php');
define( 'ACF_LITE', true );
if(function_exists("register_field_group"))
{
  register_field_group(array (
    'id' => 'acf_%e7%89%b9%e8%89%b2%e5%9b%be%e7%89%87',
    'title' => '特色图片',
    'fields' => array (
      array (
        'key' => 'field_54d9aa6072cfc',
        'label' => '特色图片图床',
        'name' => 'thumbnail',
        'type' => 'text',
        'instructions' => '填写图片url地址',
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'html',
        'maxlength' => '',
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'post',
          'order_no' => 0,
          'group_no' => 0,
        ),
      ),
    ),
    'options' => array (
      'position' => 'normal',
      'layout' => 'no_box',
      'hide_on_screen' => array (
      ),
    ),
    'menu_order' => 0,
  ));
}


/**
 * 添加面包屑导航 
 */
function cmp_breadcrumbs() {
  $delimiter = '»'; // 分隔符
  $before = '<span class="current">'; // 在当前链接前插入
  $after = '</span>'; // 在当前链接后插入
  if ( !is_home() && !is_front_page() || is_paged() ) {
    echo '<div itemscope itemtype="http://schema.org/WebPage" id="crumbs">'.__( '您现在的位置:' , 'cmp' );
    global $post;
    $homeLink = home_url();
    echo ' <a itemprop="breadcrumb" href="' . $homeLink . '">' . __( '主页' , 'cmp' ) . '</a> ' . $delimiter . ' ';
    if ( is_category() ) { // 分类 存档
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0){
        $cat_code = get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' ');
        echo $cat_code = str_replace ('<a','<a itemprop="breadcrumb"', $cat_code );
      }
      echo $before . '' . single_cat_title('', false) . '' . $after;
    } elseif ( is_day() ) { // 天 存档
      echo '<a itemprop="breadcrumb" href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a itemprop="breadcrumb"  href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;
    } elseif ( is_month() ) { // 月 存档
      echo '<a itemprop="breadcrumb" href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;
    } elseif ( is_year() ) { // 年 存档
      echo $before . get_the_time('Y') . $after;
    } elseif ( is_single() && !is_attachment() ) { // 文章
      if ( get_post_type() != 'post' ) { // 自定义文章类型
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        echo '<a itemprop="breadcrumb" href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;
      } else { // 文章 post
        $cat = get_the_category(); $cat = $cat[0];
        $cat_code = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo $cat_code = str_replace ('<a','<a itemprop="breadcrumb"', $cat_code );
        echo $before . get_the_title() . $after;
      }
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;
    } elseif ( is_attachment() ) { // 附件
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo '<a itemprop="breadcrumb" href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
    } elseif ( is_page() && !$post->post_parent ) { // 页面
      echo $before . get_the_title() . $after;
    } elseif ( is_page() && $post->post_parent ) { // 父级页面
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a itemprop="breadcrumb" href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
    } elseif ( is_search() ) { // 搜索结果
      echo $before ;
      printf( __( '<i class="fa fa-search-plus fa-2x"></i>搜索结果: %s', 'cmp' ),  get_search_query() );
      echo  $after;
    } elseif ( is_tag() ) { //标签 存档
      echo $before ;
      printf( __( '标签存档: %s', 'cmp' ), single_tag_title( '', false ) );
      echo  $after;
    } elseif ( is_author() ) { // 作者存档
      global $author;
      $userdata = get_userdata($author);
      echo $before ;
      printf( __( '作者存档: <i class="fa fa-user fa-2x"></i>%s', 'cmp' ),  $userdata->display_name );
      echo  $after;
    } elseif ( is_404() ) { // 404 页面
      echo $before;
      _e( 'Not Found', 'cmp' );
      echo  $after;
    }
    if ( get_query_var('paged') ) { // 分页
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
        echo sprintf( __( '( Page %s )', 'cmp' ), get_query_var('paged') );
    }
    echo '</div>';
  }
}


