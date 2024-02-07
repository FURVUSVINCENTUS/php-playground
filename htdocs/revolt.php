<?php
//shell: composer require revolt/event-loop

require __DIR__. '/../vendor/autoload.php';

use Revolt\EventLoop;

// délais d'exécussion
function myDelay(float $seconds): void //$seconds correspond au délais que nous choisissons
{
  $s = EventLoop::getSuspension();

  EventLoop::delay( //correspnd à la fonction setTimeout() de js
    $seconds,
    $s->resume(...)
  );

  $s->suspend();
}

// Mêmes fonction que tout à l'heure mais utilisant notre fonction myDelay()

function beat(): void
{
  for($i=0; $i<4; $i++) {
    echo "Boom💥\n"; myDelay(0.5);  // attend 1/2 seconde
    echo "Boom💥\n"; myDelay(0.5);
    echo "Clap👏\n"; myDelay(1);    // attend 1 seconde
  }
}

function sing(): void
{
  echo "\tWe\n"; 	myDelay(1);
  echo "\tWill\n"; 	myDelay(1);
  echo "\tWe\n"; 	myDelay(1);
  echo "\tWill\n"; 	myDelay(1);
  echo "\tRock\n"; 	myDelay(0.5);
  echo "\tYou!\n";
}

Revolt\EventLoop::queue(beat(...)); //ajoute aux fonctions à exécuter par Revolt en async
Revolt\EventLoop::queue(sing(...));

echo "Start\n";
Revolt\EventLoop::run();// va lancer les deux fonctions sur deux fibres enparallèle
echo "Stop\n";

 ?>
