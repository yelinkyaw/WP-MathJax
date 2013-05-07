<?php
/*
Plugin Name: WP MathJax
Plugin URI: http://www.yelinkyaw.com
Description: MathJax for Wordpress
Author: Ye Lin Kyaw
Version: 0.1.0
Author URI: http://www.yelinkyaw.com
*/

//Initialization
if (get_option('wp_mathjax_local') =="")
{
	update_option('wp_mathjax_local', 1);
	update_option('wp_mathjax_config', 'TeX-AMS-MML_HTMLorMML');
}

// Add MathJax to Header
add_action('wp_head', 'mathjax');

// MathJax Header
function mathjax()
{
	// Local or CDN MathJax Javascript
	if(get_option('wp_mathjax_local')=='1')
	{
		$mathjax_url = plugins_url('MathJax/MathJax.js', __FILE__);
	}
	else
	{
		$mathjax_url = 'http://cdn.mathjax.org/mathjax/latest/MathJax.js';
	}
	// Get MathJax Config
	$config = get_option('wp_mathjax_config');
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
	//Show Admin UI
	admin_ui();
}
?>

<?php
function admin_ui()
{
?>
<h2>WP MathJax Settings</h2>
<form method="post" action="options-general.php?page=wp-mathjax.php">
	<table>
		<tr>
			<td colspan="2"><h3>MathJax Javascript Location</h3></td>
		</tr>
		<tr>
			<td>Local:</td><td><input type="radio" name="wp_mathjax_local" value="1" <?php if(get_option('wp_mathjax_local')=='1') echo 'checked="checked"'; ?>/></td>
		</tr>
		<tr>
			<td>CDN:</td><td><input type="radio" name="wp_mathjax_local" value="2" <?php if(get_option('wp_mathjax_local')=='2') echo 'checked="checked"'; ?>/></td>
		</tr>
		<tr>
			<td colspan="2"><h3>MathJax Configuration</h3></td>
		</tr>
		<tr>
			<?php
			$config_dir = plugin_dir_path(__FILE__).'MathJax/config/';
			$files = scandir($config_dir);
			
			foreach($files as $file)
			{
				if(is_file($file))
				{
					$path_parts = pathinfo($file);
					$config_file = $path_parts['filename'];
					$checked = '';
					if(get_option('wp_mathjax_config')==$config_file)
					{
						$checked = 'checked="checked"';
					}
					echo "<td>$config_file:</td><td><input type=\"radio\" name=\"wp_mathjax_config\" value=\"$config_file\" $checked/></td>";
				}
			}
			?>
			<td>Custom:</td><td><input type="radio" name="wp_mathjax_config" value="custom" <?php if(get_option('wp_mathjax_config')=='custom') echo 'checked="checked"'; ?>/></td>
		</tr>
	</table>
	<input type="submit" name="Submit" value="Save Settings" />		
</form>
<?php
}
?>