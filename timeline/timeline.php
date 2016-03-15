<?php
/**
 * Plugin Name: Timeline Plugin
 * Plugin URI: 
 * Description: These are the building blocks to a Patient Management
 * Version: 1.0
 * 
 */
require_once 'pmedik-enhanced-image-editor/pmedik.php';

function pm_plugin_activate() {

        create_page_post();
}

register_activation_hook(__FILE__, 'pm_plugin_activate');

register_deactivation_hook(__FILE__, 'pm_plugin_deactivate');

function pm_plugin_deactivate() {
        global $wpdb;

        $p = array(
            'post_type' => 'patient_templates',
            'numberposts' => -1,
        );
		$page = array('post_type' => 'page');
		$del_page = get_posts($page);
		//check the metabox value to delete specific page
		foreach ($del_page as $pg)
		{
			$page_id = intval($pg->ID);
			$meta = get_post_meta($pg->ID,'my_meta_box_select',true);
			if($meta === 'InTimeline')
			{
				$child_post = get_posts(array('post_parent' => $page_id, 'post_type' => 'page'));
				//delete related child posts of the parent
						if (is_array($child_post) && count($child_post) > 0) {

					// Delete all the Children of the Parent Page
					foreach($child_post as $post){

						wp_delete_post($post->ID, true);

					}

				}
				wp_delete_post($page_id);
			}
			if($meta === 'Child')
			{
				$child_post = get_posts(array('post_parent' => $page_id, 'post_type' => 'page'));
				//delete related child posts of the parent
						if (is_array($child_post) && count($child_post) > 0) {

					// Delete all the Children of the Parent Page
					foreach($child_post as $post){

						wp_delete_post($post->ID, true);

					}

				}
				wp_delete_post($page_id);
			}
			else if($meta === 'Plugin')
			{
				$child_post = get_posts(array('post_parent' => $page_id, 'post_type' => 'page'));
				//delete related child posts of the parent
						if (is_array($child_post) && count($child_post) > 0) {

					// Delete all the Children of the Parent Page
					foreach($child_post as $post){

						wp_delete_post($post->ID, true);

					}

				}
				wp_delete_post($page_id);
			}
		}
        $posts = get_posts($p);
        foreach ($posts as $p) {
                $ID = intval($p->ID);
                wp_delete_post($ID);
        }

        $p1 = array(
            'post_type' => 'timeline_page',
            'numberposts' => -1,
        );

        $postsp = get_posts($p1);
        foreach ($postsp as $p) {
                $ID = intval($p->ID);
                wp_delete_post($ID);
        }
        
        $p2 = array(
            'post_type' => 'patient_page',
            'numberposts' => -1,
        );

        $postsp = get_posts($p2);
        foreach ($postsp as $p) {
                $ID = intval($p->ID);
                wp_delete_post($ID);
        }
        
}
function p_register_post_type() {
        $labels = array(
            'name' => _x('Patient Pages', 'post type general name', 'patient_management'),
            'singular_name' => _x('Patient Pages', 'post type singular name', 'patient_management'),
            'menu_name' => _x('Patient Pages', 'admin menu', 'patient_management'),
            'name_admin_bar' => _x('Patient Pages', 'add new on admin bar', 'patient_management'),
            'add_new' => _x('Add New', 'Patient pages', 'patient_management'),
            'add_new_item' => __('Add New Patient Page', 'patient_management'),
            'new_item' => __('New Patient Page', 'patient_management'),
            'edit_item' => __('Edit Patient Page', 'patient_management'),
            'view_item' => __('View Patient Page', 'patient_management'),
            'all_items' => __('All Patient Pages', 'patient_management'),
            'search_items' => __('Search Patient Page', 'patient_management'),
            'parent_item_colon' => __('Parent Patient Pages:', 'patient_management'),
            'not_found' => __('No Patient Pages found.', 'patient_management'),
            'not_found_in_trash' => __('No Patient Pages found in Trash.', 'patient_management')
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'exclude_from_search' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'patient_page'),
            'capability_type' => 'post',
            'has_archive' => true,
            'menu_position' => null,
            //'taxonomies' => array('patient_category'),
            'hierarchical' => true,
            'show_in_nav_menus' => false,
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'page-attributes','custom-fields')
        );

        register_post_type('patient_page', $args);
}

function pm_register_post_type() {
        $labels = array(
            'name' => _x('Timeline Pages', 'post type general name', 'patient_management'),
            'singular_name' => _x('Timeline Pages', 'post type singular name', 'patient_management'),
            'menu_name' => _x('Timeline Pages', 'admin menu', 'patient_management'),
            'name_admin_bar' => _x('Timeline Pages', 'add new on admin bar', 'patient_management'),
            'add_new' => _x('Add New', 'Patient pages', 'patient_management'),
            'add_new_item' => __('Add New Timeline Page', 'patient_management'),
            'new_item' => __('New Timeline Page', 'patient_management'),
            'edit_item' => __('Edit Timeline Page', 'patient_management'),
            'view_item' => __('View Timeline Page', 'patient_management'),
            'all_items' => __('All Timeline Pages', 'patient_management'),
            'search_items' => __('Search Timeline Page', 'patient_management'),
            'parent_item_colon' => __('Parent Timeline Pages:', 'patient_management'),
            'not_found' => __('No Timeline Pages found.', 'patient_management'),
            'not_found_in_trash' => __('No Timeline Pages found in Trash.', 'patient_management')
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'exclude_from_search' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'timeline'),
            'capability_type' => 'post',
            'has_archive' => true,
            'menu_position' => null,
            //'taxonomies' => array('patient_category'),
            'hierarchical' => true,
            'show_in_nav_menus' => false,
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'page-attributes','custom-fields')
        );

        register_post_type('timeline_page', $args);

        $tlabels = array(
            'name' => _x('Patient Categories', 'taxonomy general name'),
            'singular_name' => _x('Patient Category', 'taxonomy singular name'),
            'search_items' => __('Search Patient Categories'),
            'all_items' => __('All Patient Categories'),
            'parent_item' => __('Parent Patient Category'),
            'parent_item_colon' => __('Parent Patient Category:'),
            'edit_item' => __('Edit Patient Category'),
            'update_item' => __('Update Patient Category'),
            'add_new_item' => __('Add New Patient Category'),
            'new_item_name' => __('New Patient Category'),
            'menu_name' => __('Patient Categories'),
        );
        $targs = array(
            'labels' => $tlabels,
            'hierarchical' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'patient_category')
        );
        $type = array('timeline_page', 'patient_page');
        register_taxonomy('patient_category', $type, $targs);

        $targs = array(
            'label' => __('Patient Templates', 'patient_management'),
            'labels' => array(
                'singular_name' => __('Patient Templates', 'patient_management'),
                'add_new_item' => __('Add New Patient Template', 'patient_management'),
                'edit_item' => __('Edit Patient Template', 'patient_management'),
                'add_new' => __('Add New', 'patient_management'),
                'new_item' => __('New Patient Template', 'patient_management'),
                'view_item' => __('View Patient Template', 'patient_management'),
                'not_found' => __('No Patient templatess found.', 'patient_management'),
                'not_found_in_trash' => __(
                        'No Patient templates found in Trash.', 'patient_management'
                ),
                'search_items' => __('Search Patient Templates', 'patient_management'),
            ),
            'public' => true,
            'menu_icon' => 'dashicons-edit',
            'publicly_queryable' => true,
            'exclude_from_search' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'capability_type' => 'post',
            'hierarchical' => true,
            'menu_position' => null,
            'rewrite' => array('slug' => 'patient_templates'),
            'supports' => array(
                'title',
                'editor',
                'revisions',
                'author',
                'thumbnail',
                'post-formats',
                'page-attributes',
                'custom-fields'
            )
        );
        register_post_type('patient_templates', $targs);
}

add_action('init', 'pm_register_post_type');
add_action('init', 'p_register_post_type');

function timeline_meta(){
	
	add_meta_box( 'my-meta-box-id', 'Select type', 'cb_timeline', 'page', 'normal', 'low' );
}
function cb_timeline(){
	
	 global $post;
	 wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
	$values = get_post_meta( $post->ID,'my_meta_box_select',true );
	?>
		<label for="my_meta_box_selectq">Type</label>
        <select name="my_meta_box_select" id="my_meta_box_select">
            <option value="Normal" <?php if($values == 'Normal'){ echo "selected";} ?> post_id="<?php print_r($text); ?>">Normal</option>
            <option value="Plugin" <?php if($values == 'Plugin'){ echo "selected";} ?> post_id="<?php print_r($text); ?>">Plugin</option>
            <option value="InTimeline" <?php if($values == 'InTimeline'){ echo "selected";} ?> post_id="<?php print_r($text); ?>">InTimeline</option>
            <option value="Child" <?php if($values == 'Child'){ echo "selected";} ?> post_id="<?php print_r($text); ?>">Child</option>
        </select>
        <?php
       
}

add_action( 'add_meta_boxes', 'timeline_meta' );


function cb_timeline_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
     
    // now we can actually save the data
   // $allowed = sanitize_text_field( $_POST['tech'] );
     
    // Make sure your data is set before trying to save it
   
    if( isset( $_POST['my_meta_box_select'] ) )
        update_post_meta( $post_id, 'my_meta_box_select', esc_attr( $_POST['my_meta_box_select'] ) );
         
    
}
add_action( 'save_post', 'cb_timeline_save' );



