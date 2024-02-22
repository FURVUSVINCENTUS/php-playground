<?php
if(isset($_POST['new_phrase'])){
  ob_start();
  echo (readfile('cache/phrases.html')."\n<li><a href='".$_POST['link']."'>".filter_input(INPUT_POST ,'new_phrase', FILTER_DEFAULT)."</a></li>");
  //$tampon = ob_get_contents();
  //stockage du tampon dans une chaîne de chars
  //file_put_contents('cache/phrases.html', $tampon);
  file_put_contents('cache/phrases.html', ob_get_contents());
  ob_end_clean();
}
$code_id = 702;
$tries = 10;

$key = strval($tries);
apcu_store(strval($code_id), $key);
var_dump(apcu_fetch($code_id));
print_r(apcu_cache_info());
exit;
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>ob_start() - tests</title>
  </head>
  <body>
    <h1>Cas d'utilisation</h1>
    <p> <em>Ajoute un nouveau lien.</em> </p>
    <form action="ob_start_test.php" method="post">
      <input type="text" name="new_phrase" placeholder="text" value=""/>
      <input type="text" name="link" placeholder="https://exemple.com" value=""/>
      <input type="submit" value="Add"/>
    </form>
    <ol type="I">
      <?php
        readfile('cache/phrases.html');
      ?>
    </ol>
  </body>
</html>
