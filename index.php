<?php 
/*
 Plugin Name: TAMEER CONSTRUCTION PRO POSTTYPE
 Plugin URI: https://www.themeseye.com/
 Description: Creating new post type for Tameer Construction Pro Theme.
 Author: Themeseye
 Version: 1.0
 Author URI: https://www.themeseye.com/
*/

define( 'TAMEER_CONSTRUCTION_PRO_POSTTYPE_VERSION', '1.0' );

add_action( 'init', 'createcategory');
add_action( 'init', 'tameer_construction_pro_posttype_create_post_type' );

function tameer_construction_pro_posttype_create_post_type() {
  register_post_type( 'services',
    array(
      'labels' => array(
        'name' => __( 'What We Do','tameer-construction-pro-posttype' ),
        'singular_name' => __( 'What We Do','tameer-construction-pro-posttype' )
      ),
      'capability_type' => 'post',
      'menu_icon'  => 'dashicons-portfolio',
      'public' => true,
      'supports' => array(
        'title',
        'editor',
        'thumbnail'
      )
    )
  );
  register_post_type( 'projects',
    array(
      'labels' => array(
        'name' => __( 'Projects','tameer-construction-pro-posttype' ),
        'singular_name' => __( 'Projects','tameer-construction-pro-posttype' )
      ),
      'capability_type' => 'post',
      'menu_icon'  => 'dashicons-portfolio',
      'public' => true,
      'supports' => array(
        'title',
        'editor',
        'thumbnail'
      )
    )
  );
  register_post_type( 'testimonials',
    array(
      'labels' => array(
        'name' => __( 'Testimonials','tameer-construction-pro-posttype' ),
        'singular_name' => __( 'Testimonials','tameer-construction-pro-posttype' )
      ),
      'capability_type' => 'post',
      'menu_icon'  => 'dashicons-businessman',
      'public' => true,
      'supports' => array(
        'title',
        'editor',
        'thumbnail'
      )
    )
  );
  register_post_type( 'team',
    array(
      'labels' => array(
        'name' => __( 'Our Team','tameer-construction-pro-posttype' ),
        'singular_name' => __( 'Our Team','tameer-construction-pro-posttype' )
      ),
        'capability_type' => 'post',
        'menu_icon'  => 'dashicons-businessman',
        'public' => true,
        'supports' => array( 
          'title',
          'editor',
          'thumbnail'
      )
    )
  );
  register_post_type( 'properties',
    array(
      'labels' => array(
        'name' => __( 'Properties','tameer-construction-pro-posttype' ),
        'singular_name' => __( 'Properties','tameer-construction-pro-posttype' )
      ),
        'capability_type' => 'post',
        'menu_icon'  => 'dashicons-businessman',
        'public' => true,
        'supports' => array( 
          'title',
          'editor',
          'thumbnail'
      )
    )
  );
}
function createcategory() {
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name'              => __( 'Categories', 'tameer-construction-pro' ),
    'singular_name'     => __( 'Categories', 'tameer-construction-pro' ),
    'search_items'      => __( 'Search cats', 'tameer-construction-pro' ),
    'all_items'         => __( 'All Categories', 'tameer-construction-pro' ),
    'parent_item'       => __( 'Parent Categories', 'tameer-construction-pro' ),
    'parent_item_colon' => __( 'Parent Categories:', 'tameer-construction-pro' ),
    'edit_item'         => __( 'Edit Categories', 'tameer-construction-pro' ),
    'update_item'       => __( 'Update Categories', 'tameer-construction-pro' ),
    'add_new_item'      => __( 'Add New Categories', 'tameer-construction-pro' ),
    'new_item_name'     => __( 'New Categories Name', 'tameer-construction-pro' ),
    'menu_name'         => __( 'Categories', 'tameer-construction-pro' ),
  );
  $args = array(
    'hierarchical'      => true,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'createcategory' ),
  );
  register_taxonomy( 'createcategory', array( 'services' ), $args );
}
/*-------------------------Serives section------------------------*/
function tameer_construction_pro_bn_services_meta_box(){
  add_meta_box('tameer_construction_pro_posttype_services_meta',__('Enter Details','tameer_construction_pro'),'tameer_construction_pro_posttype_bn_services_meta_callback','services','normal','high');
}
// Hook things in for admin
if(is_admin()){
  add_action('admin_menu','tameer_construction_pro_bn_services_meta_box');
}
/*----------------Adds a meta box for custom post-----------------*/
function tameer_construction_pro_posttype_bn_services_meta_callback( $post ){
  wp_nonce_field( basename(__File__),'tameer_construction_pro_posttype_services_meta_nonce');
    $bn_stored_meta = get_post_meta( $post->ID );
     if(!empty($bn_stored_meta['place'][0]))
      $bn_place = $bn_stored_meta['place'][0];
    else
      $bn_place = '';
    ?>
    <div id="testimonials_custom_stuff">
      <table id="list">
        <tbody id="the-list" data-wp-lists="list:meta">
          <tr id="meta-1">
            <td class="left">
              <?php _e( 'Place', 'tameer-construction-pro-posttype' )?>
            </td>
            <td class="left" >
              <input type="text" name="place" id="place" 
              value="<?php echo esc_attr($bn_place); ?>" />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  <?php
  }
  function tameer_construction_pro_bn_services_save($post_id){
    if(!isset ($_POST['tameer_construction_pro_posttype_services_meta_nonce']) || !wp_verify_nonce($_POST['tameer_construction_pro_posttype_services_meta_nonce'],basename(__FILE__))){
      return;
  }
   if (!current_user_can('edit_post',$post_id)) {
    return;
  }
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
    return;
  }
  //save place name
  if( isset( $_POST[ 'place' ] ) ) {
    update_post_meta( $post_id, 'place', sanitize_text_field($_POST[ 'place']) );
  }
}
add_action( 'save_post', 'tameer_construction_pro_bn_services_save' );
/*-----------------------Properties Section-----------------------*/
/* Adds a meta box to the Properties editing screen---------------*/
function tameer_construction_pro_posttype_bn_properties_meta_box(){
  add_meta_box('tameer_construction_pro_posttype_properties_meta',__('Enter Details','tameer-construction-pro-posttype'),'tameer_construction_pro_posttype_bn_properties_meta_callback','properties','normal','high');
}
// Hook things in for admin
if(is_admin()){
  add_action('admin_menu','tameer_construction_pro_posttype_bn_properties_meta_box');
}
/* Adds a meta box for custom post */
function tameer_construction_pro_posttype_bn_properties_meta_callback( $post ){
  wp_nonce_field( basename( __File__ ),'tameer_construction_pro_posttype_properties_meta_nonce');
     $bn_stored_meta = get_post_meta( $post->ID );
    if(!empty($bn_stored_meta['tameer_construction_pro_posttype_properties_location'][0]))
      $bn_tameer_construction_pro_posttype_properties_location = $bn_stored_meta['tameer_construction_pro_posttype_properties_location'][0];
    else
      $bn_tameer_construction_pro_posttype_properties_location = ''; 
    if(!empty($bn_stored_meta['area'][0]))
      $bn_area = $bn_stored_meta['area'][0];
    else
      $bn_area = ''; 
    if(!empty($bn_stored_meta['bedrooms'][0]))
      $bn_bedrooms = $bn_stored_meta['bedrooms'][0];
    else
      $bn_bedrooms = ''; 
    if(!empty($bn_stored_meta['garage'][0]))
      $bn_garage = $bn_stored_meta['garage'][0];
    else
      $bn_garage = ''; 
    if(!empty($bn_stored_meta['bathrooms'][0]))
      $bn_bathrooms = $bn_stored_meta['bathrooms'][0];
    else
      $bn_bathrooms = ''; 
    if(!empty($bn_stored_meta['details'][0]))
      $bn_details = $bn_stored_meta['details'][0];
    else
      $bn_details = ''; 
    if(!empty($bn_stored_meta['custom_link'][0]))
      $bn_custom_link = $bn_stored_meta['custom_link'][0];
    else
      $bn_custom_link = ''; 
    if(!empty($bn_stored_meta['price'][0]))
      $bn_price = $bn_stored_meta['price'][0];
    else
      $bn_price = ''; 
    if(!empty($bn_stored_meta['sale'][0]))
      $bn_sale = $bn_stored_meta['sale'][0];
    else
      $bn_sale = ''; 
    ?>
    <div id="testimonials_custom_stuff">
    <table id="list">
      <tbody id="the-list" data-wp-lists="list:meta">
        <tr id="meta-1">
          <td class="left">
            <?php _e( 'Property Status', 'tameer-construction-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="sale" id="sale" 
            value="<?php echo esc_attr($bn_sale); ?>" />
          </td>
        </tr>
        <tr id="meta-2">
          <td class="left">
            <?php _e( 'Location', 'tameer-construction-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="tameer_construction_pro_posttype_properties_location" id="tameer_construction_pro_posttype_properties_location" 
            value="<?php echo esc_attr($bn_tameer_construction_pro_posttype_properties_location ); ?>" />
          </td>
        </tr>
        <tr id="meta-3">
          <td class="left">
            <?php _e( 'Area', 'tameer-construction-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="area" id="area" 
            value="<?php echo esc_attr($bn_area ); ?>" />
          </td>
        </tr>
        <tr id="meta-4">
          <td class="left">
            <?php _e( 'No. of Bedrooms', 'tameer-construction-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="bedrooms" id="bedrooms" 
            value="<?php echo esc_attr($bn_bedrooms ); ?>" />
          </td>
        </tr>
        <tr id="meta-5">
          <td class="left">
            <?php _e( 'No. of Garage', 'tameer-construction-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="garage" id="garage" 
            value="<?php echo esc_attr($bn_garage ); ?>" />
          </td>
        </tr>
        <tr id="meta-6">
          <td class="left">
            <?php _e( 'No. of Bathrooms', 'tameer-construction-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="bathrooms" id="bathrooms" 
            value="<?php echo esc_attr($bn_bathrooms ); ?>" />
          </td>
        </tr>
        <tr id="meta-7">
          <td class="left">
            <?php _e( 'More Details Label', 'tameer-construction-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="details" id="details" 
            value="<?php echo esc_attr($bn_details ); ?>" />
          </td>
        </tr>
         <tr id="meta-8">
          <td class="left">
            <?php _e( 'Custom Link', 'tameer-construction-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="custom_link" id="custom_link" 
            value="<?php echo esc_attr($bn_custom_link ); ?>" />
          </td>
        </tr>
        <tr id="meta-9">
          <td class="left">
            <?php _e( 'Price', 'tameer-construction-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="price" id="price" 
            value="<?php echo esc_attr($bn_price ); ?>" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>

<?php
}
/* Saves rthe custom meta input */
function tameer_construction_pro_bn_properties_save($post_id){
  if(!isset($_POST['tameer_construction_pro_posttype_properties_meta_nonce']) || !wp_verify_nonce($_POST['tameer_construction_pro_posttype_properties_meta_nonce'], basename(__FILE__))) {
    return;
  }
  if (!current_user_can('edit_post',$post_id)) {
    return;
  }
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
    return;
  }
    // Save location.
  if( isset( $_POST[ 'tameer_construction_pro_posttype_properties_location' ] ) ) {
    update_post_meta( $post_id, 'tameer_construction_pro_posttype_properties_location', sanitize_text_field($_POST[ 'tameer_construction_pro_posttype_properties_location']) );
  }
    // Save area.
  if( isset( $_POST[ 'area' ] ) ) {
    update_post_meta( $post_id, 'area', sanitize_text_field($_POST[ 'area']) );
  }
    // Save bedrooms.
  if( isset( $_POST[ 'bedrooms' ] ) ) {
    update_post_meta( $post_id, 'bedrooms', sanitize_text_field($_POST[ 'bedrooms']) );
  }
    // Save garage.
  if( isset( $_POST[ 'garage' ] ) ) {
    update_post_meta( $post_id, 'garage', sanitize_text_field($_POST[ 'garage']) );
  }
     // Save bathrooms.
  if( isset( $_POST[ 'bathrooms' ] ) ) {
    update_post_meta( $post_id, 'bathrooms', sanitize_text_field($_POST[ 'bathrooms']) );
  }
     // Save More Details Label.
  if( isset( $_POST[ 'details' ] ) ) {
    update_post_meta( $post_id, 'details', sanitize_text_field($_POST[ 'details']) );
  }

    // Save More Details Link
  if( isset( $_POST[ 'custom_link' ] ) ) {
    update_post_meta( $post_id, 'custom_link', sanitize_text_field($_POST[ 'custom_link']) );
  }
      // Save Price.
  if( isset( $_POST[ 'price' ] ) ) {
    update_post_meta( $post_id, 'price', sanitize_text_field($_POST[ 'price']) );
  }
   // Save Sale Label
  if( isset( $_POST[ 'sale' ] ) ) {
    update_post_meta( $post_id, 'sale', sanitize_text_field($_POST[ 'sale']) );
  }
}
add_action( 'save_post', 'tameer_construction_pro_bn_properties_save' );

/*----------------------Testimonial Section ----------------------*/
/* Adds a meta box to the Testimonial editing screen */
function tameer_construction_pro_posttype_bn_testimonial_meta_box() {
  add_meta_box( 'tameer-construction-pro-posttype-testimonial-meta', __( 'Enter Details', 'tameer-construction-pro-posttype' ), 'tameer_construction_pro_posttype_bn_testimonial_meta_callback', 'testimonials', 'normal', 'high' );
}
// Hook things in for admin
if (is_admin()){
    add_action('admin_menu', 'tameer_construction_pro_posttype_bn_testimonial_meta_box');
}
/* Adds a meta box for custom post */
function tameer_construction_pro_posttype_bn_testimonial_meta_callback( $post ) {
  wp_nonce_field( basename( __FILE__ ), 'tameer_construction_pro_posttype_posttype_testimonial_meta_nonce' );
  $bn_stored_meta = get_post_meta( $post->ID );
  if(!empty($bn_stored_meta['tameer_construction_pro_posttype_testimonial_desigstory'][0]))
      $bn_tameer_construction_pro_posttype_testimonial_desigstory = $bn_stored_meta['tameer_construction_pro_posttype_testimonial_desigstory'][0];
    else
      $bn_tameer_construction_pro_posttype_testimonial_desigstory = '';
  ?>
  <div id="testimonials_custom_stuff">
    <table id="list">
      <tbody id="the-list" data-wp-lists="list:meta">
        <tr id="meta-1">
          <td class="left">
            <?php _e( 'Designation', 'tameer-construction-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="tameer_construction_pro_posttype_testimonial_desigstory" id="tameer_construction_pro_posttype_testimonial_desigstory" value="<?php echo esc_attr( $bn_tameer_construction_pro_posttype_testimonial_desigstory ); ?>" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <?php
}

/* Saves the custom meta input */
function tameer_construction_pro_posttype_bn_metadesig_save( $post_id ) {
  if (!isset($_POST['tameer_construction_pro_posttype_posttype_testimonial_meta_nonce']) || !wp_verify_nonce($_POST['tameer_construction_pro_posttype_posttype_testimonial_meta_nonce'], basename(__FILE__))) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  // Save desig.
  if( isset( $_POST[ 'tameer_construction_pro_posttype_testimonial_desigstory' ] ) ) {
    update_post_meta( $post_id, 'tameer_construction_pro_posttype_testimonial_desigstory', sanitize_text_field($_POST[ 'tameer_construction_pro_posttype_testimonial_desigstory']) );
  }
}

add_action( 'save_post', 'tameer_construction_pro_posttype_bn_metadesig_save' );

/*------------------------- Team Section-----------------------------*/
/* Adds a meta box for Designation */
function tameer_construction_pro_posttype_bn_team_meta() {
    add_meta_box( 'tameer_construction_pro_posttype_bn_meta', __( 'Enter Details','tameer-construction-pro-posttype' ), 'tameer_construction_pro_posttype_ex_bn_meta_callback', 'team', 'normal', 'high' );
}
// Hook things in for admin
if (is_admin()){
    add_action('admin_menu', 'tameer_construction_pro_posttype_bn_team_meta');
}
/* Adds a meta box for custom post */
function tameer_construction_pro_posttype_ex_bn_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'tameer_construction_pro_posttype_bn_nonce' );
    $bn_stored_meta = get_post_meta( $post->ID );

    //facebook details
    if(!empty($bn_stored_meta['meta-facebookurl'][0]))
      $bn_meta_facebookurl = $bn_stored_meta['meta-facebookurl'][0];
    else
      $bn_meta_facebookurl = '';

    //linkdenurl details
    if(!empty($bn_stored_meta['meta-linkdenurl'][0]))
      $bn_meta_linkdenurl = $bn_stored_meta['meta-linkdenurl'][0];
    else
      $bn_meta_linkdenurl = '';

    //twitterurl details
    if(!empty($bn_stored_meta['meta-twitterurl'][0]))
      $bn_meta_twitterurl = $bn_stored_meta['meta-twitterurl'][0];
    else
      $bn_meta_twitterurl = '';

    //twitterurl details
    if(!empty($bn_stored_meta['meta-googleplusurl'][0]))
      $bn_meta_googleplusurl = $bn_stored_meta['meta-googleplusurl'][0];
    else
      $bn_meta_googleplusurl = '';
    if(!empty($bn_stored_meta['team_designation'][0]))
      $bn_meta_team_designation = $bn_stored_meta['team_designation'][0];
    else
      $bn_meta_team_designation = '';

    ?>
    <div id="agent_custom_stuff">
        <table id="list-table">         
            <tbody id="the-list" data-wp-lists="list:meta">
                <tr id="meta-1">
                  <td class="left">
                    <?php _e( 'Designation', 'tameer-construction-pro-posttype' )?>
                  </td>
                  <td class="left" >
                    <input type="text" name="team_designation" id="team_designation" value="<?php echo esc_attr( $bn_meta_team_designation ); ?>" />
                  </td>
                </tr>
                <tr id="meta-2">
                  <td class="left">
                    <?php esc_html_e( 'Facebook Url', 'tameer-construction-pro-posttype' )?>
                  </td>
                  <td class="left" >
                    <input type="url" name="meta-facebookurl" id="meta-facebookurl" value="<?php echo esc_url($bn_meta_facebookurl); ?>" />
                  </td>
                </tr>
                <tr id="meta-3">
                  <td class="left">
                    <?php esc_html_e( 'Linkedin URL', 'tameer-construction-pro-posttype' )?>
                  </td>
                  <td class="left" >
                    <input type="url" name="meta-linkdenurl" id="meta-linkdenurl" value="<?php echo esc_url($bn_meta_linkdenurl); ?>" />
                  </td>
                </tr>
                <tr id="meta-4">
                  <td class="left">
                    <?php esc_html_e( 'Twitter Url', 'tameer-construction-pro-posttype' ); ?>
                  </td>
                  <td class="left" >
                    <input type="url" name="meta-twitterurl" id="meta-twitterurl" value="<?php echo esc_url( $bn_meta_twitterurl); ?>" />
                  </td>
                </tr>
                <tr id="meta-5">
                  <td class="left">
                    <?php esc_html_e( 'GooglePlus URL', 'tameer-construction-pro-posttype' ); ?>
                  </td>
                  <td class="left" >
                    <input type="url" name="meta-googleplusurl" id="meta-googleplusurl" value="<?php echo esc_url($bn_meta_googleplusurl); ?>" />
                  </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php
}
/* Saves the custom Designation meta input */
function tameer_construction_pro_posttype_ex_bn_metadesig_save( $post_id ) {
    if( isset( $_POST[ 'meta-desig' ] ) ) {
        update_post_meta( $post_id, 'meta-desig', esc_html($_POST[ 'meta-desig' ]) );
    }
    if( isset( $_POST[ 'meta-call' ] ) ) {
        update_post_meta( $post_id, 'meta-call', esc_html($_POST[ 'meta-call' ]) );
    }
    // Save facebookurl
    if( isset( $_POST[ 'meta-facebookurl' ] ) ) {
        update_post_meta( $post_id, 'meta-facebookurl', esc_url($_POST[ 'meta-facebookurl' ]) );
    }
    // Save linkdenurl
    if( isset( $_POST[ 'meta-linkdenurl' ] ) ) {
        update_post_meta( $post_id, 'meta-linkdenurl', esc_url($_POST[ 'meta-linkdenurl' ]) );
    }
    if( isset( $_POST[ 'meta-twitterurl' ] ) ) {
        update_post_meta( $post_id, 'meta-twitterurl', esc_url($_POST[ 'meta-twitterurl' ]) );
    }
    // Save googleplusurl
    if( isset( $_POST[ 'meta-googleplusurl' ] ) ) {
        update_post_meta( $post_id, 'meta-googleplusurl', esc_url($_POST[ 'meta-googleplusurl' ]) );
    }
    // Save Designation
    if( isset( $_POST[ 'team_designation' ] ) ) {
    update_post_meta( $post_id, 'team_designation', sanitize_text_field($_POST[ 'team_designation']));
    }
}
add_action( 'save_post', 'tameer_construction_pro_posttype_ex_bn_metadesig_save' );

add_action( 'save_post', 'bn_meta_save' );
/* Saves the custom meta input */
function bn_meta_save( $post_id ) {
  if( isset( $_POST[ 'tameer_construction_pro_posttype_team_featured' ] )) {
      update_post_meta( $post_id, 'tameer_construction_pro_posttype_team_featured', esc_attr(1));
  }else{
    update_post_meta( $post_id, 'tameer_construction_pro_posttype_team_featured', esc_attr(0));
  }
}
/*------------------------ Team Shortcode --------------------------*/
function tameer_construction_pro_posttype_team_func( $atts ) {
    $team = ''; 
    $team = '<div class="row" id="team">';
      $new = new WP_Query( array( 'post_type' => 'team') );
      if ( $new->have_posts() ) :
        $k=1;
        while ($new->have_posts()) : $new->the_post();
          $post_id = get_the_ID();
          $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium' );
          $url = $thumb['0'];
          $excerpt = tameer_construction_pro_string_limit_words(get_the_excerpt(),5);
          $call = get_post_meta($post_id,'meta-call',true);
          $email = get_post_meta($post_id,'meta-desig',true);
          $facebookurl = get_post_meta($post_id,'meta-facebookurl',true);
          $linkedin = get_post_meta($post_id,'meta-linkdenurl',true);
          $twitter = get_post_meta($post_id,'meta-twitterurl',true);
          $googleplus = get_post_meta($post_id,'meta-googleplusurl',true);
          $team_designation = get_post_meta($post_id,'team_designation',true);
          $team .= '<div class="col-md-4 col-sm-2">
            <div class="box">
            	<div class="image-box-media">';
              		if (has_post_thumbnail()){
               			$team .= '<img src="'.esc_url($url).'">
                      		<div class="team-socialbox-hover">
	                      		<div class="socialbox">';
			                        if($facebookurl != '' || $linkedin != '' || $twitter != '' || $googleplus != ''){?>
			                          <?php if($facebookurl != ''){
			                            $team .= '<a class="" href="'.esc_url($facebookurl).'" target="_blank"><i class="fab fa-facebook-f"></i></a>';
			                           } if($twitter != ''){
			                            $team .= '<a class="" href="'.esc_url($twitter).'" target="_blank"><i class="fab fa-twitter"></i></a>';                          
			                           } if($linkedin != ''){
			                           $team .= ' <a class="" href="'.esc_url($linkedin).'" target="_blank"><i class="fab fa-linkedin-in"></i></a>';
			                          }if($googleplus != ''){
			                            $team .= '<a class="" href="'.esc_url($googleplus).'" target="_blank"><i class="fab fa-google-plus-g"></i></a>';
			                          }
			                        }
			                      $team .= '</div>
	                   		</div>
	                   		<div class="overlay">
	                   			<div class="work_content">
	                   				<div class="teambox-content">
	                   					<h4 class="teamtitle"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h4>
	                   					<h5 class="border_heading">'.esc_html($team_designation).'</h5>
	                   				</div>
	                   			</div>
	                   		</div>   
                	</div>';
              }
            $team .= '</div>
            </div>';
          $k++;         
        endwhile; 
        wp_reset_postdata();
      else :
        $team = '<div id="team" class="team_wrap col-md-3 mt-3 mb-4"><h2 class="center">'.__('Not Found','tameer-construction-pro-posttype').'</h2></div>';
      endif;
    $team .= '</div>';
    return $team;
}
add_shortcode( 'tameer-construction-pro-team', 'tameer_construction_pro_posttype_team_func' );

/*------------------- Testimonial Shortcode -------------------------*/
function tameer_construction_pro_posttype_testimonials_func( $atts ) {
    $testimonial = ''; 
    $testimonial = '<div id="testimonials" class="testimonials_shortcode"><div class="row inner-test-bg">';
      $new = new WP_Query( array( 'post_type' => 'testimonials') );
      if ( $new->have_posts() ) :
        $k=1;
        while ($new->have_posts()) : $new->the_post();
          $post_id = get_the_ID();
          $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium' );
          $url = $thumb['0'];
          $excerpt = tameer_construction_pro_string_limit_words(get_the_excerpt(),20);
          $designation = get_post_meta($post_id,'tameer_construction_pro_posttype_testimonial_desigstory',true);

          $testimonial .= '<div class="col-md-4 mb-4">
                <div class="testimonial_box w-100 mb-3" >
                  <div class="content_box w-100">
                      <div class="short_text"><blockquote>'.$excerpt.'</blockquote></div>
                  </div>
                  <ul class="testimonial_auther">
                    <li class="testimonial-img">';
                        if (has_post_thumbnail()){ 
                       $testimonial .='<img src="'.esc_url($url).'">';
                          } 
                      $testimonial .='</li>
                    <li class="tetsimonial-box">
                      <h4 class="testimonial_name shortcode"><a href="'.get_the_permalink().'"> '.get_the_title().'</a><cite>'.esc_html($designation).'</cite></h4>
                    </li>
                  </ul>
              	</div>
              </div>
              <div class="clearfix"></div>';
          $k++;         
        endwhile; 
        wp_reset_postdata();
      else :
        $testimonial = '<div id="testimonial" class="testimonial_wrap col-md-3 mt-3 mb-4"><h2 class="center">'.__('Not Found','tameer-construction-pro-posttype').'</h2></div>';
      endif;
    $testimonial .= '</div></div>';
    return $testimonial;
}
add_shortcode( 'tameer-construction-pro-testimonials', 'tameer_construction_pro_posttype_testimonials_func' );

/*------------------- Projects Shortcode -------------------------*/
function tameer_construction_pro_posttype_programs_func( $atts ) {
    $programs = ''; 
    $programs = '<section id="projects"><div class="projects_outer row">';
      $new = new WP_Query( array( 'post_type' => 'projects') );
      if ( $new->have_posts() ) :
        $k=1;
        while ($new->have_posts()) : $new->the_post();
          $post_id = get_the_ID();
          $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium' );
          $url = $thumb['0'];
          $excerpt = tameer_construction_pro_string_limit_words(get_the_excerpt(),20);
            $programs .= '<div class="col-lg-4 col-md-4 mb-4"> 
            <div class="projects_box">
              <div class="image-box media">';
                  if (has_post_thumbnail()){ 
                $programs .= '
                   <img class="projects-shortcode" src="'.esc_url($url).'">';
                   } 
            $programs .= '<div class="projects-box-hover-shortcode">
              <div class="projects-box-content">
              <h4 class="shortcode"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h4>
              </div>
            </div>
          </div>
          </div>
          </div>
          <div class="clearfix"></div>';
          $k++;         
        endwhile; 
        wp_reset_postdata();
      else :
        $programs = '<div id="programs" class="col-md-3 mt-3 mb-4"><h2 class="center">'.__('Not Found','tameer-construction-pro-posttype').'</h2></div></div></div>';
      endif;
    $programs .= '</div></section>';
    return $programs;
}
add_shortcode( 'tameer-construction-pro-projects', 'tameer_construction_pro_posttype_programs_func' );
/* Properties shortcode */
function tameer_construction_pro_posttype_properties_func( $atts ) {
  $properties = '';
  $properties = '<section class="row" id="properties">';
  $new = new WP_Query( array( 'post_type' => 'properties') );
    if ( $new->have_posts() ) :
  $k=1;
  while ($new->have_posts()) : $new->the_post();
        $post_id = get_the_ID();
        $excerpt = wp_trim_words(get_the_excerpt(),5);
        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'large' );
        $url = $thumb['0'];
        $sale = get_post_meta($post_id,'sale',true);
        $location = get_post_meta($post_id,'tameer_construction_pro_posttype_properties_location',true);
        $bedrooms = get_post_meta($post_id,'bedrooms',true);
        $garage = get_post_meta($post_id,'garage',true);
        $bathrooms = get_post_meta($post_id,'bathrooms',true);
        $details = get_post_meta($post_id,'details',true);
        $more_details = get_post_meta($post_id,'tameer_construction_pro_properties_more_details',true);
        $price = get_post_meta($post_id,'price',true);
        $area = get_post_meta($post_id,'area',true);
        $i=1;
        $properties .= '
          <div class="col-lg-4 col-md-4 col-sm-6 col-12">
           <div class="properties_shortcode">
          	<div class="box">
          		<div class="image-box media">';
          			  if (has_post_thumbnail()){ 
                $properties .= '<img src="'.esc_url($url).'">';
                   } 
          	   $properties .= '<div class="overlay">
          	   		<div class="row">
          	   			<div class="sale-section col-lg-4 col-md-3 col-sm-5 col-4">
          	   				<div class="sale">
          	   					<p class="sale">'.esc_html($sale).'</p>
          	   				</div>
          	   			</div>
          	   		</div>
                </div>
          	   	<div class="properties-hover">
          	   		<div class="plus-icon">
          	   			<div class="properties-icon">
          	   				<i class="fas fa-plus"></i>
          	   			</div>
          	   		</div>
          	   	</div>
              </div>
            </div>
			<div class="properties_content">
				<h4 class="title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h4>
        <span class="subtitle">'.$excerpt.'</span>
        <div class="property_details">';
          if($area != '' || $bedrooms !='' || $garage !='' || $bathrooms !='' || $details !='' || $more_details || $price != '') {
             $properties .= '<div class="properties_details row">
               <div class="col-lg-6 col-md-6 col-6">';
                if($area != ''){
                $properties .='<p><i class="fas fa-chart-area"></i>'.esc_html($area).'</p>';
                }
                $properties .= ' </div>
               <div class="col-lg-6 col-md-6 col-6">'; 
                if($bedrooms != ''){
                $properties .='<p><i class="fas fa-bed"></i>'.esc_html($bedrooms).'</p>';
                }
                $properties .= ' </div>
               <div class="col-lg-6 col-md-6 col-6">'; 
                if($garage != ''){
                $properties .='<p><i class="fas fa-motorcycle"></i>'.esc_html($garage).'</p>';
                }
               $properties .= ' </div>
               <div class="col-lg-6 col-md-6 col-6">'; 
                 if($bathrooms != ''){
                 $properties .='<p><i class="fas fa-bath"></i>'.esc_html($bathrooms).'</p>';
                 }
                 $properties .= ' </div>
               <div class="more-button col-lg-6 col-md-6 col-6">'; 
                if($details != ''){
                $properties .='<div class="more-div"><a class="more-details">'.esc_html($details).'</a></div>';
                }
                $properties .= ' </div>
               <div class="price-section col-lg-6 col-md-6 col-6">'; 
                 if($price != ''){
                 $properties .='<div class="price-div"><a class="price">'.esc_html($price).'</a></div>';
                 }
                 $properties .= ' </div>

             </div>';
          }

			 $properties .= '</div>
        </div>
       </div>
      </div>';
    if($k%2 == 0){
      $properties.= '<div class="clearfix"></div>';
    }
      $k++;
  endwhile;
  else :
    $properties = '<h2 class="center">'.esc_html__('Post Not Found','tameer_construction_pro_posttype').'</h2>';
  endif;
  $properties .= '</section>';
  return $properties;
}

add_shortcode( 'tameer-construction-pro-properties', 'tameer_construction_pro_posttype_properties_func' );
/* Property Image Gallery */

function ts_gallery_images_metabox_enqueue($hook) {
  if ( 'post.php' === $hook || 'post-new.php' === $hook ) {
    wp_enqueue_script('ts-gallery-images-metabox', plugin_dir_url( __FILE__ ) . '/js/ts-gimg.js', array('jquery', 'jquery-ui-sortable'));
    wp_enqueue_style('ts-gallery-images-metabox', plugin_dir_url( __FILE__ ) . '/css/ts-gimg.css');

    global $post;
    if ( $post ) {
      wp_enqueue_media( array(
          'post' => $post->ID,
        )
      );
    }

  }
}

add_action('admin_enqueue_scripts', 'ts_gallery_images_metabox_enqueue');

function ts_gallery_images_add_gallery_metabox($post_type) {
  $types = array('properties');

  if (in_array($post_type, $types)) {
    add_meta_box(
      'ts-gallery-image-metabox',
      __( 'Gallery Images', 'ts-gallery-images' ),
      'ts_gallery_images_meta_callback',
      $post_type,
      'normal',
      'high'
      );
  }
}

add_action('add_meta_boxes', 'ts_gallery_images_add_gallery_metabox');

function ts_gallery_images_meta_callback( $post ) {
  wp_nonce_field( basename( __FILE__ ), 'ts_gallery_images_meta_nonce' );
  $ids = get_post_meta( $post->ID, 'ts_gallery_images_gal_id', true );

  ?>
  <table class="form-table">
    <tr><td>
    <a class="gallery-add button" href="#" data-uploader-title="<?php esc_attr_e( 'Add image(s) to gallery', 'ts-gallery-images' ); ?>" data-uploader-button-text="<?php esc_attr_e( 'Add image(s)', 'ts-gallery-images' ); ?>"><?php esc_html_e( 'Add image(s)', 'ts-gallery-images' ); ?></a>

    <ul id="ts-gallery-images-item-list">
      <?php if ( $ids ) : foreach ( $ids as $key => $value ) : $image = wp_get_attachment_image_src( $value ); ?>

        <li>
          <input type="hidden" name="ts_gallery_images_gal_id[<?php echo $key; ?>]" value="<?php echo $value; ?>">
          <img class="image-preview" src="<?php echo esc_url( $image[0] ); ?>">
          <a class="change-image button button-small" href="#" data-uploader-title="<?php esc_attr_e( 'Change image', 'ts-gallery-images' ) ; ?>" data-uploader-button-text="<?php esc_attr_e( 'Change image', 'ts-gallery-images' ) ; ?>"><?php esc_html_e( 'Change image', 'ts-gallery-images' ) ; ?></a><br>
          <small><a class="remove-image" href="#"><?php esc_html_e( 'Remove image', 'ts-gallery-images' ) ; ?></a></small>
        </li>

      <?php endforeach;
      endif; ?>
    </ul>

    </td></tr>
  </table>
  <?php
}

function ts_gallery_images_meta_save($post_id) {
  if (!isset($_POST['ts_gallery_images_meta_nonce']) || !wp_verify_nonce($_POST['ts_gallery_images_meta_nonce'], basename(__FILE__))) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  if(isset($_POST['ts_gallery_images_gal_id'])) {
    $sanitized_values = array_map('intval', $_POST['ts_gallery_images_gal_id']);
    update_post_meta($post_id, 'ts_gallery_images_gal_id', $sanitized_values );
  } else {
    delete_post_meta($post_id, 'ts_gallery_images_gal_id');
  }
}
add_action('save_post', 'ts_gallery_images_meta_save');

function ts_gallery_images_get_custom_post_type_template( $single_template ) {
  global $post;
  if ($post->post_type == 'ts_gallery') {
    if ( file_exists( get_template_directory() . '/page-template/gallery.php' ) ) {
      $single_template = get_template_directory() . '/page-template/gallery.php';
    }
  }
  return $single_template;
}

add_filter( 'single_template', 'ts_gallery_images_get_custom_post_type_template' );

function ts_gallery_images_gallery_show($gallery_id) {
  if ( ! $gallery_id ) {
    return;
  }
  $images = get_post_meta($gallery_id, 'ts_gallery_images_gal_id', true);

  $res = '';
  $res ='<div id="property_carousel" class="carousel slide" data-ride="carousel">';
  if(!empty($images)){
    $gal_i=1;
    $first_gal='';
    
    $res .= '<div class="carousel-inner">';
    foreach ($images as $image) {
      global $post;
      if($gal_i == 1){ $first_gal = 'active'; } else { $first_gal = 'notactive'; }
      $thumbnail = wp_get_attachment_link($image, 'medium');
      $full = wp_get_attachment_link($image, 'large');
      $res .= '<div class="gallery-image carousel-item '.$first_gal.' ">
      <div class="ts_gallery view">
        '.$full.'
      </div>
      </div>';
      $gal_i++;
    }
    $res .= '</div>';

    $res .= '</div><a class="carousel-control-prev" href="#property_carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fa fa-angle-left fa-3x" aria-hidden="true"></i></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#property_carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"><i class="fa fa-angle-right fa-3x" aria-hidden="true"></i></span>
            <span class="sr-only">Next</span>
          </a>';

  return $res;
  }
  else { the_post_thumbnail(); }
}