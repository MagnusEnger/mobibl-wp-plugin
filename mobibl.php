<?php

/*
Plugin Name: moBibl plugin
Plugin URI: http://libriotech.no/mobibl
Description: A plugin for moBibl. Only provides a search widget, for now. 
Version: 0.1
Author: Magnus Enger
Author URI: http://libriotech.no/
Author Email: magnus@enger.priv.no
*/

/**
 * mobiblsearch_Widget Class
 */
class mobiblsearch_Widget extends WP_Widget {
	/** constructor */
	function mobiblsearch_Widget() {
	  $widget_ops = array('classname' => 'widget_mobiblsearch', 'description' => __( 'Displays a search form for moBibl.', 'mobiblsearch') );
		parent::WP_Widget( 'mobiblsearch_widget', $name = 'moBibl Search', $widget_ops );
	}

	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title; ?>
		<form method="get" action="/glitre/api/index.php" id="bib-search">
    <input type="search" name="q" id="search" value="" placeholder="emne/tittel/forfatter" />
		<input type="hidden" name="library" value="demo" /> <!-- NBNBNBNB!!! -->
    <input type="hidden" name="sort_by" value="year" />
    <input type="hidden" name="sort_order" value="descending" />
    <input type="hidden" name="format" value="mobibl" />
		</form>
		<?php echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	/** @see WP_Widget::form */
	function form( $instance ) {
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<?php 
	}

} // class Foo_Widget

// register Foo_Widget widget
add_action( 'widgets_init', create_function( '', 'return register_widget("mobiblsearch_Widget");' ) );

?>
