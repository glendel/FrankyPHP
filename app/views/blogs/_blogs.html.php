<?php
  while ( $blog = Blog::fetchAssoc( $blogs ) ) {
?>
  <tr>
    <td><?php echo $blog[ 'title' ]; ?></td>
    <td><?php echo $blog[ 'content' ]; ?></td>
    <td><a href="<?php echo getUrlFor( 'blogs', 'show', ( 'id=' . $blog[ 'id' ] ) ); ?>">Show</a></td>
    <td><a href="<?php echo getUrlFor( 'blogs', 'edit', ( 'id=' . $blog[ 'id' ] ) ); ?>">Edit</a></td>
    <td><a href="<?php echo getUrlFor( 'blogs', 'delete', ( 'id=' . $blog[ 'id' ] ) ); ?>" >Delete</a></td>
  </tr>
<?php
  }
  
  Blog::free( $blogs );
?>