function create_page_post() {
        pm_register_post_type();
		p_register_post_type();
        $my_cat = array('cat_ID' => 0, 'cat_name' => 'Timeline Default', 'category_description' => 'A Timeline Default Category of Patien page', 'taxonomy' => 'patient_category', 'category_nicename' => '', 'category_parent' => '');

        // Create the category
        wp_insert_category($my_cat);
        $parent_term = term_exists('Timeline Default', 'patient_category'); // array is returned if taxonomy is given
        $term_id = $parent_term['term_id']; // get numeric term id
        // Create post object
        $timeline_array = array('timeline' => 'Timeline');
        $p_array = array('reseach' => 'Reseach', 'consultation' => 'Consultation', 'pre_op' => 'Pre-Op', 'surgery' => 'Surgery', 'post_op_visit' => 'Post Op Visit');
		$i = 1;
        foreach ($timeline_array as $k => $v) {

                $my_post = array(
                    'comment_status' => 'closed',
                    'ping_status' => 'closed',
                    'post_author' => 1,
                    'post_name' => $k,
                    'post_title' => $v,
                    'post_status' => 'publish',
                    'post_type' => 'timeline_page',
                    'menu_order' => $i
                        //'tax_input'=>array($term_id)
                );

				$i++;
                // Insert the post into the database
                $pid = wp_insert_post($my_post);

                wp_set_post_terms($pid, array($term_id), 'patient_category');
        }
		$j=1;
		foreach ($p_array as $k1 => $v1) {

                $my_post1 = array(
                    'comment_status' => 'closed',
                    'ping_status' => 'closed',
                    'post_author' => 1,
                    'post_name' => $k1,
                    'post_title' => $v1,
                    'post_status' => 'publish',
                    'post_type' => 'patient_page',
                    'menu_order' => $j
                        //'tax_input'=>array($term_id)
                );

				$j++;
                // Insert the post into the database
                $pid1 = wp_insert_post($my_post1);

                wp_set_post_terms($pid1, array($term_id), 'patient_category');
        }
        $ptemp_arr = array(
			array('name' => 'new-link',
                'title' => ' Link to Existing Page',
                'show_in_timeline' => 0,
                'row_pos'=>1,
                'content' => "<div>
                               
                                </div>"	),
			array('name' => 'no-content-title-only',
						'title' => ' Title Only',
						'show_in_timeline' => 0,
						'row_pos'=>1,
						'content' => "<div>
						
						</div>"),
            array('name' => 'video-without-content',
                'title' => 'Video without content',
                'show_in_timeline' => 1,
                'row_pos'=>3,
                'content' => '<style>
    [contentEditable=true]:empty:not(:focus):before{
        content:attr(data-ph)
    }
</style>
                <div style="padding: 5px; text-align: center;">
<div>Enter Heading here</div>
<div style="display: inline-block; padding: 5px;">
<div class="upload_video" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/video-without-content.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/video-without-content.jpg", __FILE__) . '); background-size: cover;"></div>
<div>Caption</div>
</div>
</div>'),
            array('name' => 'video-with-content',
                'title' => 'Video with content',
                'show_in_timeline' => 0,
                'row_pos'=>2,
                'content' => '<style>
    [contentEditable=true]:empty:not(:focus):before{
        content:attr(data-ph)
    }
</style><div style="padding: 5px;">
    <div style="width:80%;display: inline-block;">
        <h2><div>Title</div></h2>
        <div><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>
            <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>
            <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p></div>
    </div>
    <div style="display: inline-block;padding: 5px;">
        <div>Enter Heading here</div>
        <div class="upload_video" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/video-without-content.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/video-without-content.jpg", __FILE__) . '); background-size: cover;"></div>
        <div>Caption</div>
    </div>
</div>'),
            array('name' => 'text-only',
                'title' => ' Text only',
                'show_in_timeline' => 0,
                'row_pos'=>2,
                'content' => "<div>
                                <p>
                                <strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                </p>
                                <p>
                                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                </p>
                                </div>"),
           array('name' => 'images-with-content1',
                'title' => ' Images with content1',
                'show_in_timeline' => 0,
                'row_pos'=>2,
                'content' => '<style>
    [contentEditable=true]:empty:not(:focus):before{
        content:attr(data-ph)
    }
</style><div style="padding: 5px;">
                                <div style="width: 70%; display: inline-block;">
                                <div>
                                <h1><div>Title</div></h1>
                                <h2><div>Sub Title</div></h2>
                                </div>
                                <div>

                                Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

                                The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.

                                The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.

                                </div>
                                </div>
                                <div style="display: inline-block; padding: 5px;">
                                <div>Enter Heading here</div>
                                <div class="upload_img" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;"></div>
                                <div>Caption</div>
                                </div></div>'
                ),
            array('name' => 'images-with-content2',
                'title' => ' Images with content2',
                'show_in_timeline' => 0,
                'row_pos'=>2,
                'content' => '<style>
    [contentEditable=true]:empty:not(:focus):before{
        content:attr(data-ph)
    }
</style><div style="padding: 5px;"><div>
                                <div>
                                <h2><div>Title</div></h2>
                                </div>
                                <div>

                                Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

                                The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.

                                The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.

                                </div>
                                <div class="upload_img" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;"></div>
                                <div>Caption</div>
                                </div></div>'
                ),
            array('name' => 'images-with-content3',
                'title' => ' Images with content3',
                'show_in_timeline' => 0,
                'row_pos'=>2,
                'content' => '<style>
[contentEditable=true]:empty:not(:focus):before{
content:attr(data-ph)
}
</style><div style="padding: 5px;">
<div style="text-align: center;">
<div >Enter Heading Here</div>
<div >Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</div>
<div style="display: inline-block; padding: 5px;">

<div class="upload_img" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;"></div>
<div contentEditable=true data-ph="Caption"></div>
</div>
<div style="display: inline-block; padding: 5px;">
<div class="upload_img" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;"></div>   
<div contentEditable=true data-ph="Caption"></div>
</div>
<div contentEditable=true data-ph="Caption"></div>
</div>
</div>'
                ),
                 /*
            array('name' => 'images-with-content',
                'title' => ' Images with content',
                'show_in_timeline' => 0,
                'content' => '<div style="padding: 5px;">
                                <div style="width: 70%; display: inline-block;">
                                <div>
                                <h1>Title</h1>
                                <h2>Sub Title</h2>
                                </div>
                                <div>

                                Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

                                The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.

                                The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.

                                </div>
                                </div>
                                <div style="display: inline-block; padding: 5px;">
                                <div>Enter heading here</div>
                                <div class="upload_img" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;"></div>
                                <div>Caption</div>
                                </div>
                                <div>
                                <div>
                                <h2>Title</h2>
                                </div>
                                <div class="upload_img" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;"></div>
                                <div>Caption</div>
                                </div>
                                <div style="text-align: center;">
                                <div>Enter heading here</div>
                                <div style="display: inline-block; padding: 5px;">
                                <div class="upload_img" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;"></div>
                                <div>Caption</div>
                                </div>
                                <div style="display: inline-block; padding: 5px;">
                                <div class="upload_img" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;"></div>
                                <div>Caption</div>
                                </div>
                                <div>Caption</div>
                                </div>
                        </div>'),
                        */
            array('name' => '1-image',
                'title' => '1 Image',
                'show_in_timeline' => 1,
                'row_pos'=>3,
                'content' => '<style>
    [contentEditable=true]:empty:not(:focus):before{
        content:attr(data-ph)
    }
</style><div style="padding: 5px; text-align: center;">
                                <div>Enter Heading here</div>
                                <div style="display: inline-block; padding: 5px;">
                                <div class="upload_img" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;"></div>
                                </div>
                                <div>Caption</div>
                                </div>'),
            array('name' => '2-image',
                'title' => '2 Image',
                'show_in_timeline' => 1,
                'row_pos'=>3,
                'content' => '<style>
    [contentEditable=true]:empty:not(:focus):before{
        content:attr(data-ph)
    }
</style><div style="padding: 5px; text-align: center;">
                        <div>Enter Heading here</div>
                        <div style="display: inline-block; padding: 5px;">
                        <div class="upload_img" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;"></div>
                        <div>Caption</div>
                        </div>
                        <div style="display: inline-block; padding: 5px;">
                        <div class="upload_img" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;"></div>
                        <div>Caption</div>
                        </div>
                        <div>Caption for all image</div>
                        </div>'),
            array('name' => '3-image',
                'title' => '3 Image',
                'row_pos'=>2,
                'show_in_timeline' => 1,
                'content' => '<style>
    [contentEditable=true]:empty:not(:focus):before{
        content:attr(data-ph)
    }
</style><div style="padding: 5px; text-align: center;">
                                <div>Enter Heading here</div>
                                <div style="display: inline-block; padding: 5px;">
                                <div class="upload_img" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;"></div>
                                <div>Caption</div>
                                </div>
                                <div style="display: inline-block; padding: 5px;">
                                <div class="upload_img" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;"></div>
                                <div>Caption</div>
                                </div>
                                <div style="display: inline-block; padding: 5px;">
                                <div class="upload_img" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;"></div>
                                <div>Caption</div>
                                </div>
                                <div>Caption for all image</div>
                                </div>'),
            array('name' => 'before-and-after',
                'title' => 'Before and after',
                'show_in_timeline' => 0,
                'row_pos'=>2,
                'content' => '<style>
    [contentEditable=true]:empty:not(:focus):before{
        content:attr(data-ph)
    }
</style><div style="padding: 5px; text-align: center;"><div id="carousel-example-generic" class="carousel slide" data-ride="carousel"><div class="carousel-inner" role="listbox"><div class="item active">
            <div class="img_outr" style="display: inline-block; padding: 1%;">
                <div class="upload_img" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;"></div>
                <div class="carousel-caption">
                    Before
                </div>
            </div>
            <div class="img_outr" style="display: inline-block; padding: 1%;">
                <div class="upload_img" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;"></div>
                <div class="carousel-caption">
                    After
                </div>
            </div>
        </div>
        <div class="item">
            <div class="img_outr" style="display: inline-block; padding: 1%;">
                <div class="upload_img" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;"></div>
                <div class="carousel-caption">
                    Before
                </div>
            </div>
            <div class="img_outr" style="display: inline-block; padding: 1%;">
                <div class="upload_img" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;"></div>
                <div class="carousel-caption">
                    After
                </div>
            </div>
        </div>
        <div class="item">
            <div class="img_outr" style="display: inline-block; padding: 1%;">
                <div class="upload_img" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;"></div>
                <div class="carousel-caption">
                    Before
                </div>
            </div>
            <div class="img_outr" style="display: inline-block; padding: 1%;">
                <div class="upload_img" style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;" data-style="height: 200px; width: 200px; background-image:url(' . plugins_url("images/1-image.jpg", __FILE__) . '); background-size: cover;"></div>
                <div class="carousel-caption">
                    After
                </div>
            </div>
        </div>
    </div>
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span><span class="sr-only">Previous</span></a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="sr-only">Next</span></a></div></div>'),
array('name' => 'steps-to-creating-template',
                'title' => 'Steps to creating a page',
                'show_in_timeline' => 0,
                'row_pos'=>2,
                'show_in_second_row'=>'yes',
                'content' => '<style>
    [contentEditable=true]:empty:not(:focus):before{
        content:attr(data-ph)
    }
</style>
<p style="text-align: center;">Click on the template tab in top right corner</p>
<img class="size-medium wp-image-1004 aligncenter" src="'. plugins_url("images/Screenshot1.png", __FILE__) .'" alt="Screenshot1" width="300" height="99" />
<p style="text-align: center;">Select the template you want to use</p>
<img class="alignnone size-medium wp-image-1005 aligncenter" src="'. plugins_url("images/Screenshot2.png", __FILE__) .'" alt="Screenshot2" width="300" height="283" />
<p style="text-align: center;">After selection, click replace existing content</p>'),
        );
		$cnt = 0;
        foreach ($ptemp_arr as $k => $v) {

                $my_post = array(
                    'comment_status' => 'closed',
                    'ping_status' => 'closed',
                    'post_author' => 1,
                    'post_name' => $v['name'],
                    'post_title' => $v['title'],
                    'post_content' => $v['content'],
                    'post_status' => 'publish',
                    'post_type' => 'patient_templates',
                    'menu_order' => $cnt
                );
				$cnt++;
                // Insert the post into the database
                $pid = wp_insert_post($my_post);
                update_post_meta($pid,'pt_thumbnails',plugins_url('/images/' . $v['name'] . '.jpg', __FILE__));
                if(isset($v['json_draft']) && !empty($v['json_draft']))
                {
					
             //   update_post_meta($pid,'_fl_builder_draft',$v['json_draft']);
				}
                
				// Insert the post into the database
                if($v['name'] == "new-link")
                {
					update_post_meta($pid, 'new-link', "1");
				}
				if($v['name']  == "no-content-title-only")
				{
					update_post_meta($pid, 'no-content-title-only', "1");
				}
                if(isset($v['show_in_second_row']) && !empty($v['show_in_second_row']))
                {
                    update_post_meta($pid, 'show_in_second_row', $v['show_in_second_row']);
                }
                update_post_meta($pid, 'show_in_timeline', $v['show_in_timeline']);
                update_post_meta($pid, 'row_pos', $v['row_pos']);
        }
}

add_action('init', 'pm_template_enqueue_scripts');

function pm_template_enqueue_scripts() {

        wp_enqueue_script(
                'tinymce-templates', plugins_url('js/tinymce-templates.js', __FILE__), array('jquery'), filemtime(dirname(__FILE__) . '/js/tinymce-templates.js'), true
        );
        wp_enqueue_style(
                'tinymce-templates', plugins_url('css/tinymce-templates.css', __FILE__), array(), filemtime(dirname(__FILE__) . '/css/tinymce-templates.css')
        );
        wp_enqueue_script(
                'bootstrap.min', plugins_url('js/bootstrap.min.js', __FILE__), array('jquery'), filemtime(dirname(__FILE__) . '/js/bootstrap.min.js'), true
        );
        wp_enqueue_style(
                'bootstrap.min', plugins_url('css/bootstrap.min.css', __FILE__), array(), filemtime(dirname(__FILE__) . '/css/bootstrap.min.css')
        );
        // enque horizontal scrolling
        wp_enqueue_style(
                'horizontalcss', plugins_url('css/jquery.horizontal.scroll.css', __FILE__), array(), filemtime(dirname(__FILE__) . '/css/jquery.horizontal.scroll.css')
        );
        
      //  wp_enqueue_script('tinymce_saved', 'cdn.tinymce.com/4/tinymce.min.js');
       wp_enqueue_style('custom_styles', plugins_url('css/cus_styles.css', __FILE__));
        wp_enqueue_style('cu_beaver_1',plugins_url('css/font-awesome.min.css', __FILE__));
        wp_enqueue_style('cu_beaver_2',plugins_url('css/foundation-icons.css', __FILE__));
        wp_enqueue_style('cu_beaver_3',plugins_url('css/fl-slideshow.css', __FILE__));
        wp_enqueue_style('cu_beaver_4',plugins_url('css/jquery.bxslider.css', __FILE__));
        wp_enqueue_style('cu_beaver_5',plugins_url('css/jquery.magnificpopup.css', __FILE__));
        /***** *****/
        
       // wp_enqueue_script('cu_beave_script_121',plugins_url('js/fl-builder-layout.js', __FILE__));
        wp_enqueue_script('yui3', 'http://yui.yahooapis.com/3.5.1/build/yui/yui-min.js');
        wp_enqueue_script('cu_beave_script_1',plugins_url('js/fl-slideshow.js', __FILE__));
        wp_enqueue_script('cu_beave_script_2',plugins_url('js/fl-gallery-grid.js', __FILE__));
        
        //wp_enqueue_script('cu_migrate',plugins_url('js/jquery.migrate.min.js', __FILE__));
      
      //  wp_enqueue_script('cu_beave_script_12',plugins_url('js/jquery.frontend.js', __FILE__));
        wp_enqueue_script('cu_beave_script_3',plugins_url('js/jquery.bxslider.min.js', __FILE__));
        wp_enqueue_script('cu_beave_script_4',plugins_url('js/jquery.easing.1.3.js', __FILE__));
        wp_enqueue_script('cu_beave_script_5',plugins_url('js/jquery.fitvids.js', __FILE__));
        wp_enqueue_script('cu_beave_script_6',plugins_url('js/jquery.imagesloaded.js', __FILE__));
        wp_enqueue_script('cu_beave_script_7',plugins_url('js/jquery.infinitescroll.js', __FILE__));
        wp_enqueue_script('cu_beave_script_8',plugins_url('js/jquery.magnificpopup.min.js', __FILE__));
        wp_enqueue_script('cu_beave_script_9',plugins_url('js/jquery.mosaicflow.min.js', __FILE__));
        wp_enqueue_script('cu_beave_script_10',plugins_url('js/jquery.waypoints.min.js', __FILE__));
        wp_enqueue_script('cu_beave_script_11',plugins_url('js/jquery.wookmark.min.js', __FILE__));
        
        
}

add_action('wp_footer', 'footer_hook');

function footer_hook() {
        if (get_post_type() === 'patient_templates') {
                remove_meta_box('slugdiv', 'patient_templates', 'normal');
                echo '<style>#visibility{display:none;} #message a{display: none;}</style>';

                /**
                 * Add editor style to the editor.
                 */
                $ver = filemtime(dirname(__FILE__) . '/css/editor-style.css');
                $editor_style = plugins_url('css/editor-style.css?ver=' . $ver, __FILE__);
                add_editor_style($editor_style);
        }

        global $content_width;

        if (isset($content_width) && intval($content_width)) {
                /**
                 * I want to set same width to preview with $content_width
                 */
                echo '<style type="text/css">';
                $preview_width = $content_width + 40; // should be same with padding * 2
                echo '#tinymce-templates-preview{ max-width: ' . $preview_width . 'px; }';
                $wrap_width = $content_width + 80; // should be same with padding * 4
                echo '#tinymce-templates-wrap{ max-width: ' . $wrap_width . 'px; }';
                echo '</style>';
        }
}

add_action('admin_head-post-new.php', 'admin_head');
add_action('admin_head-post.php', 'admin_head');

/**
 * Fires on admin_head-post.php or admin_head-post-new.php hook.
 *
 * @param  none
 * @return none
 */
function admin_head() {
        /**
         * Hide some stuff in the templates editor panel.
         */
        if (get_post_type() === 'patient_templates') {
                remove_meta_box('slugdiv', 'patient_templates', 'normal');
                echo '<style>#visibility{display:none;} #message a{display: none;}</style>';

                /**
                 * Add editor style to the editor.
                 */
                $ver = filemtime(dirname(__FILE__) . '/css/editor-style.css');
                $editor_style = plugins_url('css/editor-style.css?ver=' . $ver, __FILE__);
                add_editor_style($editor_style);
        }

        global $content_width;

        if (isset($content_width) && intval($content_width)) {
                /**
                 * I want to set same width to preview with $content_width
                 */
                echo '<style type="text/css">';
                $preview_width = $content_width + 40; // should be same with padding * 2
                echo '#tinymce-templates-preview{ max-width: ' . $preview_width . 'px; }';
                $wrap_width = $content_width + 80; // should be same with padding * 4
                echo '#tinymce-templates-wrap{ max-width: ' . $wrap_width . 'px; }';
                echo '</style>';
        }
}

add_action('admin_footer-post-new.php', 'admin_footer');
add_action('admin_footer-post.php', 'admin_footer');

/**
 * Generate javascript for the copying to the template.
 *
 * @param  none
 * @return none
 */
function admin_footer() {
        global $hook_suffix;
        if ('post-new.php' === $hook_suffix) {
                if (get_post_type() === 'patient_templates') {
                        if (isset($_GET['origin']) && intval($_GET['origin'])) {
                                $origin = get_post(intval($_GET['origin']));
                                if ($origin) {
                                        $template = array(
                                            'post_title' => $origin->post_title,
                                            'post_content' => wpautop($origin->post_content),
                                        );
                                        ?>
                                        <script type="text/javascript">
                                                var origin = <?php echo json_encode($template); ?>;
                                                jQuery('#title').val(origin.post_title);
                                                jQuery('#content').val(origin.post_content);
                                        </script>
                                        <?php
                                }
                        }
                }
        }
        ?>
        <div id="tinymce-templates-backdrop" style="desplay: none;"></div>
        <div id="tinymce-templates-wrap" class="wp-core-ui search-panel-visible" style="desplay: none;">
            <div class="modal">
                <div class="header">
                    <h1><span class="dashicons dashicons-edit"></span> <?php _e('Insert Template', 'tinymce_templates'); ?></h1>
                    <a href="#" class="close"><span class="dashicons dashicons-no-alt"></span></a>
                </div>
                <div class="container">
                    <select id="tinymce-templates-list"></select>
                    <iframe id="tinymce-templates-preview"></iframe>
                </div>
                <div class="footer">
                    <div id="tinymce-templates-message"><?php _e('Note: The template will be inserted as shortcode.', 'tinymce_templates'); ?></div>
                    <a href="#" id="tinymce-templates-insert" class="button button-primary button-large template-button-insert" disabled><?php _e('Insert Template', 'tinymce_templates'); ?></a>
                </div>
            </div>
        </div>
        <?php
        $url = admin_url('admin-ajax.php');
        $nonce = wp_create_nonce('pm_templates');

        $args = array(
            'action' => 'pm_templates',
            'nonce' => $nonce,
        );
        ?>
        <script type="text/javascript">
                var tinymce_templates_list_uri = '<?php echo $url; ?>';
                var tinymce_templates_list_args = <?php echo json_encode($args); ?>;
        </script>
        <?php
}

add_action('wp_head', 'pm_enqueue_scripts');

function pm_enqueue_scripts() {

        wp_enqueue_media();

        wp_enqueue_script(
                'jquery-ui', '//code.jquery.com/ui/1.11.4/jquery-ui.js', array('jquery'), true
        );
        wp_enqueue_script(
                'jquery.ui-contextmenu', '//cdn.jsdelivr.net/jquery.ui-contextmenu/1.8.2/jquery.ui-contextmenu.min.js', array('jquery'), true
        );
//        wp_enqueue_script(
//                'jquery.ui-smoothness', '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css', array('jquery'), true
//        );

		// enque script fro scrolling
		
        wp_enqueue_script(
                'jquery.horizontal.scroll.js', plugins_url('js/jquery.horizontal.scroll.js', __FILE__), array('jquery'), filemtime(dirname(__FILE__) . '/js/jquery.horizontal.scroll.js'), true
        );
		
        wp_enqueue_script(
                'patient-pages', plugins_url('js/patient-pages.js', __FILE__), array('jquery'), filemtime(dirname(__FILE__) . '/js/patient-pages.js'), true
        );
        wp_enqueue_script(
                'jquery.fancytree', plugins_url('js/jquery.fancytree.js', __FILE__), array('jquery'), filemtime(dirname(__FILE__) . '/js/jquery.fancytree.js'), true
        );

        wp_enqueue_script(
                'jquery.fancytree-dnd', plugins_url('js/jquery.fancytree.dnd.js', __FILE__), array('jquery'), filemtime(dirname(__FILE__) . '/js/jquery.fancytree.dnd.js'), true
        );
        wp_enqueue_script(
                'jquery.fancytree-edit', plugins_url('js/jquery.fancytree.edit.js', __FILE__), array('jquery'), filemtime(dirname(__FILE__) . '/js/jquery.fancytree.edit.js'), true
        );
        wp_enqueue_script(
                'jquery.sample', plugins_url('js/sample.js', __FILE__), array('jquery'), filemtime(dirname(__FILE__) . '/js/sample.js'), true
        );
        wp_enqueue_script(
                'jquery.fancytree.gridnav', plugins_url('js/jquery.fancytree.gridnav.js', __FILE__), array('jquery'), filemtime(dirname(__FILE__) . '/js/jquery.fancytree.gridnav.js'), true
        );
        wp_enqueue_script(
                'jquery.fancytree.table', plugins_url('js/jquery.fancytree.table.js', __FILE__), array('jquery'), filemtime(dirname(__FILE__) . '/js/jquery.fancytree.table.js'), true
        );

        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('jcrop');
        wp_enqueue_style('jcrop');
        /* wp_enqueue_script(
          'pm_fancy_nodes', plugins_url('js/pm_fancy_nodes.js', __FILE__), array('jquery'), filemtime(dirname(__FILE__) . '/js/pm_fancy_nodes.js'), true
          ); */

        wp_enqueue_style(
                'patient-pages', plugins_url('css/patient-pages.css', __FILE__), array(), filemtime(dirname(__FILE__) . '/css/patient-pages.css')
        );
        wp_enqueue_style(
                'ui.fancytree', plugins_url('css/skin-win7/ui.fancytree.css', __FILE__), array(), filemtime(dirname(__FILE__) . '/css/skin-win7/ui.fancytree.css')
        );
        wp_enqueue_style(
                'sample', plugins_url('css/sample.css', __FILE__), array(), filemtime(dirname(__FILE__) . '/css/sample.css')
        );
        wp_enqueue_style(
                'jquery-ui', '//code.jquery.com/ui/1.11.1/themes/start/jquery-ui.css'
        );
        wp_enqueue_style('thickbox');
}

//add_action('media_buttons', 'pm_media_buttons', 11);

/**
 * Fires on media_buttons hook
 *
 * @param  none
 * @return none
 */
function pm_media_buttons($editor_id = 'content') {
        wp_enqueue_media();
        wp_enqueue_script('image-edit');
        wp_enqueue_script('imgareaselect');
        wp_enqueue_style('imgareaselect');
        //if ( 'content' === $editor_id ) {
        $button_html = '<a id="%s" class="%s" href="#" data-editor="%s" title="%s">';
        $button_html .= '<span class="%s" style="%s"></span> %s';
        $button_html .= '</a>';
        printf(
                $button_html, 'button-tinymce-templates', 'button', esc_attr($editor_id), esc_attr(__('Insert Template', 'pm_templates')), 'dashicons dashicons-edit', 'margin-top: 3px;', esc_html(__('Insert Template', 'pm_templates'))
        );
        //}
}

add_filter('tinymce_templates_content', 'wptexturize');
add_filter('tinymce_templates_content', 'convert_smilies');
add_filter('tinymce_templates_content', 'convert_chars');
add_filter('tinymce_templates_content', 'wpautop');
add_filter('tinymce_templates_content', 'shortcode_unautop');
add_filter('tinymce_templates_content', 'prepend_attachment');
add_filter('tinymce_templates_content', 'do_shortcode', 11);
add_filter('tinymce_templates_content', array($GLOBALS['wp_embed'], 'run_shortcode'), 8);
add_filter('tinymce_templates_content', array($GLOBALS['wp_embed'], 'autoembed'), 8);

add_filter('tinymce_templates_preview', 'wptexturize');
add_filter('tinymce_templates_preview', 'convert_smilies');
add_filter('tinymce_templates_preview', 'convert_chars');
add_filter('tinymce_templates_preview', 'wpautop');
add_filter('tinymce_templates_preview', 'shortcode_unautop');
add_filter('tinymce_templates_preview', 'prepend_attachment');
add_filter('tinymce_templates_preview', 'do_shortcode', 11);

add_action('wp_ajax_pm_tree_get', 'wp_ajax_pm_tree_get');
add_action('wp_ajax_nopriv_pm_tree_get', 'wp_ajax_pm_tree_get');

function wp_ajax_pm_tree_get() {
        $id = $_REQUEST['id'];
        if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'pm_tree_get_' . $id)) {
                return;
        }

        $key_pm_tree = get_post_meta($id, 'pm_tree', true);

		//print_r($key_pm_tree);

        if (!empty($key_pm_tree)) {
                remove_key($key_pm_tree);
        } else {
                $key_pm_tree[] = array('title' => 'New', "expanded" => true);
        }
        echo json_encode($key_pm_tree);
        exit;
}

function remove_key(&$a) {
        if (is_array($a)) {
                unset($a['key']);
                array_walk($a, __FUNCTION__);
        }
}

add_action('wp_ajax_pm_tree', 'wp_ajax_pm_tree');

function wp_ajax_pm_tree() {
        $tr = file_get_contents("php://input");
        $json = json_decode($tr, true);

        if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'pm_trees')) {
                return;
        }

        $id = $_REQUEST['id'];
        $tree = $json[0];
        //print_r($tree);
        $key_pm_tree = get_post_meta($id, 'pm_tree');
        // check if the custom field has a value
        if (!empty($key_pm_tree)) {
                update_post_meta($id, 'pm_tree', $json);
        } else {
                add_post_meta($id, 'pm_tree', $json);
        }
        echo json_encode($tree);
        exit;
}

add_action('wp_ajax_pm_templates', 'wp_ajax_pm_templates');

/**
 * Output json of the templates.
 *
 * @param  none
 * @return none
 */
function wp_ajax_pm_templates() {
        nocache_headers();

        if (!isset($_GET['nonce']) || !wp_verify_nonce($_GET['nonce'], 'pm_templates')) {
                return;
        }

        header('Content-Type: application/javascript; charset=UTF-8');

        $templates = get_templates();

        echo json_encode($templates);
        exit;
}

function get_templates() {
        $p = array(
            'post_status' => 'publish',
            'post_type' => 'patient_templates',
            'orderby' => 'date',
            'order' => 'DESC',
            'numberposts' => -1,
        );

        $posts = get_posts($p);

        $templates = array();

        foreach ($posts as $p) {
                $ID = intval($p->ID);
                $name = esc_html(apply_filters('tinymce_template_title', $p->post_title));
                $desc = esc_html(apply_filters('tinymce_template_excerpt', $p->post_excerpt));
                $templates[$ID] = array(
                    'title' => $name,
                    'is_shortcode' => get_post_meta($ID, 'insert_as_shortcode', true),
                    'content' => $p->post_content,
                );
        }

        $templates = apply_filters('tinymce_templates_post_objects', $templates);

        if (isset($_GET['template_id']) && $_GET['template_id']) {
			echo "<h1>template id</h1> :".$_GET['template_id'];
                if (isset($templates[$_GET['template_id']]) && $templates[$_GET['template_id']]) {
                        $p = $templates[$_GET['template_id']];
                        $content = apply_filters(
                                'tinymce_templates', $p['content'], $p['content']
                        );
                        $preview = apply_filters(
                                'tinymce_templates_preview', $p['content']
                        );
                        return array(
                            'content' => wpautop($content),
                            'preview' => $preview,
                            'is_shortcode' => $p['is_shortcode'],
                        );
                }
        }

        return $templates;
}

add_shortcode('pm_template_frontend', 'pm_template_frontend_shortcode');



function pm_template_frontend_shortcode() {

        $content = '';
        $editor_id = 'pmtemplateditor';
        $url = site_url();
        ?>	
        <link rel="stylesheet" href="<?php echo $url; ?>/wp-admin/load-styles.php?c=1&dir=ltr&load=buttons,dashicons,media-views,admin-bar,wp-admin,wp-auth-check&ver=4.2.2" />
        <script src="<?php echo $url; ?>/wp-admin/js/image-edit.js"></script>
        <script src="<?php echo $url; ?>/wp-includes/js/imgareaselect/jquery.imgareaselect.js"></script>
		
        <div id="tinymce-templates-backdrop" style="desplay: none;"></div>
        <div id="tinymce-templates-wrap" class="wp-core-ui search-panel-visible" style="desplay: none;">
            <div class="modal">
                <div class="header">
                    <h1><span class="dashicons dashicons-edit"></span> <?php _e('Insert Template', 'tinymce_templates'); ?></h1>
                    <a href="#" class="close"><span class="dashicons dashicons-no-alt"></span></a>
                </div>
                <div class="container">
                    <select id="tinymce-templates-list"></select>
                    <iframe id="tinymce-templates-preview"></iframe>
                </div>
                <div class="footer">
                    <div id="tinymce-templates-message"><?php _e('Note: The template will be inserted as shortcode.', 'tinymce_templates'); ?></div>
                    <a href="#" id="tinymce-templates-insert" class="button button-primary button-large template-button-insert" disabled><?php _e('Insert Template', 'tinymce_templates'); ?></a>
                </div>
            </div>
        </div>
        <?php
        $url = admin_url('admin-ajax.php');
        $nonce = wp_create_nonce('pm_templates');

        $args = array(
            'action' => 'pm_templates',
            'nonce' => $nonce,
        );

        $tree_id = $_GET['id'];
        ?>
        <script type="text/javascript">
                var tinymce_templates_list_uri = '<?php echo $url; ?>';
                var tinymce_templates_list_args = <?php echo json_encode($args); ?>;
        </script>

        <div id="titlewrap">
            <label class="" id="title-prompt-text" for="title">Title</label>
            <input type="text" name="post_title" value="" id="title" spellcheck="true" autocomplete="off">
        </div>
        <?php
        wp_editor($content, $editor_id);
        ?>
        <div id="publishing-action">
            <span class="spinner"></span>
            <input name="original_publish" type="hidden" id="original_publish" value="Publish">
            <input type="submit" name="publish" id="pm_publish" class="button button-primary button-large" value="Publish">
        </div>

        <?php
}

function patient_page_shortcode() {
	global $current_user;
    get_currentuserinfo();
	$posts = get_posts(
                array(
					'orderby'=>'menu_order',
                    'posts_per_page' => -1,
                    'post_type' => 'timeline_page',
                    'order' => 'ASC',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'patient_category',
                            'field' => 'slug',
                            'terms' => 'timeline-default',
                        )
                    )
                )
        );
        $cwidth=count($posts)*310;
        
	?>
	<input type="hidden" value="" class="current_clicked_node" />
	<input type="hidden" value="" class="create_timeline" />
	<input type="hidden" value="" class="parent_node_of_post" />
	<div id="scrollbar">
			<a id="left_scroll" class="mouseover_left" href="#"></a>
			<div id="track">
				 <div id="dragBar"></div>
			</div>
			<a id="right_scroll" class="mouseover_right" href="#"></a></div>
		</div>
	<div id="">
			<div id="">
			<div id="" >
	<?php

        /* $p = array(
          'post_status' => 'publish',
          'post_type' => 'timeline_page',
          //'orderby' => 'date',
          'post_parent' => 0,
          //'category_name'=> 'timeline-default',
          'order' => 'ASC',
          'numberposts' => -1,
          );
          $posts = get_posts($p); */


        
        ?>
        <?php /*
        <ul id="sortable">
  <li class="ui-state-default">1</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">2</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">3</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">4</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">5</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">6</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">7</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">8</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">9</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">10</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">11</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">12</li>
  <script>console.log("1");</script>
</ul>
<script>
  jQuery(function() {
    jQuery( "#sortable" ).sortable();
    jQuery( "#sortable" ).disableSelection();
  });
  </script> */ ?>
  <div class="modal fade" id="email_link_myModal" role="dialog">
	<div class="modal-dialog modal-lg">
	
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title">Email</h4>
		</div>
		<div class="modal-body">
		 
			  <div class='container'>
			  <div class='col-md-9'>
			  
				<form class="form-horizontal email_popup_form" role="form">
				  
				  <div class="form-group to_email_ms req">
					<label class="control-label col-sm-2" for="email">To:</label>
					<div class="col-sm-10">
					  <input type="email" class="form-control to_email" id="to_email" name='to_email' placeholder='Use comma "," for multiple recipients'>
					</div>
				  </div>
				  
				  <div class="form-group subject_ms req"> 
					<label class="control-label col-sm-2" for="sub">Subject:</label>
					<div class="col-sm-10"> 
					  <input type="text" class="form-control subject" id="subject" name='subject' value="<?php echo get_user_meta($current_user->ID,'timeline_subject',true); ?>">
					</div>
				  </div>
				  
				  <div class="form-group message_ms"> 
					  <label class="control-label col-sm-2" for="sub"></label>
					  <div class="col-sm-10"> 
						  <?php 
						  $content = '';
							$editor_id = 'mycustomeditor_afds';
							$settings = array(
							'media_buttons'=>false,
							'textarea_name'=>'message_test1' ,
							'editor_class'=>'add_link_test' ,
							'media_buttons' => false,
							'quicktags'     => TRUE,
							'textarea_rows' => 50,
							'editor_height' => '50px'
							);
							//wp_editor( $content, $editor_id ,$settings);
							wp_editor($content, $editor_id, $settings = array('editor_height' => 350, 'media_buttons' => true, 'quicktags' => false, 'tinymce' => array(
                                                'toolbar1'=>'bold italic |  bullist | link image unlink | wp_adv',
                                                'toolbar2' => 'formatselect,underline,justifyfull,forecolor,|,pastetext,pasteword,removeformat,|,media,charmap,|,outdent,indent,|,undo,redo,wp_help,image | alignleft aligncenter alignright alignjustify | numlist outdent indent |',
                                              //'theme_advanced_buttons1' => 'bold, italic, ul, min_size, max_size'
                                        )));

						  ?>
						<!--<textarea class='cont_test' name='message_test'></textarea>-->
					  </div>
				  </div>
				</form>
			  </div>
			  
		  </div>
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-default for_email" >Send Email</button>
		</div>
	  </div>
	  
	</div>
</div>
  <div class="row">
	  
  
   <?php
                if (!empty($posts)) {
                        foreach ($posts as $k => $v) {
                                ?>
                                <div class="pm_inner_box pm_inner_box_timeline col-md-12 col-sm-12 col-xm-12" postid="<?php echo $v->ID; ?>">
                                    <h4><?php echo $v->post_title; ?></h4>
                                    <div class="pm_tree_area">
                                        <div class="tree" id="tree_<?php echo $v->ID; ?>" data-id="<?php echo $v->ID; ?>">
                                        </div>
                                        <?php if (is_super_admin()) { ?>
                                                <div class="pm_tree_sv09" style="display:none;">
                                                    <input type="button" name="save_tree" id="save_tree_<?php echo $v->ID; ?>" value="Save"/>
                                                </div>
                                                
                                                
                                        <?php } ?>
                                    </div>
                                </div>
                                  
                               <?php 
						   }
					   } ?> 
					   </div>
					   <?php 
					   
					   ?>
					    <div class="pm_tree_sv09" style="float:right">
							<input type="button" name="email_link" id="email_link" value="Email Link" class="mail_link" />
						</div>
						<div class='sm_body'>
						</div>
						<?php 
						
					   ?>
					   <script>
  jQuery(function() {
	   	  var at = jQuery("#tree_<?php echo $v->ID; ?>").has('ul').find('li').has('ul').find('li').has('ul').find('ul').css('display');
	   	 // alert(at);
    jQuery( ".row" ).sortable({
		stop:function(){
															var post_ids ="";
															jQuery(".pm_inner_box").each(function(){
																post_ids += jQuery(this).attr("postid")+"#";
															});
														
															jQuery.ajax({
																	type: 'POST',
																	url: '<?php echo admin_url('admin-ajax.php'); ?>',
																	data: 'action=save_position&postids='+post_ids+'&nonce=<?php echo wp_create_nonce('save_position_'); ?>',
																	success: function (res) {
																		//alert("success");
																	}

															});
														}
    });
    jQuery( ".row" ).disableSelection();
  });
  </script>
  <?php
                if (!empty($posts)) {
					
                        foreach ($posts as $k => $v) {
                                ?>
   <?php if (is_super_admin()) { ?>
	 
                                        <script type="text/javascript">
											
											var parent_post_id;
											var email_link;
											
                                                jQuery(document).ready(function () {
													jQuery('.mail_link').click(function(){
															
															jQuery("#email_link_myModal").modal();
															jQuery('#mycustomeditor_afds').val(email_link);
															
															tinyMCE.get('mycustomeditor_afds').setContent("<?php echo addslashes(get_user_meta($current_user->ID,'int_msg',true)); ?><br>"+email_link+''+"<br><?php echo addslashes(get_user_meta($current_user->ID,'timeline_email',true)); ?>");
														});
														jQuery('.for_email').click(function(e){
																
																	e.preventDefault();
																	var mail_data = jQuery('.email_popup_form').serialize();
																	
																	var msg_body = tinyMCE.get('mycustomeditor_afds').getContent();
																	msg_body = msg_body.trim();
																	var tomail = jQuery('.to_email').val();
																	var subject = jQuery('.subject').val();
																	
																	jQuery('.req').each(function(){
																		if(jQuery(this).find('input').val().length<=0)
																		{
																			jQuery(this).addClass('has-error');
																		}
																		else
																		{
																			jQuery(this).removeClass('has-error');
																		}
																	});
																	if(tomail!='' && subject!='')
																	{
																	jQuery.ajax({
																		url:"<?php echo admin_url('admin-ajax.php'); ?>",
																		type:'POST',
																		data:'action=mail_link_popup&to_email='+tomail+'&subject='+subject+'&message_test='+encodeURIComponent(msg_body),
																		beforeSend:function()
																		{
																			
																			jQuery('.for_email').removeClass('btn-default').addClass('btn-warning');
																			jQuery('.for_email').text('Sending...');
																		},
																		success:function(res)
																		{
																			//console.log(res);
																			if(res)
																			{
																				jQuery('.for_email').text('Mail Sent');
																				jQuery('.for_email').removeClass('btn-warning').addClass('btn-success');
																				setTimeout(function(){ 
																					jQuery('#email_link_myModal').trigger('click'); 
																					jQuery('.for_email').text('Send Email');
																					jQuery('.to_email').val('');
																					jQuery('.subject').val('');
																					jQuery('#mycustomeditor_afds_ifr').contents().find('#tinymce').html('');
																					jQuery('.for_email').removeClass('btn-success').addClass('btn-default');
																					
																				},2000);
																				
																			}
																			else
																			{
																				//alert('Some error occurred');
																			}
																			
																		}
																		
																		
																	});
																}
																});
														
													var b = '';
														   function mergeChildren(sources) {
															   
															  var children = [];
															  for (var index in sources) {
																var source = sources[index];
																//children.push({k: source.title});
																b+= '<li>'+source.title+'</li>';
																if (source.children) {
																	 b+='<ul>';
																  //children = children.concat(mergeChildren(source.children));
																 
																  b = mergeChildren(source.children);
																   b+='</ul>';
																}
															  }
															 
															  return b;
															}

															function findChildrenForK(sources, k) {
																
															  for (var index in sources) {
																var source = sources[index];
																
															  //  if (source.k === k) {
																   if (source.children) {
																	
																	 return mergeChildren(source.children);
																   }
																//}
															  }
															}

                                                        var CLIPBOARD = null;
                                                        jQuery("#tree_<?php echo $v->ID; ?>").has('ul').find('li').has('ul').find('li').has('ul').find('li').css("background-color", "yellow");
                                                        jQuery("#tree_<?php echo $v->ID; ?>").fancytree({
                                                                icons: false,
                                                                checkbox: true,
                                                                extensions: ["dnd", "edit"],
                                                                source: {url: "<?php echo admin_url('admin-ajax.php') . '?action=pm_tree_get&id=' . $v->ID . '&nonce=' . wp_create_nonce('pm_tree_get_' . $v->ID); ?>"},
                                                                lazyLoad: function (event, data) {
                                                                        data.result = {url: "ajax-sub2.json", debugDelay: 1000};
                                                                        
                                                                        jQuery("#tree_<?php echo $v->ID; ?>").has('ul').find('li').has('ul').find('li').has('ul').find('li').css("background-color", "yellow");
                                                                },
                                                                init: function (event,data) {
																	var selNodes = data.tree.getSelectedNodes();
																	email_link	= jQuery.map(selNodes, function(node){
																			 return  '<a href="'+encodeURI(node.data.url)+'">'+node.title+'</a><br>' ;
																			//return node.data.url+'<br>';
																		  });
																			jQuery("#tree_<?php echo $v->ID; ?>").has('ul').find('li').find('ul').has('li').find('ul').has('li').find('ul').addClass('timeline_in_ul');
																		jQuery("#tree_<?php echo $v->ID; ?>").has('ul').find('li').has('ul').find('li').has('ul').find('li').has('ul').find('li').has('ul').find('li').addClass('timeline_in_li');
																	},
                                                                dnd: {
                                                                        autoExpandMS: 400,
                                                                        focusOnClick: true,
                                                                        preventVoidMoves: true,
                                                                        preventRecursiveMoves: true,
                                                                        dragStart: function (node, data) {                                                                              
                                                                                return true;
                                                                        },
                                                                        dragEnter: function (node, data) {
                                                                              
                                                                                return true;
                                                                        },
                                                                        dragDrop: function (node, data) {                                                                              
                                                                                data.otherNode.moveTo(node, data.hitMode);
                                                                        }
                                                                },
                                                                dblclick:function(event, data) {
																	var node = data.node;
																	if (node.data.type == 'content') {
																		return false;
																	}
																	else if (node.data.type == 'link') {
																		return false;
																	}
																},
																select: function(event,data){
																	//var node = data.node
																	/*if(data.node.hasChildren())
																	{
																		//data.node.hideCheckbox=true;
																		data.node.setSelected(false);
																		//return false;
																	}else
																	{
																	   var selNodes = data.tree.getSelectedNodes();
																	email_link	= jQuery.map(selNodes, function(node){
																			 return  '<a href="'+encodeURI(node.data.url)+'">'+node.title+'</a><br>' ;
																			//return node.data.url+'<br>';
																		  });
																		//return false;
																	}*/
																	
																	 var selNodes = data.tree.getSelectedNodes();
																	email_link	= jQuery.map(selNodes, function(node){
																			if(node.data.url!=undefined)
																			{
																			 return  '<a href="'+encodeURI(node.data.url)+'">'+node.title+'</a><br>' ;
																			}
																			//return node.data.url+'<br>';
																		  });
																},
                                                                click: function (event, data) {
																		
                                                                        
																		if(data.targetType=="checkbox")
																		{
																				/*if(data.node.hasChildren())
																				{
																				    data.node.hideCheckbox=true;
																					data.node.setSelected(false);
																					//return false;
																				}else
																				{
																				   
																				    //return false;
																				}*/
																		}
																		else{
																			var node = data.node;
																			var at = jQuery("#tree_<?php echo $v->ID; ?>").has('ul').find('li').has('ul').find('li').has('ul').find('ul').css('display');
																			jQuery("#tree_<?php echo $v->ID; ?>").has('ul').find('li').find('ul').has('li').find('ul').has('li').find('ul').addClass('timeline_in_ul');
																			jQuery("#tree_<?php echo $v->ID; ?>").has('ul').find('li').has('ul').find('li').has('ul').find('li').has('ul').find('li').has('ul').find('li').addClass('timeline_in_li');
																			
																			jQuery('.fancytree-node').removeClass('fancytree-active');
																		  //  alert(JSON.stringify(node.data));
																			
																			//jQuery("#tree_<?php echo $v->ID; ?>").has('ul').find('li').has('ul').find('li').has('ul').find('li').has('ul').find('li').has('ul').find('li').css("background-color", "yellow");
																			if (node.data.type == 'link') {
																					 var title = jQuery(data.node.title).text();
																					 var tree_id = jQuery(data.node.li).closest('div.tree').data('id');
																				   
																					window.open(node.data.url, 'contentFrame');
																			   
																					jQuery('.pm_iframe_modal .editiframelink').attr("c_title",title);
																					jQuery('.pm_iframe_modal .editiframelink').attr("c_treeid",tree_id);
																					jQuery('.pm_iframe_modal .editiframelink').attr("c_url",data.node.data.url);
																					jQuery('.pm_iframe_modal').modal('show');


																			} 
																			 else if (node.data.type == 'content') {
																				 var tree_id = jQuery(data.node.li).closest('div.tree').data('id');
																				
																				 //alert(data.node.li);
																				 //jQuery("#tree_<?php echo $v->ID; ?>").has('ul').find('li').has('ul').find('li').addClass('timeline_col');
																				
																				// get key path from root node to current node
																				// var p = node.getKeyPath();
																				 
																				 //convert that path into an array
																				// var arr = p.split("/");
																				// var root;
																				 
																				 //remove first element from array because it is " , "
																				// arr.shift();
																				// var i = arr.shift();
																				//	alert(i);
																				//	 root = jQuery("#tree_<?php echo $v->ID; ?>").fancytree("getTree").activateKey(i);
																					// alert(root.data.cid);
																					 jQuery.ajax({
																							url: "<?php echo admin_url('admin-ajax.php'); ?>",
																							data: "action=pm_content_disp1&cid=" + node.data.cid + "&nonce=<?php echo wp_create_nonce('pm_content_disp_'); ?>",
																							type: 'Post',
																							cache:false,
																							success: function (res) {
																									try
																									{
																										jQuery('.pm_popup_modal .editlink').show();
																										
																										//jQuery('.pm_popup_modal').modal('show');
																										//console.log(res);
																									var res = jQuery.parseJSON(res);
																									jQuery(".pm_popup_modal .editlink").attr("c_cid",node.data.cid);
																									jQuery(".pm_popup_modal .editlink").attr("c_treeid",tree_id);
																									jQuery(".pm_popup_modal .editlink").attr("c_timeline",node.data.timeline);
																									//console.log(res.content+eval(res.cu_js));
																									jQuery('.pm_popup_modal .pm_data_body').html(res.content);
																								  
																									if(res.is_beaver_builder==1)
																									{
																										//console.log("<?php echo get_option('siteurl');?>");
																									jQuery.getScript('<?php echo get_option('siteurl');?>/wp-content/uploads/bb-plugin/cache/'+res.id+'-layout.js',function(res){
																										
																										//eval(res);
																									   });
																								   }
																								
																									jQuery('.pm_popup_modal .title h5').text(" Page Title: "+res.title);
																									jQuery('.pm_popup_modal .url').html('<a href="' + res.url + '" target="_blank">' + res.url + '</a>');
																								
																									jQuery('.pm_popup_modal').modal('show');
																									
																									jQuery('.selected_temp_moda .media-modal-close').trigger("click");
																									var timeline_res = res.timeline_tree;
																								   
																								   }
																								   catch(e)
																								   {
																									   jQuery('.pm_popup_modal .title h5').text('');
																									jQuery('.pm_popup_modal .url').html('');
																								
																									   jQuery('.pm_popup_modal_back').css('display','none');
																									  // jQuery('.pm_popup_modal_back').hide();
																									  jQuery('.pm_popup_modal .pm_data_body').html(res);
																									  jQuery('.pm_popup_modal .editlink').hide();
																									   jQuery('.pm_popup_modal').modal('show');
																								   }
																									
																							},
																							complete:function()
																							{
																								setTimeout(function(){jQuery('.pm_popup_modal').resize();
																									},3000);
																									jQuery('#myModal').scroll(function(){
																										
																										jQuery('.pm_data_body').resize();
																										});
																							}
																							
																					});

																			}
																	}
                                                                }, 
                                                                edit: {
                                                                        triggerStart: ["f2", "dblclick", "shift+click", "mac+enter"],
                                                                        beforeEdit: function (event, data) {
                                                                                var n = data.node;
                                                                                var node_data = data.node.data;
                                                                                  var tree_id1 = jQuery(data.node.li).closest('div.tree').data('id');
                                                                               
																				jQuery(".current_clicked_node").val(data.node.key);
                                                                                if (node_data.type == 'content') {
                                                                                        var tree_id = jQuery(data.node.li).closest('div.tree').data('id');
                                                                                        var cid = node_data.cid;
																					var get_level = jQuery("#tree_" + tree_id).fancytree("getActiveNode");
																					
                                                                                        jQuery.ajax({
                                                                                                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                                                                                                data: "action=pm_content_edit&cid=" + cid + "&nonce=<?php echo wp_create_nonce('pm_content_edit_'); ?>",
                                                                                                type: 'Post',
                                                                                                cache: false,
                                                                                                success: function (res) {
																										
                                                                                                        var res = jQuery.parseJSON(res);
                                                                                                        jQuery('.selected_temp_modal #temp_selected_URL').val(res.url);
																										
                                                                                                        jQuery('.selected_temp_modal #temp_selected_title').val(res.title);
                                                                                                        jQuery('#edittemplatepost_ifr').contents().find("body").html('');
                                                                                                        jQuery('#edittemplatepost_ifr').contents().find("body").append(res.content);
                                                                                                      
                                                                                                        jQuery('#savetemplate').data('tree-id', tree_id);
                                                                                                        jQuery('#savetemplate').data('tempid', 0);
                                                                                                        jQuery('#savetemplate').data('timeline', node_data.timeline);
                                                                                                        jQuery('#savetemplate').data('cid', cid);
                                                                                                        jQuery('.selected_temp_modal').show("fade");
																										edit_content();
																										//alert("level : "+get_level.getLevel());
																										if(res.metavalue === 'Child')
																										{
																														
																													var perma = jQuery('#temp_selected_URL').val();
																													var arrlink = perma.split("/");
																													arrlink.pop();
																													var last = arrlink.pop();
																													
																													var joint = arrlink.join('/');
																													joint+='/';
																													
																													var limit = joint.length;
																													
																													jQuery("#temp_selected_URL").keydown(function(event){
																															//console.log(this.selectionStart);
																															//console.log("key down: "+event.which);
																															if(event.keyCode == 8){
																																this.selectionStart--;
																															}
																															if(this.selectionStart < limit){
																																this.selectionStart = limit;
																																//console.log("in key down: "+this.selectionStart);
																																event.preventDefault();
																															}
																														});
																														jQuery("#temp_selected_URL").keyup(function(event){
																															//console.log(this.selectionStart);
																															if(this.selectionStart < limit){
																																this.selectionStart = limit;
																																//console.log("key up: "+this.selectionStart);
																																event.preventDefault();
																															}
																														});
																											}
																											else if(res.metavalue === 'InTimeline')
																						 {
																							 
																							 var perma = jQuery('#temp_selected_URL').val();
																						var arrlink = perma.split("/");
																						arrlink.pop();
																						var last = arrlink.pop();
																						//alert(arrlink+' \nlength: '+arrlink.length);
																						var joint = arrlink.join('/');
																						joint+='/';
																						//alert(joint+' \nlength of string:'+joint.length);
																						var limit = joint.length;
																						
																						jQuery("#temp_selected_URL").keydown(function(event){
																								//console.log(this.selectionStart);
																								//console.log("key down: "+event.which);
																								if(event.keyCode == 8){
																									this.selectionStart--;
																								}
																								if(this.selectionStart < limit){
																									this.selectionStart = limit;
																									//console.log("in key down: "+this.selectionStart);
																									event.preventDefault();
																								}
																							});
																							jQuery("#temp_selected_URL").keyup(function(event){
																								//console.log(this.selectionStart);
																								if(this.selectionStart < limit){
																									this.selectionStart = limit;
																									//console.log("key up: "+this.selectionStart);
																									event.preventDefault();
																								}
																							});
																								
																						}
																						else{}
																										//alert(jQuery('#temp_selected_URL').val());
																								  }
                                                                                        }); 
                                                                                        
                                                                                        return false;

                                                                                } else if (node_data.type == 'link') {
                                                                                        var title = jQuery(data.node.title).text();

                                                                                        var tree_id = jQuery(data.node.li).closest('div.tree').data('id');
                                                                                        jQuery('.pm_add_link_insert').data('tree-id', tree_id);
                                                                                        jQuery('.add_link_modal .add_link_title').val(title);
                                                                                        jQuery('.add_link_modal .add_link').val(node_data.url);
                                                                                        jQuery('.add_link_modal').show();

                                                                                        return false;
                                                                                }
                                                                        },
                                                                        edit: function (event, data) {
                                                                               
                                                                        },
                                                                        beforeClose: function (event, data) {
                                                                             
                                                                        },
                                                                        save: function (event, data) {

                                                                                setTimeout(function () {
                                                                                        jQuery(data.node.span).removeClass("pending");
                                                                                      
                                                                                        data.node.setTitle(data.node.title);
                                                                                        jQuery('#save_tree_<?php echo $v->ID; ?>').trigger('click');


                                                                                }, 2000);
                                                                              
                                                                                return true;
                                                                        },
                                                                        close: function (event, data) {
                                                                             
                                                                                if (data.save && data.isNew) {
                                                                                       
                                                                                        jQuery("#tree").trigger("nodeCommand", {cmd: "addSibling"});
                                                                                        data.node.setActive();
                                                                                        jQuery("#tree_<?php echo $v->ID; ?>").trigger("nodeCommand", {cmd: "add_page"});
                                                               
                                                                                        jQuery(data.node.span).addClass("pending");
                                                                                }
                                                                        }
                                                                },
                                                                table: {
                                                                        indentation: 20,
                                                                        nodeColumnIdx: 2,
                                                                        checkboxColumnIdx: 0
                                                                },
                                                                gridnav: {
                                                                        autofocusInput: false,
                                                                        handleCursorKeys: true
                                                                },
                                                                renderColumns: function (event, data) {
                                                                        var node = data.node,
                                                                                $select = jQuery("<select />"),
                                                                                $tdList = jQuery(node.tr).find(">td");

                                                                        $tdList.eq(1).text(node.getIndexHier()).addClass("alignRight");
                                                                      
                                                                        if (node.isFolder()) {
                                                                                $tdList.eq(2)
                                                                                        .prop("colspan", 6)
                                                                                        .nextAll().remove();
                                                                        }
                                                                        $tdList.eq(3).html("<input type='input' value='" + "" + "'>");
                                                                        $tdList.eq(4).html("<input type='input' value='" + "" + "'>");
                                                                        $tdList.eq(5).html("<input type='checkbox' value='" + "" + "'>");
                                                                        $tdList.eq(6).html("<input type='checkbox' value='" + "" + "'>");
                                                                        jQuery("<option />", {text: "a", value: "a"}).appendTo($select);
                                                                        jQuery("<option />", {text: "b"}).appendTo($select);
                                                                        $tdList.eq(7).html($select);
                                                                }
                                                        }).on("nodeCommand", function (event, data) {
                                                              
                                                                var refNode, moveMode,
                                                                        tree = jQuery(this).fancytree("getTree"),
                                                                        node = tree.getActiveNode();
                                                                        var current_node = node;
																		//		alert(node.parent.title);
																				
																				
																			// get key path from root node to current node
																			 var p = node.getKeyPath();
																			 
																			 //convert that path into an array
																			 var arr = p.split("/");
																			// alert('length:--'+arr.length);
																			 if(arr.length > 3)
																			 {
																			 var root;
																			 //alert(arr);
																			 //remove first element from array because it is " , "
																			 arr.shift();
																			 arr.shift();
																			 arr.shift();
      																		 var i = arr.shift();
																				//alert('remain '+p);
																				 root = jQuery("#tree_<?php echo $v->ID; ?>").fancytree("getTree").activateKey(i);
																				 parent_post_id = root.data.cid;
																				 jQuery(".parent_node_of_post").val(parent_post_id);
																				 //alert("parent_node_:"+jQuery(".parent_node_of_post").val());
																				 p = current_node.getKeyPath();
																				 arr = p.split("/");
																				 i = arr.pop();
																				 root = jQuery("#tree_<?php echo $v->ID; ?>").fancytree("getTree").activateKey(i);
																				 
																			 }
																				 
                                                                switch (data.cmd) {
                                                                        case "moveUp":
                                                                                refNode = node.getPrevSibling();
                                                                                if (refNode) {
                                                                                        node.moveTo(refNode, "before");
                                                                                        node.setActive();
                                                                                }
                                                                                break;
                                                                        case "moveDown":
                                                                                refNode = node.getNextSibling();
                                                                                if (refNode) {
                                                                                        node.moveTo(refNode, "after");
                                                                                        node.setActive();
                                                                                }
                                                                                break;
                                                                        case "indent":
                                                                                refNode = node.getPrevSibling();
                                                                                if (refNode) {
                                                                                        node.moveTo(refNode, "child");
                                                                                        refNode.setExpanded();
                                                                                        node.setActive();
                                                                                }
                                                                                break;
                                                                        case "outdent":
                                                                                if (!node.isTopLevel()) {
                                                                                        node.moveTo(node.getParent(), "after");
                                                                                        node.setActive();
                                                                                }
                                                                                break;
                                                                        case "rename":
                                                                                node.editStart();
                                                                                break;
                                                                        case "remove":
                                                                                refNode = node.getNextSibling() || node.getPrevSibling() || node.getParent();
                                                                                node.remove();
                                                                              
                                                                                if (refNode) {
                                                                                        refNode.setActive();
                                                                                        if (node.data.type == 'content') {

                                                                                                jQuery.ajax({
                                                                                                        type: 'Post',
                                                                                                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                                                                                        data: 'action=pm_del_page&pid=' + node.data.cid + '&nonce=<?php echo wp_create_nonce("pm_del_page"); ?>',
                                                                                                        success: function (res) {
                                                                                                            
                                                                                                        }
                                                                                                })
                                                                                        }
                                                                                        jQuery('#save_tree_<?php echo $v->ID; ?>').trigger('click');

                                                                                }

                                                                                break;
                                                                        case "addChild":
                                                                                node.editCreateNode("child", "");
                                                                                //jQuery('.create_timeline').val('');	
                                                                                break;
                                                                        case "addSibling":
                                                                                node.editCreateNode("after", "");
                                                                               // jQuery('.create_timeline').val('');	
                                                                                break;
                                                                        case "cut":
                                                                                CLIPBOARD = {mode: data.cmd, data: node};
                                                                                break;
                                                                        case "copy":
                                                                                CLIPBOARD = {
                                                                                        mode: data.cmd,
                                                                                        data: node.toDict(function (n) {
                                                                                                delete n.key;
                                                                                        })
                                                                                };
                                                                                break;
                                                                        case "clear":
                                                                                CLIPBOARD = null;
                                                                                break;
                                                                        case "paste":
                                                                                if (CLIPBOARD.mode === "cut") {
                                                                                       
                                                                                        CLIPBOARD.data.moveTo(node, "child");
                                                                                        jQuery('#save_tree_<?php echo $v->ID; ?>').trigger('click');
                                                                                        CLIPBOARD.data.setActive();
                                                                                } else if (CLIPBOARD.mode === "copy") {
                                                                                        node.addChildren(CLIPBOARD.data).setActive();
                                                                                        jQuery('#save_tree_<?php echo $v->ID; ?>').trigger('click');
                                                                                }
                                                                                break;
                                                                        case "image":
                                                                                jQuery('#insert-media-button').trigger('click');

                                                                                wp.media.editor.send.attachment = function (a, b) {
                                                                                         if (b.type == 'image') {
                                                                                                var htm = '<div class="pm_img_disp" data-url="' + b.url + '" data-id="' + b.id + '" data-type="image"><img src="' + b.url + '" width="100" /></div>';
                                                                                                node.addChildren({"title": b.title + htm, "type": "image", "id": b.id, "url": b.url});
                                                                                        } else {
                                                                                                alert('Image type only allowed');
                                                                                        }


                                                                                };

                                                                                window.restore_send_to_editor = window.send_to_editor;

                                                                                window.send_to_editor = function (html) {

                                                                                        window.send_to_editor = window.restore_send_to_editor;
                                                                                };
                                                                                return false;
                                                                                break;
                                                                        case "video":

                                                                                jQuery('#insert-media-button').trigger('click');
                                                                                wp.media.editor.send.attachment = function (a, b) {
                                                                                        if (b.type == 'video' || b.type == 'audio') {
                                                                                                 var htm = '<div class="pm_vd_disp" data-url="' + b.url + '" data-id="' + b.id + '" data-type="video"><video name="media" width="100"><source src="' + b.url + '" type="' + b.mime + '"></video></div>';
                                                                                                node.addChildren({title: b.title + htm, "type": "video", id: b.id, url: b.url});
                                                                                        } else {
                                                                                                alert('Video type only allowed');
                                                                                        }


                                                                                };

                                                                                 window.restore_send_to_editor = window.send_to_editor;
                                                                                window.send_to_editor = function (html) {

                                                                                        window.send_to_editor = window.restore_send_to_editor;

                                                                                };
                                                                                return false;
                                                                                break;
                                                                        case "add_page":
                                                                                var temp_id = '<?php echo $v->ID; ?>';
                                                                                jQuery('.pm_inst_temp').data('node', node.title);
                                                                                jQuery('.pm_inst_temp').data('tree-id', temp_id);
                                                                                jQuery('.pm_templ_review').removeClass('pm_selected');
                                                                                //console.log('add_page_ is called');
                                                                                jQuery(".header_templates").show("fade");
																				//jQuery('.create_timeline').val('');	
                                                                                break;
                                                                        case "add_link":
                                                                               var temp_id = '<?php echo $v->ID; ?>';
                                                                                jQuery('.pm_inst_temp').data('node', node.title);
                                                                                jQuery('.pm_inst_temp').data('tree-id', temp_id);
                                                                                jQuery('.pm_templ_review').removeClass('pm_selected');
                                                                                jQuery(".header_templates").show("fade");
																				//jQuery('.create_timeline').val('');	
																				
                                                                                break;
                                                                        case "add_timeline":
																				node.editCreateNode("after", "");
																				<?php //add_shortcode('page_timeline','page_timeline_shortcode'); ?>
																				jQuery('.create_timeline').val(1);
																				//alert(jQuery('.create_timeline').val());
																				break;
                                                                        default:
                                                                                alert("Unhandled command: " + data.cmd);
                                                                                return;
                                                                }

                                                        }).on("keydown", function (e) {
                                                                var cmd = null;

                                                                 switch (jQuery.ui.fancytree.eventToString(e)) {
                                                                        case "ctrl+shift+n":
                                                                        case "meta+shift+n":
                                                                                cmd = "addChild";
                                                                                break;
                                                                        case "ctrl+c":
                                                                        case "meta+c": 
                                                                                cmd = "copy";
                                                                                break;
                                                                        case "ctrl+v":
                                                                        case "meta+v": 
                                                                                cmd = "paste";
                                                                                break;
                                                                        case "ctrl+x":
                                                                        case "meta+x": 
                                                                                cmd = "cut";
                                                                                break;
                                                                        case "ctrl+n":
                                                                        case "meta+n": 
                                                                                cmd = "addSibling";
                                                                                break;
                                                                        case "del":
                                                                        case "meta+backspace": 
                                                                                cmd = "remove";
                                                                                break;
                                                                                
                                                                        case "ctrl+up":
                                                                                cmd = "moveUp";
                                                                                break;
                                                                        case "ctrl+down":
                                                                                cmd = "moveDown";
                                                                                break;
                                                                        case "ctrl+right":
                                                                        case "ctrl+shift+right": 
                                                                                cmd = "indent";
                                                                                break;
                                                                        case "ctrl+left":
                                                                        case "ctrl+shift+left": 
                                                                                cmd = "outdent";
                                                                }
                                                                if (cmd) {
                                                                        jQuery(this).trigger("nodeCommand", {cmd: cmd});
                                                                       
                                                                        return false;
                                                                }
                                                        });

                                                        jQuery("#tree_<?php echo $v->ID; ?>").contextmenu({
                                                                delegate: "span.fancytree-title",
                                                              
                                                                menu: [
                                                                      
                                                                        {title: "New sibling", cmd: "addSibling", uiIcon: "ui-icon-plus"},
                                                                        {title: "New child", cmd: "addChild", uiIcon: "ui-icon-arrowreturn-1-e"},
                                                                        {title: "----"},
                                                                        {title: "Add Content to the title", cmd: "add_page", uiIcon: "ui-icon-note", disabled: false},
																		{title: "Add Timeline", cmd: "add_timeline", uiIcon: "ui-icon-plus"},
                                                                        {title: "----"},
                                                                        {title: "Edit", cmd: "rename", uiIcon: "ui-icon-pencil"},
                                                                        {title: "Delete", cmd: "remove", uiIcon: "ui-icon-trash"},
                                                                        {title: "----"},
                                                                        {title: "Cut", cmd: "cut", uiIcon: "ui-icon-scissors"},
                                                                        {title: "Copy", cmd: "copy", uiIcon: "ui-icon-copy"},
                                                                        {title: "Paste as child", cmd: "paste", uiIcon: "ui-icon-clipboard", disabled: true}
                                                                ],
                                                                beforeOpen: function (event, ui) {
                                                                        var node = jQuery.ui.fancytree.getNode(ui.target);
																		tr = jQuery("#tree_<?php echo $v->ID; ?>").fancytree('getTree');
																		var n = tr.getActiveNode();
																		
																		//alert(n);
                                                                        jQuery("#tree_<?php echo $v->ID; ?>").contextmenu("enableEntry", "paste", !!CLIPBOARD);
                                                                        node.setActive();
                                                                },
                                                                select: function (event, ui) {
                                                                        var that = this;
																		tr = jQuery("#tree_<?php echo $v->ID; ?>").fancytree('getTree');
																		var n = tr.getActiveNode();
																		//alert(n.title+' : '+n.getLevel());
																		if(ui.cmd=="rename")
																		{
																			jQuery("#savetemplate").val("Edit Page");
																		}
																		else
																		{
																			jQuery("#savetemplate").val("Create Page");
																		}
																		//alert('nodename: '+n.key);
                                                                        setTimeout(function () {
                                                                                jQuery(that).trigger("nodeCommand", {cmd: ui.cmd});
                                                                        }, 100);

                                                                      
                                                                }
                                                        });
                                                        jQuery(".editiframelink").on('click',function(){
															jQuery('.pm_iframe_modal .media-modal-close').trigger("click");
															    var title = jQuery(this).attr("c_title");
																var tree_id = jQuery(this).attr("c_treeid");
																var url = jQuery(this).attr("c_url");
																jQuery('.pm_add_link_insert').data('tree-id', tree_id);
																jQuery('.add_link_modal .add_link_title').val(title);
																jQuery('.add_link_modal .add_link').val(url);
																jQuery('.add_link_modal').show();

															return false;
														});
														 jQuery(".editlink").on('click',function(){
															 jQuery("#savetemplate").val("Edit Page");
														jQuery('.pm_popup_modal .media-modal-close').trigger("click");
														
															var linkval = jQuery(this).attr("c_cid");
															var treeid = jQuery(this).attr("c_treeid");
															var timeline = jQuery(this).attr("c_timeline");
															 var get_level = jQuery("#tree_" + treeid).fancytree("getActiveNode");
															//alert("level of the node: "+get_level.getLevel());
																jQuery.ajax({
																		url: "<?php echo admin_url('admin-ajax.php'); ?>",
																		data: "action=pm_content_edit&cid=" + linkval + "&nonce=<?php echo wp_create_nonce('pm_content_edit_'); ?>",
																		type: 'Post',
																		cache: false,
																		success: function (res) {
																				var res = jQuery.parseJSON(res);
								
																				//alert('link call');
																				jQuery('.selected_temp_modal #temp_selected_URL').val(res.url);
																				jQuery('#p_builder').attr('href',res.url+'?fl_builder');
																				jQuery('.selected_temp_modal #temp_selected_title').val(res.title);
																				jQuery('#edittemplatepost_ifr').contents().find("body").html('');
																				jQuery('#edittemplatepost_ifr').contents().find("body").append(res.content);
																			
																				jQuery('#savetemplate').data('tree-id', treeid);
																				jQuery('#savetemplate').data('tempid', 0);
																				jQuery('#savetemplate').data('cid', linkval);
																				jQuery('#savetemplate').data('timeline', timeline);
																				jQuery('.selected_temp_modal').show("fade");

																				edit_content();
																				if(res.metavalue === 'Child')
																										{
																														
																													var perma = jQuery('#temp_selected_URL').val();
																													var arrlink = perma.split("/");
																													arrlink.pop();
																													var last = arrlink.pop();
																													
																													var joint = arrlink.join('/');
																													joint+='/';
																													
																													var limit = joint.length;
																													
																													jQuery("#temp_selected_URL").keydown(function(event){
																															//console.log(this.selectionStart);
																															//console.log("key down: "+event.which);
																															if(event.keyCode == 8){
																																this.selectionStart--;
																															}
																															if(this.selectionStart < limit){
																																this.selectionStart = limit;
																																//console.log("in key down: "+this.selectionStart);
																																event.preventDefault();
																															}
																														});
																														jQuery("#temp_selected_URL").keyup(function(event){
																															//console.log(this.selectionStart);
																															if(this.selectionStart < limit){
																																this.selectionStart = limit;
																																//console.log("key up: "+this.selectionStart);
																																event.preventDefault();
																															}
																														});
																											}
																											else if(res.metavalue === 'InTimeline')
																						 {
																							 
																							 var perma = jQuery('#temp_selected_URL').val();
																						var arrlink = perma.split("/");
																						arrlink.pop();
																						var last = arrlink.pop();
																						//alert(arrlink+' \nlength: '+arrlink.length);
																						var joint = arrlink.join('/');
																						joint+='/';
																						//alert(joint+' \nlength of string:'+joint.length);
																						var limit = joint.length;
																						
																						jQuery("#temp_selected_URL").keydown(function(event){
																								//console.log(this.selectionStart);
																								//console.log("key down: "+event.which);
																								if(event.keyCode == 8){
																									this.selectionStart--;
																								}
																								if(this.selectionStart < limit){
																									this.selectionStart = limit;
																									//console.log("in key down: "+this.selectionStart);
																									event.preventDefault();
																								}
																							});
																							jQuery("#temp_selected_URL").keyup(function(event){
																								//console.log(this.selectionStart);
																								if(this.selectionStart < limit){
																									this.selectionStart = limit;
																									//console.log("key up: "+this.selectionStart);
																									event.preventDefault();
																								}
																							});
																								
																						}
																		}
																});
																return false;
														});
                                                        jQuery('#save_tree_<?php echo $v->ID; ?>').on('click', function () {
                                                                
                                                                var tree = jQuery("#tree_<?php echo $v->ID; ?>").fancytree("getTree");
                                                                selNodes = tree.getSelectedNodes();
                                                                selNodes.forEach(function(node) {
																   node.setSelected(false);
																  });
                                                                var d = tree.toDict(true);
                                                                var nodes = JSON.stringify(d.children);

                                                                jQuery.ajax({
                                                                        type: 'POST',
                                                                        url: '<?php echo admin_url('admin-ajax.php'); ?>?action=pm_tree&id=<?php echo $v->ID; ?>&nonce=<?php echo wp_create_nonce('pm_trees'); ?>',
                                                                                                         data: nodes,
                                                                                                        dataType: "json",
                                                                                                        contentType: 'application/json',
                                                                                                        success: function (res) {
																									
                                                                                                        }

                                                                                                });
                                                                                        })

                                                                                });
                                                                             
                                                        
                                        </script>
                                        
																			<?php } else {
                                        ?>
                                        <script type="text/javascript">
											var email_link;
                                                jQuery(document).ready(function () {
															
															jQuery('.mail_link').click(function(){
															
															jQuery("#email_link_myModal").modal();
															jQuery('#mycustomeditor_afds').val(email_link);
															
															tinyMCE.get('mycustomeditor_afds').setContent("<?php echo addslashes(get_user_meta($current_user->ID,'int_msg',true)); ?><br>"+email_link+''+"<br><?php echo addslashes(get_user_meta($current_user->ID,'timeline_email',true)); ?>");
														});
														jQuery('.for_email').click(function(e){
																
																	e.preventDefault();
																	var mail_data = jQuery('.email_popup_form').serialize();
																	
																	var msg_body = tinyMCE.get('mycustomeditor_afds').getContent();
																	msg_body = msg_body.trim();
																	var tomail = jQuery('.to_email').val();
																	var subject = jQuery('.subject').val();
																	
																	jQuery('.req').each(function(){
																		if(jQuery(this).find('input').val().length<=0)
																		{
																			jQuery(this).addClass('has-error');
																		}
																		else
																		{
																			jQuery(this).removeClass('has-error');
																		}
																	});
																	if(tomail!='' && subject!='')
																	{
																	jQuery.ajax({
																		url:"<?php echo admin_url('admin-ajax.php'); ?>",
																		type:'POST',
																		data:'action=mail_link_popup&to_email='+tomail+'&subject='+subject+'&message_test='+encodeURIComponent(msg_body),
																		beforeSend:function()
																		{
																			
																			jQuery('.for_email').removeClass('btn-default').addClass('btn-warning');
																			jQuery('.for_email').text('Sending...');
																		},
																		success:function(res)
																		{
																			//console.log(res);
																			if(res)
																			{
																				jQuery('.for_email').text('Mail Sent');
																				jQuery('.for_email').removeClass('btn-warning').addClass('btn-success');
																				setTimeout(function(){ 
																					jQuery('#email_link_myModal').trigger('click'); 
																					jQuery('.for_email').text('Send Email');
																					jQuery('.to_email').val('');
																					jQuery('.subject').val('');
																					jQuery('#mycustomeditor_afds_ifr').contents().find('#tinymce').html('');
																					jQuery('.for_email').removeClass('btn-success').addClass('btn-default');
																					
																				},2000);
																				
																			}
																			else
																			{
																				//alert('Some error occurred');
																			}
																			
																		}
																		
																		
																	});
																}
																});	
                                                        jQuery("#tree_<?php echo $v->ID; ?>").fancytree({
                                                                icons: false,
                                                                minExpandLevel: 1,
                                                                checkbox:true,
                                                                generateIds: true,
                                                                idPrefix: "pm_node",
                                                                
                                                                source: {url: "<?php echo admin_url('admin-ajax.php') . '?action=pm_tree_get&id=' . $v->ID . '&nonce=' . wp_create_nonce('pm_tree_get_' . $v->ID); ?>"},
                                                                lazyLoad: function (event, data) {
                                                                        data.result = $.ajax({
                                                                                url: "ajax-sub2.json",
                                                                                dataType: "json"
                                                                        });
                                                                },
                                                                init: function (event,data) {
																	var selNodes = data.tree.getSelectedNodes();
																	email_link	= jQuery.map(selNodes, function(node){
																			 return  '<a href="'+encodeURI(node.data.url)+'">'+node.title+'</a><br>' ;
																			//return node.data.url+'<br>';
																		  });
																			jQuery("#tree_<?php echo $v->ID; ?>").has('ul').find('li').find('ul').has('li').find('ul').has('li').find('ul').addClass('timeline_in_ul');
																		jQuery("#tree_<?php echo $v->ID; ?>").has('ul').find('li').has('ul').find('li').has('ul').find('li').has('ul').find('li').has('ul').find('li').addClass('timeline_in_li');
																	},
																select: function(event,data){
																	//var node = data.node
																	 var selNodes = data.tree.getSelectedNodes();
																	email_link	= jQuery.map(selNodes, function(node){
																			if(node.data.url!=undefined)
																			{
																			 return  '<a href="'+encodeURI(node.data.url)+'">'+node.title+'</a><br>' ;
																			}
																			//return node.data.url+'<br>';
																		  });
																	
																},
                                                                click: function (event, data) {
																	
																		if(data.targetType=="checkbox")
																		{
																				/*if(data.node.hasChildren())
																				{
																				    data.node.hideCheckbox=true;
																					data.node.setSelected(false);
																					//return false;
																				}else
																				{
																				   
																				    //return false;
																				}*/
																		}
																		else{
                                                                        var node = data.node;

                                                                        jQuery('.fancytree-node').removeClass('fancytree-active');
																		
                                                                        if (node.data.type == 'link') {
                                                                               
                                                                                window.open(node.data.url, 'contentFrame');
                                                                              
                                                                                jQuery('.pm_iframe_modal').modal('show');


                                                                        } else if (node.data.type == 'content') {
                                                                                jQuery.ajax({
                                                                                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                                                                                        data: "action=pm_content_disp&cid=" + node.data.cid + "&nonce=<?php echo wp_create_nonce('pm_content_disp_'); ?>",
                                                                                        type: 'Post',
                                                                                        success: function (res) {
                                                                                                var res = jQuery.parseJSON(res);
																								/**********/
																								if(res.title == null)
																								{
																									jQuery('.pm_popup_modal .title h5').text("No Content added");
																								}
																								else
																								{
																									jQuery('.pm_popup_modal .title h5').text(" Page Title: "+res.title);
																								}
																								if(res.url == false)
																								{
																									jQuery('.pm_popup_modal .url').html('');
																								}
																								else
																								{
																									jQuery('.pm_popup_modal .url').html('<a href="' + res.url + '" target="_blank">' + res.url + '</a>');
																								}
                                                                                                jQuery('.pm_popup_modal .pm_data_body').html(res.content);
                                                                                               if(res.is_beaver_builder==1)
																									{
																										
																									jQuery.getScript('<?php echo get_option('siteurl');?>/wp-content/uploads/bb-plugin/cache/'+res.id+'-layout.js',function(res){
																										
																										//eval(res);
																									   });
																								   }
                                                                                               // jQuery('.pm_popup_modal .title h1').text(res.title);
                                                                                              //  jQuery('.pm_popup_modal .url').html('<a href="' + res.url + '" target="_blank">' + res.url + '</a>');
                                                                                             
                                                                                                jQuery('.pm_popup_modal').modal('show');
                                                                                        },
                                                                                        complete:function()
                                                                                        {
																							setTimeout(function(){jQuery('.pm_popup_modal').resize();
																								},3000);
																								jQuery('#myModal').scroll(function(){
																									
																									jQuery('.pm_data_body').resize();
																									});
																						}
                                                                                });

                                                                        }
                                                                    }
                                                                }
                                                        });


                                                });
                                        </script>

                                <?php }
                                ?>
                                <?php } 
							} 
							?>

 <script type="text/javascript">
							jQuery(document).ready(function(){
								jQuery('#horiz_container_outer').horizontalScroll();
							
							});
					</script>
      
        <?php if (is_super_admin()) { ?>
                                                                                                                                                                                                                        <!--                <a href="#" id="insert-media-button" class="button insert-media add_media add-media-button" style="display: none;" title="Add Media"><span class="wp-media-buttons-icon"></span> Add Media</a>-->
                <input type="hidden" value="<?php echo plugins_url('ajax-tree-fs.php', __FILE__); ?>" id="node_url" />

                <div class="add_link_modal fixed-container full-height" style="display: none;">
                    <div class="fixed-container-inner">
                        <div class="modal-inner">          

                            <div class="link_cls"><div class="pm_temp_title">Add Link</div>
                                <img src="<?php echo plugins_url("images/close.png", __FILE__) ?>" onclick="jQuery('.add_link_modal').hide('fade');
                                                                jQuery('.add_link_modal input.add_link').val('');" class="media-modal-close" />

                                <div class="">
                                    <div><label>Title</label><input type="text" name="add_link_title" class="add_link_title" placeholder="Enter Title"/></div>
                                    <div>

                                        <label>Link</label><input type="text" name="add_link" class="add_link" placeholder="e.g http://example.com"/> 
                                    </div>
                                    <button type="button" class="pm_add_link_insert">Insert</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="header_templates modal login-prompt-modal fixed-container full-height" close="modal.close" class-name="login-prompt-modal" style="display: none;">				
                    <div class="fixed-container-inner">
                        <div class="modal-inner">
                            <img src="<?php echo plugins_url("images/close.png", __FILE__) ?>" onclick="jQuery('.header_templates').hide('fade');" class="media-modal-close close_click" />

                            <div class="modal-transclude" ng-transclude="">
                                <div class="login-prompt ng-scope" ng-show="showLoginPrompt">    
                                    <div class="umtop">

                                        <div class="um_box_up pm_temp_title">Select template to Add content in title</div>
                                        <div class="um_box_mid">
                                            <div class="um_box_mid_content comman_wrapper">
												<script>
													function load_template_selection(postids)
													{
														jQuery.ajax({
																type: 'POST',
																url: '<?php echo admin_url('admin-ajax.php'); ?>',
																data: 'action=save_template_position&postids='+postids+'&nonce=<?php echo wp_create_nonce('save_template_position_'); ?>',
																async:true,
																success: function (res) {
																	//alert("success");
																}

														});
													}
													jQuery(function() {
														jQuery( ".templates_selection" ).sortable({
															 start: function(event, ui) {
																jQuery(".pm_templ_review").addClass("noclick");
															},
															stop:function(){
																 
																 setTimeout(function(){jQuery(".pm_templ_review").unbind("click.prevent");}, 300);
																var post_ids ="";
																jQuery(".pm_templ_review").each(function(){
																	post_ids += jQuery(this).attr("data-pid")+"#";
																});
																load_template_selection(post_ids);
																
																
															}
															
														});
														jQuery( ".templates_selection" ).disableSelection();
													  });
												</script>
                                                <div class="templates_selection" style="margin:20px;">
                                                    <!--<div class="pm_templ_review" data-id="0">
                                                        <div class="pm_temp_title">New Link</div>
                                                        <div class="pm_temp_content"></div>
                                                    </div> -->
                                                    
                                                    <?php
                                                    $p = array(
                                                        'post_status' => 'publish',
                                                        'post_type' => 'patient_templates',
                                                        'orderby'=>'menu_order',
                                                        'order' => 'ASC',
                                                        'numberposts' => -1,
                                                    );

                                                    $posts = get_posts($p);

                                                    $templates = array();
                                                    if (!empty($posts)) {
														?>
														<div class="num_rows">
														<?php
                                                            foreach ($posts as $p) {
                                                                    $ID = intval($p->ID);
                                                                    $metas = get_post_meta($ID, 'show_in_timeline', true);
                                                                    //print_r($metas);
                                                                    $name = esc_html(apply_filters('tinymce_template_title', $p->post_title));
                                                                    $desc = esc_html(apply_filters('tinymce_template_excerpt', $p->post_excerpt));
                                                                    
                                                                    if(get_post_meta($ID,'row_pos',true)=="1")
                                                                    {
																		?>
                                                                    <script>
																		jQuery('.templates_selection').resize();
                                                                    </script>
                                                                    <?php
																		 if(get_post_meta($ID,'no-content-title-only',true) != "" && get_post_meta($ID,'no-content-title-only',true) == "1")
																		{?>
																			<div class="pm_templ_review" data-nid="0" data-pid="<?php echo $p->ID; ?>" >
																				<div class="pm_temp_title">Title Only</div>
																				<div class="pm_temp_content"></div>
																			</div>
																		<?php
																		}
																		else if(get_post_meta($ID,'new-link',true) != "" && get_post_meta($ID,'new-link',true) == "1")
																		{ ?>
																			<div class="pm_templ_review" data-id="0" data-pid="<?php echo $p->ID; ?>" >
																				<div class="pm_temp_title">Link to Existing Page</div>
																				<div class="pm_temp_content"></div>
																			</div>   
																		<?php
																		}
																		
																		
																	}
																}
																?>
																</div><div class="clearfix"></div>
														<div class="num_rows">
															<p><strong>Create web page</strong></p>
														<?php
																foreach ($posts as $p) {
                                                                    $ID = intval($p->ID);
                                                                    $metas = get_post_meta($ID, 'show_in_timeline', true);
                                                                    //print_r($metas);
                                                                    $name = esc_html(apply_filters('tinymce_template_title', $p->post_title));
                                                                    $desc = esc_html(apply_filters('tinymce_template_excerpt', $p->post_excerpt));
                                                                   
                                                                    if(get_post_meta($ID,'show_in_second_row',true)=="yes")
                                                                    {
																		 ?>
                                                                    <script>
																		jQuery('.templates_selection').resize();
                                                                    </script>
                                                                    <?php
																		update_post_meta($ID,'timeline_bb_post_thumbnail',plugins_url('/images/' . $p->post_name . '.jpg', __FILE__));
																		?>
																		<div class="pm_templ_review" data-pid="<?php echo $p->ID; ?>" data-id="<?php echo $p->ID; ?>" data-timeline="<?php echo $metas; ?>">
																			<div class="pm_temp_title"><?php //echo $p->post_title; ?></div>
																			<div class="pm_temp_content "><img src="<?php echo plugins_url('/images/' . $p->post_name . '.jpg', __FILE__); ?>" /><div class="overbox"></div></div>

																		</div>      
																		<?php
																	}
																}
																?>
																</div><div class="clearfix"></div>
														<div class="num_rows">
															<p><strong>Show in Timeline</strong></p>
														<?php
																foreach ($posts as $p) {
                                                                    $ID = intval($p->ID);
                                                                    $metas = get_post_meta($ID, 'show_in_timeline', true);
                                                                    //print_r($metas);
                                                                    $name = esc_html(apply_filters('tinymce_template_title', $p->post_title));
                                                                    $desc = esc_html(apply_filters('tinymce_template_excerpt', $p->post_excerpt));
                                                                   
                                                                    if(get_post_meta($ID,'row_pos',true)=="3")
                                                                    {
																		 ?>
                                                                    <script>
																		jQuery('.templates_selection').resize();
                                                                    </script>
                                                                    <?php
																		update_post_meta($ID,'timeline_bb_post_thumbnail',plugins_url('/images/' . $p->post_name . '.jpg', __FILE__));
																		?>
																		<div class="pm_templ_review" data-pid="<?php echo $p->ID; ?>" data-id="<?php echo $p->ID; ?>" data-timeline="<?php echo $metas; ?>">
																			<div class="pm_temp_title"><?php echo $p->post_title; ?></div>
																			<div class="pm_temp_content "><img src="<?php echo plugins_url('/images/' . $p->post_name . '.jpg', __FILE__); ?>" /><div class="overbox"></div></div>

																		</div>      
																		<?php
																	}
                                                                }   
                                                                ?>
                                                                </div>
                                                                <?php
                                                            }
                                                    
                                                    ?>
                                                    <!--<div class="pm_templ_review" data-nid="0">
                                                        <div class="pm_temp_title">No Content Title only</div>
                                                        <div class="pm_temp_content"></div>
                                                    </div>-->
                                                </div>
                                                <button class="pm_inst_temp" type="button" style="display:none;" >Insert Template</button>
                                            </div>
                                        </div>
                                        <div class="um_box_down"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="selected_temp_modal fixed-container full-height" style="display: none;">
                    <div class="fixed-container-inner">
                        <div class="modal-inner">          

                            <div class=""><div class="pm_temp_title">Add page</div>
                                <img src="<?php echo plugins_url("images/close.png", __FILE__) ?>" onclick="jQuery('.selected_temp_modal').hide('fade');" class="media-modal-close close_click" />

                                <?php
                                $url = site_url();
                                ?>
                                <link rel="stylesheet" href="<?php echo $url; ?>/wp-admin/load-styles.php?c=1&dir=ltr&load=buttons,dashicons,media-views,admin-bar,wp-admin,wp-auth-check&ver=4.2.2" />
                                <script src="<?php echo $url; ?>/wp-admin/js/image-edit.js"></script>
                                <script src="<?php echo $url; ?>/wp-includes/js/imgareaselect/jquery.imgareaselect.js"></script>
                                <form id="inser_template_page" method="POST" name="inser_template_page">
                                    <div class="temp">
										 <label class="">Page URL</label>
                                        <input name="" type="text" id="temp_selected_URL" />
                                        <label class="">Add Title</label>
                                        <input name="" type="text" id="temp_selected_title" />
                                        <!--<a href="" id="p_builder" target="_blank">Page Builder</a>-->
                                        <script>
											
                                        </script>
                                    </div>
                                    <div class="temp_selected" >
                                        <?php
                                        $content = "";
                                        $editor_id = 'edittemplatepost';

                                        wp_editor($content, $editor_id, $settings = array('editor_height' => 350, 'media_buttons' => true, 'quicktags' => false, 'tinymce' => array(
                                                'toolbar1'=>'bold italic |  bullist | link image unlink | wp_adv',
                                                'toolbar2' => 'formatselect,underline,justifyfull,forecolor,|,pastetext,pasteword,removeformat,|,media,charmap,|,outdent,indent,|,undo,redo,wp_help,image | alignleft aligncenter alignright alignjustify | numlist outdent indent |',
                                              'theme_advanced_buttons1' => 'bold, italic, ul, min_size, max_size'
                                        )));
                                        ?>
                                    </div>
                                    <div class="">
                                        <input type="button" id="savetemplate" value="Create Page" />
                                    </div>
                                </form>
                            </div>
  
                        </div>
                    </div>
                </div>
                <div id="tmp_handler" class='hide'>
                </div>
<input type="hidden" value="0" name="is_loade" id="is_loade" />
                <script type="text/javascript">

                                        function edit_content() {

                                                jQuery("#edittemplatepost_ifr").contents().find("body").find('div.upload_img').droppable();
                                                jQuery("#edittemplatepost_ifr").contents().find("body").find('div.upload_img').on('drop', function (event) {
                                                        jQuery("#edittemplatepost_ifr").contents().find("body").find('div.upload_img').removeClass('selected');
                                                        jQuery(this).addClass('selected');

                                                        //stop the browser from opening the file
                                                        event.preventDefault();

                                                        if (event.type === "drop") {
                                                                var rowCount = 0;
                                                                var files = event.originalEvent.dataTransfer.files;
                                                                //console.log(files);
                                                                if (files[0])
                                                                        var formData = new FormData();

                                                                //append the files to the formData object
                                                                //Use FormData to send the files
                                                                formData.append('files', files[0]);
                                                                //jQuery(this).append(files[0].name);
                                                                //console.log(formData);
                                                                handleFileUpload(event.originalEvent.dataTransfer.files, jQuery(this));
                                                        }
                                                });

                                                if(jQuery("#is_loade").val() == 1)
                                                {
                                                    return false;
                                                }
                                                jQuery("#is_loade").val("1");
                                                

                                                jQuery('#edittemplatepost_ifr').contents().find("body").on('mousedown', 'div.upload_img img', function (e) {

                                                        /*if (e.which == 3) {
                                                         var temp = jQuery('#edittemplatepost_ifr').contents().find("body").find('div.upload_img');
                                                         temp.find('.imgEditAd01').remove();
                                                         var htm = '<div class="imgEditAd01" style="z-index:100;"><div class="crop">Crop</div><div>';
                                                         jQuery(this).closest('div.upload_img').append(htm);
                                                         }*/
                                                });

                                                jQuery('#edittemplatepost_ifr').contents().find("body").on('click', 'div.upload_video', function (event) {

                                                        if (jQuery(this).find('img').length == 0) {
                                                                var $this = jQuery(this);
                                                                $this.html('');
                                                                jQuery('.mce-toolbar button .mce-i-media').trigger('click');
                                                               
                                                                tinyMCE.activeEditor.on('keyup', function (e,o) {
                                                                        
                                                                        var imgdiv = tinyMCE.activeEditor.selection.getNode();
                                                                        
                                                                        if(e.keyIdentifier == 'U+007F'){
                                                                                var img = jQuery(imgdiv).find('img');
                                                                                if(img.length == 0){
                                                                                        jQuery(imgdiv).empty();
                                                                                       jQuery(imgdiv).attr('style',jQuery(imgdiv).data('style')); 
                                                                                }
                                                                        }
                                                                });
                                                                
                                                                tinyMCE.activeEditor.selection.onBeforeSetContent.add(function (ed, o) {
                                                                        if (o.content.length > 0) {
                                                                                $this.removeAttr('style');
                                                                        }
                                                                });

                                                                /*window.send_to_editor = function (html) {
                                                                 $this.html(html);
                                                                 $this.removeAttr('style');
                                                                 }*/
                                                        }
                                                });

                                                jQuery('#edittemplatepost_ifr').contents().find("body").on('click', 'div.upload_img', function (event) {
                                                        var img = jQuery(this).find('img');

                                                        if (img.length == 0) {
                                                                var $this = jQuery(this);
                                                                $this.html('');
                                                                $this.addClass('selected');

                                                                callb();

                                                                window.send_to_editor = function (html) {
                                                                        $this.html(html);
                                                                        $this.removeAttr('style');
                                                                }
                                                        }

                                                });

                                                
                                               

                                                jQuery('.mce-container.mce-btn-group').on('click', 'div.mce-btn .dashicons-no', function () {
                                                        //console.log(jQuery('#edittemplatepost_ifr').contents().find("body").find('div[class^=upload].selected').data('style'));
                                                        var atr = jQuery('#edittemplatepost_ifr').contents().find("body").find('div[class^=upload].selected').data('style');
                                                        jQuery('#edittemplatepost_ifr').contents().find("body").find('div.upload_img.selected').attr('style', atr);
                                                });

                                        }

                                        jQuery(document).ready(function () {

                                                jQuery('.pm_templ_review').on('click', function () {
													
														if(jQuery(".pm_templ_review").hasClass("noclick"))
														{
															jQuery(".pm_templ_review").removeClass("noclick")
															return false;
														}
														
                                                        jQuery('.pm_templ_review').removeClass('pm_selected');
                                                        var temp_id = jQuery(this).data('id');
                                                        var timeline = jQuery(this).data('timeline');

                                                        if (temp_id != undefined) {

                                                                jQuery('.pm_inst_temp').data('tempid', temp_id);
                                                                jQuery('.pm_inst_temp').data('timeline', timeline);
                                                                jQuery(this).addClass('pm_selected');
                                                                jQuery('.pm_inst_temp').trigger('click');
                                                        } else {
                                                                jQuery('.header_templates').hide();
                                                        }

                                                });
												var inserted_post = '';
                                                jQuery('.pm_inst_temp').on('click', function () {

                                                        var temp_id = jQuery(this).data('tempid');
                                                        var tree_id = jQuery(this).data('tree-id');
                                                        var timeline = jQuery(this).data('timeline');
                                                        var title = jQuery(this).data('node');

                                                        if (temp_id > 0) {
                                                                jQuery.ajax({
                                                                        type: 'POST',
                                                                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                                                                        data: 'action=pm_template_selected&temp_id=' + temp_id + '&nonce=<?php echo wp_create_nonce("pm_temp_selected"); ?>',
                                                                        success: function (res) {
                                                                                /*** only text ***/
                                                                                jQuery("#tmp_handler").html(title);
                                                                                title_new = jQuery("#tmp_handler").find("strong:first").html();
                                                                                if(jQuery("#tmp_handler").find("strong:first").length != 0)
																				{
																					title_new = jQuery("#tmp_handler").find("strong:first").html();
																				}
																				else
																				{
																					var myContent = '<div id="test">Hello <span>world!</span></div>';
																					title_new = jQuery("#tmp_handler").text();
																				}
                                                                                jQuery('.selected_temp_modal #temp_selected_title').val(title_new);

                                                                                //jQuery('.selected_temp_modal #temp_selected_title').val(title);
                                                                                jQuery('.header_templates').hide();
                                                                                var gettype;
																				var par;
                                                                                //var htm = '<p><h1>'+title+'</h1></p>'+res;
                                                                                jQuery('#edittemplatepost_ifr').contents().find("body").html('');
                                                                                jQuery('#edittemplatepost_ifr').contents().find("body").append(res);
                                                                                var title_field = jQuery.trim(jQuery('#temp_selected_title').val());
                                                                                var cnt = tinyMCE.get('edittemplatepost').getContent();
                                                                                var cid = jQuery(this).data('cid');
                                                                                jQuery('.selected_temp_modal').show('fade');
                                                                                
                                                                                //below ajax is for setting parent post to manage URL structure.
                                                                                
                                                                                // after template select start
                                                                                jQuery.ajax({
																					url: "<?php echo admin_url('admin-ajax.php'); ?>",
																					type: 'POST',
																					data: 'action=after_template_select&pid=' + tree_id + '&current_clicked_node=' + jQuery(".current_clicked_node").val() + '&title=' + title_field + '&content=' + cnt + '&cid=' + cid +'&sel_template='+temp_id,
																					success:function(res1){
																					
																						var res1 = jQuery.parseJSON(res1);
																					 
																						jQuery('#temp_selected_URL').val(res1.permalink);
																						jQuery('#p_builder').attr('href',res1.permalink+'?fl_builder');

																						/*** Copied from post_add_content AJAX ***/	
																						if (res1.post_ID > 0) {
																								var node = jQuery("#tree_" + tree_id).fancytree("getActiveNode");
																								
                                                                                        if(res1.show_in==1)
                                                                                        {
                                                                                            
                                                                                            jQuery('#savetemplate').attr('data-show_in',res1.show_in);
                                                                                            jQuery('.temp_selected').css({'display':'block'});
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            jQuery('.temp_selected').css({'display':'none'});
                                                                                            jQuery('#p_builder').click(function(){
                                                                                                jQuery('.selected_temp_modal').hide();
                                                                                             });
                                                                                            jQuery('#savetemplate').attr('data-show_in',res1.show_in);
                                                                                        }
																								if (node) {

																										var htm = '<div class="timlin90"><div><span style="text-decoration: underline;">' + title_field + '</span></div><div><div class="overbox"></div>' + cnt + '</div></div>';
																										//var htm = '<a href="' + res.url + '" target="_blank">' + title + '</a>';
																										//var htm = '<span data-url="' + res.url + '" data-type="content" data-cid="' + res.id + '">' + title + '</span>';
																										//node.setTitle(htm);
																										if (timeline == 0) {
																												htm = '<span style="text-decoration: underline;">' + title_field + '</span>';
																										}

																										node.fromDict({
																												title: htm,
																												//title: '<strong>' + title + '</strong>',
																												url: res1.permalink,
																												type: 'content',
																												cid: res1.post_ID,
																												timeline: timeline
																										});
																										jQuery('#save_tree_' + tree_id).trigger('click');
																										/*jQuery('#edittemplatepost_ifr').contents().find("body").html('');
																										jQuery('#edittemplatepost').val('')
																										//jQuery(".selected_temp_modal").hide('fade');
																										jQuery('#temp_selected_title').val('');*/

																								}
																						}	
																						/*** Copied from post_add_content AJAX ***/		
																							
																						inserted_post = res1.post_ID;
																						 var get_level = jQuery("#tree_" + tree_id).fancytree("getActiveNode");
																						
																						if(get_level.getLevel()>4)
																						{
																							
																							jQuery.ajax({
																							url: "<?php echo admin_url('admin-ajax.php'); ?>",
																							type: 'POST',
																							data: 'action=set_parent_post&pid=' + inserted_post + '&current_clicked_node=' + jQuery(".current_clicked_node").val() + '&title=' + title_field + '&content=' + cnt + '&parentid=' + jQuery(".parent_node_of_post").val() +'',
																							success:function(res2){
																									jQuery('#temp_selected_URL').val(res2);
																									var perma = jQuery('#temp_selected_URL').val();
																						var arrlink = perma.split("/");
																						arrlink.pop();
																						 var len;
																						var last = arrlink.pop();
																						
																						var joint = arrlink.join('/');
																						joint+='/';
																						
																						var limit = joint.length;
																						
																						jQuery("#temp_selected_URL").keydown(function(event){
																								//console.log(this.selectionStart);
																								//console.log("key down: "+event.which);
																								if(event.keyCode == 8){
																									this.selectionStart--;
																								}
																								if(this.selectionStart < limit){
																									this.selectionStart = limit;
																									//console.log("in key down: "+this.selectionStart);
																									event.preventDefault();
																								}
																							});
																							jQuery("#temp_selected_URL").keyup(function(event){
																								//console.log(this.selectionStart);
																								if(this.selectionStart < limit){
																									this.selectionStart = limit;
																									//console.log("key up: "+this.selectionStart);
																									event.preventDefault();
																								}
																							});
																							
																							}
																							
																							});
																						}
																						//checks the level
																						else if(jQuery('.create_timeline').val() == 1)
																						 {	
																							 jQuery('.create_timeline').val(2);
																																													
																							 jQuery.ajax({
																							url: "<?php echo admin_url('admin-ajax.php'); ?>",
																							type: 'POST',
																							data: 'action=pm_get_post_types',
																							success:function(res4){
																								//alert(res4);
																																									
																								gettype = res4;
																								var get_val = gettype.split('');
																								if(get_val[get_val.length-1]=='0')
																								{
																									get_val.pop();
																									gettype = get_val.join('');
																									par = jQuery.parseJSON(gettype);
																									len = par.length;
																									get_level.addChildren(par);
																										//console.log(this);
																								}
																							}
																							
																							});
																							
																							 //This will add default node(5 columns) everytime when new timeline is created
																																																
																							 var childobj = [{title : 'Research' ,key:'_1077'}, {title : 'Consultation', key:'_1078'}, {title : 'Pre-Op', key:'_1079'}, {title : 'Surgery', key:'_1080'}, {title : 'Post Op Visit', key:'_1081'}];
																							  
																							 //get_level.addChildren(gettype);
																							 var perma = jQuery('#temp_selected_URL').val();
																						var arrlink = perma.split("/");
																						arrlink.pop();
																						var last = arrlink.pop();
																						//alert(arrlink+' \nlength: '+arrlink.length);
																						var joint = arrlink.join('/');
																						joint+='/';
																						//alert(joint+' \nlength of string:'+joint.length);
																						var limit = joint.length;
																						
																						jQuery("#temp_selected_URL").keydown(function(event){
																								//console.log(this.selectionStart);
																								//console.log("key down: "+event.which);
																								if(event.keyCode == 8){
																									this.selectionStart--;
																								}
																								if(this.selectionStart < limit){
																									this.selectionStart = limit;
																									//console.log("in key down: "+this.selectionStart);
																									event.preventDefault();
																								}
																							});
																							jQuery("#temp_selected_URL").keyup(function(event){
																								//console.log(this.selectionStart);
																								if(this.selectionStart < limit){
																									this.selectionStart = limit;
																									//console.log("key up: "+this.selectionStart);
																									event.preventDefault();
																								}
																							});
																							cnt = "[page_timeline id="+inserted_post+"]";
																						jQuery.ajax({
																							url: "<?php echo admin_url('admin-ajax.php'); ?>",
																							type: 'POST',
																							data: 'action=insert_meta_value&pid=' + inserted_post + '&current_clicked_node=' + jQuery(".current_clicked_node").val() + '&title=' + title_field + '&content=' + cnt + '&cid=' + cid +'',
																							success:function(res3){
																								
																								
																							}
																							
																							});
																						}
																						else
																						{
																							jQuery.ajax({
																							url: "<?php echo admin_url('admin-ajax.php'); ?>",
																							type: 'POST',
																							data: 'action=insert_page_meta_value&pid=' + inserted_post + '&current_clicked_node=' + jQuery(".current_clicked_node").val() + '&title=' + title_field + '&content=' + cnt + '&cid=' + cid +'',
																							success:function(res3){
																								
																								
																							}
																							
																							});
																						
																						}
																						}
																					});
																					
																					
																					
																					//after template select over.
                                                                                jQuery('#savetemplate').data('tree-id', tree_id);
                                                                                jQuery('#savetemplate').data('tempid', temp_id);
                                                                                jQuery('#savetemplate').data('timeline', timeline);

                                                                                edit_content();

                                                                        }
                                                                })
                                                        } else {
                                                                jQuery('.header_templates').hide('fade');
                                                                jQuery('.add_link_modal .add_link_title').val(title);
                                                                jQuery('.pm_add_link_insert').data('tree-id', tree_id);
                                                                jQuery('.add_link_modal').show('fade');
                                                        }

                                                });

                                                jQuery('.pm_add_link_insert').on('click', function () {

                                                        var url = jQuery.trim(jQuery('.add_link').val());
                                                        var title = jQuery.trim(jQuery('.add_link_title').val());
                                                        var tree_id = jQuery(this).data('tree-id');
                                                        var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
                                                        jQuery('.pm_error').remove();

                                                        if (title.length == 0) {
                                                                jQuery('.add_link_title').after('<span class="pm_error">Please enter title</span>');
                                                        }

                                                        if (url.length > 0) {
                                                                if (!regexp.test(url)) {
                                                                        jQuery('.add_link').after('<span class="pm_error">Please enter valid url link</span>');
                                                                }
                                                                else {
                                                                        var node = jQuery("#tree_" + tree_id).fancytree("getActiveNode");
                                                                        if (node) {
                                                                                jQuery('.add_link_modal').hide('fade');
                                                                                //var htm = '<a href="' + url + '" target="_blank">' + url + '</a>';
                                                                                //var htm = '<span data-url="' + url + '" data-type="link">' + node.title + '</a>';
                                                                                var htm = '<u>' + title + '</u>';
                                                                                //node.addChildren({title: htm, "type": "link", 'url': url});
                                                                                node.fromDict({
                                                                                        //title: htm,
                                                                                        title: htm,
                                                                                        type: 'link',
                                                                                        url: url
                                                                                });
                                                                                jQuery('#save_tree_' + tree_id).trigger('click');
                                                                                jQuery('.add_link').val('');
                                                                        }
                                                                }


                                                        } else {
                                                                jQuery(this).after('<span class="pm_error">Please enter link</span>');
                                                        }
                                                });


                                                jQuery('#savetemplate').on('click', function () {
														jQuery("#savetemplate").val("Create Page");
                                                        var tmp_img_cls = jQuery('#edittemplatepost_ifr').contents().find("body").find('div.upload_img');
                                                        var tmp_vd_cls = jQuery('#edittemplatepost_ifr').contents().find("body").find('div.upload_video');
                                                        tmp_img_cls.removeAttr('style');
                                                        tmp_vd_cls.removeAttr('style');

                                                        var tree_id = jQuery(this).data('tree-id');
                                                        var temp_id = jQuery(this).data('tempid');
                                                        var timeline = jQuery(this).data('timeline');
                                                        var cid = jQuery(this).data('cid');
														//alert('tree_id:'+tree_id+'\ntemp_id:'+temp_id+'\ntimeline:'+timeline+'\ncid:'+cid);
                                                        jQuery('.rerror').remove();
                                                        var title = jQuery.trim(jQuery('#temp_selected_title').val());
                                                        var post_URL = jQuery.trim(jQuery('#temp_selected_URL').val());
                                                        if (title.length > 0) {

                                                                
                                                                var cnt = tinyMCE.get('edittemplatepost').getContent();
                                                                var perma = jQuery('#temp_selected_URL').val();
                                                                var slash = perma.split('');
                                                                if(slash[slash.length-1]!=='/')
                                                                {
																	slash[slash.length]='/';
																	perma = slash.join('');
																}
																//alert(perma);
																						var arrlink = perma.split("/");
																						
																						arrlink = perma.split("/");
																						arrlink.pop();
																						var last = arrlink.pop();
																						var joint = arrlink.join('/');
																						joint+='/';
																						//console.log(joint+'----'+last);
																											
																	        if(jQuery('.create_timeline').val()==2)
																						{
																							jQuery('.create_timeline').val('');
																							cnt = "[page_timeline id="+inserted_post+" tree_id="+tree_id+"]";
																						}
																						
																/*console.log("Post Slug => "+last);
																console.log("Post Title => "+title);
																console.log("Post Content => "+cnt);*/
																
                                                                jQuery.ajax({
                                                                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                                                        type: 'POST',
                                                                        data: 'action=pm_add_content&pid=' + tree_id + '&current_clicked_node=' + jQuery(".current_clicked_node").val() + '&title=' + title + '&content=' + encodeURIComponent(cnt) + '&cid=' + cid + '&nonce=<?php echo wp_create_nonce("pm_add_content"); ?>&posturl=' + post_URL+'&slug='+ last +'&insert=' + inserted_post + '',
                                                                        success: function (res) {
																				//	alert(res);
                                                                                var res = jQuery.parseJSON(res);
                                                                        
                                                                                //console.log(res);
                                                                                //alert(res.url);
                                                                                if (res.id > 0) {
                                                                                        var node = jQuery("#tree_" + tree_id).fancytree("getActiveNode");
                                                                                    	
                                                                                        if (node) {

                                                                                                var htm = '<div class="timlin90"><div><span style="text-decoration: underline;">' + title + '</span></div><div><div class="overbox"></div>' + cnt + '</div></div>';
                                                                                                //var htm = '<a href="' + res.url + '" target="_blank">' + title + '</a>';
                                                                                                //var htm = '<span data-url="' + res.url + '" data-type="content" data-cid="' + res.id + '">' + title + '</span>';
                                                                                                //node.setTitle(htm);
                                                                                                if (timeline == 0) {
                                                                                                        htm = '<span style="text-decoration: underline;">' + title + '</span>';
                                                                                                }

                                                                                                node.fromDict({
                                                                                                        title: htm,
                                                                                                        //title: '<strong>' + title + '</strong>',
                                                                                                        url: res.url,
                                                                                                        type: 'content',
                                                                                                        cid: res.id,
                                                                                                        timeline: timeline
                                                                                                });
                                                                                                jQuery('#save_tree_' + tree_id).trigger('click');
                                                                                                jQuery('#edittemplatepost_ifr').contents().find("body").html('');
                                                                                                jQuery('#edittemplatepost').val('')
                                                                                                
                                                                                                jQuery('#temp_selected_title').val('');
                                                                                                var btn_attr = jQuery('#savetemplate').attr('data-show_in');;
                                                                                                if(btn_attr==0)
                                                                                                {
                                                                                                    window.open(post_URL+"?fl_builder",'_blank');
                                                                                                    jQuery(".selected_temp_modal").hide('fade');
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    jQuery(".selected_temp_modal").hide('fade');
                                                                                                }
                                                                                                

                                                                                        }
                                                                                }
                                                                        }
                                                                });
															

                                                        } else {
                                                                jQuery('#temp_selected_title').after('<span class="rerror" style="font-size: 12px;color: red;">Please enter title here.</span>');
                                                        }

                                                });
                                        });

                                        function callb() {
                                                jQuery('#insert-media-button').trigger('click');

                                        }

                                        function handleFileUpload(files, obj)
                                        {
                                                //console.log(files);
                                                var fd = new FormData();

                                                fd.append('file', files[0]);

                                                //  var status = new createStatusbar(obj); //Using this we can set progress.
                                                //  status.setFileNameSize(files[i].name,files[i].size);
                                                sendFileToServer(fd, status);

                                        }

                                        function sendFileToServer(formData, status)
                                        {
                                                var uploadURL = "<?php echo admin_url('admin-ajax.php'); ?>"; //Upload URL
                                                var extraData = {}; //Extra Data.

                                                var jqXHR = jQuery.ajax({
                                                        xhr: function () {
                                                                var xhrobj = jQuery.ajaxSettings.xhr();
                                                                if (xhrobj.upload) {
                                                                        xhrobj.upload.addEventListener('progress', function (event) {
                                                                                /*   var percent = 0;
                                                                                 var position = event.loaded || event.position;
                                                                                 var total = event.total;
                                                                                 if (event.lengthComputable) {
                                                                                 percent = Math.ceil(position / total * 100);
                                                                                 }
                                                                                 //Set progress
                                                                                 status.setProgress(percent);*/
                                                                        }, false);
                                                                }
                                                                return xhrobj;
                                                        },
                                                        url: uploadURL + "?action=pm_drop_files&nonce=<?php echo wp_create_nonce("pm_upload_nonce"); ?>",
                                                        type: "POST",
                                                        contentType: false,
                                                        processData: false,
                                                        cache: false,
                                                        data: formData,
                                                        beforeSend: function () {
                                                                jQuery('#edittemplatepost_ifr').contents().find("body").find('div.upload_img.selected').html('<img src="<?php echo plugins_url("images/loader.gif", __FILE__) ?>" style="margin-top: 70px;" />');
                                                        },
                                                        success: function (data) {
                                                                //status.setProgress(100);
                                                                var res = jQuery.parseJSON(data);
                                                                if (res != "error")
                                                                {
                                                                        jQuery('#edittemplatepost_ifr').contents().find("body").find('div.upload_img.selected').html(res.img);
                                                                        jQuery('#edittemplatepost_ifr').contents().find("body").find('div.upload_img.selected').removeAttr('style');
                                                                        jQuery('#edittemplatepost_ifr').contents().find("body").find('div.upload_img.selected img').addClass('wp-image-' + res.id);

                                                                }
                                                                else
                                                                {

                                                                        alert('error');
                                                                }
                                                                //$("#status1").append("File upload Done<br>");           
                                                        }
                                                });
                                        }

                </script>
                <div class="pm_popup_modal modal modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content cu_modal-content">
							<a class="editlink" >Edit Template</a>
							<div class="title"><h5></h5></div>
                            <div class="modal-header1">
                                <img data-dismiss="modal" src="<?php echo plugins_url("images/close.png", __FILE__) ?>" onclick="jQuery('.pm_popup_modal').hide();
                                                                jQuery('.pm_data_body').empty();" class="media-modal-close" />
                            </div>
                            <div class="modal-body cu_modal-body">
                                <div class="entry-content">
                                    <div class="url"></div>
                                    
                                    <div class="pm_data_body"></div>
                                    <script class="pm_data_body_script"></script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="pm_iframe_modal modal modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
							<a class="editiframelink">Edit Template</a>
                            <div class="modal-header1">
                                <img data-dismiss="modal" src="<?php echo plugins_url("images/close.png", __FILE__) ?>" onclick="jQuery('.pm_iframe_modal').hide();
                                                                jQuery('#contentFrame').empty();" class="media-modal-close" />
                            </div>
                            <div class="modal-body">
                                <iframe src="#" name="contentFrame" id="contentFrame" width="100%" height="80%"
                                        scrolling="yes" marginheight="0" marginwidth="0" frameborder="0">
                                <p>Your browser does not support iframes</p>
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
        } else {
                ?>
                <style>
                    .img_outr {
                        display: inline-block;
                        margin: 1%;
                    }
                    .carousel-caption{
                        position:relative;
                        right: 0;
                        left: 0;
                        bottom: 0;
                        color: #000;
                    }
                    .carousel-control{

                        background-image:none !important;  
                        border-bottom:none !important;
                        width: 4%;

                    }
                </style>

                <div class="pm_popup_modal modal modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header1">
                                <img data-dismiss="modal" src="<?php echo plugins_url("images/close.png", __FILE__) ?>" onclick="jQuery('.pm_popup_modal').hide();
                                                                jQuery('.pm_data_body').empty();" class="media-modal-close" />
                            </div>
                            <div class="modal-body">
                                <div class="entry-content">
                                    <div class="url"></div>
                                    <div class="title"><h1></h1></div>
                                    <div class="pm_data_body"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pm_iframe_modal modal modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header1">
                                <img data-dismiss="modal" src="<?php echo plugins_url("images/close.png", __FILE__) ?>" onclick="jQuery('.pm_iframe_modal').hide();
                                                                jQuery('#contentFrame').empty();" class="media-modal-close" />
                            </div>
                            <div class="modal-body">
                                <iframe src="#" name="contentFrame" id="contentFrame" width="100%" height="80%"
                                        scrolling="yes" marginheight="0" marginwidth="0" frameborder="0">
                                <p>Your browser does not support iframes</p>
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
        }
        ?>
        </div>
        </div>
        </div>
        
        <?php
}

add_shortcode('patient_page_timeline', 'patient_page_shortcode');

function p_patient_page_shortcode() {
	global $current_user;
    get_currentuserinfo();
	$posts = get_posts(
                array(
					'orderby'=>'menu_order',
                    'posts_per_page' => -1,
                    'post_type' => 'patient_page',
                    'order' => 'ASC',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'patient_category',
                            'field' => 'slug',
                            'terms' => 'timeline-default',
                        )
                    )
                )
        );
        $cwidth=count($posts)*310;
        
	?>
	<input type="hidden" value="" class="current_clicked_node" />
	<input type="hidden" value="" class="parent_node_of_post" />
	<div id="scrollbar">
			<a id="left_scroll" class="mouseover_left" href="#"></a>
			<div id="track">
				 <div id="dragBar"></div>
			</div>
			<a id="right_scroll" class="mouseover_right" href="#"></a></div>
		</div>
	<div id="horiz_container_outer">
			<div id="horiz_container_inner">
			<div id="horiz_container" style="width:<?php echo $cwidth; ?>px">
	<?php

        /* $p = array(
          'post_status' => 'publish',
          'post_type' => 'timeline_page',
          //'orderby' => 'date',
          'post_parent' => 0,
          //'category_name'=> 'timeline-default',
          'order' => 'ASC',
          'numberposts' => -1,
          );
          $posts = get_posts($p); */


        
        ?>
        <?php /*
        <ul id="sortable">
  <li class="ui-state-default">1</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">2</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">3</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">4</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">5</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">6</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">7</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">8</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">9</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">10</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">11</li>
  <script>console.log("1");</script>
  <li class="ui-state-default">12</li>
  <script>console.log("1");</script>
</ul>
<script>
  jQuery(function() {
    jQuery( "#sortable" ).sortable();
    jQuery( "#sortable" ).disableSelection();
  });
  </script> */ ?>
  <div class="modal fade" id="email_link_myModal" role="dialog">
	<div class="modal-dialog modal-lg">
	
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title">Email</h4>
		</div>
		<div class="modal-body">
		  
			  <div class='container'>
			  <div class='col-md-9'>
			  
				<form class="form-horizontal email_popup_form" role="form">
				  
				  <div class="form-group req">
					<label class="control-label col-sm-2" for="email">To:</label>
					<div class="col-sm-10">
					  <input type="email" class="form-control to_email" id="email" name='to_email'>
					</div>
				  </div>
				 
				  
				  <div class="form-group req"> 
					<label class="control-label col-sm-2" for="sub">Subject:</label>
					<div class="col-sm-10"> 
					  <input type="text" class="form-control subject" id="sub" name='subject' value="<?php echo get_user_meta($current_user->ID,'timeline_subject',true); ?>">
					</div>
				  </div>
				  
				  <div class="form-group"> 
					  <label class="control-label col-sm-2" for="sub"></label>
					  <div class="col-sm-10"> 
						  <?php 
						  $content = '';
							$editor_id = 'mycustomeditor_afds';
							$settings = array(
							'media_buttons'=>false,
							'textarea_name'=>'message_test1' ,
							'editor_class'=>'add_link_test' ,
							'media_buttons' => false,
							'quicktags'     => TRUE,
							'textarea_rows' => 50,
							'editor_height' => '50px'
							);
							wp_editor($content, $editor_id, $settings = array('editor_height' => 350, 'media_buttons' => true, 'quicktags' => false, 'tinymce' => array(
                                                'toolbar1'=>'bold italic |  bullist | link image unlink | wp_adv',
                                                'toolbar2' => 'formatselect,underline,justifyfull,forecolor,|,pastetext,pasteword,removeformat,|,media,charmap,|,outdent,indent,|,undo,redo,wp_help,image | alignleft aligncenter alignright alignjustify | numlist outdent indent |',
                                              //'theme_advanced_buttons1' => 'bold, italic, ul, min_size, max_size'
                                        )));

						  ?>
						<!--<textarea class='cont_test' name='message_test'></textarea>-->
					  </div>
				  </div>
				  
				 
				</form>
			  </div>
			  </div>
		  
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-default for_email">Send Email</button>
		</div>
	  </div>
	  
	</div>
</div>
  <div class="row">
  
   <?php
                if (!empty($posts)) {
                        foreach ($posts as $k => $v) {
                                ?>
                                <script>
									var num_link_<?php echo $v->ID; ?>;
                                </script>
                                <div class="pm_inner_box col-md-2 col-sm-6 col-xm-12" postid="<?php echo $v->ID; ?>">
                                    <h4><?php echo $v->post_title; ?></h4>
                                    <div class="pm_tree_area">
                                        <div class="tree" id="tree_<?php echo $v->ID; ?>" data-id="<?php echo $v->ID; ?>">
                                        </div>
                                        <?php if (is_super_admin()) { ?>
                                                <div class="pm_tree_sv09" style="display:none;">
                                                    <input type="button" name="save_tree" id="save_tree_<?php echo $v->ID; ?>" value="Save"/>
                                                </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                  
                               <?php 
						   }
					   } ?> 
					   <div class="pm_tree_sv09" style="float:right">
							<input type="button" name="email_link" id="email_link" value="Email Link" class="mail_link" />
						</div>
					   <?php 
					   if(is_super_admin())
					   {
					   ?>
					   
					
						<script>
								//top.email_link;
								var t_arr=[];
								
							jQuery(document).ready(function(){
							
								jQuery('.mail_link').click(function(){
									var final_mail=[];
									var put_str ='';
														<?php
														
														$i=0;
														foreach ($posts as $k => $v) {
															
															
															?>
															if(num_link_<?php echo $v->ID; ?>!='' && num_link_<?php echo $v->ID; ?>.length>0)
															{
																
														
															final_mail[<?php echo $i;?>] = num_link_<?php echo $v->ID; ?>;
															put_str += num_link_<?php echo $v->ID; ?>;
															<?php $i++; ?>
															}
															<?php
															
														}
														?>
														
															
															jQuery("#email_link_myModal").modal();
															
															tinyMCE.get('mycustomeditor_afds').setContent("<?php echo addslashes(get_user_meta($current_user->ID,'int_msg',true)); ?><br>"+put_str.replace(",","")+''+"<br><?php echo addslashes(get_user_meta($current_user->ID,'timeline_email',true)); ?>");
															
														});
														jQuery('.for_email').click(function(e){
																	e.preventDefault();
																	//alert();
																	var mail_data = jQuery('.email_popup_form').serialize();
																	var msg_body = tinyMCE.get('mycustomeditor_afds').getContent();
																	msg_body = msg_body.trim();
																	var tomail = jQuery('.to_email').val();
																	var subject = jQuery('.subject').val();
																	jQuery('.req').each(function(){
																		if(jQuery(this).find('input').val().length<=0)
																		{
																			jQuery(this).addClass('has-error');
																		}
																		else
																		{
																			jQuery(this).removeClass('has-error');
																		}
																	});
																	if(tomail!='' && subject!='')
																	{
																	jQuery.ajax({
																		url:"<?php echo admin_url('admin-ajax.php'); ?>",
																		type:'POST',
																		data:'action=mail_link_popup&to_email='+tomail+'&subject='+subject+'&message_test='+encodeURIComponent(msg_body),
																		beforeSend:function()
																		{
																			
																			jQuery('.for_email').removeClass('btn-default').addClass('btn-warning');
																			jQuery('.for_email').text('Sending...');
																		},
																		success:function(res)
																		{
																			if(res)
																			{
																				jQuery('.for_email').text('Mail Sent');
																				jQuery('.for_email').removeClass('btn-warning').addClass('btn-success');
																				setTimeout(function(){ 
																					jQuery('#email_link_myModal').trigger('click'); 
																					jQuery('.for_email').text('Send Email');
																					jQuery('.to_email').val('');
																					jQuery('.subject').val('');
																					jQuery('#mycustomeditor_afds_ifr').contents().find('#tinymce').html('');
																					
																				jQuery('.for_email').removeClass('btn-success').addClass('btn-default');
																					
																				},2000);
																				
																			}
																			else
																			{
																				//alert('Some error occurred');
																			}
																			//console.log(jQuery('#mycustomeditor_afds_ifr').contents().find('#tinymce').html());
																		}
																	});
																}
																});
								});
						</script>
						<?php 
						}
						else
						{
							?>
							<script>
								//top.email_link;
								var t_arr=[];
								
							jQuery(document).ready(function(){
							
								jQuery('.mail_link').click(function(){
									var final_mail=[];
									var put_str ='';
														<?php
														
														$i=0;
														foreach ($posts as $k => $v) {
															
															
															?>
															if(num_link_<?php echo $v->ID; ?>!='' && num_link_<?php echo $v->ID; ?>.length>0)
															{
																
															//console.log(num_link_<?php echo $v->ID; ?>);
															final_mail[<?php echo $i;?>] = num_link_<?php echo $v->ID; ?>;
															put_str += num_link_<?php echo $v->ID; ?>;
															<?php $i++; ?>
															}
															<?php
															
														}
														?>
														
															
															jQuery("#email_link_myModal").modal();
															
															tinyMCE.get('mycustomeditor_afds').setContent(put_str.replace(",",""));
															
														});
														jQuery('.for_email').click(function(e){
																	e.preventDefault();
																	//alert();
																	var mail_data = jQuery('.email_popup_form').serialize();
																	var msg_body = tinyMCE.get('mycustomeditor_afds').getContent();
																	msg_body = msg_body.trim();
																	var tomail = jQuery('.to_email').val();
																	var subject = jQuery('.subject').val();
																	jQuery('.req').each(function(){
																		if(jQuery(this).find('input').val().length<=0)
																		{
																			jQuery(this).addClass('has-error');
																		}
																		else
																		{
																			jQuery(this).removeClass('has-error');
																		}
																	});
																	if(tomail!='' && subject!='')
																	{
																	jQuery.ajax({
																		url:"<?php echo admin_url('admin-ajax.php'); ?>",
																		type:'POST',
																		data:'action=mail_link_popup&to_email='+tomail+'&subject='+subject+'&message_test='+encodeURIComponent(msg_body),
																		beforeSend:function()
																		{
																			
																			jQuery('.for_email').removeClass('btn-default').addClass('btn-warning');
																			jQuery('.for_email').text('Sending...');
																		},
																		success:function(res)
																		{
																			if(res)
																			{
																				jQuery('.for_email').text('Mail Sent');
																				jQuery('.for_email').removeClass('btn-warning').addClass('btn-success');
																				setTimeout(function(){ 
																					jQuery('#email_link_myModal').trigger('click'); 
																					jQuery('.for_email').text('Send Email');
																					jQuery('.to_email').val('');
																					jQuery('.subject').val('');
																					jQuery('#mycustomeditor_afds_ifr').contents().find('#tinymce').html('');
																					
																				jQuery('.for_email').removeClass('btn-success').addClass('btn-default');
																					
																				},2000);
																				
																			}
																			else
																			{
																				//alert('Some error occurred');
																			}
																			//console.log(jQuery('#mycustomeditor_afds_ifr').contents().find('#tinymce').html());
																		}
																	});
																}
																});
								});
						</script>
							<?php
						}
					   ?>
					   </div>
					   <script>
  jQuery(function() {
    jQuery( ".row" ).sortable({
		stop:function(){
															var post_ids ="";
															jQuery(".pm_inner_box").each(function(){
																post_ids += jQuery(this).attr("postid")+"#";
															});
														
															jQuery.ajax({
																	type: 'POST',
																	url: '<?php echo admin_url('admin-ajax.php'); ?>',
																	data: 'action=save_position&postids='+post_ids+'&nonce=<?php echo wp_create_nonce('save_position_'); ?>',
																	success: function (res) {
																		//alert("success");
																	}

															});
														}
    });
    jQuery( ".row" ).disableSelection();
  });
  </script>
  <?php
                if (!empty($posts)) {
                        foreach ($posts as $k => $v) {
                                ?>
   <?php if (is_super_admin()) { ?>
                                        <script type="text/javascript">
											var parent_post_id;
                                                jQuery(document).ready(function () {
                                                        var CLIPBOARD = null;
                                                        jQuery("#tree_<?php echo $v->ID; ?>").fancytree({
                                                                icons: false,
                                                                checkbox:true,
                                                                extensions: ["dnd", "edit"],
                                                                source: {url: "<?php echo admin_url('admin-ajax.php') . '?action=pm_tree_get&id=' . $v->ID . '&nonce=' . wp_create_nonce('pm_tree_get_' . $v->ID); ?>"},
                                                                lazyLoad: function (event, data) {
                                                                        data.result = {url: "ajax-sub2.json", debugDelay: 1000};
                                                                },
                                                                init: function (event,data) {
																	var selNodes = data.tree.getSelectedNodes();
																	//console.log(selNodes);
																	num_link_<?php echo $v->ID; ?>	= jQuery.map(selNodes, function(node){
																		
																			 return  '<a href="'+encodeURI(node.data.url)+'">'+node.title+'</a><br>' ;
																			//return node.data.url+'<br>';
																		  });
																		  
																},
                                                                dnd: {
                                                                        autoExpandMS: 400,
                                                                        focusOnClick: true,
                                                                        preventVoidMoves: true,
                                                                        preventRecursiveMoves: true,
                                                                        dragStart: function (node, data) {                                                                              
                                                                                return true;
                                                                        },
                                                                        dragEnter: function (node, data) {
                                                                              
                                                                                return true;
                                                                        },
                                                                        dragDrop: function (node, data) {                                                                              
                                                                                data.otherNode.moveTo(node, data.hitMode);
                                                                        }
                                                                },
                                                                select: function(event,data){
																	//var node = data.node
																	
																	/*if(data.node.hasChildren())
																	{
																		//data.node.hideCheckbox=true;
																		data.node.setSelected(false);
																		//return false;
																	}else
																	{
																	   var selNodes = data.tree.getSelectedNodes();
																	num_link_<?php echo $v->ID; ?>	= jQuery.map(selNodes, function(node){
																		//console.log(node.title);
																		
																			 return  '<a href="'+encodeURI(node.data.url)+'">'+node.title+'</a><br>' ;
																			//return node.data.url+'<br>';
																		  });
																		  
																	}*/
																	 var selNodes = data.tree.getSelectedNodes();
																	num_link_<?php echo $v->ID; ?>	= jQuery.map(selNodes, function(node){
																		//console.log(node.data.url);
																			if(node.data.url!=undefined)
																			{
																			 return  '<a href="'+encodeURI(node.data.url)+'">'+node.title+'</a><br>' ;
																			}
																			
																			//return node.data.url+'<br>';
																		  });
																	
																	//alert(email_link);
																},
                                                                dblclick:function(event, data) {
																	var node = data.node;
																	if (node.data.type == 'content') {
																		return false;
																	}
																	else if (node.data.type == 'link') {
																		return false;
																	}
																},
                                                                click: function (event, data) {
																		
																		if(data.targetType=="checkbox")
																		{
																				/*if(data.node.hasChildren())
																				{
																				    data.node.hideCheckbox=true;
																					data.node.setSelected(false);
																					//return false;
																				}else
																				{
																				   
																				    //return false;
																				}*/
																		}
																		else{
                                                                        var node = data.node;
																		
                                                                        jQuery('.fancytree-node').removeClass('fancytree-active');

                                                                        if (node.data.type == 'link') {
																			     var title = jQuery(data.node.title).text();
                                                                                 var tree_id = jQuery(data.node.li).closest('div.tree').data('id');
                                                                               
                                                                                window.open(node.data.url, 'contentFrame');
                                                                           
                                                                                jQuery('.pm_iframe_modal .editiframelink').attr("c_title",title);
                                                                                jQuery('.pm_iframe_modal .editiframelink').attr("c_treeid",tree_id);
                                                                                jQuery('.pm_iframe_modal .editiframelink').attr("c_url",data.node.data.url);
                                                                                jQuery('.pm_iframe_modal').modal('show');


                                                                        } 
                                                                         else if (node.data.type == 'content') {
																			 var tree_id = jQuery(data.node.li).closest('div.tree').data('id');
																			// alert(node.getKeyPath());
																			
																			// get key path from root node to current node
																			// var p = node.getKeyPath();
																			 
																			 //convert that path into an array
																			// var arr = p.split("/");
																			// var root;
																			 
																			 //remove first element from array because it is " , "
																			// arr.shift();
      																		// var i = arr.shift();
																			//	alert(i);
																			//	 root = jQuery("#tree_<?php echo $v->ID; ?>").fancytree("getTree").activateKey(i);
																				// alert(root.data.cid);
																				//console.log("http://"+window.location);
																			     jQuery.ajax({
                                                                                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                                                                                        data: "action=pm_content_disp1&cid=" + node.data.cid + "&nonce=<?php echo wp_create_nonce('pm_content_disp_'); ?>",
                                                                                        type: 'Post',
                                                                                        cache:false,
                                                                                        success: function (res) {
																								//console.log(res);
																								jQuery('.pm_popup_modal').modal('show');
                                                                                                var res = jQuery.parseJSON(res);
                                                                                                
                                                                                                jQuery(".pm_popup_modal .editlink").attr("c_cid",node.data.cid);
                                                                                                jQuery(".pm_popup_modal .editlink").attr("c_treeid",tree_id);
                                                                                                jQuery(".pm_popup_modal .editlink").attr("c_timeline",node.data.timeline);
                                                                                                jQuery('.pm_popup_modal .pm_data_body').html(res.content);
                                                                                                
																									if(res.is_beaver_builder==1)
																									{
																										//console.log("<?php echo get_option('siteurl');?>");
																									jQuery.getScript('<?php echo get_option('siteurl');?>/wp-content/uploads/bb-plugin/cache/'+res.id+'-layout.js',function(res){
																										
																										//eval(res);
																									   });
																								   }
																								
                                                                                                jQuery('.pm_popup_modal .title h5').text(" Page Title: "+res.title);
                                                                                                jQuery('.pm_popup_modal .url').html('<a href="' + res.url + '" target="_blank">' + res.url + '</a>');
                                                                                            
                                                                                                jQuery('.pm_popup_modal').modal('show');
                                                                                                jQuery('.selected_temp_moda .media-modal-close').trigger("click");
                                                                                        },
																							complete:function()
																							{
																								setTimeout(function(){jQuery('.pm_popup_modal').resize();
																									},3000);
																									jQuery('#myModal').scroll(function(){
																										
																										jQuery('.pm_data_body').resize();
																										});
																							}
                                                                                });

                                                                        }
																	}
                                                                }, 
                                                                edit: {
                                                                        triggerStart: ["f2", "dblclick", "shift+click", "mac+enter"],
                                                                        beforeEdit: function (event, data) {
                                                                                var n = data.node;
                                                                                var node_data = data.node.data;
                                                                                  var tree_id1 = jQuery(data.node.li).closest('div.tree').data('id');
                                                                               
																				jQuery(".current_clicked_node").val(data.node.key);
                                                                                if (node_data.type == 'content') {
                                                                                        var tree_id = jQuery(data.node.li).closest('div.tree').data('id');
                                                                                        var cid = node_data.cid;
																					var get_level = jQuery("#tree_" + tree_id).fancytree("getActiveNode");
																					
                                                                                        jQuery.ajax({
                                                                                                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                                                                                                data: "action=pm_content_edit&cid=" + cid + "&nonce=<?php echo wp_create_nonce('pm_content_edit_'); ?>",
                                                                                                type: 'Post',
                                                                                                success: function (res) {
																										
                                                                                                        var res = jQuery.parseJSON(res);
                                                                                                        jQuery('.selected_temp_modal #temp_selected_URL').val(res.url);
																										jQuery('#p_builder').attr('href',res.url+'?fl_builder');
                                                                                                        jQuery('.selected_temp_modal #temp_selected_title').val(res.title);
                                                                                                        jQuery('#edittemplatepost_ifr').contents().find("body").html('');
                                                                                                        jQuery('#edittemplatepost_ifr').contents().find("body").append(res.content);
                                                                                                      
                                                                                                        jQuery('#savetemplate').data('tree-id', tree_id);
                                                                                                        jQuery('#savetemplate').data('tempid', 0);
                                                                                                        jQuery('#savetemplate').data('timeline', node_data.timeline);
                                                                                                        jQuery('#savetemplate').data('cid', cid);
                                                                                                        jQuery('.selected_temp_modal').show("fade");
																										edit_content();
																										//alert("level : "+get_level.getLevel());
																										if(get_level.getLevel()>2)
																										{
																														
																													var perma = jQuery('#temp_selected_URL').val();
																													var arrlink = perma.split("/");
																													arrlink.pop();
																													var last = arrlink.pop();
																													
																													var joint = arrlink.join('/');
																													joint+='/';
																													
																													var limit = joint.length;
																													
																													jQuery("#temp_selected_URL").keydown(function(event){
																															//console.log(this.selectionStart);
																															//console.log("key down: "+event.which);
																															if(event.keyCode == 8){
																																this.selectionStart--;
																															}
																															if(this.selectionStart < limit){
																																this.selectionStart = limit;
																																//console.log("in key down: "+this.selectionStart);
																																event.preventDefault();
																															}
																														});
																														jQuery("#temp_selected_URL").keyup(function(event){
																															//console.log(this.selectionStart);
																															if(this.selectionStart < limit){
																																this.selectionStart = limit;
																																//console.log("key up: "+this.selectionStart);
																																event.preventDefault();
																															}
																														});
																											}
																											else if(get_level.getLevel()<2)
																						 {
																							 
																							 var perma = jQuery('#temp_selected_URL').val();
																						var arrlink = perma.split("/");
																						arrlink.pop();
																						var last = arrlink.pop();
																						//alert(arrlink+' \nlength: '+arrlink.length);
																						var joint = arrlink.join('/');
																						joint+='/';
																						//alert(joint+' \nlength of string:'+joint.length);
																						var limit = joint.length;
																						
																						jQuery("#temp_selected_URL").keydown(function(event){
																								//console.log(this.selectionStart);
																								//console.log("key down: "+event.which);
																								if(event.keyCode == 8){
																									this.selectionStart--;
																								}
																								if(this.selectionStart < limit){
																									this.selectionStart = limit;
																									//console.log("in key down: "+this.selectionStart);
																									event.preventDefault();
																								}
																							});
																							jQuery("#temp_selected_URL").keyup(function(event){
																							//	console.log(this.selectionStart);
																								if(this.selectionStart < limit){
																									this.selectionStart = limit;
																									//console.log("key up: "+this.selectionStart);
																									event.preventDefault();
																								}
																							});
																								
																						}
																										//alert(jQuery('#temp_selected_URL').val());
																								  }
                                                                                        }); 
                                                                                        
                                                                                        return false;

                                                                                } else if (node_data.type == 'link') {
                                                                                        var title = jQuery(data.node.title).text();

                                                                                        var tree_id = jQuery(data.node.li).closest('div.tree').data('id');
                                                                                        jQuery('.pm_add_link_insert').data('tree-id', tree_id);
                                                                                        jQuery('.add_link_modal .add_link_title').val(title);
                                                                                        jQuery('.add_link_modal .add_link').val(node_data.url);
                                                                                        jQuery('.add_link_modal').show();

                                                                                        return false;
                                                                                }
                                                                        },
                                                                        edit: function (event, data) {
                                                                               
                                                                        },
                                                                        beforeClose: function (event, data) {
                                                                             
                                                                        },
                                                                        save: function (event, data) {

                                                                                setTimeout(function () {
                                                                                        jQuery(data.node.span).removeClass("pending");
                                                                                      
                                                                                        data.node.setTitle(data.node.title);
                                                                                        jQuery('#save_tree_<?php echo $v->ID; ?>').trigger('click');


                                                                                }, 2000);
                                                                              
                                                                                return true;
                                                                        },
                                                                        close: function (event, data) {
                                                                             
                                                                                if (data.save && data.isNew) {
                                                                                       
                                                                                        jQuery("#tree").trigger("nodeCommand", {cmd: "addSibling"});
                                                                                        data.node.setActive();
                                                                                        jQuery("#tree_<?php echo $v->ID; ?>").trigger("nodeCommand", {cmd: "add_page"});
                                                               
                                                                                        jQuery(data.node.span).addClass("pending");
                                                                                }
                                                                        }
                                                                },
                                                                table: {
                                                                        indentation: 20,
                                                                        nodeColumnIdx: 2,
                                                                        checkboxColumnIdx: 0
                                                                },
                                                                gridnav: {
                                                                        autofocusInput: false,
                                                                        handleCursorKeys: true
                                                                },
                                                                renderColumns: function (event, data) {
                                                                        var node = data.node,
                                                                                $select = jQuery("<select />"),
                                                                                $tdList = jQuery(node.tr).find(">td");

                                                                        $tdList.eq(1).text(node.getIndexHier()).addClass("alignRight");
                                                                      
                                                                        if (node.isFolder()) {
                                                                                $tdList.eq(2)
                                                                                        .prop("colspan", 6)
                                                                                        .nextAll().remove();
                                                                        }
                                                                        $tdList.eq(3).html("<input type='input' value='" + "" + "'>");
                                                                        $tdList.eq(4).html("<input type='input' value='" + "" + "'>");
                                                                        $tdList.eq(5).html("<input type='checkbox' value='" + "" + "'>");
                                                                        $tdList.eq(6).html("<input type='checkbox' value='" + "" + "'>");
                                                                        jQuery("<option />", {text: "a", value: "a"}).appendTo($select);
                                                                        jQuery("<option />", {text: "b"}).appendTo($select);
                                                                        $tdList.eq(7).html($select);
                                                                }
                                                        }).on("nodeCommand", function (event, data) {
                                                              
                                                                var refNode, moveMode,
                                                                        tree = jQuery(this).fancytree("getTree"),
                                                                        node = tree.getActiveNode();
                                                                        var current_node = node;
																		//		alert(node.parent.title);
																				
																				
																			// get key path from root node to current node
																			 var p = node.getKeyPath();
																			 
																			 //convert that path into an array
																			 var arr = p.split("/");
																			 var root;
																			 //alert(arr);
																			 //remove first element from array because it is " , "
																			 arr.shift();
      																		 var i = arr.shift();
																			//	alert(i);
																				 root = jQuery("#tree_<?php echo $v->ID; ?>").fancytree("getTree").activateKey(i);
																				 parent_post_id = root.data.cid;
																				 jQuery(".parent_node_of_post").val(parent_post_id);
																				 //alert("parent_node_:"+jQuery(".parent_node_of_post").val());
																				 p = current_node.getKeyPath();
																				 arr = p.split("/");
																				 i = arr.pop();
																				 root = jQuery("#tree_<?php echo $v->ID; ?>").fancytree("getTree").activateKey(i);
																				// alert(root.title);
																				 
                                                                switch (data.cmd) {
                                                                        case "moveUp":
                                                                                refNode = node.getPrevSibling();
                                                                                if (refNode) {
                                                                                        node.moveTo(refNode, "before");
                                                                                        node.setActive();
                                                                                }
                                                                                break;
                                                                        case "moveDown":
                                                                                refNode = node.getNextSibling();
                                                                                if (refNode) {
                                                                                        node.moveTo(refNode, "after");
                                                                                        node.setActive();
                                                                                }
                                                                                break;
                                                                        case "indent":
                                                                                refNode = node.getPrevSibling();
                                                                                if (refNode) {
                                                                                        node.moveTo(refNode, "child");
                                                                                        refNode.setExpanded();
                                                                                        node.setActive();
                                                                                }
                                                                                break;
                                                                        case "outdent":
                                                                                if (!node.isTopLevel()) {
                                                                                        node.moveTo(node.getParent(), "after");
                                                                                        node.setActive();
                                                                                }
                                                                                break;
                                                                        case "rename":
                                                                                node.editStart();
                                                                                break;
                                                                        case "remove":
                                                                                refNode = node.getNextSibling() || node.getPrevSibling() || node.getParent();
                                                                                node.remove();
                                                                              
                                                                                if (refNode) {
                                                                                        refNode.setActive();
                                                                                        if (node.data.type == 'content') {

                                                                                                jQuery.ajax({
                                                                                                        type: 'Post',
                                                                                                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                                                                                        data: 'action=pm_del_page&pid=' + node.data.cid + '&nonce=<?php echo wp_create_nonce("pm_del_page"); ?>',
                                                                                                        success: function (res) {
                                                                                                            
                                                                                                        }
                                                                                                })
                                                                                        }
                                                                                        jQuery('#save_tree_<?php echo $v->ID; ?>').trigger('click');

                                                                                }

                                                                                break;
                                                                        case "addChild":
                                                                                node.editCreateNode("child", "");
                                                                                break;
                                                                        case "addSibling":
                                                                                node.editCreateNode("after", "");
                                                                                break;
                                                                        case "cut":
                                                                                CLIPBOARD = {mode: data.cmd, data: node};
                                                                                break;
                                                                        case "copy":
                                                                                CLIPBOARD = {
                                                                                        mode: data.cmd,
                                                                                        data: node.toDict(function (n) {
                                                                                                delete n.key;
                                                                                        })
                                                                                };
                                                                                break;
                                                                        case "clear":
                                                                                CLIPBOARD = null;
                                                                                break;
                                                                        case "paste":
                                                                                if (CLIPBOARD.mode === "cut") {
                                                                                       
                                                                                        CLIPBOARD.data.moveTo(node, "child");
                                                                                        jQuery('#save_tree_<?php echo $v->ID; ?>').trigger('click');
                                                                                        CLIPBOARD.data.setActive();
                                                                                } else if (CLIPBOARD.mode === "copy") {
                                                                                        node.addChildren(CLIPBOARD.data).setActive();
                                                                                        jQuery('#save_tree_<?php echo $v->ID; ?>').trigger('click');
                                                                                }
                                                                                break;
                                                                        case "image":
                                                                                jQuery('#insert-media-button').trigger('click');

                                                                                wp.media.editor.send.attachment = function (a, b) {
                                                                                         if (b.type == 'image') {
                                                                                                var htm = '<div class="pm_img_disp" data-url="' + b.url + '" data-id="' + b.id + '" data-type="image"><img src="' + b.url + '" width="100" /></div>';
                                                                                                node.addChildren({"title": b.title + htm, "type": "image", "id": b.id, "url": b.url});
                                                                                        } else {
                                                                                                alert('Image type only allowed');
                                                                                        }


                                                                                };

                                                                                window.restore_send_to_editor = window.send_to_editor;

                                                                                window.send_to_editor = function (html) {

                                                                                        window.send_to_editor = window.restore_send_to_editor;
                                                                                };
                                                                                return false;
                                                                                break;
                                                                        case "video":

                                                                                jQuery('#insert-media-button').trigger('click');
                                                                                wp.media.editor.send.attachment = function (a, b) {
                                                                                        if (b.type == 'video' || b.type == 'audio') {
                                                                                                 var htm = '<div class="pm_vd_disp" data-url="' + b.url + '" data-id="' + b.id + '" data-type="video"><video name="media" width="100"><source src="' + b.url + '" type="' + b.mime + '"></video></div>';
                                                                                                node.addChildren({title: b.title + htm, "type": "video", id: b.id, url: b.url});
                                                                                        } else {
                                                                                                alert('Video type only allowed');
                                                                                        }


                                                                                };

                                                                                 window.restore_send_to_editor = window.send_to_editor;
                                                                                window.send_to_editor = function (html) {

                                                                                        window.send_to_editor = window.restore_send_to_editor;

                                                                                };
                                                                                return false;
                                                                                break;
                                                                        case "add_page":
                                                                                var temp_id = '<?php echo $v->ID; ?>';
                                                                                jQuery('.pm_inst_temp').data('node', node.title);
                                                                                jQuery('.pm_inst_temp').data('tree-id', temp_id);
                                                                                jQuery('.pm_templ_review').removeClass('pm_selected');
                                                                                jQuery(".header_templates").show("fade");

                                                                                break;
                                                                        case "add_link":
                                                                               var temp_id = '<?php echo $v->ID; ?>';
                                                                                jQuery('.pm_inst_temp').data('node', node.title);
                                                                                jQuery('.pm_inst_temp').data('tree-id', temp_id);
                                                                                jQuery('.pm_templ_review').removeClass('pm_selected');
                                                                                jQuery(".header_templates").show("fade");

                                                                                break;
                                                                        default:
                                                                                alert("Unhandled command: " + data.cmd);
                                                                                return;
                                                                }

                                                        }).on("keydown", function (e) {
                                                                var cmd = null;

                                                                 switch (jQuery.ui.fancytree.eventToString(e)) {
                                                                        case "ctrl+shift+n":
                                                                        case "meta+shift+n":
                                                                                cmd = "addChild";
                                                                                break;
                                                                        case "ctrl+c":
                                                                        case "meta+c": 
                                                                                cmd = "copy";
                                                                                break;
                                                                        case "ctrl+v":
                                                                        case "meta+v": 
                                                                                cmd = "paste";
                                                                                break;
                                                                        case "ctrl+x":
                                                                        case "meta+x": 
                                                                                cmd = "cut";
                                                                                break;
                                                                        case "ctrl+n":
                                                                        case "meta+n": 
                                                                                cmd = "addSibling";
                                                                                break;
                                                                        case "del":
                                                                        case "meta+backspace": 
                                                                                cmd = "remove";
                                                                                break;
                                                                                
                                                                        case "ctrl+up":
                                                                                cmd = "moveUp";
                                                                                break;
                                                                        case "ctrl+down":
                                                                                cmd = "moveDown";
                                                                                break;
                                                                        case "ctrl+right":
                                                                        case "ctrl+shift+right": 
                                                                                cmd = "indent";
                                                                                break;
                                                                        case "ctrl+left":
                                                                        case "ctrl+shift+left": 
                                                                                cmd = "outdent";
                                                                }
                                                                if (cmd) {
                                                                        jQuery(this).trigger("nodeCommand", {cmd: cmd});
                                                                       
                                                                        return false;
                                                                }
                                                        });

                                                        jQuery("#tree_<?php echo $v->ID; ?>").contextmenu({
                                                                delegate: "span.fancytree-title",
                                                              
                                                                menu: [
                                                                      
                                                                        {title: "New sibling", cmd: "addSibling", uiIcon: "ui-icon-plus"},
                                                                        {title: "New child", cmd: "addChild", uiIcon: "ui-icon-arrowreturn-1-e"},
                                                                        {title: "----"},
                                                                        {title: "Add Content to the title", cmd: "add_page", uiIcon: "ui-icon-note", disabled: false},
                                                                     
                                                                        {title: "----"},
                                                                        {title: "Edit", cmd: "rename", uiIcon: "ui-icon-pencil"},
                                                                        {title: "Delete", cmd: "remove", uiIcon: "ui-icon-trash"},
                                                                        {title: "----"},
                                                                        {title: "Cut", cmd: "cut", uiIcon: "ui-icon-scissors"},
                                                                        {title: "Copy", cmd: "copy", uiIcon: "ui-icon-copy"},
                                                                        {title: "Paste as child", cmd: "paste", uiIcon: "ui-icon-clipboard", disabled: true}
                                                                ],
                                                                beforeOpen: function (event, ui) {
                                                                        var node = jQuery.ui.fancytree.getNode(ui.target);
																		tr = jQuery("#tree_<?php echo $v->ID; ?>").fancytree('getTree');
																		var n = tr.getActiveNode();
																		//alert(tr.getKeyPath());
																		//alert(n);
                                                                        jQuery("#tree_<?php echo $v->ID; ?>").contextmenu("enableEntry", "paste", !!CLIPBOARD);
                                                                        node.setActive();
                                                                },
                                                                select: function (event, ui) {
                                                                        var that = this;
																		if(ui.cmd=="rename")
																		{
																			jQuery("#savetemplate").val("Edit Page");
																		}
																		else
																		{
																			jQuery("#savetemplate").val("Create Page");
																		}
                                                                        setTimeout(function () {
                                                                                jQuery(that).trigger("nodeCommand", {cmd: ui.cmd});
                                                                        }, 100);

                                                                      
                                                                }
                                                        });
                                                        jQuery(".editiframelink").on('click',function(){
															jQuery('.pm_iframe_modal .media-modal-close').trigger("click");
															    var title = jQuery(this).attr("c_title");
																var tree_id = jQuery(this).attr("c_treeid");
																var url = jQuery(this).attr("c_url");
																jQuery('.pm_add_link_insert').data('tree-id', tree_id);
																jQuery('.add_link_modal .add_link_title').val(title);
																jQuery('.add_link_modal .add_link').val(url);
																jQuery('.add_link_modal').show();

															return false;
														});
														 jQuery(".editlink").on('click',function(){
															 jQuery("#savetemplate").val("Edit Page");
														jQuery('.pm_popup_modal .media-modal-close').trigger("click");
														
															var linkval = jQuery(this).attr("c_cid");
															var treeid = jQuery(this).attr("c_treeid");
															var timeline = jQuery(this).attr("c_timeline");
															 var get_level = jQuery("#tree_" + treeid).fancytree("getActiveNode");
															//alert("level of the node: "+get_level.getLevel());
																jQuery.ajax({
																		url: "<?php echo admin_url('admin-ajax.php'); ?>",
																		data: "action=pm_content_edit&cid=" + linkval + "&nonce=<?php echo wp_create_nonce('pm_content_edit_'); ?>",
																		type: 'Post',
																		success: function (res) {
																				var res = jQuery.parseJSON(res);
																				//alert('link call');
																				jQuery('.selected_temp_modal #temp_selected_URL').val(res.url);
																				jQuery('.selected_temp_modal #temp_selected_title').val(res.title);
																				jQuery('#edittemplatepost_ifr').contents().find("body").html('');
																				jQuery('#edittemplatepost_ifr').contents().find("body").append(res.content);
																				jQuery('#p_builder').attr('href',res.url+'?fl_builder');
																				jQuery('#savetemplate').data('tree-id', treeid);
																				jQuery('#savetemplate').data('tempid', 0);
																				jQuery('#savetemplate').data('cid', linkval);
																				jQuery('#savetemplate').data('timeline', timeline);
																				jQuery('.selected_temp_modal').show("fade");

																				edit_content();
																				if(get_level.getLevel()>2)
																										{
																														
																													var perma = jQuery('#temp_selected_URL').val();
																													var arrlink = perma.split("/");
																													arrlink.pop();
																													var last = arrlink.pop();
																													
																													var joint = arrlink.join('/');
																													joint+='/';
																													
																													var limit = joint.length;
																													
																													jQuery("#temp_selected_URL").keydown(function(event){
																															//console.log(this.selectionStart);
																															//console.log("key down: "+event.which);
																															if(event.keyCode == 8){
																																this.selectionStart--;
																															}
																															if(this.selectionStart < limit){
																																this.selectionStart = limit;
																																//console.log("in key down: "+this.selectionStart);
																																event.preventDefault();
																															}
																														});
																														jQuery("#temp_selected_URL").keyup(function(event){
																															//console.log(this.selectionStart);
																															if(this.selectionStart < limit){
																																this.selectionStart = limit;
																																//console.log("key up: "+this.selectionStart);
																																event.preventDefault();
																															}
																														});
																											}
																											else if(get_level.getLevel()<2)
																						 {
																							 
																							 var perma = jQuery('#temp_selected_URL').val();
																						var arrlink = perma.split("/");
																						arrlink.pop();
																						var last = arrlink.pop();
																						//alert(arrlink+' \nlength: '+arrlink.length);
																						var joint = arrlink.join('/');
																						joint+='/';
																						//alert(joint+' \nlength of string:'+joint.length);
																						var limit = joint.length;
																						
																						jQuery("#temp_selected_URL").keydown(function(event){
																								//console.log(this.selectionStart);
																								//console.log("key down: "+event.which);
																								if(event.keyCode == 8){
																									this.selectionStart--;
																								}
																								if(this.selectionStart < limit){
																									this.selectionStart = limit;
																								//	console.log("in key down: "+this.selectionStart);
																									event.preventDefault();
																								}
																							});
																							jQuery("#temp_selected_URL").keyup(function(event){
																							//	console.log(this.selectionStart);
																								if(this.selectionStart < limit){
																									this.selectionStart = limit;
																									//console.log("key up: "+this.selectionStart);
																									event.preventDefault();
																								}
																							});
																								
																						}
																		}
																});
																return false;
														});
                                                        jQuery('#save_tree_<?php echo $v->ID; ?>').on('click', function () {
                                                                
                                                                var tree = jQuery("#tree_<?php echo $v->ID; ?>").fancytree("getTree");
                                                                var d = tree.toDict(true);
                                                                var nodes = JSON.stringify(d.children);

                                                                jQuery.ajax({
                                                                        type: 'POST',
                                                                        url: '<?php echo admin_url('admin-ajax.php'); ?>?action=pm_tree&id=<?php echo $v->ID; ?>&nonce=<?php echo wp_create_nonce('pm_trees'); ?>',
                                                                                                         data: nodes,
                                                                                                        dataType: "json",
                                                                                                        contentType: 'application/json',
                                                                                                        success: function (res) {
																									
                                                                                                        }

                                                                                                });
                                                                                        })

                                                                                });
                                                                             
                                                        
                                        </script>
                                        
																			<?php } else {
                                        ?>
                                        <script type="text/javascript">
                                                jQuery(document).ready(function () {

                                                        jQuery("#tree_<?php echo $v->ID; ?>").fancytree({
                                                                icons: false,
                                                                minExpandLevel: 1,
                                                                generateIds: true,
                                                                idPrefix: "pm_node",
                                                                checkbox:true,
                                                                source: {url: "<?php echo admin_url('admin-ajax.php') . '?action=pm_tree_get&id=' . $v->ID . '&nonce=' . wp_create_nonce('pm_tree_get_' . $v->ID); ?>"},
                                                                lazyLoad: function (event, data) {
                                                                        data.result = $.ajax({
                                                                                url: "ajax-sub2.json",
                                                                                dataType: "json"
                                                                        });
                                                                },
                                                                init: function (event,data) {
																	var selNodes = data.tree.getSelectedNodes();
																	//console.log(selNodes);
																	num_link_<?php echo $v->ID; ?>	= jQuery.map(selNodes, function(node){
																		
																			 return  '<a href="'+encodeURI(node.data.url)+'">'+node.title+'</a><br>' ;
																			//return node.data.url+'<br>';
																		  });
																		  
																},
                                                                select: function(event,data){
																	//var node = data.node
																	
																	/*if(data.node.hasChildren())
																	{
																		//data.node.hideCheckbox=true;
																		data.node.setSelected(false);
																		//return false;
																	}else
																	{
																	   var selNodes = data.tree.getSelectedNodes();
																	num_link_<?php echo $v->ID; ?>	= jQuery.map(selNodes, function(node){
																		//console.log(node.title);
																		
																			 return  '<a href="'+encodeURI(node.data.url)+'">'+node.title+'</a><br>' ;
																			//return node.data.url+'<br>';
																		  });
																		  
																	}*/
																	 var selNodes = data.tree.getSelectedNodes();
																	num_link_<?php echo $v->ID; ?>	= jQuery.map(selNodes, function(node){
																		//console.log(node.data.url);
																			if(node.data.url!=undefined)
																			{
																			 return  '<a href="'+encodeURI(node.data.url)+'">'+node.title+'</a><br>' ;
																			}
																			
																			//return node.data.url+'<br>';
																		  });
																	
																	//alert(email_link);
																},
                                                                click: function (event, data) {
																	
																	if(data.targetType=="checkbox")
																		{
																				/*if(data.node.hasChildren())
																				{
																				    data.node.hideCheckbox=true;
																					data.node.setSelected(false);
																					//return false;
																				}else
																				{
																				   
																				    //return false;
																				}*/
																		}
																		else{
                                                                        var node = data.node;

                                                                        jQuery('.fancytree-node').removeClass('fancytree-active');
																		
                                                                        if (node.data.type == 'link') {
                                                                               
                                                                                window.open(node.data.url, 'contentFrame');
                                                                              
                                                                                jQuery('.pm_iframe_modal').modal('show');


                                                                        } else if (node.data.type == 'content') {
                                                                                jQuery.ajax({
                                                                                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                                                                                        data: "action=pm_content_disp&cid=" + node.data.cid + "&nonce=<?php echo wp_create_nonce('pm_content_disp_'); ?>",
                                                                                        type: 'Post',
                                                                                        success: function (res) {
                                                                                                var res = jQuery.parseJSON(res);
																								/**********/
																								if(res.title == null)
																								{
																									jQuery('.pm_popup_modal .title h5').text("No Content added");
																								}
																								else
																								{
																									jQuery('.pm_popup_modal .title h5').text(" Page Title: "+res.title);
																								}
																								if(res.url == false)
																								{
																									jQuery('.pm_popup_modal .url').html('');
																								}
																								else
																								{
																									jQuery('.pm_popup_modal .url').html('<a href="' + res.url + '" target="_blank">' + res.url + '</a>');
																								}
                                                                                                jQuery('.pm_popup_modal .pm_data_body').html(res.content);
                                                                                                if(res.is_beaver_builder==1)
																									{
																										//console.log("<?php echo get_option('siteurl');?>");
																									jQuery.getScript('<?php echo get_option('siteurl');?>/wp-content/uploads/bb-plugin/cache/'+res.id+'-layout.js',function(res){
																										
																										//eval(res);
																									   });
																								   }
                                                                                               // jQuery('.pm_popup_modal .title h1').text(res.title);
                                                                                              //  jQuery('.pm_popup_modal .url').html('<a href="' + res.url + '" target="_blank">' + res.url + '</a>');
                                                                                             
                                                                                                jQuery('.pm_popup_modal').modal('show');
                                                                                        },
																							complete:function()
																							{
																								setTimeout(function(){jQuery('.pm_popup_modal').resize();
																									},3000);
																									jQuery('#myModal').scroll(function(){
																										
																										jQuery('.pm_data_body').resize();
																										});
																							}
																							
                                                                                });

                                                                        }
																	}
                                                                }
                                                                
                                                        });


                                                });
                                        </script>

                                <?php }
                                ?>
                                <?php } 
							} 
							?>

 <script type="text/javascript">
							jQuery(document).ready(function(){
								jQuery('#horiz_container_outer').horizontalScroll();
							
							});
					</script>
      
        <?php if (is_super_admin()) { ?>
                                                                                                                                                                                                                        <!--                <a href="#" id="insert-media-button" class="button insert-media add_media add-media-button" style="display: none;" title="Add Media"><span class="wp-media-buttons-icon"></span> Add Media</a>-->
                <input type="hidden" value="<?php echo plugins_url('ajax-tree-fs.php', __FILE__); ?>" id="node_url" />

                <div class="add_link_modal fixed-container full-height" style="display: none;">
                    <div class="fixed-container-inner">
                        <div class="modal-inner">          

                            <div class="link_cls"><div class="pm_temp_title">Add Link</div>
                                <img src="<?php echo plugins_url("images/close.png", __FILE__) ?>" onclick="jQuery('.add_link_modal').hide('fade');
                                                                jQuery('.add_link_modal input.add_link').val('');" class="media-modal-close" />

                                <div class="">
                                    <div><label>Title</label><input type="text" name="add_link_title" class="add_link_title" placeholder="Enter Title"/></div>
                                    <div>

                                        <label>Link</label><input type="text" name="add_link" class="add_link" placeholder="e.g http://example.com"/> 
                                    </div>
                                    <button type="button" class="pm_add_link_insert">Insert</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="header_templates modal login-prompt-modal fixed-container full-height" close="modal.close" class-name="login-prompt-modal" style="display: none;">				
                    <div class="fixed-container-inner">
                        <div class="modal-inner">
                            <img src="<?php echo plugins_url("images/close.png", __FILE__) ?>" onclick="jQuery('.header_templates').hide('fade');" class="media-modal-close close_click" />

                            <div class="modal-transclude" ng-transclude="">
                                <div class="login-prompt ng-scope" ng-show="showLoginPrompt">    
                                    <div class="umtop">

                                        <div class="um_box_up pm_temp_title">Select template to Add content in title</div>
                                        <div class="um_box_mid">
                                            <div class="um_box_mid_content comman_wrapper">
												<script>
													function load_template_selection(postids)
													{
														jQuery.ajax({
																type: 'POST',
																url: '<?php echo admin_url('admin-ajax.php'); ?>',
																data: 'action=save_template_position&postids='+postids+'&nonce=<?php echo wp_create_nonce('save_template_position_'); ?>',
																async:true,
																success: function (res) {
																	//alert("success");
																}

														});
													}
													jQuery(function() {
														jQuery( ".templates_selection" ).sortable({
															 start: function(event, ui) {
																jQuery(".pm_templ_review").addClass("noclick");
															},
															stop:function(){
																 
																 setTimeout(function(){jQuery(".pm_templ_review").unbind("click.prevent");}, 300);
																var post_ids ="";
																jQuery(".pm_templ_review").each(function(){
																	post_ids += jQuery(this).attr("data-pid")+"#";
																});
																load_template_selection(post_ids);
																
																
															}
															
														});
														jQuery( ".templates_selection" ).disableSelection();
													  });
												</script>
                                                <div class="templates_selection" style="margin:20px;">
                                                    <!--<div class="pm_templ_review" data-id="0">
                                                        <div class="pm_temp_title">New Link</div>
                                                        <div class="pm_temp_content"></div>
                                                    </div> -->
                                                    
                                                    <?php
                                                    $p = array(
                                                        'post_status' => 'publish',
                                                        'post_type' => 'patient_templates',
                                                        'orderby'=>'menu_order',
                                                        'order' => 'ASC',
                                                        'numberposts' => -1,
                                                    );

                                                    $posts = get_posts($p);

                                                    $templates = array();
                                                    if (!empty($posts)) {
														?>
														<div class="num_rows">
															
														<?php
                                                            foreach ($posts as $p) {
                                                                    $ID = intval($p->ID);
                                                                    $metas = get_post_meta($ID, 'show_in_timeline', true);
                                                                    //print_r($metas);
                                                                    $name = esc_html(apply_filters('tinymce_template_title', $p->post_title));
                                                                    $desc = esc_html(apply_filters('tinymce_template_excerpt', $p->post_excerpt));
                                                                    
                                                                    if(get_post_meta($ID,'row_pos',true)=="1")
                                                                    {
																		?>
                                                                    <script>
																		jQuery('.templates_selection').resize();
                                                                    </script>
                                                                    <?php
                                                                    
																		if(get_post_meta($ID,'no-content-title-only',true) != "" && get_post_meta($ID,'no-content-title-only',true) == "1")
																		{?>
																			<div class="pm_templ_review" data-nid="0" data-pid="<?php echo $p->ID; ?>" >
																				<div class="pm_temp_title">Title only</div>
																				<div class="pm_temp_content"></div>
																			</div>
																		<?php
																		}
																		else if(get_post_meta($ID,'new-link',true) != "" && get_post_meta($ID,'new-link',true) == "1")
																		{ ?>
																			<div class="pm_templ_review" data-id="0" data-pid="<?php echo $p->ID; ?>" >
																				<div class="pm_temp_title">Link To Existing Page</div>
																				<div class="pm_temp_content"></div>
																			</div>   
																		<?php
																		}
																		 
																		
																	}
																}
																?>
																</div><div class="clearfix"></div>
														<div class="num_rows">
															<p><strong>Create web page</strong></p>
														<?php
																foreach ($posts as $p) {
                                                                    $ID = intval($p->ID);
                                                                    $metas = get_post_meta($ID, 'show_in_timeline', true);
                                                                    //print_r($metas);
                                                                    $name = esc_html(apply_filters('tinymce_template_title', $p->post_title));
                                                                    $desc = esc_html(apply_filters('tinymce_template_excerpt', $p->post_excerpt));
                                                                   
                                                                    if(get_post_meta($ID,'show_in_second_row',true)=="yes")
                                                                    {
																		 ?>
                                                                    <script>
																		jQuery('.templates_selection').resize();
                                                                    </script>
                                                                    <?php
																		update_post_meta($ID,'timeline_bb_post_thumbnail',plugins_url('/images/' . $p->post_name . '.jpg', __FILE__));
																		?>
																		<div class="pm_templ_review" data-pid="<?php echo $p->ID; ?>" data-id="<?php echo $p->ID; ?>" data-timeline="<?php echo $metas; ?>">
																			<div class="pm_temp_title"><?php //echo $p->post_title; ?></div>
																			<div class="pm_temp_content "><img src="<?php echo plugins_url('/images/' . $p->post_name . '.jpg', __FILE__); ?>" /><div class="overbox"></div></div>

																		</div>      
																		<?php
																	}
																}
																?>
																</div><div class="clearfix"></div>
														<div class="num_rows">
															<p><strong>Show in Timeline</strong></p>
														<?php
																foreach ($posts as $p) {
                                                                    $ID = intval($p->ID);
                                                                    $metas = get_post_meta($ID, 'show_in_timeline', true);
                                                                    //print_r($metas);
                                                                    $name = esc_html(apply_filters('tinymce_template_title', $p->post_title));
                                                                    $desc = esc_html(apply_filters('tinymce_template_excerpt', $p->post_excerpt));
                                                                   
                                                                    if(get_post_meta($ID,'row_pos',true)=="3")
                                                                    {
																		 ?>
                                                                    <script>
																		jQuery('.templates_selection').resize();
                                                                    </script>
                                                                    <?php
																		update_post_meta($ID,'timeline_bb_post_thumbnail',plugins_url('/images/' . $p->post_name . '.jpg', __FILE__));
																		?>
																		<div class="pm_templ_review" data-pid="<?php echo $p->ID; ?>" data-id="<?php echo $p->ID; ?>" data-timeline="<?php echo $metas; ?>">
																			<div class="pm_temp_title"><?php echo $p->post_title; ?></div>
																			<div class="pm_temp_content "><img src="<?php echo plugins_url('/images/' . $p->post_name . '.jpg', __FILE__); ?>" /><div class="overbox"></div></div>

																		</div>      
																		<?php
																	}
                                                                }   
                                                                ?>
                                                                </div>
                                                                <?php
                                                            }
                                                    ?>
                                                    <!--<div class="pm_templ_review" data-nid="0">
                                                        <div class="pm_temp_title">No Content Title only</div>
                                                        <div class="pm_temp_content"></div>
                                                    </div>-->
                                                </div>
                                                <button class="pm_inst_temp" type="button" style="display:none;" >Insert Template</button>
                                            </div>
                                        </div>
                                        <div class="um_box_down"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="selected_temp_modal fixed-container full-height" style="display: none;">
                    <div class="fixed-container-inner">
                        <div class="modal-inner">          

                            <div class=""><div class="pm_temp_title">Add page</div>
                                <img src="<?php echo plugins_url("images/close.png", __FILE__) ?>" onclick="jQuery('.selected_temp_modal').hide('fade');" class="media-modal-close close_click" />

                                <?php
                                $url = site_url();
                                ?>
                                <link rel="stylesheet" href="<?php echo $url; ?>/wp-admin/load-styles.php?c=1&dir=ltr&load=buttons,dashicons,media-views,admin-bar,wp-admin,wp-auth-check&ver=4.2.2" />
                                <script src="<?php echo $url; ?>/wp-admin/js/image-edit.js"></script>
                                <script src="<?php echo $url; ?>/wp-includes/js/imgareaselect/jquery.imgareaselect.js"></script>
                                <form id="inser_template_page" method="POST" name="inser_template_page">
                                    <div class="temp">
										 <label class="">Page URL</label>
                                        <input name="" type="text" id="temp_selected_URL" />
                                        <label class="">Add Title</label>
                                        <input name="" type="text" id="temp_selected_title" />
										<!--<a href="" id="p_builder" target="_blank">Page Builder</a>-->
                                        <script>
											jQuery('#p_builder').click(function(){
													jQuery('.selected_temp_modal').hide();
												});
                                        </script>
                                    </div>
                                    <div class="temp_selected">
                                        <?php
                                        $content = "";
                                        $editor_id = 'edittemplatepost';

                                        wp_editor($content, $editor_id, $settings = array('editor_height' => 350, 'media_buttons' => true, 'quicktags' => false, 'tinymce' => array(
                                                'toolbar1'=>'bold italic |  bullist | link image unlink | wp_adv',
                                                'toolbar2' => 'formatselect,underline,justifyfull,forecolor,|,pastetext,pasteword,removeformat,|,media,charmap,|,outdent,indent,|,undo,redo,wp_help,image | alignleft aligncenter alignright alignjustify | numlist outdent indent |',
                                              //'theme_advanced_buttons1' => 'bold, italic, ul, min_size, max_size'
                                        )));
                                        ?>
                                    </div>
                                    <div class="">
                                        <input type="button" id="savetemplate" value="Create Page" />
                                    </div>
                                </form>
                            </div>
  
                        </div>
                    </div>
                </div>
                <div id="tmp_handler">
                </div>
<input type="hidden" value="0" name="is_loade" id="is_loade" />
                <script type="text/javascript">

                                        function edit_content() {

                                                jQuery("#edittemplatepost_ifr").contents().find("body").find('div.upload_img').droppable();
                                                jQuery("#edittemplatepost_ifr").contents().find("body").find('div.upload_img').on('drop', function (event) {
                                                        jQuery("#edittemplatepost_ifr").contents().find("body").find('div.upload_img').removeClass('selected');
                                                        jQuery(this).addClass('selected');

                                                        //stop the browser from opening the file
                                                        event.preventDefault();

                                                        if (event.type === "drop") {
                                                                var rowCount = 0;
                                                                var files = event.originalEvent.dataTransfer.files;
                                                                //console.log(files);
                                                                if (files[0])
                                                                        var formData = new FormData();

                                                                //append the files to the formData object
                                                                //Use FormData to send the files
                                                                formData.append('files', files[0]);
                                                                //jQuery(this).append(files[0].name);
                                                                //console.log(formData);
                                                                handleFileUpload(event.originalEvent.dataTransfer.files, jQuery(this));
                                                        }
                                                });

                                                if(jQuery("#is_loade").val() == 1)
                                                {
                                                    return false;
                                                }
                                                jQuery("#is_loade").val("1");
                                                

                                                jQuery('#edittemplatepost_ifr').contents().find("body").on('mousedown', 'div.upload_img img', function (e) {

                                                        /*if (e.which == 3) {
                                                         var temp = jQuery('#edittemplatepost_ifr').contents().find("body").find('div.upload_img');
                                                         temp.find('.imgEditAd01').remove();
                                                         var htm = '<div class="imgEditAd01" style="z-index:100;"><div class="crop">Crop</div><div>';
                                                         jQuery(this).closest('div.upload_img').append(htm);
                                                         }*/
                                                });

                                                jQuery('#edittemplatepost_ifr').contents().find("body").on('click', 'div.upload_video', function (event) {

                                                        if (jQuery(this).find('img').length == 0) {
                                                                var $this = jQuery(this);
                                                                $this.html('');
                                                                jQuery('.mce-toolbar button .mce-i-media').trigger('click');
                                                                //alert(tinymce.activeEditor.selection.getNode().nodeName);
                                                                //tinyMCE.activeEditor.selection.setContent('<strong>Some contents</strong>');
                                                                tinyMCE.activeEditor.on('keyup', function (e,o) {
                                                                        
                                                                        var imgdiv = tinyMCE.activeEditor.selection.getNode();
                                                                        
                                                                        if(e.keyIdentifier == 'U+007F'){
                                                                                var img = jQuery(imgdiv).find('img');
                                                                                if(img.length == 0){
                                                                                        jQuery(imgdiv).empty();
                                                                                       jQuery(imgdiv).attr('style',jQuery(imgdiv).data('style')); 
                                                                                }
                                                                        }
                                                                });
                                                                
                                                                tinyMCE.activeEditor.selection.onBeforeSetContent.add(function (ed, o) {
                                                                        if (o.content.length > 0) {
                                                                                $this.removeAttr('style');
                                                                        }
                                                                });

                                                                /*window.send_to_editor = function (html) {
                                                                 $this.html(html);
                                                                 $this.removeAttr('style');
                                                                 }*/
                                                        }
                                                });

                                                jQuery('#edittemplatepost_ifr').contents().find("body").on('click', 'div.upload_img', function (event) {
                                                        var img = jQuery(this).find('img');

                                                        if (img.length == 0) {
                                                                var $this = jQuery(this);
                                                                $this.html('');
                                                                $this.addClass('selected');

                                                                callb();

                                                                window.send_to_editor = function (html) {
                                                                        $this.html(html);
                                                                        $this.removeAttr('style');
                                                                }
                                                        }

                                                });

                                                
                                               

                                                jQuery('.mce-container.mce-btn-group').on('click', 'div.mce-btn .dashicons-no', function () {
                                                        //console.log(jQuery('#edittemplatepost_ifr').contents().find("body").find('div[class^=upload].selected').data('style'));
                                                        var atr = jQuery('#edittemplatepost_ifr').contents().find("body").find('div[class^=upload].selected').data('style');
                                                        jQuery('#edittemplatepost_ifr').contents().find("body").find('div.upload_img.selected').attr('style', atr);
                                                });

                                        }

                                        jQuery(document).ready(function () {

                                                jQuery('.pm_templ_review').on('click', function () {
													
														if(jQuery(".pm_templ_review").hasClass("noclick"))
														{
															jQuery(".pm_templ_review").removeClass("noclick")
															return false;
														}
														
                                                        jQuery('.pm_templ_review').removeClass('pm_selected');
                                                        var temp_id = jQuery(this).data('id');
                                                        var timeline = jQuery(this).data('timeline');

                                                        if (temp_id != undefined) {

                                                                jQuery('.pm_inst_temp').data('tempid', temp_id);
                                                                jQuery('.pm_inst_temp').data('timeline', timeline);
                                                                jQuery(this).addClass('pm_selected');
                                                                jQuery('.pm_inst_temp').trigger('click');
                                                        } else {
                                                                jQuery('.header_templates').hide();
                                                        }

                                                });
												var inserted_post = '';
                                                jQuery('.pm_inst_temp').on('click', function () {

                                                        var temp_id = jQuery(this).data('tempid');
                                                        var tree_id = jQuery(this).data('tree-id');
                                                        var timeline = jQuery(this).data('timeline');
                                                        var title = jQuery(this).data('node');

                                                        if (temp_id > 0) {
                                                                jQuery.ajax({
                                                                        type: 'POST',
                                                                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                                                                        data: 'action=pm_template_selected&temp_id=' + temp_id + '&nonce=<?php echo wp_create_nonce("pm_temp_selected"); ?>',
                                                                        success: function (res) {
                                                                                /*** only text ***/
                                                                                jQuery("#tmp_handler").html(title);
                                                                                title_new = jQuery("#tmp_handler").find("strong:first").html();
                                                                                if(jQuery("#tmp_handler").find("strong:first").length != 0)
																				{
																					title_new = jQuery("#tmp_handler").find("strong:first").html();
																				}
																				else
																				{
																					var myContent = '<div id="test">Hello <span>world!</span></div>';
																					title_new = jQuery("#tmp_handler").text();
																				}
                                                                                jQuery('.selected_temp_modal #temp_selected_title').val(title_new);

                                                                                //jQuery('.selected_temp_modal #temp_selected_title').val(title);
                                                                                jQuery('.header_templates').hide();
                                                                                //var htm = '<p><h1>'+title+'</h1></p>'+res;
                                                                                jQuery('#edittemplatepost_ifr').contents().find("body").html('');
                                                                                jQuery('#edittemplatepost_ifr').contents().find("body").append(res);
                                                                                var title_field = jQuery.trim(jQuery('#temp_selected_title').val());
                                                                                var cnt = tinyMCE.get('edittemplatepost').getContent();
                                                                                var cid = jQuery(this).data('cid');
                                                                                jQuery('.selected_temp_modal').show('fade');
                                                                                
                                                                                //below ajax is for setting parent post to manage URL structure.
                                                                                
                                                                                // after template select start
                                                                                jQuery.ajax({
																					url: "<?php echo admin_url('admin-ajax.php'); ?>",
																					type: 'POST',
																					data: 'action=after_template_select&pid=' + tree_id + '&current_clicked_node=' + jQuery(".current_clicked_node").val() + '&title=' + title_field + '&content=' + cnt + '&cid=' + cid +'&sel_template='+temp_id,
																					success:function(res1){
																					
																						var res1 = jQuery.parseJSON(res1);
																					
																						jQuery('#temp_selected_URL').val(res1.permalink);
																						jQuery('#p_builder').attr('href',res1.permalink+'?fl_builder');
																						/*** Copied from post_add_content AJAX ***/	
																						if (res1.post_ID > 0) {
																								var node = jQuery("#tree_" + tree_id).fancytree("getActiveNode");
																								
																								if (node) {

																										var htm = '<div class="timlin90"><div><span style="text-decoration: underline;">' + title_field + '</span></div><div><div class="overbox"></div>' + cnt + '</div></div>';
																										//var htm = '<a href="' + res.url + '" target="_blank">' + title + '</a>';
																										//var htm = '<span data-url="' + res.url + '" data-type="content" data-cid="' + res.id + '">' + title + '</span>';
																										//node.setTitle(htm);
																										if (timeline == 0) {
																												htm = '<span style="text-decoration: underline;">' + title_field + '</span>';
																										}

																										node.fromDict({
																												title: htm,
																												//title: '<strong>' + title + '</strong>',
																												url: res1.permalink,
																												type: 'content',
																												cid: res1.post_ID,
																												timeline: timeline
																										});
																										jQuery('#save_tree_' + tree_id).trigger('click');
																										/*jQuery('#edittemplatepost_ifr').contents().find("body").html('');
																										jQuery('#edittemplatepost').val('')
																										//jQuery(".selected_temp_modal").hide('fade');
																										jQuery('#temp_selected_title').val('');*/

																								}
																						}	
																						/*** Copied from post_add_content AJAX ***/	
																						inserted_post = res1.post_ID;
																						 var get_level = jQuery("#tree_" + tree_id).fancytree("getActiveNode");
																						
																						
																						if(get_level.getLevel()>2)
																						{
																							
																							jQuery.ajax({
																							url: "<?php echo admin_url('admin-ajax.php'); ?>",
																							type: 'POST',
																							data: 'action=set_parent_post&pid=' + inserted_post + '&current_clicked_node=' + jQuery(".current_clicked_node").val() + '&title=' + title_field + '&content=' + cnt + '&parentid=' + jQuery(".parent_node_of_post").val() +'',
																							success:function(res2){
																									jQuery('#temp_selected_URL').val(res2);
																									var perma = jQuery('#temp_selected_URL').val();
																						var arrlink = perma.split("/");
																						arrlink.pop();
																						var last = arrlink.pop();
																						
																						var joint = arrlink.join('/');
																						joint+='/';
																						
																						var limit = joint.length;
																						
																						jQuery("#temp_selected_URL").keydown(function(event){
																								//console.log(this.selectionStart);
																								//console.log("key down: "+event.which);
																								if(event.keyCode == 8){
																									this.selectionStart--;
																								}
																								if(this.selectionStart < limit){
																									this.selectionStart = limit;
																									//console.log("in key down: "+this.selectionStart);
																									event.preventDefault();
																								}
																							});
																							jQuery("#temp_selected_URL").keyup(function(event){
																								//console.log(this.selectionStart);
																								if(this.selectionStart < limit){
																									this.selectionStart = limit;
																									//console.log("key up: "+this.selectionStart);
																									event.preventDefault();
																								}
																							});
																							
																							}
																							
																							});
																						}
																						//checks the level
																						else if(get_level.getLevel()<2)
																						 {
																							 var gettype;
																							 jQuery.ajax({
																							url: "<?php echo admin_url('admin-ajax.php'); ?>",
																							type: 'POST',
																							data: 'action=pm_get_post_types',
																							success:function(res4){
																																									
																								gettype = res4;
																								//console.log(gettype);

																							}
																							
																							});
																							 
																							 
																							 var perma = jQuery('#temp_selected_URL').val();
																						var arrlink = perma.split("/");
																						arrlink.pop();
																						var last = arrlink.pop();
																						//alert(arrlink+' \nlength: '+arrlink.length);
																						var joint = arrlink.join('/');
																						joint+='/';
																						//alert(joint+' \nlength of string:'+joint.length);
																						var limit = joint.length;
																						
																						jQuery("#temp_selected_URL").keydown(function(event){
																								//console.log(this.selectionStart);
																								//console.log("key down: "+event.which);
																								if(event.keyCode == 8){
																									this.selectionStart--;
																								}
																								if(this.selectionStart < limit){
																									this.selectionStart = limit;
																									//console.log("in key down: "+this.selectionStart);
																									event.preventDefault();
																								}
																							});
																							jQuery("#temp_selected_URL").keyup(function(event){
																								//console.log(this.selectionStart);
																								if(this.selectionStart < limit){
																									this.selectionStart = limit;
																									//console.log("key up: "+this.selectionStart);
																									event.preventDefault();
																								}
																							});
																																		  
																						jQuery.ajax({
																							url: "<?php echo admin_url('admin-ajax.php'); ?>",
																							type: 'POST',
																							data: 'action=insert_meta_value&pid=' + inserted_post + '&current_clicked_node=' + jQuery(".current_clicked_node").val() + '&title=' + title_field + '&content=' + cnt + '&cid=' + cid +'',
																							success:function(res3){
																								
																								
																								
																							}
																							
																							});
																						}
																						}
																					});
																					//after template select over.
                                                                                jQuery('#savetemplate').data('tree-id', tree_id);
                                                                                jQuery('#savetemplate').data('tempid', temp_id);
                                                                                jQuery('#savetemplate').data('timeline', timeline);

                                                                                edit_content();

                                                                        }
                                                                })
                                                        } else {
                                                                jQuery('.header_templates').hide('fade');
                                                                jQuery('.add_link_modal .add_link_title').val(title);
                                                                jQuery('.pm_add_link_insert').data('tree-id', tree_id);
                                                                jQuery('.add_link_modal').show('fade');
                                                        }

                                                });

                                                jQuery('.pm_add_link_insert').on('click', function () {

                                                        var url = jQuery.trim(jQuery('.add_link').val());
                                                        var title = jQuery.trim(jQuery('.add_link_title').val());
                                                        var tree_id = jQuery(this).data('tree-id');
                                                        var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
                                                        jQuery('.pm_error').remove();

                                                        if (title.length == 0) {
                                                                jQuery('.add_link_title').after('<span class="pm_error">Please enter title</span>');
                                                        }

                                                        if (url.length > 0) {
                                                                if (!regexp.test(url)) {
                                                                        jQuery('.add_link').after('<span class="pm_error">Please enter valid url link</span>');
                                                                }
                                                                else {
                                                                        var node = jQuery("#tree_" + tree_id).fancytree("getActiveNode");
                                                                        if (node) {
                                                                                jQuery('.add_link_modal').hide('fade');
                                                                                //var htm = '<a href="' + url + '" target="_blank">' + url + '</a>';
                                                                                //var htm = '<span data-url="' + url + '" data-type="link">' + node.title + '</a>';
                                                                                var htm = '<u>' + title + '</u>';
                                                                                //node.addChildren({title: htm, "type": "link", 'url': url});
                                                                                node.fromDict({
                                                                                        //title: htm,
                                                                                        title: htm,
                                                                                        type: 'link',
                                                                                        url: url
                                                                                });
                                                                                jQuery('#save_tree_' + tree_id).trigger('click');
                                                                                jQuery('.add_link').val('');
                                                                        }
                                                                }


                                                        } else {
                                                                jQuery(this).after('<span class="pm_error">Please enter link</span>');
                                                        }
                                                });


                                                jQuery('#savetemplate').on('click', function () {
														jQuery("#savetemplate").val("Create Page");
                                                        var tmp_img_cls = jQuery('#edittemplatepost_ifr').contents().find("body").find('div.upload_img');
                                                        var tmp_vd_cls = jQuery('#edittemplatepost_ifr').contents().find("body").find('div.upload_video');
                                                        tmp_img_cls.removeAttr('style');
                                                        tmp_vd_cls.removeAttr('style');

                                                        var tree_id = jQuery(this).data('tree-id');
                                                        var temp_id = jQuery(this).data('tempid');
                                                        var timeline = jQuery(this).data('timeline');
                                                        var cid = jQuery(this).data('cid');

                                                        jQuery('.rerror').remove();
                                                        var title = jQuery.trim(jQuery('#temp_selected_title').val());
                                                        var post_URL = jQuery.trim(jQuery('#temp_selected_URL').val());
                                                        if (title.length > 0) {

                                                                
                                                                var cnt = tinyMCE.get('edittemplatepost').getContent();
                                                                var perma = jQuery('#temp_selected_URL').val();
                                                                var slash = perma.split('');
                                                                if(slash[slash.length-1]!=='/')
                                                                {
																	slash[slash.length]='/';
																	perma = slash.join('');
																}
																//alert(perma);
																						var arrlink = perma.split("/");
																						
																						arrlink = perma.split("/");
																						arrlink.pop();
																						var last = arrlink.pop();
																						var joint = arrlink.join('/');
																						joint+='/';
																					//	console.log(joint+'----'+last);
																	
                                                                jQuery.ajax({
                                                                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                                                        type: 'POST',
                                                                        data: 'action=pm_add_content&pid=' + tree_id + '&current_clicked_node=' + jQuery(".current_clicked_node").val() + '&title=' + title + '&content=' + cnt + '&cid=' + cid + '&nonce=<?php echo wp_create_nonce("pm_add_content"); ?>&posturl=' + post_URL+'&slug='+ last +'&insert=' + inserted_post + '',
                                                                        success: function (res) {
																						
                                                                                var res = jQuery.parseJSON(res);
                                                                               // console.log(res.url);
                                                                                
                                                                                if (res.id > 0) {
                                                                                        var node = jQuery("#tree_" + tree_id).fancytree("getActiveNode");
                                                                                    	
                                                                                        if (node) {

                                                                                                var htm = '<div class="timlin90"><div><span style="text-decoration: underline;">' + title + '</span></div><div><div class="overbox"></div>' + cnt + '</div></div>';
                                                                                                //var htm = '<a href="' + res.url + '" target="_blank">' + title + '</a>';
                                                                                                //var htm = '<span data-url="' + res.url + '" data-type="content" data-cid="' + res.id + '">' + title + '</span>';
                                                                                                //node.setTitle(htm);
                                                                                                if (timeline == 0) {
                                                                                                        htm = '<span style="text-decoration: underline;">' + title + '</span>';
                                                                                                }

                                                                                                node.fromDict({
                                                                                                        title: htm,
                                                                                                        //title: '<strong>' + title + '</strong>',
                                                                                                        url: res.url,
                                                                                                        type: 'content',
                                                                                                        cid: res.id,
                                                                                                        timeline: timeline
                                                                                                });
                                                                                                jQuery('#save_tree_' + tree_id).trigger('click');
                                                                                                jQuery('#edittemplatepost_ifr').contents().find("body").html('');
                                                                                                jQuery('#edittemplatepost').val('')
                                                                                                jQuery(".selected_temp_modal").hide('fade');
                                                                                                jQuery('#temp_selected_title').val('');
                                                                                                window.open(post_URL+"?fl_builder",'_blank');

                                                                                        }
                                                                                }
                                                                        }
                                                                });

                                                        } else {
                                                                jQuery('#temp_selected_title').after('<span class="rerror" style="font-size: 12px;color: red;">Please enter title here.</span>');
                                                        }

                                                });
                                        });

                                        function callb() {
                                                jQuery('#insert-media-button').trigger('click');

                                        }

                                        function handleFileUpload(files, obj)
                                        {
                                                //console.log(files);
                                                var fd = new FormData();

                                                fd.append('file', files[0]);

                                                //  var status = new createStatusbar(obj); //Using this we can set progress.
                                                //  status.setFileNameSize(files[i].name,files[i].size);
                                                sendFileToServer(fd, status);

                                        }

                                        function sendFileToServer(formData, status)
                                        {
                                                var uploadURL = "<?php echo admin_url('admin-ajax.php'); ?>"; //Upload URL
                                                var extraData = {}; //Extra Data.

                                                var jqXHR = jQuery.ajax({
                                                        xhr: function () {
                                                                var xhrobj = jQuery.ajaxSettings.xhr();
                                                                if (xhrobj.upload) {
                                                                        xhrobj.upload.addEventListener('progress', function (event) {
                                                                                /*   var percent = 0;
                                                                                 var position = event.loaded || event.position;
                                                                                 var total = event.total;
                                                                                 if (event.lengthComputable) {
                                                                                 percent = Math.ceil(position / total * 100);
                                                                                 }
                                                                                 //Set progress
                                                                                 status.setProgress(percent);*/
                                                                        }, false);
                                                                }
                                                                return xhrobj;
                                                        },
                                                        url: uploadURL + "?action=pm_drop_files&nonce=<?php echo wp_create_nonce("pm_upload_nonce"); ?>",
                                                        type: "POST",
                                                        contentType: false,
                                                        processData: false,
                                                        cache: false,
                                                        data: formData,
                                                        beforeSend: function () {
                                                                jQuery('#edittemplatepost_ifr').contents().find("body").find('div.upload_img.selected').html('<img src="<?php echo plugins_url("images/loader.gif", __FILE__) ?>" style="margin-top: 70px;" />');
                                                        },
                                                        success: function (data) {
                                                                //status.setProgress(100);
                                                                var res = jQuery.parseJSON(data);
                                                                if (res != "error")
                                                                {
                                                                        jQuery('#edittemplatepost_ifr').contents().find("body").find('div.upload_img.selected').html(res.img);
                                                                        jQuery('#edittemplatepost_ifr').contents().find("body").find('div.upload_img.selected').removeAttr('style');
                                                                        jQuery('#edittemplatepost_ifr').contents().find("body").find('div.upload_img.selected img').addClass('wp-image-' + res.id);

                                                                }
                                                                else
                                                                {

                                                                        alert('error');
                                                                }
                                                                //$("#status1").append("File upload Done<br>");           
                                                        }
                                                });
                                        }

                </script>
                <div class="pm_popup_modal modal modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content cu_modal-content">
							<a class="editlink" >Edit Template</a>
							<div class="title"><h5></h5></div>
                            <div class="modal-header1">
                                <img data-dismiss="modal" src="<?php echo plugins_url("images/close.png", __FILE__) ?>" onclick="jQuery('.pm_popup_modal').hide();
                                                                jQuery('.pm_data_body').empty();" class="media-modal-close" />
                            </div>
                            <div class="modal-body cu_modal-body">
                                <div class="entry-content">
                                    <div class="url"></div>
                                    
                                    <div class="pm_data_body"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="pm_iframe_modal modal modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
							<a class="editiframelink">Edit Template</a>
                            <div class="modal-header1">
                                <img data-dismiss="modal" src="<?php echo plugins_url("images/close.png", __FILE__) ?>" onclick="jQuery('.pm_iframe_modal').hide();
                                                                jQuery('#contentFrame').empty();" class="media-modal-close" />
                            </div>
                            <div class="modal-body">
                                <iframe src="#" name="contentFrame" id="contentFrame" width="100%" height="80%"
                                        scrolling="yes" marginheight="0" marginwidth="0" frameborder="0">
                                <p>Your browser does not support iframes</p>
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
        } else {
                ?>
                <style>
                    .img_outr {
                        display: inline-block;
                        margin: 1%;
                    }
                    .carousel-caption{
                        position:relative;
                        right: 0;
                        left: 0;
                        bottom: 0;
                        color: #000;
                    }
                    .carousel-control{

                        background-image:none !important;  
                        border-bottom:none !important;
                        width: 4%;

                    }
                </style>

                <div class="pm_popup_modal modal modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header1">
                                <img data-dismiss="modal" src="<?php echo plugins_url("images/close.png", __FILE__) ?>" onclick="jQuery('.pm_popup_modal').hide();
                                                                jQuery('.pm_data_body').empty();" class="media-modal-close" />
                            </div>
                            <div class="modal-body">
                                <div class="entry-content">
                                    <div class="url"></div>
                                    <div class="title"><h1></h1></div>
                                    <div class="pm_data_body"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pm_iframe_modal modal modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header1">
                                <img data-dismiss="modal" src="<?php echo plugins_url("images/close.png", __FILE__) ?>" onclick="jQuery('.pm_iframe_modal').hide();
                                                                jQuery('#contentFrame').empty();" class="media-modal-close" />
                            </div>
                            <div class="modal-body">
                                <iframe src="#" name="contentFrame" id="contentFrame" width="100%" height="80%"
                                        scrolling="yes" marginheight="0" marginwidth="0" frameborder="0">
                                <p>Your browser does not support iframes</p>
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
        }
        ?>
        </div>
        </div>
        </div>
        
        <?php
}

add_shortcode('patient_page', 'p_patient_page_shortcode');


add_action('wp_ajax_pm_get_post_types','pm_get_post_types');

function pm_get_post_types(){
	$args = array('post_type' => 'patient_page','post_per_page' => -1);
	$posts = get_posts($args);
	$i=0;
	

foreach($posts as $k) {
	
	$value[$i]['title'] = $k->post_title;
	$value[$i]['key'] = '_'.$k->ID;
	$i++;
    
    
}

	
	echo json_encode($value);
}

add_action('wp_ajax_pm_template_selected', 'pm_template_selected');

function pm_template_selected() {

        $id = $_REQUEST['temp_id'];
        if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'pm_temp_selected')) {
                return;
        }

        $post_id = $id;
        $post = get_post($post_id);

        echo $content = do_shortcode($post->post_content);
        exit;
}

add_action('wp_ajax_pm_add_content', 'pm_add_content');

function pm_add_content() {
        $id = $_REQUEST['pid'];
        
		if(empty($_POST['slug']))
		{
			$posturl = $_POST['title'];
		}
		else
		{
			$posturl = $_POST['slug'];
		}	
        if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'pm_add_content')) {
                return;
        }
        //print_r($_POST);
        if (is_numeric($_POST['insert'])) {
                $post_id = $_POST['insert'];
                // Update post
                $my_post = array(
                    'ID' => $_POST['insert'],
                    'post_name' => sanitize_title($posturl),
                    'post_title' => wp_strip_all_tags($_POST['title']),
                    'post_name' => sanitize_title($_POST['slug']),
                    'post_content' => $_POST['content'],
                );
                
                

                // Update the post into the database
               wp_update_post($my_post);
              //  update_post_meta($_POST['cid'],'my_meta_box_select','Child');
        } else {
                // Create post object
                $my_post = array(
					'ID' => $_POST['cid'],
					'post_name' => sanitize_title($posturl),
                    'post_title' => wp_strip_all_tags($_POST['title']),
                    'post_content' => $_POST['content'],
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_type' => 'page',
                    'comment_status' => 'closed'
                );

                // Insert the post into the database
                $post_id = wp_update_post($my_post);
                
        }
        
        /*echo "<pre>";
		print_r($my_post);
		echo "</pre>";
		exit;*/
		
		//update_post_meta($post_id,'my_meta_box_select','InTimeline');
        $url = get_permalink($post_id);
        update_post_meta($post_id,"column_attached_id",$_REQUEST["pid"]);		
        $p_t = get_post_meta($_REQUEST['pid'],'pm_tree',false);
		update_post_meta($post_id,"current_clicked_key",$_REQUEST["current_clicked_node"]);
		$arr = get_post($post_id);
		$slug = $arr->post_name;
        echo json_encode(array('url' => $url, 'id' => $post_id, 'slug' => $slug));
		//echo json_encode($p_t);
        exit;
}

