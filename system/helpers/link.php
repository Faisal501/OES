<?php
  function linkCSS($cssPath){
    $url = BASEURL. "/". $cssPath;
    echo '<link rel="stylesheet" href="'. $url .'" type="text/css">';
  }

  function linkJS($jsPath){
    $url = BASEURL. "/". $jsPath;
    echo '<script src="'. $url .'"></script>';
  }

 ?>
