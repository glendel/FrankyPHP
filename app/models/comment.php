<?php
  if ( class_exists( 'DbAdapter' ) && !class_exists( 'Comment' ) ) {
    /**
     * Comment
     **/
    class Comment extends DbAdapter {
      protected static $tableName = 'comments';
      
      /**
       * findAllByBlog
       **/
      public static function findAllByBlog( $blog ) {
        $sqlstr = self::queryBuilder( 'select', array( 'where' => ( '`blog_id` = ' . self::realEscapeString( $blog[ 'id' ] ) ) ) );
        
        return( self::query( $sqlstr ) );
      }
    }
    
    Comment::validate();
  }