add_action('wp_ajax_after_template_select', 'after_template_select');

function after_template_select() {

        //$id = $_REQUEST['temp_id'];
        /*if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'pm_temp_selected')) {
                return;
        }*/
        
        
        if (is_numeric($_POST['cid'])) {
                $post_id = $_POST['cid'];
                // Update post
                $my_post = array(
                    'ID' => $_POST['cid'],
                    'post_title' => wp_strip_all_tags($_POST['title']),
                    'post_name' => sanitize_title($_POST['title']),
                    'post_content' => $_POST['content'],
                );
				$insert_post['condition']='in IF';
                // Update the post into the database
                wp_update_post($my_post);
        } else {
                // Create post object
                $my_post = array(
                    'post_title' => wp_strip_all_tags($_POST['title']),
                    'post_content' => $_POST['content'],
                    'post_status' => 'publish',
                    'post_author' => 1,
                    //'post_parent' => $id,
                    'post_type' => 'page',
                    'comment_status' => 'closed'
                );

                // Insert the post into the database
                $insert_post['condition']='in else';
                $post_id = wp_insert_post($my_post);
        }
    //    update_post_meta($post_id,'my_meta_box_select','InTimeline');
		$insert_post['permalink'] = get_permalink($post_id);
		update_post_meta($post_id,"column_attached_id",$_REQUEST["pid"]);	
		update_post_meta($post_id,"current_clicked_key",$_REQUEST["current_clicked_node"]);
		update_post_meta($post_id,"current_sel_temp_thumb",get_post_meta($_REQUEST["sel_template"],'pt_thumbnails',true));
		$insert_post['post_ID'] = $post_id;
        $insert_post['show_in'] = get_post_meta($_REQUEST["sel_template"],'show_in_timeline',true);
        echo json_encode($insert_post);      
		exit;
	     
}

