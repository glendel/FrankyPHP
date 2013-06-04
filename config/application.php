<?php
  $_APPLICATION = array();
  
  setLayoutTo( 'application' );
  setViewToRenderTo( $controller, $view );
  
  require_once( getControllerPathFor( $controller ) );
  include_once( getLayoutOrViewPathToRender() );
