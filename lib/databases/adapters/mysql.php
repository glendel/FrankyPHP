<?php
  if ( !class_exists( 'DbAdapter' ) ) {
    /**
     * DbAdapter
     **/
    class DbAdapter {
      protected static $dbConnection;
      
      /**
       * setDbConnection
       **/
      public static function setDbConnection( $dbConnection ) {
        self::$dbConnection = $dbConnection;
      }
      
      /**
       * connect
       **/
      public static function connect() {
        $objMysqli = @new mysqli( DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWD );
        
        // Check connection
        if ( $objMysqli->connect_errno ) {
          // error_log(  );
          $errorMessage = '<p style="color:red;">Failed Connection!</p>';
          $errorMessage .= '<p>ERROR ' . $objMysqli->connect_errno . ' (' . @$objMysqli->sqlstate . ') : ' . $objMysqli->connect_error . '</p>';
          $errorMessage .= '<p>Please set the "DATABASE_HOST", "DATABASE_USERNAME" and "DATABASE_PASSWD" constants in the "/config/database.php" file to valid connection credentials.</p>';
          die( $errorMessage );
          throw new Exception( "Failed Connection!<br />\nERROR " . $objMysqli->connect_errno . ' (' . $objMysqli->sqlstate . ') : ' . $objMysqli->connect_error );
        }
        
        self::setDbConnection( $objMysqli );
      }
      
      /**
       * getDbConnection
       **/
      public static function getDbConnection() {
        return( self::$dbConnection );
      }
      
      /**
       * dbExists
       **/
      public static function dbExists( $dbName = DATABASE_DBNAME ) {
        $sqlstr = self::queryBuilder( 'select', array( 'select' => '`SCHEMA_NAME`', 'table' => '`information_schema`.`SCHEMATA`', 'where' => ( '`SCHEMA_NAME` = "' . $dbName . '"' ) ) );
        $result = self::query( $sqlstr );
        
        return( $result->num_rows > 0 );
      }
      
      /**
       * selectDb
       **/
      public static function selectDb( $dbName = DATABASE_DBNAME ) {
        if ( !self::dbExists( $dbName ) ) {
          $errorMessage = '<p style="color:red;">The Selected Database ("' . $dbName . '") Does Not Exist!</p>';
          $errorMessage .= '<p>Please modify the "DATABASE_DBNAME" constant in the "/config/database.php" file to a valid an existing database or create the "' . $dbName . '" database.</p>';
          die( $errorMessage );
          throw new Exception( $errorMessage );
        }
        
        $objMysqli = self::getDbConnection();
        
        $objMysqli->select_db( $dbName );
        
        $sqlstr = 'SELECT DATABASE() AS `dbName`';
        
        if ( $result = self::query( $sqlstr ) ) {
          $obj = self::fetchAssoc( $result );
          
          if ( $obj[ 'dbName' ] != $dbName ) {
            throw new Exception( "Failed Selecting Database!<br />\nERROR " . $objMysqli->errno . ' (' . $objMysqli->sqlstate . ') : ' . $objMysqli->error );
          }
        }
      }
      
      /**
       * close
       **/
      public static function close() {
        self::getDbConnection()->close();
      }
      
      /**
       * getTableName
       **/
      public static function getTableName() {
        return( static::$tableName );
      }
      
      /**
       * tableExists
       **/
      public static function tableExists( $tableName = '', $dbName = DATABASE_DBNAME ) {
        $tableName = ( ( empty( $tableName ) ) ? self::getTableName() : trim( $tableName ) );
        $sqlstr = self::queryBuilder( 'select', array( 'select' => '`TABLE_NAME`', 'table' => '`information_schema`.`TABLES`', 'where' => ( '`TABLE_SCHEMA` = "' . $dbName . '" AND `TABLE_NAME` = "' . $tableName . '"' ) ) );
        $result = self::query( $sqlstr );
        
        return( $result->num_rows > 0 );
      }
      
      /**
       * getPrimaryKey
       **/
      public static function getPrimaryKey() {
        return( ( ( property_exists( get_called_class(), 'primaryKey' ) ) ? static::$primaryKey : 'id' ) );
      }
      
      /**
       * realEscapeString
       **/
      public static function realEscapeString( $string ) {
        return( self::getDbConnection()->real_escape_string( $string ) );
      }
      
      /**
       * getEscapedTableName
       **/
      public static function getEscapedTableName() {
        return( self::realEscapeString( self::getTableName() ) );
      }
      
      /**
       * getEscapedPrimaryKey
       **/
      public static function getEscapedPrimaryKey() {
        return( self::realEscapeString( self::getPrimaryKey() ) );
      }
      
      /**
       * queryBuilder
       **/
      public static function queryBuilder( $type, $options = array() ) {
        $table = ( ( isset( $options[ 'table' ] ) && !empty( $options[ 'table' ] ) ) ? self::realEscapeString( $options[ 'table' ] ) : ( '`' . self::getEscapedTableName() . '`' ) );
        $select = '*';
        $from = $table;
        $joins = '';
        $where = '';
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $sqlstr = '';
        
        if ( isset( $options[ 'select' ] ) && !empty( $options[ 'select' ] ) ) { $select = $options[ 'select' ]; }
        if ( isset( $options[ 'from' ] ) && !empty( $options[ 'from' ] ) ) { $from = $options[ 'from' ]; }
        if ( isset( $options[ 'joins' ] ) && !empty( $options[ 'joins' ] ) ) { $joins = ( ' ' . trim( $options[ 'joins' ] ) ); }
        if ( isset( $options[ 'where' ] ) && !empty( $options[ 'where' ] ) ) { $where = ( ' WHERE ' . $options[ 'where' ] ); }
        if ( isset( $options[ 'group_by' ] ) && !empty( $options[ 'group_by' ] ) ) { $groupBy = ( ' GROUP BY ' . $options[ 'group_by' ] ); }
        if ( isset( $options[ 'order_by' ] ) && !empty( $options[ 'order_by' ] ) ) {
          $orderBy = ( ' ORDER BY ' . $options[ 'order_by' ] );
          $orderBy .= ( ( isset( $options[ 'order' ] ) && !empty( $options[ 'order' ] ) ) ? ( ' ' . strtoupper( $options[ 'order' ] ) ) : ' ASC' );
        }
        if ( isset( $options[ 'limit' ] ) && !empty( $options[ 'limit' ] ) ) { $limit = ( ' LIMIT ' . $options[ 'limit' ] ); }
        
        switch( $type ) {
          case 'insert':
            if ( !isset( $options[ 'values' ] ) || empty( $options[ 'values' ] ) ) { throw new Exception( 'The "values" parameter is required to build the "insert" query.' ); }
            $fields = '';
            if ( isset( $options[ 'fields' ] ) && !empty( $options[ 'fields' ] ) ) {
              $fields = ' ( ' . $options[ 'fields' ] . ' )';
            }
            
            $sqlstr = 'INSERT INTO ' . $table . $fields . ' VALUES ( ' . $options[ 'values' ] . ' )';
          break;
          case 'select':
            $sqlstr = 'SELECT ' . $select . ' FROM ' . $from . $joins . $where . $groupBy . $orderBy . $limit;
          break;
          case 'update':
            if ( !isset( $options[ 'set' ] ) || empty( $options[ 'set' ] ) ) { throw new Exception( 'The "set" parameter is required to build the "update" query.' ); }
            $sqlstr = 'UPDATE ' . $table . $joins . ' SET ' . $options[ 'set' ] . $where;
          break;
          case 'delete':
            $sqlstr = 'DELETE ' . $table . ' FROM ' . $from . $joins . $where;
          break;
          case 'desc':
          case 'describe':
          case 'explain':
            $sqlstr = 'DESC ' . $table;
          break;
        }
        
        return( $sqlstr );
      }
      
      /**
       * prepare
       **/
      public static function prepare( $sqlstr, $args = null ) {
        // http://core.trac.wordpress.org/browser/tags/3.5.1/wp-includes/wp-db.php
        return( $sqlstr );
      }
      
      /**
       * query
       **/
      public static function query( $sqlstr ) {
        return( self::getDbConnection()->query( $sqlstr ) );
      }
      
      /**
       * lastInsertedId
       **/
      public static function lastInsertedId() {
        return( self::getDbConnection()->insert_id );
      }
      
      /**
       * countRows
       **/
      public static function countRows( &$result ) {
        return( $result->num_rows );
      }
      
      /**
       * fetchAssoc
       **/
      public static function fetchAssoc( &$result ) {
        return( $result->fetch_assoc() );
      }
      
      /**
       * free
       **/
      public static function free( &$result ) {
        $result->free();
      }
      
      /**
       * findAll
       **/
      public static function findAll( $options = array() ) {
        $sqlstr = self::queryBuilder( 'select', $options );
        
        return( self::query( $sqlstr ) );
      }
      
      /**
       * findBy
       **/
      public static function findBy( $field, $value ) {
        $obj = array();
        $sqlstr = self::queryBuilder( 'select', array( 'where' => ( '`' . self::realEscapeString( $field ) . '` = "' . self::realEscapeString( $value ) . '"' ) ) );
        
        if ( $result = self::query( $sqlstr ) ) {
          $tmpObj = self::fetchAssoc( $result );
          if ( !empty( $tmpObj ) ) { $obj = $tmpObj; }
          self::free( $result );
        }
        
        return( $obj );
      }
      
      /**
       * findById
       **/
      public static function findById( $id ) {
        return( self::findBy( self::getPrimaryKey(), $id ) );
      }
      
      /**
       * initialize
       **/
      public static function initialize() {
        $obj = array();
        $sqlstr = self::queryBuilder( 'desc' );
        
        if ( $result = self::query( $sqlstr ) ) {
          while ( $row = self::fetchAssoc( $result ) ) {
            $obj[ $row[ 'Field' ] ] = $row[ 'Default' ];
          }
          self::free( $result );
        }
        
        return( $obj );
      }
      
      /**
       * isValid
       **/
      public static function isValid( &$obj ) {
        if ( !isset( $obj[ 'errors' ] ) || !is_array( $obj[ 'errors' ] ) ) { $obj[ 'errors' ] = array(); }
        if ( !isset( $obj[ 'errors' ][ 'messages' ] ) || !is_array( $obj[ 'errors' ][ 'messages' ] ) ) { $obj[ 'errors' ][ 'messages' ] = array(); }
        
        return( true );
      }
      
      /**
       * create
       **/
      public static function create( &$obj ) {
        if ( is_array( $obj ) ) {
          if ( !static::isValid( $obj ) ) { return( false ); } else { unset( $obj[ 'errors' ] ); }
          
          $fields = '';
          $values = '';
          
          foreach ( $obj as $field => $value ) {
            if ( $field == self::getEscapedPrimaryKey() ) { continue; }
            $fields .= '`' . self::realEscapeString( $field ) . '`, ';
            $values .=  '"' . self::realEscapeString( $value ) . '", ';
          }
          
          $sqlstr = self::queryBuilder( 'insert', array( 'fields' => substr( $fields, 0, -2 ), 'values' => substr( $values, 0, -2 ) ) );
          
          if ( self::query( $sqlstr ) ) {
            $obj[ self::getEscapedPrimaryKey() ] = self::lastInsertedId();
            return( true );
          }
        }
        
        return( false );
      }
      
      /**
       * assignNewValues
       **/
      public static function assignNewValues( &$obj, $newValues ) {
        if ( is_array( $obj ) && is_array( $newValues ) ) {
          if ( isset( $newValues[ self::getEscapedPrimaryKey() ] ) ) { unset( $newValues[ self::getEscapedPrimaryKey() ] ); }
          
          foreach( $newValues as $key => $value ) {
            $obj[ $key ] = $value;
          }
        }
      }
      
      /**
       * update
       **/
      public static function update( &$obj, $newValues, $where = '' ) {
        if ( is_array( $obj ) && is_array( $newValues ) ) {
          self::assignNewValues( $obj, $newValues );
          if ( !static::isValid( $obj ) ) { return( false ); } else { unset( $obj[ 'errors' ] ); }
          if ( empty( $where ) ) { $where = ( '`' . self::getEscapedPrimaryKey() . '` = ' . self::realEscapeString( $obj[ self::getEscapedPrimaryKey() ] ) ); }
          
          $fieldsAndValues = '';
          
          foreach ( $obj as $field => $value ) {
            if ( $field == self::getEscapedPrimaryKey() ) { continue; }
            $fieldsAndValues .= '`' . self::realEscapeString( $field ) . '` = "' . self::realEscapeString( $value ) . '", ';
          }
          
          $sqlstr = self::queryBuilder( 'update', array( 'set' => substr( $fieldsAndValues, 0, -2 ), 'where' => $where ) );
          
          if ( self::query( $sqlstr ) ) {
            return( true );
          }
        }
        
        return( false );
      }
      
      /**
       * destroy
       **/
      public static function destroy( &$obj, $where = '' ) {
        if ( is_array( $obj ) ) {
          if ( empty( $where ) ) { $where = ( '`' . self::getEscapedPrimaryKey() . '` = ' . self::realEscapeString( $obj[ self::getEscapedPrimaryKey() ] ) ); }
          $sqlstr = self::queryBuilder( 'delete', array( 'where' => $where ) );
          
          if ( self::query( $sqlstr ) ) {
            return( true );
          }
        }
        
        return( false );
      }
      
      /**
       * destroyById
       **/
      public static function destroyById( $id ) {
        return( self::destroy( self::findById( $id ) ) );
      }
    }
  }
