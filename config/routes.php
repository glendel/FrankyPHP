<?php
  $params = $_REQUEST;
  $controller = ( ( !isset( $params[ 'controller' ] ) || empty( $params[ 'controller' ] ) ) ? 'home' : $params[ 'controller' ] );
  $action = ( ( !isset( $params[ 'action' ] ) || empty( $params[ 'action' ] ) ) ? 'index' : $params[ 'action' ] );
  $view = $action;
