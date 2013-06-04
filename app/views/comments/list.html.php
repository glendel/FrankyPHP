<h1>List of Comments</h1>
<?php
   if ( $numComments > 0 ) { //check if more than 0 record found
?>
<table border='1'>
<tr>
   <th>Content</th>
   <th colspan="3">Actions</th>
</tr>
 <?php include( '_comments.html.php' ); ?>
</table>
<?php
   Comment::free( $comments );
   }else{ //if no records found
   echo "No records found.";
   }
?>
<br/>
<a href="<?php echo getUrlFor( 'comments', 'new' ); ?>">New Comment</a>
