<h1>Comment</h1>
<?php
if ( isset( $comment ) && !empty( $comment ) ) {
 include '_comment.html.php';
} else {
    echo  'Error: The comment With ID "' . $id . '" does not exists.';
  }
?>
