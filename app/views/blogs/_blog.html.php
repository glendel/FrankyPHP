<table border="1">
  <tr>
    <td><b>Title</b></td>
    <td><?php echo $blog[ 'title' ]; ?></td>
  </tr>
  <tr>
    <td><b>Content</b></td>
    <td><?php echo $blog[ 'content' ]; ?></td>
  </tr>
  <tr>
    <td colspan="2">
      <a href="<?php echo getUrlFor( 'blogs', 'edit', ( 'id=' . $blog[ 'id' ] ) ); ?>">Edit</a> |
      <?php if ( $action == 'delete' ) { echo '<a href="' . getUrlFor( 'blogs', 'destroy', ( 'id=' . $blog[ 'id' ] ) ) . '">Yes, Destroy It!</a>'; } else { echo '<a href="' . getUrlFor( 'blogs', 'delete', ( 'id=' . $blog[ 'id' ] ) ) . '">Delete</a>'; } ?> |
      <a href="<?php echo getUrlFor( 'blogs' ); ?>">Back to List</a>
    </td>
  </tr>
</table>
