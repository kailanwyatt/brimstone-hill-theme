<?php
require_once dirname( __DIR__, 3 ) . '/wp-load.php';
delete_option( 'bh_home_discover_json' );
echo "Option deleted successfully.";
