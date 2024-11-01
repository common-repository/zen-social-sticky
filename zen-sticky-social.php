<?php /* 
Plugin Name: Zen Sticky social
Plugin URI: 
Description: Facebook and Twitter sticky squares on bottom left side.
Version: 0.3
Author: Bogdan Dinga
Author URI: http://zendevel.wordpress.com/
License: GPLv2
*/ 

function zen_ss_admin_action(){
	add_options_page('Sticky Social', 'Zen StickySocial', 'manage_options', __FILE__, 'zen_ss_admin');
}
add_action('admin_menu','zen_ss_admin_action');

function zen_ss_activation(){
	$options = array( 'facebook' => '', 'twitter' => '' );
	update_option('zen_ss_settings', $options);
}
register_activation_hook(__FILE__, 'zen_ss_activation');

function zen_ss_deactivation(){
	delete_option('zen_ss_settings');
}
register_deactivation_hook(__FILE__, 'zen_ss_deactivation');

function zen_ss_add_css(){
	wp_enqueue_style( 'zensocial-css', plugins_url( 'css/zensocial.min.css' , __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'zen_ss_add_css' );

function zen_ss_admin(){
	$options = get_option('zen_ss_settings');
	$twitter = ( $option['twitter'] != '' ) ? '' : $options['twitter'] ;
	$facebook = ( $option['facebook'] != '' ) ? '' : $options['facebook'] ;
?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br></div>
		<h2>Zen Sticky Social - Settings</h2>
<?php
	if(isset($_POST['submit'])){
		$twitter = $_POST['twitter'] ;
		$facebook = $_POST['facebook'] ;
		$options_build = array( 'facebook' => $facebook, 'twitter' => $twitter );
		if ( update_option('zen_ss_settings', $options_build) ){
?>
	<div id="message" class="updated"><p>Update <strong>succesuful</strong>.</p></div>
<?php 
	}else{ 
?>
	<div id="message" class="error"><p>Update <strong>failed</strong>.</p></div>
<?php }} ?>
		<form action ="" method="POST">
			<table class="form-table">
				<tbody>
					<tr valign="top">
					<th scope="row"><label for="twitter">Twitter username:</label></th>
						<td><input name="twitter" type="text" id="twitter" value="<?php echo $twitter ; ?>" class="regular-text" placeholder="Twitter">
						<p class="description">Hint: http://twitter.com/username or @username </p></td>
					</tr>
					<tr valign="top">
					<th scope="row"><label for="facebook">Facebook username:</label></th>
						<td><input name="facebook" type="text" id="facebook" value="<?php echo $facebook ; ?>" class="regular-text" placeholder="Facebook">
						<p class="description">Hint: http://www.facebook.com/username</p></td>
					</tr>
				</tbody>
			</table>
		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
		</form>
	</div>
<?php 
}

function zen_ss_footer(){
$options = get_option('zen_ss_settings');
$facebook = ( $options['facebook'] != '' )? 'https://www.facebook.com/'.$options['facebook'].'' : '#' ;
$twitter = ( $options['twitter'] != '' )? 'https://twitter.com/'.$options['twitter'].'' : '#' ;
?>
	<div class="social" id="test_test">
		<span></span>
		<a href="<?php echo $facebook ; ?>" target="_blank"></a>
		<a href="<?php echo $twitter ; ?>" target="_blank"></a>
	</div>
<?php }
add_action('wp_footer', 'zen_ss_footer');
?>