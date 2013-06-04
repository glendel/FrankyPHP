<?php
if  ( isset( $comment ) && !empty( $comment ) ) {
    include( '_form.html.php' );
  } else {
    echo  'Error: The comment With ID "' . $id . '" does not exists.';
  }



