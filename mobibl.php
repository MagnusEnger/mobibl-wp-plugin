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

// -------------------------------------------------------------------
// moBibl pages widget

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
// moBibl RSS widget
// Based on the WP default RSS widget

class mobiblrss_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => __('Vis nyheter fra en RSS-strøm.') );
		$control_ops = array( 'width' => 400, 'height' => 200 );
		parent::__construct( 'rss', __('moBibl RSS'), $widget_ops, $control_ops );
	}

	function widget($args, $instance) {

		if ( isset($instance['error']) && $instance['error'] )
			return;

		extract($args, EXTR_SKIP);

		$url = $instance['url'];
		while ( stristr($url, 'http') != $url )
			$url = substr($url, 1);

		if ( empty($url) )
			return;

		// self-url destruction sequence
		if ( in_array( untrailingslashit( $url ), array( site_url(), home_url() ) ) )
			return;

		$rss = fetch_feed($url);
		$title = $instance['title'];
		$desc = '';
		$link = '';

		if ( ! is_wp_error($rss) ) {
			$desc = esc_attr(strip_tags(@html_entity_decode($rss->get_description(), ENT_QUOTES, get_option('blog_charset'))));
			// if ( empty($title) )
			// 	$title = esc_html(strip_tags($rss->get_title()));
			$link = esc_url(strip_tags($rss->get_permalink()));
			while ( stristr($link, 'http') != $link )
				$link = substr($link, 1);
		}

		// if ( empty($title) )
		// 	$title = empty($desc) ? __('Unknown Feed') : $desc;

		$title = apply_filters('widget_title', $title, $instance, $this->id_base);
		$url = esc_url(strip_tags($url));
		$icon = includes_url('images/rss.png');
		if ( $title )
			$title = "<h2>$title</h2>";

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		mobibl_widget_rss_output( $rss, $instance );
		echo $after_widget;

		if ( ! is_wp_error($rss) )
			$rss->__destruct();
		unset($rss);
	}

	function update($new_instance, $old_instance) {
		$testurl = ( isset($new_instance['url']) && ($new_instance['url'] != $old_instance['url']) );
		return mobibl_widget_rss_process( $new_instance, $testurl );
	}

	function form($instance) {

		if ( empty($instance) )
			$instance = array( 'title' => '', 'url' => '', 'items' => 10, 'error' => false, 'show_summary' => 0, 'show_author' => 0, 'show_date' => 0 );
		$instance['number'] = $this->number;

		mobibl_widget_rss_form( $instance );
	}
}

/**
 * Display the RSS entries in a list.
 *
 * @since 2.5.0
 *
 * @param string|array|object $rss RSS url.
 * @param array $args Widget arguments.
 */
