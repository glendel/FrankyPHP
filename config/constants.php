<?php
  // Paths
  defined( 'APP_PATH' ) or define( 'APP_PATH', ( ROOT_PATH . 'app' . PS ) );
  defined( 'MODELS_PATH' ) or define( 'MODELS_PATH', ( APP_PATH . 'models' . PS ) );
  defined( 'VIEWS_PATH' ) or define( 'VIEWS_PATH', ( APP_PATH . 'views' . PS ) );
  defined( 'CONTROLLERS_PATH' ) or define( 'CONTROLLERS_PATH', ( APP_PATH . 'controllers' . PS ) );
  defined( 'HELPERS_PATH' ) or define( 'HELPERS_PATH', ( APP_PATH . 'helpers' . PS ) );
  defined( 'ASSETS_PATH' ) or define( 'ASSETS_PATH', ( APP_PATH . 'assets' . PS ) );
  defined( 'IMAGES_PATH' ) or define( 'IMAGES_PATH', ( ASSETS_PATH . 'images' . PS ) );
  defined( 'JAVASCRIPTS_PATH' ) or define( 'JAVASCRIPTS_PATH', ( ASSETS_PATH . 'javascripts' . PS ) );
  defined( 'STYLESHEETS_PATH' ) or define( 'STYLESHEETS_PATH', ( ASSETS_PATH . 'stylesheets' . PS ) );
  
  // URLs
  defined( 'US' ) or define( 'US', '/' ); // URL Separator
  defined( 'ROOT_URL' ) or define( 'ROOT_URL', ( getCurrentUrl( true ) . US ) );
  defined( 'ASSETS_URL' ) or define( 'ASSETS_URL', ( ROOT_URL . 'app' . US . 'assets' . US ) );
  defined( 'IMAGES_URL' ) or define( 'IMAGES_URL', ( ASSETS_URL . 'images' . US ) );
  defined( 'JAVASCRIPTS_URL' ) or define( 'JAVASCRIPTS_URL', ( ASSETS_URL . 'javascripts' . US ) );
  defined( 'STYLESHEETS_URL' ) or define( 'STYLESHEETS_URL', ( ASSETS_URL . 'stylesheets' . US ) );
