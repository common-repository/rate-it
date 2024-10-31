<?php
/*
Plugin Name: Rate it!
Plugin URI: http://chrisjdavis.org/university/rate-it/
Version: 1.5.1
Description: A collection of functions that allow you to add a rating to each post.
Author: Chris J. Davis
Author URI: http://chrisjdavis.org
*/

if (! function_exists('maybe_add_column')) {
	require_once(ABSPATH . '/wp-admin/upgrade-functions.php');}
	$cjd_table = $wpdb->posts;
	$cjd_table_column = "post_rating";	$cjd_table_sql= "ALTER TABLE " . $cjd_table . " ADD COLUMN " . $cjd_table_column . " INT(11) DEFAULT '1' NOT NULL";
	
	maybe_add_column($cjd_table, $cjd_table_column, $cjd_table_sql);

function current_rating($ID) {
global $wpdb, $post;
$post_rating = $wpdb->get_var("SELECT post_rating FROM $wpdb->posts WHERE ID = '$ID'");
	$rating = $post_rating;
	if ($rating < 50) {
	echo "(";
	echo $rating;
	echo ")";
	echo "  <input type=\"submit\" name=\"Submit\" value=\"Vote for this article\" />";
	} else {
	echo "(";
	echo $rating;
	echo ")";
		}
	}
	
function rate_post($ID) {
global $wpdb, $post;
$ratings = $wpdb->get_var("SELECT post_rating FROM $wpdb->posts WHERE ID = '$ID'");
if ($ratings) {
		$add = ($ratings + 1);
		$return = $wpdb->query("UPDATE $wpdb->posts SET post_rating = '$add' WHERE ID='$ID'");
		}
	}
	
//Thanks to zedrdave and masquerade from #wordpress for their help in getting this done.

function rating_icon($ID) {
global $wpdb, $post;

	$star = "&#9733;";
	$heart = "&#10084;";
	
$post_rating = $wpdb->get_var("SELECT post_rating FROM $wpdb->posts WHERE ID = '$ID'");

$rating = $post_rating;

if (($rating > 29) and ($rating < 49)) {
	echo '<span class="rating">';
	//echo '<a href="/toprated.php" title="top rated posts">';
	echo $star;
	//echo "</a>";
	echo '</span>';
		} else {
		if ($rating > 49) {
		echo '<span class="rating">';
		//echo '<a href="/toprated.php" title="top rated posts">';
		echo $heart;
		//echo "</a>";
		echo '</span>';
			} else {
				if ($rating >= 29) {
				echo "";
			}
		}
	}
}

function if_admin($ID) {
global $user_level;
	get_currentuserinfo();
			if ($user_level > 9) {
			echo '<span class="rating"><a href="/admin_rate.php?rate=1&amp;id=';
			echo $ID;
			echo "&amp;return=";
			echo get_permalink($ID);
			echo '">1</a>/<a href="/admin_rate.php?rate=30&amp;id=';
			echo $ID;
			echo "&amp;return=";
			echo get_permalink($ID);
			echo '">30</a>/<a href="/admin_rate.php?rate=50&amp;id=';
			echo $ID;
			echo "&amp;return=";
			echo get_permalink($ID);
			echo '">50</a></span>';
		} else {
				echo "";
		}
	}

function rate_admin() {
global $user_level;
	get_currentuserinfo();
			if ($user_level > 9) {
			echo '<span class="rating"><a href="/admin_rate.php?rate=1&id=';
			echo the_ID();
			echo "&return=";
			echo get_permalink();
			echo '">1</a>/<a href="/admin_rate.php?rate=30&id=';
			echo the_ID();
			echo "&return=";
			echo get_permalink();
			echo '">30</a>/<a href="/admin_rate.php?rate=50&id=';
			echo the_ID();
			echo "&return=";
			echo get_permalink();
			echo '">50</a></span>';
		} else {
				echo "";
		}
	}
	
function admin_rate($num,$ID) {
global $wpdb, $post;
$ratings = $wpdb->get_var("SELECT post_rating FROM $wpdb->posts WHERE ID = '$ID'");
if ($ratings) {
		$return = $wpdb->query("UPDATE $wpdb->posts SET post_rating = '$num' WHERE ID='$ID'");
		}
	}
?>