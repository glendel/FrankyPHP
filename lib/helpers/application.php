<?php
  /**
   * getCurrentUrl
   **/
  function getCurrentUrl( $root = false ) {
    $scheme = ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] == 'on' ) ? 'https://' : 'http://';
    $domain = $_SERVER[ 'SERVER_NAME' ];
    $port = ( $_SERVER[ 'SERVER_PORT' ] != '80' ) ? ( ':' . $_SERVER[ 'SERVER_PORT' ] ) : '';
    $currentUrl = $scheme . $domain . $port;
    $currentUrl .= ( ( $root === true ) ? dirname( $_SERVER[ 'SCRIPT_NAME' ] ) : $_SERVER[ 'REQUEST_URI' ] );
    
    return( $currentUrl );
  }
  
  /**
   * getUrlFor
   **/
  function getUrlFor( $options, $action = '', $params = '' ) {
    $url = ( ROOT_URL . 'index.php' );
    
    if ( is_array( $options ) ) {
      if ( isset( $options[ 'controller' ] ) && !empty( $options[ 'controller' ] ) ) { $url .= '?controller=' . $options[ 'controller' ]; }
      if ( isset( $options[ 'action' ] ) && !empty( $options[ 'action' ] ) ) { $url .= ( ( strpos( $url, '?' ) === false ) ? '?' : '&' ) . 'action=' . $options[ 'action' ]; }
      if ( isset( $options[ 'params' ] ) && !empty( $options[ 'params' ] ) ) { $url .= ( ( strpos( $url, '?' ) === false ) ? '?' : '&' ) . $options[ 'params' ]; }
    } else {
      if ( !empty( $options ) ) { $url .= '?controller=' . $options; }
      if ( !empty( $action ) ) { $url .= ( ( strpos( $url, '?' ) === false ) ? '?' : '&' ) . 'action=' . $action; }
      if ( !empty( $params ) ) { $url .= ( ( strpos( $url, '?' ) === false ) ? '?' : '&' ) . $params; }
    }
    
    return( $url );
  }
  
  /**
   * redirectTo
   **/
  function redirectTo( $options, $action = '', $params = '' ) {
    header( 'Location: ' . getUrlFor( $options, $action, $params) );
    exit( 0 );
  }
  
  /**
   * getControllerPathFor
   **/
  function getControllerPathFor( $controller ) {
    return( CONTROLLERS_PATH . $controller . '.php' );
  }
  
  /**
   * getHelperPathFor
   **/
  function getHelperPathFor( $helper ) {
    return( HELPERS_PATH . $helper . '.php' );
  }
  
  /**
   * getModelPathFor
   **/
  function getModelPathFor( $model ) {
    return( MODELS_PATH . $model . '.php' );
  }
  
  /**
   * getViewPathFor
   **/
  function getViewPathFor( $controller, $view, $type = 'html' ) {
    return( VIEWS_PATH . $controller . PS . $view . '.' . $type . '.php' );
  }
  
  /**
   * getLayoutPathFor
   **/
  function getLayoutPathFor( $layout ) {
    return( getViewPathFor( 'layouts', $layout ) );
  }
  
  /**
   * getPartialPathFor
   **/
  function getPartialPathFor( $controller, $partial, $type = 'html' ) {
    return( getViewPathFor( $controller, ( '_' . $partial ), $type ) );
  }
  
  /**
   * setViewToRenderTo
   **/
  function setViewToRenderTo( $controller, $view, $type = 'html' ) {
    global $_APPLICATION;
    
    $_APPLICATION[ 'view_path' ] = getViewPathFor( $controller, $view, $type );
  }
  
  /**
   * getViewPathToRender
   **/
  function getViewPathToRender() {
    global $_APPLICATION;
    
    return( ( ( isset( $_APPLICATION[ 'view_path' ] ) ) ? $_APPLICATION[ 'view_path' ] : '' ) );
  }
  
  /**
   * getImagePathFor
   **/
  function getImagePathFor( $image ) {
    return( IMAGES_PATH . $image );
  }
  
  /**
   * getImageUrlFor
   **/
  function getImageUrlFor( $image ) {
    return( IMAGES_URL . $image );
  }
  
  /**
   * getJavaScriptPathFor
   **/
  function getJavaScriptPathFor( $javascript ) {
    return( JAVASCRIPTS_PATH . $javascript . '.js' );
  }
  
  /**
   * getJavaScriptUrlFor
   **/
  function getJavaScriptUrlFor( $javascript ) {
    return( JAVASCRIPTS_URL . $javascript . '.js' );
  }
  
  /**
   * getJavaScriptTagFor
   **/
  function getJavaScriptTagFor( $javascript ) {
    return( ( ( is_readable( getJavaScriptPathFor( $javascript ) ) ) ? '<script type="text/javascript" src="' . getJavaScriptUrlFor( $javascript ) . '"></script>' : '' ) );
  }
  
  /**
   * getStyleSheetPathFor
   **/
  function getStyleSheetPathFor( $stylesheet ) {
    return( STYLESHEETS_PATH . $stylesheet . '.css' );
  }
  
  /**
   * getStyleSheetUrlFor
   **/
  function getStyleSheetUrlFor( $stylesheet ) {
    return( STYLESHEETS_URL . $stylesheet . '.css' );
  }
  
  /**
   * getStyleSheetTagFor
   **/
  function getStyleSheetTagFor( $stylesheet ) {
    return( ( ( is_readable( getStyleSheetPathFor( $stylesheet ) ) ) ? '<link rel="stylesheet" type="text/css" href="' . getStyleSheetUrlFor( $stylesheet ) . '" />' : '' ) );
  }
  
  /**
   * setLayoutTo
   **/
  function setLayoutTo( $layout ) {
    global $_APPLICATION;
    
    $_APPLICATION[ 'layout' ] = $layout;
  }
  
  /**
   * getLayout
   **/
  function getLayout() {
    global $_APPLICATION;
    
    return( ( ( isset( $_APPLICATION[ 'layout' ] ) ) ? $_APPLICATION[ 'layout' ] : '' ) );
  }
  
  /**
   * getLayoutOrViewPathToRender
   **/
  function getLayoutOrViewPathToRender() {
    global $_APPLICATION;
    
    if ( isset( $_APPLICATION[ 'layout' ] ) && !empty( $_APPLICATION[ 'layout' ] ) ) {
      return( getLayoutPathFor( $_APPLICATION[ 'layout' ] ) );
    } else {
      return( getViewPathToRender() );
    }
  }
  
  /**
   * getErrorMessageFor
   **/
  function getErrorMessageFor( $obj, $defaultErrorMessage = '' ) {
    $message = '';
    
    if ( is_array( $obj ) && is_array( $obj[ 'errors' ] ) && is_array( $obj[ 'errors' ][ 'messages' ] ) && !empty( $obj[ 'errors' ][ 'messages' ] ) ) {
      $message .= count( $obj[ 'errors' ][ 'messages' ] ) . ' error(s) prohibited the data from being saved.<br/><br/>';
      $message .= 'There were problems with the following fields:<br/>';
      $message .= '<ul>';
      
      foreach( $obj[ 'errors' ][ 'messages' ] as $field => $messages ) {
        foreach( $messages as $msg ) {
          $message .= '<li><b>' . ucwords( strtolower( $field ) ) . ':</b> ' . $msg . '</li>';
        }
      }
      
      $message .= '</ul>';
    }
    
    if ( empty( $message ) ) { $message .= (string)$defaultErrorMessage; }
    
    return( $message );
  }
  
  /**
   * setFlashMessage
   **/
  function setFlashMessage( $type, $message ) {
    if ( !isset( $_SESSION[ 'flash' ] ) ) { $_SESSION[ 'flash' ] = array(); }
    $_SESSION[ 'flash' ][ $type ] = $message;
  }
  
  /**
   * getFlashMessage
   **/
  function getFlashMessage( $type ) {
    $message = '';
    
    if ( isset( $_SESSION[ 'flash' ] ) && isset( $_SESSION[ 'flash' ][ $type ] ) ) {
      $message = $_SESSION[ 'flash' ][ $type ];
      unset( $_SESSION[ 'flash' ][ $type ] );
    }
    
    return( $message );
  }
  
  /**
   * setContentFor
   **/
  function setContentFor( $name, $content ) {
    if ( !isset( $_SESSION[ 'yield' ] ) ) { $_SESSION[ 'yield' ] = array(); }
    if ( !isset( $_SESSION[ 'yield' ][ $name ] ) ) { $_SESSION[ 'yield' ][ $name ] = array(); }
    array_push( $_SESSION[ 'yield' ][ $name ], $content );
  }
  
  /**
   * contentForExists
   **/
  function contentForExists( $name ) {
    return( ( isset( $_SESSION[ 'yield' ] ) && isset( $_SESSION[ 'yield' ][ $name ] ) ) );
  }
  
  /**
   * getContentFor
   **/
  function getContentFor( $name ) {
    $content = '';
    
    if ( contentForExists( $name ) ) {
      $total = count( $_SESSION[ 'yield' ][ $name ] );
      
      for ( $i = 0; $i < $total; $i++ ) {
        $content .= $_SESSION[ 'yield' ][ $name ][ $i ];
        if ( ( $i + 1 ) < $total ) { $content .= "\n"; }
      }
    }
    
    return( $content );
  }
  
  /**
   * unsetContents
   **/
  function unsetContents() {
    if ( isset( $_SESSION[ 'yield' ] ) ) { unset( $_SESSION[ 'yield' ] ); }
  }