function insert_meta_value(){
	 
		 $as = update_post_meta($_POST['pid'],'my_meta_box_select','InTimeline');
		 echo "changed";
	exit;
}

add_action('wp_ajax_insert_meta_value','insert_meta_value');

/*categorise the pages*/
function insert_page_meta_value(){
	 
		 $as = update_post_meta($_POST['pid'],'my_meta_box_select','Plugin');
		 echo "changed to plugin";
	exit;
}

add_action('wp_ajax_insert_page_meta_value','insert_page_meta_value');


/*to maintain URL parent post is set*/
function set_parent_post(){
	 
		 $my_post = array('ID' => $_POST['pid'],'post_parent' => $_POST['parentid']);
		$p_id = wp_update_post($my_post);
		update_post_meta($_POST['pid'],'my_meta_box_select','Child');
		 echo get_permalink($p_id);
	exit;
}

add_action('wp_ajax_set_parent_post','set_parent_post');

add_action('wp_ajax_pm_drop_files', 'pm_drop_files');

function pm_drop_files() {
        if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'pm_upload_nonce')) {
                return;
        }

        // These files need to be included as dependencies when on the front end.
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );

        // Let WordPress handle the upload.
        // Remember, 'my_image_upload' is the name of our file input in our form above.
        $attachment_id = media_handle_upload('file', 0);

        if (is_wp_error($attachment_id)) {
                // There was an error uploading the image.
                echo json_encode($arr['status'] = 'error');
        } else {
                // The image was uploaded successfully!
                $arr['img'] = wp_get_attachment_image($attachment_id, $size = "medium");
                $arr['id'] = $attachment_id;
                $arr['status'] = 'success';
                echo json_encode($arr);
        }
        exit;
}

