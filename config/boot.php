<?php
  require_once( LIB_PATH . 'helpers' . PS . 'application.php' );
  require_once( CONFIG_PATH . 'constants.php' );
  require_once( CONFIG_PATH . 'database.php' );
  require_once( LIB_PATH . 'databases' . PS . 'adapters' . PS . DATABASE_ADAPTER . '.php' );
  DbAdapter::connect();
  require_once( CONFIG_PATH . 'routes.php' );
  require_once( CONFIG_PATH . 'application.php' );
  DbAdapter::close();
