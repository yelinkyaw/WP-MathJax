<?php
/*
Plugin Name: WP MathJax
Plugin URI: http://wordpress.org/extend/plugins/wp-mathjax/
Description: MathJax for Wordpress
Author: Ye Lin Kyaw
Version: 0.1.0
Author URI: http://www.yelinkyaw.com
*/

function mathjax()
{
	$mathjax_url = plugins_url('/MathJax/MathJax.js', __FILE__);
	$config = 'TeX-AMS-MML_HTMLorMML';
	echo "<script type=\"text/javascript\" src=\"$mathjax_url?config=$config\"></script>";
}

add_action('wp_head', 'mathjax');
?>