add_action('wp_ajax_pm_del_page', 'pm_del_page');

function pm_del_page() {
        $postid = $_REQUEST['pid'];

        if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'pm_del_page')) {
                return;
        }
        $child_post = get_posts(array('post_parent' => $postid, 'post_type' => 'page'));
        if (is_array($child_post) && count($child_post) > 0) {

    // Delete all the Children of the Parent Page
    foreach($child_post as $post){

        wp_delete_post($post->ID, true);

    }

}
        wp_delete_post($postid, true);

        exit;
}

/* display post content in popup */
add_action('wp_ajax_nopriv_pm_content_disp', 'pm_content_disp');

function pm_content_disp() {
        $postid = $_REQUEST['cid'];

        if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'pm_content_disp_')) {
                return;
        }

        $post = get_post($postid);
        //print_r($post);
        $arr['id'] = $post->ID;
        $arr['title'] = $post->post_title;
        $arr['url'] = esc_url(get_permalink($post->ID));
        $arr['content'] = do_shortcode($post->post_content);
        $arr['is_beaver_builder'] = get_post_meta($post->ID,'_fl_builder_enabled',true);
        $arr['metavalue'] = get_post_meta($post->ID,'my_meta_box_select',true);
        //echo json_encode($arr);
		if($arr['metavalue'] === 'InTimeline')
        {
			//echo '<div class="url"><a target="_blank" href="'.$arr['url'].'">'.$arr['title'].'</a></div>';
			//echo '<div class="title"><h1>'.$arr['title'].'</h1></div>';
			//do_shortcode($post->post_content);
			$arr['content'] = do_shortcode($post->post_content);
			if($arr['is_beaver_builder']==1)
			{
				$arr['content'] = get_post_meta($post->ID,'rendered_content',true);
				
			}
			echo json_encode($arr);
			exit;
		}
		else
		{
			
			$arr['content'] = do_shortcode($post->post_content);
			if($arr['is_beaver_builder']==1)
			{
				$arr['content'] = get_post_meta($post->ID,'rendered_content',true);
				
			}
			echo json_encode($arr);
			exit;
		}
}

