<h1>List of Blogs</h1>
<?php
  if ( $numBlogs > 0 ) { //check if more than 0 record found
?>
<table border="1">
  <tr>
    <th>Title</th>
    <th>Content</th>
    <th colspan="3">Actions</th>
  </tr>
  <?php include( getPartialPathFor( 'blogs', 'blogs' ) ); ?>
</table>
<?php
  } else { //if no records found
    echo "No records found.";
  }
?>
<br />
<a href="<?php echo getUrlFor( 'blogs', 'new' ); ?>">New blog</a> |
<a href="<?php echo getUrlFor( '' ); ?>">Back to Menu</a>
