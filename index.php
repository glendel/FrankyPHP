<?php
  session_start();
  
  defined( 'PS' ) or define( 'PS', '/' ); // Path Separator
  defined( 'ROOT_PATH' ) or define( 'ROOT_PATH', ( dirname( __FILE__ ) . PS ) );
  defined( 'CONFIG_PATH' ) or define( 'CONFIG_PATH', ( ROOT_PATH . 'config' . PS ) );
  defined( 'LIB_PATH' ) or define( 'LIB_PATH', ( ROOT_PATH . 'lib' . PS ) );
  
  require_once( CONFIG_PATH . 'boot.php' );
