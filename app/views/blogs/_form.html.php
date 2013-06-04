<form action="<?php echo $formAction; ?>" method="post" style="border:0px;">
  <table>
    <tr>
      <td><b>Title</b></td>
      <td><input type="text" name="blog[title]" value="<?php echo $blog[ 'title' ]; ?>" /></td>
    </tr>
    <tr>
      <td><b>Content</b></td>
      <td><textarea name="blog[content]"><?php echo $blog[ 'content' ]; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" value="Save" name="save" /> | <a href="<?php echo getUrlFor( 'blogs' ); ?>">Cancel</a></td>
    </tr>
  </table>
</form>
