<?php
ob_start();
if(isset($_POST['new_phrase'])){

}
  $tampon = htmlspecialchars(ob_get_contents(), FILTER_DEFAULT); //stockage du tampon dans une chaîne de chars
  ob_end_clean();
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
    <p><?php echo $tampon; ?></p>
  </body>
</html>
