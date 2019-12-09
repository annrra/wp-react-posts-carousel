<?php
/**
 * Plugin Name: React Posts Carousels
 * Plugin URI: http://bettermonday.org
 * Description: This plugin shows posts from custom category as carousel.
 * Version: 1.0.0
 * Author: Andrey Raychev
 * Author URI: http://bettermonday.org
 * License: GPL2
 */
 
add_action('admin_init', 'carousel_posts_init' );
add_action('admin_menu', 'carouselposts_options_add_page');
// Init plugin options to white list our options
function carousel_posts_init(){
	register_setting( 'carousel_posts_options', 'rp_sample', 'carouselposts_options_validate' );
}
// Add menu page
function carouselposts_options_add_page() {
	add_options_page('CarouselPosts Settings', 'CarouselPosts', 'manage_options', 'rp_sampleoptions', 'carouselposts_options_do_page');
}
// Draw the menu page itself
function carouselposts_options_do_page() {
	?>
	<div class="wrap">
		<h2>CarouselPosts Settings</h2>
		<form method="post" action="options.php">
			<?php settings_fields('carousel_posts_options'); ?>
			<?php 
            $defaults = array(
                'catname' => 'Uncategorized',
                'postsnumber' => '5',
                'slidesnum' => '1'
            );
            $options = get_option('rp_sample', $defaults);
            ?>
			<table class="form-table">
				<tr valign="top"><th scope="row">Category name</th>
					<td><input type="text" name="rp_sample[catname]" value="<?php echo $options['catname']; ?>" /><br />
                    <p>Add the category name</p>
                    </td>
				</tr>
                <tr valign="top"><th scope="row">Number of posts</th>
					<td><input type="text" name="rp_sample[postsnumber]" value="<?php echo $options['postsnumber']; ?>" /><br />
                    <p>Number of posts to be shown in the slider.</p>
                    </td>
				</tr>
                <tr valign="top"><th scope="row">Slides to show</th>
                    <td><input type="number" id="rp_sample[slidesnum]" name="rp_sample[slidesnum]" value="<?php echo $options['slidesnum']; ?>" min="1" max="3" /><br />
                    <p>Number of posts to show in one frame.</p>
                    </td>
				</tr>
			</table>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>
	</div>
	<?php	
}
// Sanitize and validate input. Accepts an array, return a sanitized array.
function carouselposts_options_validate($input) {
	// Say our second option must be safe text with no HTML tags
	$input['catname'] =  wp_filter_nohtml_kses($input['catname']);
    $input['postsnumber'] =  wp_filter_nohtml_kses($input['postsnumber']);
    $input['slidesnum'] =  wp_filter_nohtml_kses($input['slidesnum']);
	
	return $input;
}
/************************************************************************************************/ 
function carousel_posts_assets() {
    
    wp_register_script('carouselposts-bundle-js', plugins_url('public/bundle.js', __FILE__ ), '', '', true );
	wp_enqueue_script( 'carouselposts-bundle-js' );
    
    wp_enqueue_style( 'slick-slider-styles', plugins_url( 'assets/css/slick.min.css', __FILE__ ) ); 
    wp_enqueue_style( 'slick-slider-theme-styles', plugins_url( 'assets/css/slick-theme.min.css', __FILE__ ) );
    
    wp_enqueue_style( 'carouselposts', plugins_url( 'assets/css/carouselposts.css', __FILE__ ) );
    
}
add_action( 'wp_enqueue_scripts', 'carousel_posts_assets' );
/** carusel js function**/
function carousel_hook_js() {
    
    $defaults = array(
        'catname' => 'Uncategorized',
        'postsnumber' => '5',
        'slidesnum' => '1'
    );
    $rpc_options = get_option('rp_sample', $defaults);
    
    $rpc_cat_name = $rpc_options['catname'];
    $cat_id = get_cat_ID ( $rpc_cat_name );
    $postsnum = $rpc_options['postsnumber'];
    $slidesnum = $rpc_options['slidesnum'];
    ?>
    
    <script>
        var RPC_ALL_url = "<?php echo get_site_url(); ?>/wp-json/wp/v2/posts";
        var RPC_CAT_url = "<?php echo get_site_url(); ?>/wp-json/wp/v2/posts?categories=<?php echo $cat_id; ?>";
        
        var RPC_posts_num = <?php echo $postsnum; ?>;
        var RPC_slides_num = <?php echo $slidesnum; ?>;
    </script>
    
    <?php
    
}
add_action('wp_head', 'carousel_hook_js');
/** end carusel js function**/
/** Add featured images to wp json */
function rpc_register_images_field() {
    register_rest_field ( 
        'post',
        'images',
        array(
            'get_callback'    => 'rpc_images_urls',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}
add_action( 'rest_api_init', 'rpc_register_images_field' );
function rpc_images_urls( $object, $field_name, $request ) {
    $medium = wp_get_attachment_image_src( get_post_thumbnail_id( $object->id ), 'medium' );
    $medium_url = $medium['0'];
    $large = wp_get_attachment_image_src( get_post_thumbnail_id( $object->id ), 'large' );
    $large_url = $large['0'];
    return array(
        'medium' => $medium_url,
        'large'  => $large_url,
    );
}
/** End add featured images to wp json */
/**shortcode function**/
function init_postitems( $atts ) {
    
    $defaults = array(
        'catname' => 'Uncategorized',
        'postsnumber' => '5',
        'slidesnum' => '1'
    );
    $rpc_options = get_option('rp_sample', $defaults);
    
    $slidesnum = $rpc_options['slidesnum'];
    
    $output = '<div id="go-round" class="go-round go-round--slideshow' . $slidesnum . '"></div>' . "\n";
       
    wp_reset_postdata();
    
    return $output;
    
}
add_shortcode( 'posts-carousel', 'init_postitems' );
/**end shortcode function**/