/* edit page content */
add_action('wp_ajax_pm_content_edit', 'pm_content_edit');

function pm_content_edit() {
        $postid = $_REQUEST['cid'];

        if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'pm_content_edit_')) {
                return;
        }

        $post = get_post($postid);
        
        $arr['id'] = $post->ID;
        $arr['title'] = $post->post_title;
        $arr['url'] = get_permalink($post->ID);
        $arr['parent'] = $post->post_parent;
        $arr['content'] = do_shortcode($post->post_content);
        $arr['metavalue'] = get_post_meta($post->ID,'my_meta_box_select',true);
        echo json_encode($arr);

        exit;
}

/* display post content in popup */
add_action('wp_ajax_pm_content_disp1', 'pm_content_disp1');
add_action('wp_ajax_nopriv_pm_content_disp1', 'pm_content_disp1');

function pm_content_disp1() {
         $postid = $_REQUEST['cid'];

        if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'pm_content_disp_')) {
                return;
        }

        $post = get_post($postid);
        //print_r($post);
        $arr['id'] = $post->ID;
        $arr['title'] = $post->post_title;
        $arr['url'] = esc_url(get_permalink($post->ID));
        $arr['parent'] = $post->post_parent;
        $arr['is_beaver_builder'] = get_post_meta($post->ID,'_fl_builder_enabled',true);
        $arr['metavalue'] = get_post_meta($post->ID,'my_meta_box_select',true);
        //echo json_encode($arr);
		if($arr['metavalue'] === 'InTimeline')
        {
			//echo '<div class="url"><a target="_blank" href="'.$arr['url'].'">'.$arr['title'].'</a></div>';
			//echo '<div class="title"><h1>'.$arr['title'].'</h1></div>';
			//do_shortcode($post->post_content);
			$arr['content'] = do_shortcode($post->post_content);
			if($arr['is_beaver_builder']==1)
			{
				$arr['content'] = get_post_meta($post->ID,'rendered_content',true);
				
			}
			echo json_encode($arr);
			exit;
		}
		else
		{
			
			$arr['content'] = do_shortcode($post->post_content);
			if($arr['is_beaver_builder']==1)
			{
				$arr['content'] = get_post_meta($post->ID,'rendered_content',true);
				
			}
			echo json_encode($arr);
			exit;
		}
}

