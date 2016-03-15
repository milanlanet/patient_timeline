jQuery(document).ready(function($) {
        
    $(document).on("click", "#upload_image_button", function() {
console.log('fdf');
        //jQuery.data(document.body, 'prevElement', $(this).prev());

        window.send_to_editor = function(html) {
                
            var imgurl = jQuery('img',html).attr('src');
            var inputText = jQuery.data(document.body, 'prevElement');

            if(inputText != undefined && inputText != '')
            {
                inputText.val(imgurl);
            }

            tb_remove();
        };

        tb_show('', '../wp-admin/media-upload.php?type=image&TB_iframe=true&post_id=0');
        return false;
    });
});