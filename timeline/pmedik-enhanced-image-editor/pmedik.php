<?php

class PmEdik {

    private static $_options = array(
        'pmedik_enable_buildin_editor' => '0',
    );

    public function __construct() {
        //$this->plugin_url = plugins_url().'/pmedik-enhanced-image-editor';
        $this->plugin_url = plugins_url('/',__FILE__);
        $this->plugin_dir_path = plugin_dir_path( __FILE__ );
        plugin_dir_path( __FILE__ );

        // Frontend
        add_filter('wp_print_scripts', array(&$this, 'init_javascripts'), 10);
        add_filter('media_row_actions', array(&$this, 'media_row_action_add'), 10);
        add_action( 'admin_footer-post-new.php', array(&$this, 'pmedik_script_injection') ); // Hook to inject into attachment details area
        add_action( 'admin_footer-post.php', array(&$this, 'pmedik_script_injection') ); // Hook to inject into attachment details area

        add_action( 'wp_footer', array(&$this, 'pmedik_script_injection') ); // Hook to inject into attachment details area
        // Admin hooks
        add_action('admin_menu', array(&$this, 'pmedik_settings_menu'));

        $this->ajax_init();
    }

    function pmedik_settings_menu() {
      add_submenu_page('options-general.php', 'Edik Settings', 'Edik Settings', 'manage_options', 'pmedik-settings', array(&$this, 'settings_page'));
      add_action( 'admin_init', array(&$this, 'register_mysettings' ));
    }

    function register_mysettings() {
        foreach(self::$_options as $option=>$value) {
            register_setting( 'pmedik-settings-group', $option );
        }
    }

    function settings_page() {
        foreach(self::$_options as $option_name=>$default_value)
            $options[$option_name] = get_option($option_name, $default_value);

        require($this->plugin_dir_path.'/tpl/pmedik-settings.php');
    }

    private function ajax_init() {
        add_filter('wp_ajax_pmedik_get_editor_content', array(&$this, 'ajax_pmedik_get_editor_content'), 10);
        add_filter('wp_ajax_pmedik_update_attachment', array(&$this, 'ajax_pmedik_update_attachment'), 10);
    }

    public function media_row_action_add($row_actions) {
            
        // Extract current attachement ID
        
                preg_match('/post=([0-9]*)/', $row_actions['edit'], $out);
                $current_att_id = $out[1];

                $action['pmedik_edit'] = '<a href="'.get_site_url().'/wp-admin/admin-ajax.php?action=pmedik_get_editor_content&image='.$current_att_id.'" class="pmedik-wp-extended-edit" title="Edit using Edik extended editor">Extended Image Editor</a>';
       
        
        $updated_row_actions = array_merge($action, array_slice($row_actions, 1));
        if (get_option('pmedik_enable_buildin_editor', 0)):
            $updated_row_actions = array_merge(array_slice($row_actions, 0, 1), $updated_row_actions);
            
        endif;

        return $updated_row_actions;
    }

    public function init_javascripts() {
        //if ( is_admin() ) {
            wp_register_script('pmedik_admin_script', ( $this->plugin_url . '/js/pmedik.js'), false);
            wp_enqueue_script('pmedik_admin_script');

            wp_localize_script('pmedik_admin_script', 'pmedik_script_vars', array( 'pmedik_plugin_url' => $this->plugin_url, 'ajax_nonce' => wp_create_nonce('pmedik-attachment')));
        //}
    }

    public function ajax_pmedik_get_editor_content() {
        $image = wp_get_attachment_image_src($_GET["image"], 'full');
        echo '<div id="for_pmedik" data-attach-id="'.$_GET["image"].'" data-src="'.$image[0].'"></div>';
        die();
    }

    public function ajax_pmedik_update_attachment() {
        check_ajax_referer('pmedik-attachment', 'nonce');

        $att_image_path = get_attached_file($_POST['att_id']);
        $image = $_POST["image"];

        list($type, $data) = explode(';', $image);
        list(, $data)      = explode(',', $data);
	
        file_put_contents($att_image_path, base64_decode($data));
        
        $old_meta = wp_get_attachment_metadata($_POST['att_id']);

        $path_parts = pathinfo($old_meta["file"]);

        $upload_dir = wp_upload_dir();
        $files_path =  $upload_dir["basedir"]."/".$path_parts["dirname"];

        // Deleting all old files, before creating new
        foreach ($old_meta["sizes"] as $val) {
            @unlink($files_path.'/'.$val['file']);
        }
        
        // Thumbnails regenerating
        $data = wp_generate_attachment_metadata( $_POST['att_id'], $att_image_path );
        wp_update_attachment_metadata( $_POST['att_id'], $data );

        $data['full_path'] = $upload_dir['baseurl'].'/'.$path_parts['dirname'];
        echo json_encode($data);

        die();
    }

