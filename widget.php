<?php
/*热门标签*/
class hotTag extends WP_Widget {
    /** 构造函数 */
    function hotTag() {
        parent::WP_Widget(false, $name = '热门标签(hotTag)');   
    }
       
    /*输出工具内容*/
    function widget($args, $instance) {     
        extract( $args );
        ?>
              <?php echo $before_widget; ?>
                  <?php echo $before_title
                      . $instance['title']
                      . $after_title; ?>
                <div class="hotTag"><?php wp_tag_cloud('smallest=12&largest=12&unit=px&number='.$instance['Num']
.'&orderby=count&order=DESC'); ?></div>
              <?php echo $after_widget; ?>
        <?php
    }
       
    /** 选项保存过程 */
    function update($new_instance, $old_instance) {             
        return $new_instance;
    }
       
    /** 在管理界面输出选项表单 */
    function form($instance) {              
        $title = esc_attr($instance['title']);
        $Num = esc_attr($instance['Num']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('Num'); ?>">数量：</label><input class="widefat" id="<?php echo $this->get_field_id('Num'); ?>" name="<?php echo $this->get_field_name('Num'); ?>" type="text"  value="<?php echo $Num; ?>" /></p>
            <?php 
    }
       
} 
add_action('widgets_init', create_function('', 'return register_widget("hotTag");'));
 
class CustomWidget extends WP_Widget {
    /** 构造函数 */
    function CustomWidget() {
        parent::WP_Widget(false, $name = 'CustomWidget');   
    }
    /*输出工具内容*/
    function widget($args, $instance) {     
        extract( $args );
        ?>
              <?php echo $before_widget; ?>
                  <?php echo $before_title
                      . $instance['title']
                      . $after_title; ?>
                      <div class="content">
                            <div class="post">
                                <?php
                                 echo $instance['Text'];
                                ?>
                            </div>
                      </div>
              <?php echo $after_widget; ?>
        <?php
    }
    /** 选项保存过程 */
    function update($new_instance, $old_instance) {             
        return $new_instance;
    }
    /** 在管理界面输出选项表单 */
    function form($instance) {              
        $title = esc_attr($instance['title']);
        $Text = esc_attr($instance['Text']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>">Title：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('Text'); ?>">Text：<input class="widefat" id="<?php echo $this->get_field_id('Text'); ?>" name="<?php echo $this->get_field_name('Text'); ?>" type="text"  value="<?php echo $Text; ?>" /></label></p>
            <?php 
    }

}
add_action('widgets_init', create_function('', 'return register_widget("CustomWidget");'));