<?php
session_start();
// démarrage de la session et attribution de la variable session_gc_maxlifetime
$_SESSION['session_gc_maxlifetime'] = 300;
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="master.css">
    <title>$_SESSION_SimpleLogout</title>
  </head>
  <body>
    <main id="moves">
      <h1>Bonjour</h1>
      <a href="exit.php" alt="Leave" id="leave">🚪</a>
      <p>Pour garder la session ouverte, rester actif (scroll, click, onmousemove, keystroke)</p>
      <form class="" action="simpleLogout.php" method="post">
        <input type="text" name="focus" value="click to focus here" autofocus>
      </form>
    </main>
    <script>
      var w = new Worker('./webworker.js');
      w.onmessage = function(event) {
        if(event.data === 'logout') {
          w.terminate();
          console.log("Logged OUT");
          document.location = "exit.php";
        }
      }
      window.onblur = function(){ w.postMessage('enableTimeout'); }
      window.onfocus = function(){ w.postMessage('disableTimeout'); }
      window.onclick = function(){ w.postMessage('disableTimeout'); }
    </script>
  </body>
</html>
