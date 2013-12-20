<?php
  if ( class_exists( 'DbAdapter' ) && !class_exists( 'Blog' ) ) {
    /**
     * Blog
     **/
    class Blog extends DbAdapter {
      protected static $tableName = 'blogs';
      
      /**
       * isValid
       **/
      public static function isValid( &$blog ) {
        $isValid = parent::isValid( $blog );
        
        if ( isset( $blog[ 'title' ] ) && empty( $blog[ 'title' ] ) ) {
          $blog[ 'errors' ][ 'messages' ][ 'title' ] = array( 'The "Title" cannot be empty.' );
        }
        
        if ( isset( $blog[ 'content' ] ) && empty( $blog[ 'content' ] ) ) {
          $blog[ 'errors' ][ 'messages' ][ 'content' ] = array( 'The "Content" cannot be empty.' );
        }
        
        $isValid = ( $isValid && ( !isset( $blog[ 'errors' ] ) || !isset( $blog[ 'errors' ][ 'messages' ] ) || empty( $blog[ 'errors' ][ 'messages' ] ) ) );
        
        return( $isValid );
      }
      
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
