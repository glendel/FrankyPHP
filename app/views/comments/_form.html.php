<form action="<?php echo $formAction; ?>" method="post" style="border:0px;">
     <table>
       <tr>
         <td>Comment</td>
         <td><textarea name="comment[content]"><?php echo $comment[ 'content' ]; ?></textarea>
         </td>
       </tr>
       <tr>
         <td colspan="2"><input type="submit" value="Save" name="save" /> | <a href="<?php echo getUrlFor( 'comments' ); ?>">Cancel</a></td>
       </tr>
     </table>
</form>