function mobibl_widget_rss_output( $rss, $args = array() ) {
	if ( is_string( $rss ) ) {
		$rss = fetch_feed($rss);
	} elseif ( is_array($rss) && isset($rss['url']) ) {
		$args = $rss;
		$rss = fetch_feed($rss['url']);
	} elseif ( !is_object($rss) ) {
		return;
	}

	if ( is_wp_error($rss) ) {
		if ( is_admin() || current_user_can('manage_options') )
			echo '<p>' . sprintf( __('<strong>RSS Error</strong>: %s'), $rss->get_error_message() ) . '</p>';
		return;
	}

	$default_args = array( 'show_author' => 0, 'show_date' => 0, 'show_summary' => 0 );
	$args = wp_parse_args( $args, $default_args );
	extract( $args, EXTR_SKIP );

	$items = (int) $items;
	if ( $items < 1 || 20 < $items )
		$items = 10;
	$show_summary  = (int) $show_summary;
	$show_author   = (int) $show_author;
	$show_date     = (int) $show_date;

	if ( !$rss->get_item_quantity() ) {
		echo '<ul><li>' . __( 'An error has occurred; the feed is probably down. Try again later.' ) . '</li></ul>';
		$rss->__destruct();
		unset($rss);
		return;
	}

	echo '<div data-role="collapsible-set">';
	$counter = 0;
	foreach ( $rss->get_items(0, $items) as $item ) {
		
		/*
		$link = $item->get_link();
		while ( stristr($link, 'http') != $link )
			$link = substr($link, 1);
		$link = esc_url(strip_tags($link));
		*/
		
		$title = esc_attr(strip_tags($item->get_title()));
		if ( empty($title) )
			$title = __('Uten tittel');

		$desc = $item->get_description(); // str_replace( array("\n", "\r"), ' ', esc_attr( $item->get_description(), ENT_QUOTES, get_option('blog_charset') ) );
		// $desc = wp_html_excerpt( $desc, 100000 );

		// Append ellipsis. Change existing [...] to [&hellip;].
		/* moBibl does not need this, I think...
		if ( '[...]' == substr( $desc, -5 ) )
			$desc = substr( $desc, 0, -5 ) . '[&hellip;]';
		elseif ( '[&hellip;]' != substr( $desc, -10 ) )
			$desc .= ' [&hellip;]';
    */
    
		// $desc = esc_html( $desc );

    /*
		if ( $show_summary ) {
			$summary = $desc;
		} else {
			$summary = '';
		}
		*/

		$date = '';
		if ( $show_date ) {
			$date = $item->get_date( 'U' );

			if ( $date ) {
				$date = ' <span class="rss-date">' . date_i18n( get_option( 'date_format' ), $date ) . '</span>';
			}
		}

		$author = '';
		if ( $show_author ) {
			$author = $item->get_author();
			if ( is_object($author) ) {
				$author = $author->get_name();
				$author = ' <cite>' . esc_html( strip_tags( $author ) ) . '</cite>';
			}
		}

    $expanded = '';
    if ( $counter == 0 && $show_summary ) {
      $expanded = ' data-collapsed="false"';
    }
    
    echo('<div data-role="collapsible" data-theme="c" data-content-theme="c"' . $expanded . '>');
		echo("<h3>{$title}</h3>");
		echo($desc);
		if ( $show_date || $show_author ) {
		  echo('<div>Publisert ' . $date);
		  if ( $show_author ) {
		    echo(' av ' . $author);
		  } 
		  echo('</div>');
		}
		echo('</div>');
		
		$counter++;
		
	}
	echo '</div>'; // End collapsible-set
	
	$rss->__destruct();
	unset($rss);
}

/**
 * Display RSS widget options form.
 *
 * The options for what fields are displayed for the RSS form are all booleans
 * and are as follows: 'url', 'title', 'items', 'show_summary', 'show_author',
 * 'show_date'.
 *
 * @since 2.5.0
 *
 * @param array|string $args Values for input fields.
 * @param array $inputs Override default display options.
 */
