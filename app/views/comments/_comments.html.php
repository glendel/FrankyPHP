<?php
 while ( $comment = Comment::fetchAssoc( $comments ) ) {
?>
   <tr>
   <td><?php echo $comment[ 'content' ]; ?></td>
    <td><a href="<?php echo getUrlFor( 'comments', 'show', ( 'id=' . $comment[ 'id' ] ) ); ?>">Show</a></td></td>
    <td><a href="<?php echo getUrlFor( 'comments', 'edit', ( 'id=' . $comment[ 'id' ] ) ); ?>">Edit</a></td></td>
    <td><a href="<?php echo getUrlFor( 'comments', 'delete', ( 'id=' . $comment[ 'id' ] ) ); ?>">Delete</a></td></td>
   </tr>

<?php
}
?>
