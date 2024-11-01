<?php
/*
Plugin Name: TCVN Panorama Widget
Plugin URI: http://VinaThemes.biz
Description: A simple widget to display 360 degree images in a position.
Version: 1.0
Author: VinaThemes
Author URI: http://VinaThemes.biz
Author email: mr_hiennc@yahoo.com
Demo URI: http://VinaDemo.biz
Forum URI: http://laptrinhvien-vn.com
License: GPLv3+
*/

//Defined global variables
if(!defined('TCVN_DIRECTORY')) 		define('TCVN_DIRECTORY', dirname(__FILE__));
if(!defined('TCVN_INC_DIRECTORY')) 	define('TCVN_INC_DIRECTORY', TCVN_DIRECTORY . '/includes');
if(!defined('TCVN_URI')) 			define('TCVN_URI', get_bloginfo('url') . '/wp-content/plugins/tcvn-panorama-widget');
if(!defined('TCVN_INC_URI')) 		define('TCVN_INC_URI', TCVN_URI . '/includes');

//Include library
if(!defined('TCVN_FUNCTIONS')) {
    include_once TCVN_INC_DIRECTORY . '/functions.php';
    define('TCVN_FUNCTIONS', 1);
}
if(!defined('TCVN_FIELDS')) {
    include_once TCVN_INC_DIRECTORY . '/fields.php';
    define('TCVN_FIELDS', 1);
}

class Panorama_Widget extends WP_Widget 
{
	function Panorama_Widget()
	{
		$widget_ops = array(
			'classname' => 'panorama_widget',
			'description' => __('A simple widget to display 360 degree images in a positions.')
		);
		$this->WP_Widget('panorama_widget', __('TCVN Panorama Slider'), $widget_ops);
	}
	
	function form($instance)
	{
		$instance = wp_parse_args( 
			(array) $instance, 
			array( 
				'url' 			=> TCVN_INC_URI . '/images/demo-panorama.jpg',
				'iwidth' 		=> '1352',
				'iheight' 		=> '352',
				'mwidth' 		=> '600',
				'position'		=> '0',
				'speed'			=> '20000',
				'direction'		=> 'left',
				'control'		=> 'auto',
				'auto'			=> 'yes',
				'mode'			=> 'yes',
			)
		);

		$url 		= esc_attr($instance['url']);
		$iwidth 	= esc_attr($instance['iwidth']);
		$iheight 	= esc_attr($instance['iheight']);
		$mwidth 	= esc_attr($instance['mwidth']);
		$position 	= esc_attr($instance['position']);
		$speed 		= esc_attr($instance['speed']);
		$direction 	= esc_attr($instance['direction']);
		$control 	= esc_attr($instance['control']);
		$auto 		= esc_attr($instance['auto']);
		$mode 		= esc_attr($instance['mode']);
		?>
		<p><?php echo _e('========= Display Setting ========='); ?></p>
        <p><?php echo eTextField($this, 'url', 'Path to Image', $url); ?></p>
        <p><?php echo eTextField($this, 'iwidth', 'Image width (px)', $iwidth); ?></p>
        <p><?php echo eTextField($this, 'iheight', 'Image height (px)', $iheight); ?></p>
        <p><?php echo eTextField($this, 'mwidth', 'Module width (px)', $mwidth); ?></p>
        <p><?php echo _e('========= Effect Setting ========='); ?></p>
        <p><?php echo eTextField($this, 'position', 'Start Position', $position); ?></p>
        <p><?php echo eTextField($this, 'speed', 'Speed', $speed); ?></p>
        <p><?php echo eSelectOption($this, 'direction', 'Direction', array('left'=>'Left', 'right'=>'Right'), $direction); ?></p>
        <p><?php echo eSelectOption($this, 'control', 'Control Display', array('auto'=>'Auto', 'always'=>'Always'), $control); ?></p>
        <p><?php echo eRadioButton($this, 'auto', 'Auto Start', array('yes'=>'Yes', 'no'=>'No'), $auto); ?></p>
        <p><?php echo eRadioButton($this, 'mode', 'Mode 360', array('yes'=>'Yes', 'no'=>'No'), $mode); ?></p>
		<?php
	}
	
	function update($new_instance, $old_instance) 
	{
		return $new_instance;
	}
	
	function widget($args, $instance) 
	{
		extract($args);
		
		$url 		= getConfigValue($instance, 'url', 			'');
		$iwidth 	= getConfigValue($instance, 'iwidth', 		'1352');
		$iheight 	= getConfigValue($instance, 'iheight', 		'352');
		$mwidth 	= getConfigValue($instance, 'mwidth', 		'600');
		$position 	= getConfigValue($instance, 'position', 	'0');
		$speed 		= getConfigValue($instance, 'speed', 		'20000');
		$direction 	= getConfigValue($instance, 'direction', 	'left');
		$control 	= getConfigValue($instance, 'control', 		'auto');
		$auto 		= getConfigValue($instance, 'auto', 		'yes');
		$mode 		= getConfigValue($instance, 'mode', 		'yes');
		
		echo $before_widget;
		?>
        <div id="tcvn-panorama-slider">
        	<img src="<?php echo $url; ?>" class="panorama" width="<?php echo $iwidth; ?>" height="<?php echo $iheight; ?>" />
        </div>
        <div id="tcvn-copyright">
        	<a href="http://vinathemes.biz" title="Free download Wordpress Themes, Wordpress Plugins - VinaThemes.biz">Free download Wordpress Themes, Wordpress Plugins - VinaThemes.biz</a>
        </div>
        <script type="text/javascript">
			jQuery(document).ready(function($) {
				$("#tcvn-panorama-slider img.panorama").panorama({
					viewport_width: 	<?php echo $mwidth; ?>,
					speed: 				<?php echo $speed; ?>,
					direction: 			'<?php echo $direction; ?>',
					control_display: 	'<?php echo $control; ?>',
					start_position: 	<?php echo $position; ?>,
					auto_start: 		<?php echo ($auto == 'yes') ? 'true' : 'false'; ?>,
					mode_360: 			<?php echo ($mode == 'yes') ? 'true' : 'false'; ?>,
				});
			});
		</script>
		<?php
		echo $after_widget;
	}
}

add_action('widgets_init', create_function('', 'return register_widget("Panorama_Widget");'));
wp_enqueue_style('panorama-css', TCVN_INC_URI . '/css/style.css', '', '1.0', 'screen' );
wp_enqueue_script('jquery');
wp_enqueue_script('panorama-javascript', TCVN_INC_URI . '/js/jquery.panorama.js', 'jquery', '1.0', true);
?>