<?php
  if ( class_exists( 'DbAdapter' ) && !class_exists( 'Blog' ) ) {
    /**
     * Blog
     **/
    class Blog extends DbAdapter {
      protected static $tableName = 'blogs';
      
      /**
       * comments
       **/
      public static function comments( $blog ) {
        require( getModelPathFor( 'comment' ) );
        return( Comment::findAllByBlog( $blog ) );
      }
      
      /**
       * destroy
       **/
      public static function destroy( &$blog ) {
        if ( $comments = self::comments( $blog ) ) {
          while ( $comment = Comment::fetchAssoc( $comments ) ) {
            Comment::destroy( $comment );
          }
          Comment::free( $comments );
        }
        
        parent::destroy( $blog );
      }
    }
  }
