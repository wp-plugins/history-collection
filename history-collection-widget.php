<?php
function historycollection_widget_init()
{
		if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;
	function historycollection_widget($args) {
		$options = get_option('quotescollection');
		$title = isset($options['title'])?apply_filters('the_title', $options['title']):__('History', 'quotes-collection');
		$show_title = isset($options['show_title'])?$options['show_title']:1;
		$show_taag = isset($options['show_taag'])?$options['show_taag']:1;
		$show_limit = isset($options['show_limit'])?$options['show_limit']:5;
		$parms ="echo=0&show_title={$show_title}&show_taag={$show_taag}&show_limit={$show_limit}";
			extract($args);
			echo $before_widget;
			if($title) echo $before_title . $title . $after_title . "\n";
			historycollection_quote($parms);
			echo $after_widget;
	}
	function historycollection_widget_control()
	{
		$options = array(
			'title' => __('History', 'quotes-collection'), 
			'show_title' => 1,
			'show_taag' => 0,
			'show_limit'=>5,
		);
		if($options_saved = get_option('quotescollection'))
			$options = array_merge($options, $options_saved);
		if(isset($_REQUEST['quotescollection-submit']) && $_REQUEST['quotescollection-submit']) { 
			$options['title'] = strip_tags(stripslashes($_REQUEST['quotescollection-title']));
			$options['show_title'] = (isset($_REQUEST['quotescollection-show_title']) && $_REQUEST['quotescollection-show_title'])?1:0;
			$options['show_taag'] = (isset($_REQUEST['quotescollection-show_taag']) && $_REQUEST['quotescollection-show_taag'])?1:0;
			$options['show_limit'] = strip_tags(stripslashes($_REQUEST['quotescollection-show_limit']));
			update_option('quotescollection', $options);
		}
		$show_title_checked = $show_taag_checked	;
        if($options['show_title'])
        	$show_title_checked = ' checked="checked"';
        if($options['show_taag'])
        	$show_taag_checked = ' checked="checked"';
		echo "<p style=\"text-align:left;\"><label for=\"quotescollection-title\">".__('Title', 'quotes-collection')." </label><input class=\"widefat\" type=\"text\" id=\"quotescollection-title\" name=\"quotescollection-title\" value=\"".htmlspecialchars($options['title'], ENT_QUOTES)."\" /></p>";
		echo "<p style=\"text-align:left;\"><input type=\"checkbox\" id=\"quotescollection-show_title\" name=\"quotescollection-show_title\" value=\"1\"{$show_title_checked} /> <label for=\"quotescollection-show_title\">".__('Show title?', 'quotes-collection')."</label></p>";
		echo "<p style=\"text-align:left;\"><input type=\"checkbox\" id=\"quotescollection-show_taag\" name=\"quotescollection-show_taag\" value=\"1\"{$show_taag_checked} /> <label for=\"quotescollection-show_taag\">".__('Show tags?', 'quotes-collection')."</label></p>";
		echo "<p style=\"text-align:left;\"><label for=\"quotescollection-show_limit\">".__('show limit', 'quotes-collection')." </label><input class=\"widefat\" type=\"text\" id=\"quotescollection-show_limit\" name=\"quotescollection-show_limit\" value=\"".htmlspecialchars($options['show_limit'], ENT_QUOTES)."\" /></p>";
		echo "<div id=\"quotescollection-adv_opts\" style=\"display:none\">";
    	echo "</div>";
		echo "<input type=\"hidden\" id=\"quotescollection-submit\" name=\"quotescollection-submit\" value=\"1\" />";
	}
	if ( function_exists( 'wp_register_sidebar_widget' ) ) {
		wp_register_sidebar_widget( 'quotescollection', 'History', 'historycollection_widget' );
		wp_register_widget_control( 'quotescollection', 'History', 'historycollection_widget_control', 250, 350 );
	} else {
		register_sidebar_widget(array('History', 'widgets'), 'historycollection_widget');
		register_widget_control('History', 'historycollection_widget_control', 250, 350);
	}
}
add_action('plugins_loaded', 'historycollection_widget_init');?>