add_action('wp_ajax_pm_content_disp2', 'pm_content_disp2');
add_action('wp_ajax_nopriv_pm_content_disp2', 'pm_content_disp2');

function pm_content_disp2() {
         $postid = $_REQUEST['cid'];

        if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'pm_content_disp_')) {
                return;
        }

        $post = get_post($postid);
        //print_r($post);
        $arr['id'] = $post->ID;
        $arr['title'] = $post->post_title;
        $arr['url'] = esc_url(get_permalink($post->ID));
        $arr['parent'] = $post->post_parent;
        
        $arr['metavalue'] = get_post_meta($post->ID,'my_meta_box_select',true);
        
		if($arr['metavalue'] === 'InTimeline')
        {
			echo '<div class="url"><a target="_blank" href="'.$arr['url'].'">'.$arr['url'].'</a></div>';
			echo '<div class="title"><h1>'.$arr['title'].'</h1></div>';
			do_shortcode($post->post_content);
			exit;
		}
		else
		{
			
			$arr['content'] = do_shortcode($post->post_content);
			echo json_encode($arr);
			exit;
		}
}

/*find the timeline from all timelines*/
function recursion($array,$postid) {
	
    $results = array();

	if (is_array($array))
	{		
		foreach ($array as $sub_array){
			if((isset($sub_array['data']['cid'])) && ($sub_array['data']['cid'] == $postid))
			{
				$results[] = $sub_array;
			}
			$results = array_merge($results, recursion($sub_array, $postid));
			
			/*echo "<pre>";
			print_r($results);
			echo "</pre>";*/
		}
	}
	//print_r($results);
	return  $results;
}