    public function pmedik_script_injection()
    {
        ?>
        <script>
            jQuery(function($) {
                //$('#wpcontent').ajaxStop(function() {

                    var add_link = function() {
                            
                        var details = $('.attachment-details .edit-attachment');
                        
                        $.each(details, function(i, detail) {
                            parent = $(detail).parent();
                            
                            if (parent.find('.pmedik-wp-extended-edit').length<=0) {
                                // Getting of attachment ID
                                var mask = /post=([0-9]*)/;
                                var found = $(detail).attr('href').match(mask);
                                var att_id = found[1];
                               

                                $(detail).before($('<a class="pmedik-wp-extended-edit" href="<?php echo get_site_url(); ?>/wp-admin/admin-ajax.php?action=pmedik_get_editor_content&image='+att_id+'">Extended image edit</a>'));
                            }
                            <?php if (!get_option('pmedik_enable_buildin_editor', 0)):?>
                            $(detail).css('display', 'none');
                            <?php endif; ?>
                        });
                    };
                    add_link();
                    
                    $(document).on('click', '.dashicons-edit', function() {
                    	var cls_name = $('.wp-editor-container').find('iframe').contents().find('img[data-mce-selected=1]').attr('class');
                    	var parts = cls_name.split("wp-image-");
                    	var t_id = parts[1].split(' ');
                    	var att_id = t_id[0];
                    	$('.embed-media-settings .edit-attachment').before($('<a class="pmedik-wp-extended-edit" href="<?php echo get_site_url(); ?>/wp-admin/admin-ajax.php?action=pmedik_get_editor_content&image='+att_id+'">Extended image edit</a>'));
                    	
                    });
                    
                    $(document).on('click','.image-details .media-button-select',function(){
                      //var src = $('.wp-editor-container').find('iframe').contents().find('img[data-mce-selected=1]').attr('src');
                      var src = $('#br_image').data('src');
                      
                      $('.wp-editor-container').find('iframe').contents().find('img[data-mce-selected=1]').attr('src',src);
                    	$('.wp-editor-container').find('iframe').contents().find('img[data-mce-selected=1]').attr('data-mce-src',src);
                    })
                    

                    $(document).on('click', '.attachment-preview .thumbnail', function() {
                    	
                        add_link();
                    });

                    // WOO Commerce: Appending Extended edit button to products list (Product Gallery)
                    var imgs = $('#woocommerce-product-images .product_images .image');

                    $.each(imgs, function(img) {
                        if ($(this).find('.actions a.pmedik-wp-extended-edit').length<=0)
                            $(this).find('.actions').append('<li><a href="<?php echo get_site_url(); ?>/wp-admin/admin-ajax.php?action=pmedik_get_editor_content&image='+$(this).data('attachment_id')+'" class="pmedik-wp-extended-edit" title="Extended image editor"></a></li>')
                    });

                    $('.hide-if-no-js #remove-post-thumbnail').parent().append('<a id="pmedik-featured-image" href="<?php echo get_site_url(); ?>/wp-admin/admin-ajax.php?action=pmedik_get_editor_content&image=<?php echo get_post_thumbnail_id(); ?>" class="pmedik-wp-extended-edit" title="Extended image editor">Image editor</a>');
                //});

                <?php if(isset($_GET["post"])):?>
                        // Adding pmedik editor to attachment page
                        var standard_btn = $('input[id*="imgedit-open-btn-"]');

                        $('<input type="button" value="Extended image edit" class="button pmedik-wp-extended-edit" data-src="<?php echo get_site_url(); ?>/wp-admin/admin-ajax.php?action=pmedik_get_editor_content&image=<?php echo $_GET["post"]; ?>">').insertAfter(standard_btn);

                        <?php if (!get_option('pmedik_enable_buildin_editor', 0)):?>
                            standard_btn.remove();

                        <?php endif; ?>
                <?php endif; ?>
            });
        </script>
    <?php
    }

}



new PmEdik();
