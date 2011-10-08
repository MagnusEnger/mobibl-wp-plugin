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

/*  Copyright 2011 Magnus Enger Libriotech (email : magnus@enger.priv.no)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
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
		$placeholder = empty( $instance['placeholder'] ) ? 'emne/tittel/forfatter' : $instance['placeholder'];
		$library = empty( $instance['library'] ) ? 'demo' : $instance['library'];
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title; ?>
		<form method="get" action="/wp-content/plugins/mobibl-wp-plugin/glitre-proxy.php" id="bib-search">
    <input type="search" name="q" id="search" value="" placeholder="<?php echo($placeholder); ?>" />
		<input type="hidden" name="library" value="<?php echo($library); ?>" />
    <input type="hidden" name="sort_by" value="year" />
    <input type="hidden" name="sort_order" value="descending" />
    <input type="hidden" name="format" value="mobibl" />
		</form>
		<?php echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']       = strip_tags($new_instance['title']);
		$instance['placeholder'] = strip_tags($new_instance['placeholder']);
		$instance['library'] = strip_tags($new_instance['library']);
		return $instance;
	}

	/** @see WP_Widget::form */
	function form( $instance ) {
		if ( $instance ) {
	 		//Defaults
  		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Search the catalogue', 'placeholder' => 'emne/tittel/forfatter', 'library' => 'demo') );
			$title       = esc_attr( $instance[ 'title' ] );
			$placeholder = esc_attr( $instance[ 'placeholder' ] );
			$library = esc_attr( $instance[ 'library' ] );
		}
		else {
			$title = __( 'New title', 'text_domain' );
			$placeholder = __( 'emne/tittel/forfatter', 'text_domain' );
			$library = __( 'demo', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('library'); ?>"><?php _e('Library:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('library'); ?>" name="<?php echo $this->get_field_name('library'); ?>" type="text" value="<?php echo $library; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('placeholder'); ?>"><?php _e('Placeholder:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('placeholder'); ?>" name="<?php echo $this->get_field_name('placeholder'); ?>" type="text" value="<?php echo $placeholder; ?>" />
		</p>
		<?php 
	}

} 

// register 
add_action( 'widgets_init', create_function( '', 'return register_widget("mobiblsearch_Widget");' ) );

/**
 * mobiblnews_Widget Class
 */
class mobiblnews_Widget extends WP_Widget {
	/** constructor */
	function mobiblnews_Widget() {
	  $widget_ops = array('classname' => 'widget_mobiblnews', 'description' => __( 'Displays news/blog items.', 'mobiblnews') );
		parent::WP_Widget( 'mobiblnews_widget', $name = 'moBibl News/Blog', $widget_ops );
	}

	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		extract( $args );
		# Get parameters
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title; ?>
      <ul id="news-menu" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
          <li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
        <?php endwhile;endif ?>
      </ul>
		<?php echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']       = strip_tags($new_instance['title']);
		return $instance;
	}

	/** @see WP_Widget::form */
	function form( $instance ) {
		if ( $instance ) {
	 		//Defaults
  		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Search the catalogue', 'placeholder' => 'emne/tittel/forfatter', 'library' => 'demo') );
			$title       = esc_attr( $instance[ 'title' ] );
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

} 

// register widget
add_action( 'widgets_init', create_function( '', 'return register_widget("mobiblnews_Widget");' ) );

/**
 * mobiblpages_Widget Class
 */
class mobiblpages_Widget extends WP_Widget {
	/** constructor */
	function mobiblpages_Widget() {
	  $widget_ops = array('classname' => 'widget_mobiblpages', 'description' => __( 'Displays pages as a menu, in the order you have decided.', 'mobiblpages') );
		parent::WP_Widget( 'mobiblpages_widget', $name = 'moBibl Pages', $widget_ops );
	}

	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		extract( $args );
		# Get parameters
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		if ( $title ) {
			echo $before_title . $title . $after_title; 
	  }
	  # Get the menu, replace the default <ul> 
	  $mobibl_menu = wp_page_menu(array('echo' => false));
	  echo(str_replace('<ul', '<ul data-theme="c" data-inset="true" data-role="listview" ', $mobibl_menu));
    echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']       = strip_tags($new_instance['title']);
		return $instance;
	}

	/** @see WP_Widget::form */
	function form( $instance ) {
		if ( $instance ) {
	 		//Defaults
  		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Search the catalogue', 'placeholder' => 'emne/tittel/forfatter', 'library' => 'demo') );
			$title       = esc_attr( $instance[ 'title' ] );
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

} 

// register widget
add_action( 'widgets_init', create_function( '', 'return register_widget("mobiblpages_Widget");' ) );

// -------------------------------------------------------------------
// moBibl Dashboard widget

function mobibl_dashboard_widget_function() {
	// Display whatever it is you want to show
	echo "Hello World, I'm the great moBibl Dashboard Widget";
} 

// Create the function use in the action hook

function mobibl_add_dashboard_widgets() {
	wp_add_dashboard_widget('mobibl_dashboard_widget', 'moBibl Dashboard Widget', 'mobibl_dashboard_widget_function');	
} 

// Hook into the 'wp_dashboard_setup' action to register our other functions

add_action('wp_dashboard_setup', 'mobibl_add_dashboard_widgets' );

?>
