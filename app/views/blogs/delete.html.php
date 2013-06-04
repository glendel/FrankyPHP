<h1>Delete Blog</h1>
<b>Are you sure you want to destroy the next Blog ?</b><br /><br />
<?php
  if  ( isset( $blog ) && !empty( $blog ) ) {
    include( getPartialPathFor( 'blogs', 'blog' ) );
  } else {
    echo  'Error: The blog With ID "' . $id . '" does not exists.';
  }
?>
