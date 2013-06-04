     <table border="1">
       <tr>
         <td><b>Comment</b></td>
         <td><?php echo $comment[ 'content' ]; ?></td>
       </tr>
       <td colspan="2">
      <a href="<?php echo getUrlFor( 'comments', 'edit', ( 'id=' . $comment[ 'id' ] ) ); ?>">Edit</a> |
      <?php if ( $action == 'delete' ) { echo '<a href="' . getUrlFor( 'comments', 'destroy', ( 'id=' . $comment[ 'id' ] ) ) . '">Yes, Destroy It!</a>'; } else { echo '<a href="' . getUrlFor( 'comments', 'delete', ( 'id=' . $comment[ 'id' ] ) ) . '">Delete</a>'; } ?> |
      <a href="<?php echo getUrlFor( 'comments' ); ?>">Back to List</a>
    </td>
       </tr>
     </table>