function mobibl_widget_rss_form( $args, $inputs = null ) {

	$default_inputs = array( 'url' => true, 'title' => true, 'items' => true, 'show_summary' => true, 'show_author' => true, 'show_date' => true );
	$inputs = wp_parse_args( $inputs, $default_inputs );
	extract( $args );
	extract( $inputs, EXTR_SKIP);

	$number = esc_attr( $number );
	$title  = esc_attr( $title );
	$url    = esc_url( $url );
	$items  = (int) $items;
	if ( $items < 1 || 20 < $items )
		$items  = 10;
	$show_summary   = (int) $show_summary;
	$show_author    = (int) $show_author;
	$show_date      = (int) $show_date;

	if ( !empty($error) )
		echo '<p class="widget-error"><strong>' . sprintf( __('RSS Error: %s'), $error) . '</strong></p>';

	if ( $inputs['url'] ) :
?>
	<p><label for="rss-url-<?php echo $number; ?>"><?php _e('Enter the RSS feed URL here:'); ?></label>
	<input class="widefat" id="rss-url-<?php echo $number; ?>" name="widget-rss[<?php echo $number; ?>][url]" type="text" value="<?php echo $url; ?>" /></p>
<?php endif; if ( $inputs['title'] ) : ?>
	<p><label for="rss-title-<?php echo $number; ?>"><?php _e('Give the feed a title:'); ?></label>
	<input class="widefat" id="rss-title-<?php echo $number; ?>" name="widget-rss[<?php echo $number; ?>][title]" type="text" value="<?php echo $title; ?>" /></p>
<?php endif; if ( $inputs['items'] ) : ?>
	<p><label for="rss-items-<?php echo $number; ?>"><?php _e('How many items would you like to display?'); ?></label>
	<select id="rss-items-<?php echo $number; ?>" name="widget-rss[<?php echo $number; ?>][items]">
<?php
		for ( $i = 1; $i <= 20; ++$i )
			echo "<option value='$i' " . ( $items == $i ? "selected='selected'" : '' ) . ">$i</option>";
?>
	</select></p>
<?php endif; if ( $inputs['show_summary'] ) : ?>
	<p><input id="rss-show-summary-<?php echo $number; ?>" name="widget-rss[<?php echo $number; ?>][show_summary]" type="checkbox" value="1" <?php if ( $show_summary ) echo 'checked="checked"'; ?>/>
	<label for="rss-show-summary-<?php echo $number; ?>"><?php _e('Vis innhold for første innførsel?'); ?></label></p>
<?php endif; if ( $inputs['show_author'] ) : ?>
	<p><input id="rss-show-author-<?php echo $number; ?>" name="widget-rss[<?php echo $number; ?>][show_author]" type="checkbox" value="1" <?php if ( $show_author ) echo 'checked="checked"'; ?>/>
	<label for="rss-show-author-<?php echo $number; ?>"><?php _e('Display item author if available?'); ?></label></p>
<?php endif; if ( $inputs['show_date'] ) : ?>
	<p><input id="rss-show-date-<?php echo $number; ?>" name="widget-rss[<?php echo $number; ?>][show_date]" type="checkbox" value="1" <?php if ( $show_date ) echo 'checked="checked"'; ?>/>
	<label for="rss-show-date-<?php echo $number; ?>"><?php _e('Display item date?'); ?></label></p>
<?php
	endif;
	foreach ( array_keys($default_inputs) as $input ) :
		if ( 'hidden' === $inputs[$input] ) :
			$id = str_replace( '_', '-', $input );
?>
	<input type="hidden" id="rss-<?php echo $id; ?>-<?php echo $number; ?>" name="widget-rss[<?php echo $number; ?>][<?php echo $input; ?>]" value="<?php echo $$input; ?>" />
<?php
		endif;
	endforeach;
}

/**
 * Process RSS feed widget data and optionally retrieve feed items.
 *
 * The feed widget can not have more than 20 items or it will reset back to the
 * default, which is 10.
 *
 * The resulting array has the feed title, feed url, feed link (from channel),
 * feed items, error (if any), and whether to show summary, author, and date.
 * All respectively in the order of the array elements.
 *
 * @since 2.5.0
 *
 * @param array $widget_rss RSS widget feed data. Expects unescaped data.
 * @param bool $check_feed Optional, default is true. Whether to check feed for errors.
 * @return array
 */
function mobibl_widget_rss_process( $widget_rss, $check_feed = true ) {
	$items = (int) $widget_rss['items'];
	if ( $items < 1 || 20 < $items )
		$items = 10;
	$url           = esc_url_raw(strip_tags( $widget_rss['url'] ));
	$title         = trim(strip_tags( $widget_rss['title'] ));
	$show_summary  = isset($widget_rss['show_summary']) ? (int) $widget_rss['show_summary'] : 0;
	$show_author   = isset($widget_rss['show_author']) ? (int) $widget_rss['show_author'] :0;
	$show_date     = isset($widget_rss['show_date']) ? (int) $widget_rss['show_date'] : 0;

	if ( $check_feed ) {
		$rss = fetch_feed($url);
		$error = false;
		$link = '';
		if ( is_wp_error($rss) ) {
			$error = $rss->get_error_message();
		} else {
			$link = esc_url(strip_tags($rss->get_permalink()));
			while ( stristr($link, 'http') != $link )
				$link = substr($link, 1);

			$rss->__destruct();
			unset($rss);
		}
	}

	return compact( 'title', 'url', 'link', 'items', 'error', 'show_summary', 'show_author', 'show_date' );
}

// register widget
add_action( 'widgets_init', create_function( '', 'return register_widget("mobiblrss_Widget");' ) );

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