/***** save block position ******/

add_action('wp_ajax_save_position', 'save_position');

function save_position() {


        if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'save_position_')) {
                return;
        }
		$postids = $_REQUEST['postids'];
		$postids = trim($postids,"#");
		$postid_arr = explode("#",$postids);
		
		for($i=0;$i<count($postid_arr);$i++)
		{
			
			$my_post = array(
			  'ID'           => $postid_arr[$i],
			  'menu_order'   => $i+1,
			  
			);
			// Update the post into the database
			wp_update_post( $my_post );
			 
		}
		
        exit;
}

/***** save block position ******/

add_action('wp_ajax_save_template_position', 'save_template_position');

function save_template_position() 
{
        if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'save_template_position_')) {
                return;
        }
		$postids = $_REQUEST['postids'];
		$postids = trim($postids,"#");
		$postid_arr = explode("#",$postids);
		
		for($i=0;$i<count($postid_arr);$i++)
		{
			
			$my_post = array(
			  'ID'           => $postid_arr[$i],
			  'menu_order'   => $i+1,
			  
			);
			// Update the post into the database
			wp_update_post( $my_post );
			 
		}
		
        exit;
}

add_shortcode('page_timeline','page_timeline_shortcode');
function page_timeline_shortcode($attr)
{
				$tree_id = $attr['tree_id'];
				$post_id = $attr['id'];
				echo "<div id='pg_timeline'></div>";
					
					
					
			$tree_data = get_post_meta($tree_id,'pm_tree',true);
		
			$tree_time = recursion($tree_data,$post_id);
			echo '<div class="horiz_container_outer"><div class="horiz_container_inner"><div class="horiz_container"><div class="row">';
			traverseArray($tree_time[0]['children']);
			echo '</div></div></div></div>';
			
			?>
			<script>
				jQuery(document).ready(function(){
					jQuery('.pm_popup_modal_back').css('display','none');
					//alert('short_code');
					});
				
			</script>
			<div class="pm_popup_modal_back modal modal fade bs-example-modal-lg " id="myModal_back" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header1">
                                <img data-dismiss="modal" src="<?php echo plugins_url("images/close.png", __FILE__) ?>" onclick="jQuery('.pm_popup_modal_back').hide();
                                                                jQuery('.pm_data_body').empty();" class="media-modal-close" />
                            </div>
                            <div class="modal-body">
                                <div class="entry-content">
                                    <div class="url_back"></div>
                                    <div class="title_back"><h1></h1></div>
                                    <div class="pm_data_body_back"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pm_iframe_modal modal modal fade bs-example-modal-lg" id="myModal_back" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header1">
                                <img data-dismiss="modal" src="<?php echo plugins_url("images/close.png", __FILE__) ?>" onclick="jQuery('.pm_iframe_modal').hide();
                                                                jQuery('#contentFrame').empty();" class="media-modal-close" />
                            </div>
                            <div class="modal-body">
                                <iframe src="#" name="contentFrame" id="contentFrame" width="100%" height="80%"
                                        scrolling="yes" marginheight="0" marginwidth="0" frameborder="0">
                                <p>Your browser does not support iframes</p>
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
			<?php
				
}

add_action('wp_ajax_pg_timeline_tree', 'pg_timeline_tree');
add_action('wp_ajax_nopriv_pg_timeline_tree', 'pg_timeline_tree');

function pg_timeline_tree(){
	if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], 'pg_timeline_tree')) {
                return;
        }
		$tree_id = $_REQUEST['tid'];
		$post_id = $_REQUEST['id'];
	
	    $tree_data = get_post_meta($tree_id,'pm_tree',true);
		$tree_time = recursion($tree_data,$post_id);
		//print_r($tree_time);
		echo json_encode($tree_time);
		exit;
	
}

function traverseArray($array)
{ 
	$content = '';
	
	/*echo "<pre>";
	print_r($array);*/
	
	//exit;
	
	// Loops through each element. If element again is array, function is recalled. If not, result is echoed.
	foreach($array as $key=>$value)
	{ 
		if(is_array($value))
		{ 
			//if(isset($value['children']))
				$g = $value['children'];
			
			if(!isset($value['data']['url']))
			{
				echo '<div class="pm_inner_box col-md-2 col-sm-6 col-xm-12">';
				echo '<h4>'.$value['title'].'</h4>';
				echo "<div class='pm_tree_area'><div id='tree".$value['key']."'>";
			}
			else
			{
				$trim = trim($value['title']);
				echo '<li data-url="'.$value['data']['url'].'" data-type="'.$value['data']['type'].'" data-cid="'.$value['data']['cid'].'" data-timeline="'.$value['data']['timeline'].'">'.$trim;
			}
			
			if($g && is_array($g))
			{
				echo "<ul class='in_pages'>";
				traverseArray($g);
				echo '</ul></li>';
			}
			
			if(!isset($value['data']['url']))
			{
				echo '</div></div></div>';
				?>
				
				<script type="text/javascript">
										jQuery(document).ready(function () {
															jQuery('.pm_popup_modal_back').hide();
                                                        jQuery("#tree<?php echo $value['key']; ?>").fancytree({
                                                                icons: false,
                                                                //minExpandLevel: 1,
                                                                generateIds: true,
                                                                idPrefix: "pm_node",
                                                                //source: {url: "<?php echo admin_url('admin-ajax.php') . '?action=pm_tree_get&id=' . $value['key'] . '&nonce=' . wp_create_nonce('pm_tree_get_' . $value['key']); ?>"},
                                                                
                                                                click: function (event, data) {
                                                                        var node = data.node;

                                                                        jQuery('.fancytree-node').removeClass('fancytree-active');
																		
                                                                        if (node.data.type == 'link') {
                                                                               
                                                                                window.open(node.data.url, 'contentFrame');
                                                                              
                                                                                jQuery('.pm_iframe_modal').modal('show');


                                                                        } else if (node.data.type == 'content') {
                                                                                jQuery.ajax({
                                                                                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                                                                                        data: "action=pm_content_disp2&cid=" + node.data.cid + "&nonce=<?php echo wp_create_nonce('pm_content_disp_'); ?>",
                                                                                        type: 'Post',
                                                                                        success: function (res) {
                                                                                                var res = jQuery.parseJSON(res);
																								/**********/
																							if(res.title == null)
																								{
																									jQuery('.pm_popup_modal_back .title_back h1').text("No Content added");
																								}
																								else
																								{
																									jQuery('.pm_popup_modal_back .title_back h1').text(res.title);
																								}
																								if(res.url == false)
																								{
																									jQuery('.pm_popup_modal_back .url_back').html('');
																								}
																								else
																								{
																									jQuery('.pm_popup_modal_back .url_back').html('<a href="' + res.url + '" target="_blank">' + res.url + '</a>');
																								}
                                                                                                jQuery('.pm_popup_modal_back .pm_data_body_back').html(res.content);
                                                                                               // jQuery('.pm_popup_modal .title h1').text(res.title);
                                                                                              //  jQuery('.pm_popup_modal .url').html('<a href="' + res.url + '" target="_blank">' + res.url + '</a>');
                                                                                             
                                                                                                jQuery('.pm_popup_modal_back').modal('show');
                                                                                        }
                                                                                });

                                                                        }
                                                                }
                                                        });


                                                });
                                        </script>
                                        
				<?php
				
			}
		} 
	}
	//echo $content;
}


function set_li($array,$postid) {
	
      $results = array();

	  if (is_array($array))
	  {
		 
		foreach ($array as $sub_array){
			if((isset($sub_array['data']['cid'])) && ($sub_array['data']['cid'] == $postid)){
			$results[] = $sub_array;
			}
			$results = array_merge($results, set_li($sub_array, $postid));
		}
	  }
	//print_r($results);
	 return  $results;
 
}

function save_patient_page($post_id) {
	// If this is a revision, get real post ID
	$current_post = get_post($post_id);
	
	$json_tree_id = get_post_meta($post_id,"column_attached_id",true);
	$json_tree = get_post_meta($json_tree_id,"pm_tree",true);
	$current_clicked_key = get_post_meta($post_id,"current_clicked_key",true);	
	$enc_array = utf8enc($json_tree,$current_clicked_key,$current_post);	
	update_post_meta($json_tree_id,"pm_tree",$enc_array);	
}
function utf8enc($array,$current_clicked_key,$current_post) {
    if (!is_array($array)) return;
    $helper = array();
    foreach ($array as $key => $value) { 
		$helper[utf8_encode($key)] = is_array($value) ? utf8enc($value,$current_clicked_key,$current_post) : utf8_encode($value) ;
		if($key == "title" && $array["key"] == $current_clicked_key)
		{
		$helper[utf8_encode($key)] = "<span style='text-decoration: underline;'>".$current_post->post_title."</span>";
		}

	}
    return $helper;
}


function manage_patient_page()
{
	$current_post = get_posts(array('post_type'=>'timeline_page'));
	
	global $wpdb;
   
	$current_post=$current_post[0];
	$json_tree = get_post_meta($current_post->ID,'pm_tree',true);
	if(isset($json_tree) && !empty($json_tree))
	{
	
		$final_arr=$json_tree;
		
		/*** Check all values in database ***/
		$j=0;
		$uploads = wp_upload_dir();
			$upload_path = $uploads['baseurl'];
		$keys=get_rec_ids($json_tree);
		/*foreach ($keys as $k) {
			$is_active = get_post_meta($k,'_fl_builder_enabled',true);
			if($is_active==1)
			{
				wp_enqueue_script('cu_for_js-'.$k,$upload_path.'/bb-plugin/cache/'.$k.'-layout.js');
				wp_enqueue_style('cu_for_css-'.$k,$upload_path.'/bb-plugin/cache/'.$k.'-layout.css');
				$is_active=0;
			}
			
		}*/
		
		$keys_s1=array();
		if(isset($keys) && !empty($keys))
		{
			foreach ($keys as $k) {
				$data = $wpdb->get_var('SELECT COUNT(*) FROM '.$wpdb->prefix.'posts where post_status="publish" and ID='.$k);       
				if($data<=0)
				{
					
					$keys_s1[$j]=$k;
					$j++;
				}
			}
		}
		//$keys_s1=array(628,662);
		if(isset($keys_s1) && !empty($keys_s1))
		{
			foreach ($keys_s1 as $key => $value) {
				$final_arr = get_rec_ar($final_arr,$final_arr,$value);
			}
		}
		
		$final_arr_str=$final_arr;
		$ra=array_remove_empty($final_arr);
		$fix_key=fix_keys($ra);
		/*echo '<pre>';
		echo '<h3>After Deleting NODE</h3>';
		print_r($fix_key);
		echo '<h3>PAGES</h3>';
		print_r(get_post_meta($current_post->ID,'pm_tree',true));
		echo '</pre>';
		exit;*/
		
		if(isset($fix_key))
		{
		
		update_post_meta($current_post->ID,'pm_tree',$fix_key);
		}
		else
		{
			$original_data = get_post_meta($current_post->ID,'pm_tree',true);
			update_post_meta($current_post->ID,'pm_tree',$original_data);
		}
	}
}
function fix_keys($array) {
    $numberCheck = false;
    foreach ($array as $k => $val) {
        if (is_array($val)) $array[$k] = fix_keys($val); //recurse
        if (is_numeric($k)) $numberCheck = true;
    }
    if ($numberCheck === true) {
        return array_values($array);
    } else {
        return $array;
    }
}
function get_rec_ar($json_tree,$xv,$cid)
{
   
   $return = array();
        foreach ($json_tree as $key=>$val) { 
            if(is_array($val))
            {
			
               if(isset($val['cid']) && $val['cid']==$cid){
                
                unset($json_tree);
                //continue;
               }
               else{
                $json_tree[$key]=get_rec_ar($val,$xv,$cid);
               }

                
            }
          
        }
    
    return $json_tree;
}

function add_strong_tag($json_tree)
{
   
   $return = array();
        foreach ($json_tree as $key=>$val) { 
            if(is_array($val))
            {
				
				if(!empty($val['title']))
				{
					$val['title']=htmlspecialchars($val['title']);
				}
                $json_tree[$key]=add_strong_tag($val);
               
                             
            }
          
        }
    
    return $json_tree;
}



function array_remove_empty($haystack)
{
    foreach ($haystack as $key => $value) {
        if (is_array($value)) {
            $haystack[$key] = array_remove_empty($haystack[$key]);
        }
       
		if(!isset($haystack[$key]['key']) && is_numeric($key))
		{
			
			unset($haystack[$key]);
		}
        if ($haystack[$key]=="") {
			
            //unset($haystack[$key]);
        }
     
    }

    return $haystack;
}
function get_rec_ids($json_tree)
{
    //if (!is_array($json_tree)) return;
   $return = array();
        foreach ($json_tree as $key=>$value) { 
            
            if(is_array($value))
            {
                $return = array_merge($return, get_rec_ids($value));
            }
            else{
      
                if($key=='cid')
                {
                    $return[]=$value;  
                }
               
            }
        }
    
    return $return;
}
add_action( 'init', 'manage_patient_page' );

add_action("admin_init","call_func");
function call_func() { 
add_action( 'save_post', 'save_patient_page' );


}
add_action( 'admin_menu', 'my_plugin_menu_timeline' );
function my_plugin_menu_timeline()
{
	add_options_page( 'Timeline Email settings', 'Timeline Email settings', 'manage_options', 'timeline-mail', 'email_timeline_set');
	
}

function email_timeline_set()
{
	echo '<h3>Email settings</h3>';
	global $current_user;
    get_currentuserinfo();
	?>
			  <div class='container'>
			  <div class='col-md-9'>
			  
				<form class="form-horizontal timeline_form" role="form">
				
				  
				  <div class="form-group subject_ms req"> 
					<label class="control-label col-sm-2" for="sub">Subject:</label>
					<div class="col-sm-10"> 
					  <input type="text" class="form-control subject" id="timeline_subject" name='timeline_subject' value="<?php echo get_user_meta($current_user->ID,'timeline_subject',true); ?>">
					</div>
				  </div>
				  
				  <div class="form-group message_ms"> 
					  <label class="control-label col-sm-2" for="sub">Intro Message</label>
					  <div class="col-sm-10"> 
						  <?php 
						  $content = '';
							$editor_id = 'timeline_email_wrap';
							$settings = array(
							'media_buttons'=>false,
							'textarea_name'=>'message_test1' ,
							'editor_class'=>'add_link_test' ,
							'media_buttons' => false,
							'quicktags'     => TRUE,
							'textarea_rows' => 50,
							'editor_height' => '50px'
							);
							wp_editor( $content, $editor_id ,$settings);
							/*wp_editor($content, $editor_id, $settings = array('editor_height' => 350, 'media_buttons' => true, 'quicktags' => true, 'tinymce' => array(
                                                'toolbar1'=>'bold italic |  bullist | link image unlink | wp_adv',
                                                'toolbar2' => 'formatselect,underline,justifyfull,forecolor,|,pastetext,pasteword,removeformat,|,media,charmap,|,outdent,indent,|,undo,redo,wp_help,image | alignleft aligncenter alignright alignjustify | numlist outdent indent |',
                                              //'theme_advanced_buttons1' => 'bold, italic, ul, min_size, max_size'
                                        )));*/

						  ?>
						<!--<textarea class='cont_test' name='message_test'></textarea>-->
					  </div>
				  </div>
				  				  
				  <div class="form-group message_ms"> 
					  <label class="control-label col-sm-2" for="sub">Signature</label>
					  <div class="col-sm-10"> 
						  <?php 
						  $content = '';
							$editor_id = 'timeline_email';
							$settings = array(
							'media_buttons'=>false,
							'textarea_name'=>'message_test1' ,
							'editor_class'=>'add_link_test' ,
							'media_buttons' => false,
							'quicktags'     => TRUE,
							'textarea_rows' => 50,
							'editor_height' => '50px'
							);
							//wp_editor( $content, $editor_id ,$settings);
							wp_editor($content, $editor_id, $settings = array('editor_height' => 350, 'media_buttons' => true, 'quicktags' => true, 'tinymce' => array(
                                                'toolbar1'=>'bold italic |  bullist | link image unlink | wp_adv',
                                                'toolbar2' => 'formatselect,underline,justifyfull,forecolor,|,pastetext,pasteword,removeformat,|,media,charmap,|,outdent,indent,|,undo,redo,wp_help,image | alignleft aligncenter alignright alignjustify | numlist outdent indent |',
                                              //'theme_advanced_buttons1' => 'bold, italic, ul, min_size, max_size'
                                        )));

						  ?>
						<!--<textarea class='cont_test' name='message_test'></textarea>-->
					  </div>
				  </div>
				  
				  
				  <div class="form-group "> 
					<div class="col-sm-10"> 
					  <button type="button" class="btn btn-info save_details" >Save Details</button>
					</div>
				  </div>
				  
				</form>
			  </div>
			  
			  </div>
				
			  <script>
				  
				  jQuery(document).ready(function(){
					
					  setTimeout(function(){
						 tinyMCE.get('timeline_email').setContent("<?php echo addslashes(get_user_meta($current_user->ID,'timeline_email',true)); ?>");
						 tinyMCE.get('timeline_email_wrap').setContent("<?php echo addslashes(get_user_meta($current_user->ID,'int_msg',true)); ?>");
						  },700);
				  jQuery('.save_details').click(function(e){
						e.preventDefault();
						var subject = jQuery('#timeline_subject').val();
						var signature = tinyMCE.get('timeline_email').getContent();
						var int_msg = tinyMCE.get('timeline_email_wrap').getContent();
						
						signature = encodeURIComponent(signature);
						jQuery.ajax({
							url:"<?php echo admin_url('admin-ajax.php'); ?>",
							type:"POST",
							data:"action=save_timeline_email_settings&timeline_subject="+subject+"&timeline_email="+signature+"&int_msg="+int_msg,
							success:function(res){
									if(res)
									{
										alert('Data Saved');
									}
									else
									{
										alert('Please try again later');
									}
							}
							
							});
					  });
				        
					  
					  jQuery('.update_tempadsfsadfs').click(function(e){
						  e.preventDefault();
							jQuery.ajax({
								url:"<?php echo admin_url('admin-ajax.php'); ?>",
								data:"action=push_bb_template",
								success:function(res)
								{
									alert('Saved');
								}
								});
						  });
					  });
			  </script>
			  
	<?php
	
}
add_action('wp_ajax_save_timeline_email_settings','save_timeline_email_settings');
function save_timeline_email_settings()
{
	global $current_user;
    get_currentuserinfo();
    if(isset($_REQUEST['timeline_subject']) && !empty($_REQUEST['timeline_subject']))
	{
		update_user_meta($current_user->ID,'timeline_subject',strip_tags($_REQUEST['timeline_subject']));
		update_user_meta($current_user->ID,'timeline_email',$_REQUEST['timeline_email']);
		update_user_meta($current_user->ID,'int_msg',$_REQUEST['int_msg']);
		
		$po = get_posts(array('post_type'=>'patient_templates','posts_per_page'=>-1));
		foreach($po as $p)
		{
			update_post_meta($p->ID,'pt_thumbnails',plugins_url('/images/' . $p->post_name . '.jpg', __FILE__));
		}
		return true;
	}
	return false;
}

add_action('wp_ajax_push_bb_template','push_bb_template');
function push_bb_template()
{
	 $p = array(
			'post_status' => 'publish',
			'post_type' => 'patient_templates',
			'orderby'=>'menu_order',
			'order' => 'ASC',
			'numberposts' => -1,
		);

		$posts = get_posts($p);
		foreach($posts as $k)
		{
			$duplicate = get_page_by_title($k->post_title,OBJECT,'fl-builder-template');
			
			if(isset($duplicate) && !empty($duplicate))
			{
				wp_update_post(array(
				"ID"	=> $duplicate->ID,
				"post_title" => $duplicate->post_title,
				"post_content" => $duplicate->post_content,
				));
			}
			else
			{
				$post_id = wp_insert_post(array(
					'post_title'	 => $k->post_title,
					'post_type'		 => 'fl-builder-template',
					'post_status'	 => 'publish',
					'post_content'	 => $k->post_content,
					'ping_status'	 => 'closed',
					'comment_status' => 'closed'
				));
				update_post_meta($post_id,'timeline_bb_post_thumbnail',plugins_url('/images/' . $k->post_name . '.jpg', __FILE__));
				update_post_meta($post_id,'timeline_save_cont',$k->post_content);
				// Set the template type.
				wp_set_post_terms( $post_id, 'layout', 'fl-builder-template-type' );
			}
		}

}


add_action('wp_ajax_mail_link_popup','mail_link_popup');
add_action('wp_ajax_nopriv_mail_link_popup','mail_link_popup');
function mail_link_popup()
{
	
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=utf-8" . "\r\n";
	
	if(wp_mail($_REQUEST['to_email'],$_REQUEST['subject'],trim(stripslashes(urldecode($_REQUEST['message_test']))),$headers))
	{
		return true;
		//exit;
	}
	exit;

}
add_action('init','remove_panel');
function remove_panel(){
	add_action('wp_footer','remove_panel_query');
}
function remove_panel_query()
{
	?>
	<script>
		jQuery(document).ready(function(){
				if(jQuery('div').hasClass('fl-builder-bar-content'))
				{
					jQuery('body').addClass('dothis');
					jQuery('#content').css({'margin-left':'0'});
					jQuery('#sidebar').addClass('slideside');
					jQuery('.site-footer').addClass('slidefooter');
					
				  
				}
				else
				{
					jQuery('body').removeClass('dothis');
					jQuery('#content').removeClass('slideleft');
					jQuery('#sidebar').removeClass('slideside');
					jQuery('.site-footer').removeClass('slidefooter');
				}
			});
	</script>
	<?php
}
