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
        $objMysqli = new mysqli( DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWD, DATABASE_DBNAME );
        
        // Check connection
        if ( $objMysqli->connect_errno ) {
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
       * queryBuilder
       **/
      public static function queryBuilder( $type, $options = array() ) {
        $table = ( ( isset( $options[ 'table' ] ) && !empty( $options[ 'table' ] ) ) ? self::realEscapeString( $options[ 'table' ] ) : ( '`' . self::getEscapedTableName() . '`' ) );
        $select = '*';
        $from = $table;
        $joins = '';
        $where = '';
        $order = '';
        $limit = '';
        $sqlstr = '';
        
        if ( isset( $options[ 'select' ] ) && !empty( $options[ 'select' ] ) ) { $select = $options[ 'select' ]; }
        if ( isset( $options[ 'from' ] ) && !empty( $options[ 'from' ] ) ) { $from = $options[ 'from' ]; }
        if ( isset( $options[ 'joins' ] ) && !empty( $options[ 'joins' ] ) ) { $joins = $options[ 'joins' ]; }
        if ( isset( $options[ 'where' ] ) && !empty( $options[ 'where' ] ) ) { $where = ( ' WHERE ' . $options[ 'where' ] ); }
        if ( isset( $options[ 'order' ] ) && !empty( $options[ 'order' ] ) ) { $order = ( ' ORDER BY ' . $options[ 'order' ] ); }
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
            $sqlstr = 'SELECT ' . $select . ' FROM ' . $from . $joins . $where . $order . $limit;
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
      public static function findAll() {
        $sqlstr = self::queryBuilder( 'select' );
        
        return( self::query( $sqlstr ) );
      }
      
      /**
       * findById
       **/
      public static function findById( $id ) {
        $obj = array();
        $sqlstr = self::queryBuilder( 'select', array( 'where' => ( '`id` = ' . self::realEscapeString( $id ) ) ) );
        
        if ( $result = self::query( $sqlstr ) ) {
          $tmpObj = self::fetchAssoc( $result );
          if ( !empty( $tmpObj ) ) { $obj = $tmpObj; }
          self::free( $result );
        }
        
        return( $obj );
      }
      
      /**
       * initialize
       **/
      public static function initialize() {
        $obj = array();
        $sqlstr = self::queryBuilder( 'desc' );
        
        if ( $result = self::query( $sqlstr ) ) {
          while ( $row = self::fetchAssoc( $result ) ) {
            $obj[ $row[ 'Field' ] ] = '';
          }
          self::free( $result );
        }
        
        return( $obj );
      }
      
      /**
       * create
       **/
      public static function create( &$obj ) {
        if ( is_array( $obj ) ) {
          $fields = '';
          $Values = '';
          
          foreach ( $obj as $field => $value ) {
            if ( $field == 'id' ) { continue; }
            $fields .= '`' . self::realEscapeString( $field ) . '`, ';
            $values .=  '"' . self::realEscapeString( $value ) . '", ';
          }
          
          $sqlstr = self::queryBuilder( 'insert', array( 'fields' => substr( $fields, 0, -2 ), 'values' => substr( $values, 0, -2 ) ) );
          
          if ( self::query( $sqlstr ) ) {
            $obj[ 'id' ] = self::lastInsertedId();
            return( true );
          }
        }
        
        return( false );
      }
      
      /**
       * update
       **/
      public static function update( &$obj ) {
        if ( is_array( $obj ) ) {
          $fieldsAndValues = '';
          
          foreach ( $obj as $field => $value ) {
            if ( $field == 'id' ) { continue; }
            $fieldsAndValues .= '`' . self::realEscapeString( $field ) . '` = "' . self::realEscapeString( $value ) . '", ';
          }
          
          $sqlstr = self::queryBuilder( 'update', array( 'set' => substr( $fieldsAndValues, 0, -2 ), 'where' => ( '`id` = ' . self::realEscapeString( $obj[ 'id' ] ) ) ) );
          
          if ( self::query( $sqlstr ) ) {
            return( true );
          }
        }
        
        return( false );
      }
      
      /**
       * destroy
       **/
      public static function destroy( &$obj ) {
        if ( is_array( $obj ) ) {
          $sqlstr = self::queryBuilder( 'delete', array( 'where' => ( '`id` = ' . self::realEscapeString( $obj[ 'id' ] ) ) ) );
          
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
