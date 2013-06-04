<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="content-language" content="GB" />
    <!--[if IE]>
      <meta http-equiv="X-UA-Compatible" content="IE=Edge,Chrome=1" />
      <script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <title>FrankyPHP - A Home Made Framework For Training Purposes</title>
    <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <?php echo getStyleSheetTagFor( 'application' ); ?>
  </head>
  <body>
    <?php
      include_once( getPartialPathFor( 'layouts', 'flash' ) );
      include_once( getViewPathToRender() );
    ?>
    <script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>
    <?php echo getJavaScriptTagFor( 'application' ); ?>
  </body>
</html>
