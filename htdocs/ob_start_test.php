<?php
// ob_start/clean/en_clean/flush/end_flush ...https://www.php.net/manual/fr/ref.outcontrol.php
// Fonctions de bufferisation de sortie
if(isset($_POST['new_phrase'])){
  ob_start();
  echo (readfile('cache/phrases.html')."\n<li><a href='".$_POST['link']."'>".filter_input(INPUT_POST ,'new_phrase', FILTER_DEFAULT)."</a></li>");
  //$tampon = ob_get_contents();
  //stockage du tampon dans une chaîne de chars
  //file_put_contents('cache/phrases.html', $tampon);
  file_put_contents('cache/phrases.html', ob_get_contents());
  ob_end_clean();
}

// apcu_add/fetch/strore/cache_info... https://www.php.net/manual/fr/ref.apcu.php
// Fonctions APCu
$code_id = 702;
$tries = 10;
$cached = null;

$key = strval($tries);
apcu_store(strval($code_id), $key); // enregistrement des essais dans un tableau identifier par la valeur de $code_id
$cached = apcu_fetch($code_id);
// test d'équivalence entre les valeurs récupérées et les valeurs locales
if($tries == $cached){
  echo "Fetched tries successfully! 701 made ".$cached." tries.";
} else {
  echo "Try again!";
}
//print_r(apcu_cache_info());
//exit;
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
