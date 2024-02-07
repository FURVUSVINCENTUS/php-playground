<?php
//shell: composer require amphp/amp
//shell: composer require revolt/event-loop
require __DIR__. '/../vendor/autoload.php';

use function Amp\async;
use function Amp\delay;
use Revolt\EventLoop;

function beat(): void
{
  for($i=0; $i<4; $i++) {
    echo "Boom💥\n"; Amp\delay(0.5);  // attend 1/2 seconde
    echo "Boom💥\n"; Amp\delay(0.5);
    echo "Clap👏\n"; Amp\delay(1);    // attend 1 seconde
  }
}

function sing(): void
{
  echo "\tWe\n"; 	Amp\delay(1);
  echo "\tWill\n"; 	Amp\delay(1);
  echo "\tWe\n"; 	Amp\delay(1);
  echo "\tWill\n"; 	Amp\delay(1);
  echo "\tRock\n"; 	Amp\delay(0.5);
  echo "\tYou!\n";
}
# Appel des fonctions

Amp\async(beat(...));// enregistre les fonctions en asyncrone
Amp\async(sing(...));

echo "Start\n";
Revolt\EventLoop::run();// va lancer les deux fonctions sur deux fibres enparallèle
echo "Stop\n";
 ?>
