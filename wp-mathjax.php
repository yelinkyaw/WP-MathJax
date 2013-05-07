<?php
/*
Plugin Name: WP MathJax
Plugin URI: http://www.yelinkyaw.com
Description: MathJax for Wordpress
Author: Ye Lin Kyaw
Version: 0.1.0
Author URI: http://www.yelinkyaw.com
*/

// Add MathJax to Header
add_action('wp_head', 'mathjax');

// MathJax Header
function mathjax()
{
	if(get_option('wp_mathjax_local')=='1')
	{
		$mathjax_url = plugins_url('MathJax/MathJax.js', __FILE__);
	}
	else
	{
		$mathjax_url = 'http://cdn.mathjax.org/mathjax/latest/MathJax.js';
	}
	$config = 'TeX-AMS-MML_HTMLorMML';
	echo "<script type=\"text/javascript\" src=\"$mathjax_url?config=$config\"></script>\n";
}

// Add Admin Panel
add_action('admin_menu', 'wp_mathjax_option');

// Admin Panel
function wp_mathjax_option()
{
	add_options_page('WP MathJax', 'WP MathJax', 'administrator', 'wp-mathjax.php', 'admin_options');
}

function admin_options()
{
	if(isset($_POST['Submit']))
	{
		update_option('wp_mathjax_local', $_POST['wp_mathjax_local']);
	}
	
	//Initialization
	if (get_option('wp_mathjax_local') =="")
	{
		update_option('wp_mathjax_local', 1);
	}
	
	//Show Admin UI
	admin_ui();
}
?>

<?php
function admin_ui()
{
?>
<h2>WP MathJax</h2>
<form method="post" action="options-general.php?page=wp-mathjax.php">
	<table>
		<tr>
			<td>MathJax Local:</td><td><input type="radio" name="wp_mathjax_local" value="1" <?php if(get_option('wp_mathjax_local')=='1') echo 'checked="checked"'; ?>/></td>
		</tr>
		<tr>
			<td>MathJax CDN:</td><td><input type="radio" name="wp_mathjax_local" value="0" <?php if(get_option('wp_mathjax_local')=='0') echo 'checked="checked"'; ?>/></td>
		</tr>
	</table>
	<input type="submit" name="Submit" value="Save Settings" />		
</form>
<?php
}
?>