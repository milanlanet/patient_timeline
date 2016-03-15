
<?php
require_once('../../../wp-load.php'); 

wp_head();

echo do_shortcode('[pm_template_frontend]');

wp_footer();
?>