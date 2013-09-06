<?php
  require( getModelPathFor( 'comment' ) );
  
  switch( $action ) {
    case 'new':
      $comment = Comment::initialize();
      $formAction = getUrlFor( $controller, 'create' );
    break;
    case 'edit':
      $id = $params[ 'id' ];
      $comment = Comment::findById( $id );
      
      if  ( empty( $comment ) ) {
        setFlashMessage( 'error', 'The Comment With ID "' . $id . '" does not exist.' );
        redirectTo( $controller );
      }
      
      $formAction = getUrlFor( $controller, 'update', ( 'id=' . $id ) );
    break;
    case 'index':
    case 'list':
      if ( $comments = Comment::findAll() ) {
        $numComments = Comment::countRows( $comments );
        setViewToRenderTo( $controller, 'list' );
      } else {
        redirectTo( $controller );
      }
    break;
    case 'show':
      $id = $params[ 'id' ];
      $comment = Comment::findById( $id );
      
      if  ( empty( $comment ) ) {
        setFlashMessage( 'error', 'The Comment With ID "' . $id . '" does not exist.' );
        redirectTo( $controller );
      }
    break;
    case 'delete':
      $id = $params[ 'id' ];
      $comment = Comment::findById( $id );
      
      if  ( empty( $comment ) ) {
        setFlashMessage( 'error', 'The Comment With ID "' . $id . '" does not exist.' );
        redirectTo( $controller );
      }
    break;
    case 'create':
      $comment = $params[ 'comment' ];
      
      if ( Comment::create( $comment ) ) {
        setFlashMessage( 'notice', 'The Comment With ID "' . $comment[ 'id' ] . '" was successfully created.' );
        redirectTo( $controller, 'show', ( 'id=' . $comment[ 'id' ] ) );
      }
      
      setFlashMessage( 'error', getErrorMessageFor( $comment, 'The Comment could not be created.' ) );
      $formAction = getUrlFor( $controller, 'create' );
      setViewToRenderTo( $controller, 'new' );
    break;
    case 'update':
      $id = $params[ 'id' ];
      $oldComment = Comment::findById( $id );
      
      if  ( empty( $oldComment ) ) {
        setFlashMessage( 'error', 'The comment With ID "' . $id . '" does not exists.' );
        redirectTo( $controller );
      }
      
      $comment = $params[ 'comment' ];
      $comment[ 'id' ] = $id;
      
      if ( Comment::update( $comment ) ) {
        setFlashMessage( 'notice', 'The comment With ID "' . $id . '" was successfully updated.' );
        redirectTo( $controller, 'show', ( 'id=' . $id ) );
      }
      
      setFlashMessage( 'error', getErrorMessageFor( $comment, ( 'The comment With ID "' . $id . '" could not be updated.' ) ) );
      $formAction = getUrlFor( $controller, 'update', ( 'id=' . $id ) );
      setViewToRenderTo( $controller, 'edit' );
    break;
    case 'destroy':
      $id = $params[ 'id' ];
      $comment = Comment::findById( $id );
      
      if  ( empty( $comment ) ) {
        setFlashMessage( 'error', 'The comment With ID "' . $id . '" does not exists.' );
      } else {
        if ( Comment::destroy( $comment ) ) {
          setFlashMessage( 'notice', 'The comment With ID "' . $id . '" was successfully destroyed.' );
        } else {
          setFlashMessage( 'error', 'The comment With ID "' . $id . '" could not be destroyed.' );
        }
      }
      
      redirectTo( $controller );
    break;
    default:
      redirectTo( $controller );
  }
