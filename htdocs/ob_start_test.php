<?php
if(isset($_POST['new_phrase'])){
  ob_start();
  echo (readfile('cache/phrases.html')."\n<li>".filter_input(INPUT_POST ,'new_phrase', FILTER_DEFAULT)."</li>");
  $tampon = ob_get_contents();
  //stockage du tampon dans une chaîne de chars
  file_put_contents('cache/phrases.html', $tampon);
  ob_end_clean();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>ob_start() - tests</title>
  </head>
  <body>
    <h1>Cas d'utilisation</h1>
    <form action="ob_start_test.php" method="post">
      <input type="text" name="new_phrase" value=""/>
      <input type="submit" value="Add"/>
    </form>
    <ol type="I">
      <?php
        readfile('cache/phrases.html');
      ?>
    </ol>
  </body>
</html>
