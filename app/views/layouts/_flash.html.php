<?php
  $notice = trim( getFlashMessage( 'notice' ) );
  $warning = trim( getFlashMessage( 'warning' ) );
  $error = trim( getFlashMessage( 'error' ) );
  
  if ( !empty( $notice ) || !empty( $warning ) || !empty( $error ) ) {
?>
<div class="flash">
<?php
  if ( !empty( $notice ) ) {
?>
<div class="ui-state-default ui-corner-all">
  <p>
    <span class="ui-icon ui-icon-info"></span>
    <strong>Notice :</strong> "<?= $notice; ?>"
  </p>
</div>
<?php
  }
  
  if ( !empty( $warning ) ) {
?>
<div class="ui-state-highlight ui-corner-all">
  <p>
    <span class="ui-icon ui-icon-info"></span>
    <strong>Warning :</strong> "<?= $warning; ?>"
  </p>
</div>
<?php
  }
  
  if ( !empty( $error ) ) {
?>
<div class="ui-state-error ui-corner-all">
  <p>
    <span class="ui-icon ui-icon-alert"></span>
    <strong>Alert :</strong>
    <?= $error; ?>
  </p>
</div>
<?php
    }
?>
</div>
<?php
  }
?>
