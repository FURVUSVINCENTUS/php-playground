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
    <title>$_SESSION_test</title>
  </head>
  <body>
    <h1>Bonjour</h1>
    <p><span>Sur cette page, nous découvrous comment fermer une session à l'aide d'un modal javascript qui apparaît après un délais de </span><input type="number" id="secs" value="15" autofocus="autofocus"/></p>
    <!-- modal -->
    <section class="modal" id="myModal">
      <div class="modal-content">
      <div>
        <h3><span>Session liftime: </span><span id="rebours"></span></h3>
        <hr/>
        <button type="button" name="leave" id="leave">Fermer la session</button>
        <button type="button" name="stay" id="stay">Rester connecté</button>
      </div>
    </section>
    <!--FIN modal-->
    <script>
    window.onload = function () {

      let modal = document.getElementById("myModal");
      let reb = document.getElementById("rebours");
      let leave = document.getElementById("leave");
      let stay = document.getElementById("stay");
      //let seconds = 15;
      let secs = document.getElementById("secs");
      let seconds = secs.value; //Pour obtenir la valeur du champ
      let timeout = seconds * 1000;
      let Interval ;
      let Timeout ;
      let SleepModal ;
      let SleepTimer ;
      // focus
      let previousElement = null;

      document.addEventListener("onmousemove", sleep(event));

      function startTimer () {
        reb.innerHTML = seconds--;// décrémente l'élément timer du modal toutes les secondes
      }
      function rebours() {
        clearInterval(Interval);
        Interval = setInterval(startTimer, 1000);
      }
      function show () {
        modal.style.display = "block";
        rebours();
        //console.group("timeout show");
        //console.log(timeout);
        //console.groupEnd();
        Timeout = setTimeout(autologout, timeout);
      }
      function stayLogged () {
        modal.style.display = "block";
        reset();
      }
      SleepModal = setTimeout(show, 6000);
      SleepTimer = setTimeout(startTimer, 6000);

      function sleep (event) {
        clearTimeout(SleepModal);
        clearTimeout(SleepTimer);
        SleepModal = setTimeout(show, 6000);
        SleepTimer = setTimeout(startTimer, 6000);
        reset()
        console.log("Sleeping!");
      }

      function reset () {
        clearInterval(Interval);
        clearTimeout(Timeout);
        setTimeout(show, 6000);
        setTimeout(startTimer, 6000);
        //seconds = 15;
        seconds = secs.value;
        timeout = seconds * 1000;
        //console.group("reset timeout");
        //console.log(timeout);
        //console.groupEnd();
      }
      function autologout () {
        modal.style.display = "none";
        reset();
        document.location = "exit.php";
      }

      leave.onclick = function() {
        modal.style.display = "none";
        reset();
        document.location = "exit.php";
      }
      stay.onclick = function() {
        modal.style.display = "none";
        //secs.focus();
        reset();
      }
    }
    </script>
  </body>
</html>
