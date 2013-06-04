<h1>Blog</h1>
<?php
  if  ( isset( $blog ) && !empty( $blog ) ) {
    include( getPartialPathFor( 'blogs', 'blog' ) );
  } else {
    echo  'Error: The blog With ID "' . $id . '" does not exists.';
  }
?>
