<?php
/*
Plugin Name: WP tags to Technorati
Plugin URI: http://www.geekyramblings.org/plugins/wp-tags-to-technorati/
Description: Simple plugin to convert Wordpress 2.3's tags to Technorati ('http://technorati.com') links.
Version: 1.02
Author: David Gibbs
Author URI: http://www.geekyramblings.org
*/

/*

    Copyright 2007,2008 by David Gibbs <david@midrange.com>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

$tags2tech_version = 1.02;

$tag_url = "http://technorati.com/tag";

$tag_start = "\n<!-- start wp-tags-to-technorati $tags2tech_version -->\n";
$tag_end = "\n<!-- end wp-tags-to-technorati -->\n";

set_magic_quotes_runtime(0);

function tags2tech_content ($text) {

	$include_footer = get_option('tags2tech_footer');
	$include_feed = get_option('tags2tech_feed');
	$include_home = get_option('tags2tech_home');

	if ($include_footer && is_feed() && !$include_feed) {
		$include_footer = false;
	}	
	
	if ($include_footer && is_home() && !$include_home) {
		$include_footer = false;
	}	
	
	if ($include_footer && (!is_feed() || is_feed() && $include_feed)) {
		return $text.tags2tech_get_tags_links();
	} else {
		return $text;
	}

}

function tags2tech_get_tags_links() {

	global $tag_start,$tag_end;

	$new_window = get_option('tags2tech_new_window');

	$tags = get_the_tags();

	$tag_text = get_option('tags2tech_label')." ";
	
	$count=0;

	$tag_count=count($tags);

	if (is_array($tags)) {
		foreach($tags as $tag) {
			$count++;
			$link = tags2tech_get_link($tag->name,$new_window);
			$tag_text = $tag_text.($count>1?', ':'').$link;
		}
		$tag_links = "\n<p class='technorati-tags'>".$tag_text."</p>\n";
	} elseif ($tags->name != "") {
		$tag_links = "\n<p class='technorati-tags'>".$tag_text.tags2tech_get_link($tags->name,$new_window)."</p>\n";
	} else {
		$tag_links = "";
	}

	return $tag_start.$tag_links.$tag_end;
}

function tags2tech_get_link($tag,$new_window = false) {
	global $tag_url;

	$rel_nofollow = get_option('tags2tech_rel_nofollow');

	$link_rel = 'tag';

	if ($rel_nofollow) {
		$link_rel .= ',nofollow';
	}

	$encoded_tag = urlencode($tag);

	$target = $new_window?'_blank':'_self';

	$link = "<a class='technorati-link' href='$tag_url/$encoded_tag' rel='$link_rel' target='$target'>$tag</a>";
	
	return $link;
}

function tags2tech_options_menu() {

	?>
	<div class="wrap">
	<h2>Tags to Technorati Settings</h2>
	<form method="post" action="options.php">
	 <!-- <?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo attribute_escape($_GET['page']); ?>"> -->
	<?php wp_nonce_field('update-options'); ?>

<table class="form-table">
 <tr>
 	<th scope="row" valign="top"><?php _e('Technorati Tags label') ?>:</th>
 	<td>
	<input id="tags2tech_label" type="text" name="tags2tech_label" value="<?php echo get_option('tags2tech_label'); ?>" />
  	 	<label for="inputid"><?php _e('Text that will display in front of the tags') ?></label>
 	</td>
 </tr>
 <tr>
 	<th scope="row" valign="top"><?php _e('Open Technorati links in a new window?') ?></th>
 	<td>
	<input id=tags2tech_new_window" type="checkbox" name="tags2tech_new_window" <?php echo get_option('tags2tech_new_window')?'checked=checked':''; ?> /> 
  	 	<label for="tags2tech_new_window"><?php _e('Check this box to open links to Technorati in a new window.') ?></label>
 	</td>
 </tr>
 <tr>
 	<th scope="row" valign="top"><?php _e('Include tags in post footer?') ?></th>
 	<td>
	<input id="tags2tech_footer" type="checkbox" name="tags2tech_footer" <?php echo get_option('tags2tech_footer')?'checked=checked':''; ?> /> 
  	 	<label for="tags2tech_footer"><?php _e('If you want to include the links in any other location on the page than the footer, disable this checkbox and add a call to') ?> <code>tags2tech_get_tags_links()</code> <?php _e('somewhere in the main wordpress \'loop\'.') ?></label>
 	</td>
 </tr>
 <tr>
 	<th scope="row" valign="top"><?php _e('Add "nofollow" to the links rel attribute?') ?></th>
 	<td>
	<input id=tags2tech_rel_nofollow" type="checkbox" name="tags2tech_rel_nofollow" <?php echo get_option('tags2tech_rel_nofollow')?'checked=checked':''; ?> /> 
  	 	<label for="tags2tech_rel_nofollow"><?php _e('Check this box to add "nofollow" to the generated links rel attribute (they already have the value \'tag\').') ?></label>
 	</td>
 </tr>
 <tr>
 	<th scope="row" valign="top"><?php _e('Include tags in RSS feed?') ?></th>
 	<td>
	<input id=tags2tech_feed" type="checkbox" name="tags2tech_feed" <?php echo get_option('tags2tech_feed')?'checked=checked':''; ?> /> 
  	 	<label for="tags2tech_feed"><?php _e('Check this box to include the tags in the RSS feed.') ?></label>
 	</td>
 </tr>
 <tr>
 	<th scope="row" valign="top"><?php _e('Include tags on home page?') ?></th>
 	<td>
	<input id=tags2tech_home" type="checkbox" name="tags2tech_home" <?php echo get_option('tags2tech_home')?'checked=checked':''; ?> /> 
  	 	<label for="tags2tech_home"><?php _e('Check this box to include the tags on the home page.') ?></label>
 	</td>
 </tr>
</table>

<script type="text/javascript">
var WPHC_AFF_ID = '14466';
var WPHC_WP_VERSION = '<?php global $wp_version; echo $wp_version; ?>';
</script>
<script type="text/javascript"
	src="http://cloud.wphelpcenter.com/wp-admin/0001/deliver.js">
</script>


        <p class="submit">
        <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
        </p>
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="tags2tech_label,tags2tech_footer,tags2tech_new_window,tags2tech_rel_nofollow,tags2tech_feed,tags2tech_home"/>
	</form>
	</div>
	<?php 

}

function tags2tech_menu() {
    add_options_page('Tags to Technorati', 'Tags to Technorati', 8, __FILE__, 'tags2tech_options_menu');
}

function tags2tech_checkupgrade() {
	global $tags2tech_version;

	$last_version = get_option('tags2tech_version');
	$current_version = $tags2tech_version;
	if ($current_version > $last_version) {
		echo "<!-- upgrading to $tags2tech_version -->\n";
		$label = get_option('tags2tech_label');
		echo "<!-- oldlabel = $label -->\n";
		if (substr($label,-1) <> ":") {
			$newlabel = $label.":";
			update_option('tags2tech_label',$newlabel);
		}
		update_option('tags2tech_version',$tags2tech_version);
	}

}

function tags2tech_activate() {
        // Let's add some options
	// add_option('tags2tech_label', 'Technorati Tags');
}

function tags2tech_deactivate() {
        // Clean up the options
	delete_option('tags2tech_label');
	delete_option('tags2tech_footer');
	delete_option('tags2tech_new_window');
	delete_option('tags2tech_rel_nofollow');
	delete_option('tags2tech_feed');
	delete_option('tags2tech_home');
}

add_option('tags2tech_version', $tags2tech_version);
add_option('tags2tech_label', __('Technorati Tags:'));
add_option('tags2tech_footer', true);
add_option('tags2tech_new_window', false);
add_option('tags2tech_rel_nofollow', false);
add_option('tags2tech_feed', true);
add_option('tags2tech_home', true);
add_filter('the_content', 'tags2tech_content');
add_action('admin_menu', 'tags2tech_menu');

// register_activation_hook( __FILE__, 'tags2tech_activate' );

add_action('activate_wp-tags-to-technorati/wp-tags-to-technorati.php',
	'tags2tech_activate');
add_action('deactivate_wp-tags-to-technorati/wp-tags-to-technorati.php',
	'tags2tech_deactivate');

// add_action('wp_head','tags2tech_checkupgrade');
add_action('plugins_loaded','tags2tech_checkupgrade');

?>
