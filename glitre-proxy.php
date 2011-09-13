<?php

if (!empty($_SERVER['QUERY_STRING'])) {

  $page = file_get_contents('http://glitre.mobibl.no/glitre/api/?' . $_SERVER['QUERY_STRING']);
  if ($page) {
    echo($page);
  } else {
    echo('no page');
  }

} else {

  echo('no query string');

}

?>
