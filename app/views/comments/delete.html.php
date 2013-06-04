<h1>Delete Comment</h1>
<b>Are you sure you want to destroy the next Comment ?</b><br /><br />
<?php
  if  ( isset( $comment ) && !empty( $comment ) ) {
    include( '_comment.html.php' );
  } else {
    echo  'Error: The comment With ID "' . $id . '" does not exists.';
  }
?>
