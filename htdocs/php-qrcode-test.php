<?php
use chillerlan\QRCode\{QRCode, QROptions};

require_once __DIR__.'/../vendor/autoload.php';

$data = 'https://www.go.fvaj.ch/login.php';

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>QRcode test & stuff</title>
    <style media="screen">
      body {
        background: grey;
      }
    </style>
  </head>
  <body>
    <h1>QRcode tests</h1>
    <h2>
      <details>
        <summary>Exemple basique</summary>
       <?php
       echo '<img src="'.(new QRCode)->render($data).'" alt="QR Code" />';
       ?>
      </details>
      <details>
        <summary>Niveaux de correction (eccLevel)</summary>
        <details open>
          <summary>L (Light) 7%</summary>
          <?php
            $qrcodeL = new QRCode;

            $optionL = new QROptions;
            $optionL->EccLevel = "L";

            $qrcodeL->setOptions($optionL);
            echo '<img src="'.($qrcodeL)->render($data).'" alt="QR Code" />';
          ?>
        </details>
        <details>
          <summary>M (Medium) 15%</summary>
          <pre><?php
            $qrcodeM = new QRCode;

            $optionM = new QROptions;
            $optionM->eccLevel = "M";
            $qrcodeM->setOptions($optionM);
            echo '<img src="'.($qrcodeM)->render($data).'" alt="QR Code" />';
          ?></pre>
        </details>
        <details>
        <summary>Q (Quite high??) 25%</summary>
        <pre><?php
          $qrcodeQ = new QRCode;

          $optionQ = new QROptions;
          $optionQ->eccLevel = "Q";
          $qrcodeQ->setOptions($optionQ);
          echo '<img src="'.($qrcodeQ)->render($data).'" alt="QR Code" />';
        ?></pre>
        </details>
        <details>
        <summary>H (High) 30%</summary>
        <pre><?php
          $qrcodeH = new QRCode;

          $optionH = new QROptions;
          $optionH->eccLevel = "H";
          $qrcodeH->setOptions($optionH);
          echo '<img src="'.($qrcodeH)->render($data).'" alt="QR Code" />';
        ?></pre>
        </details>

      </details>
      <details>
        <summary>quietzoneSize</summary>
        <details>
          <summary>1</summary>
          <pre><?php
            $qrcodeQZ1 = new QRCode;

            $optionQZ1 = new QROptions;
            $optionQZ1->quietzoneSize = 1;
            $qrcodeQZ1->setOptions($optionQZ1);
            echo '<img src="'.($qrcodeQZ1)->render($data).'" alt="QR Code" />';
          ?></pre>
        </details>
        <details>
          <summary>2</summary>
          <pre><?php
            $qrcodeQZ2 = new QRCode;

            $optionQZ2 = new QROptions;
            $optionQZ2->quietzoneSize = 2;
            $qrcodeQZ2->setOptions($optionQZ2);
            echo '<img src="'.($qrcodeQZ2)->render($data).'" alt="QR Code" />';
          ?></pre>
        </details>
        <details>
          <summary>3</summary>
          <pre><?php
            $qrcodeQZ3 = new QRCode;

            $optionQZ3 = new QROptions;
            $optionQZ3->quietzoneSize = 3;
            $qrcodeQZ3->setOptions($optionQZ3);
            echo '<img src="'.($qrcodeQZ3)->render($data).'" alt="QR Code" />';
          ?></pre>
        </details>
        <details>
          <summary>4</summary>
          <pre><?php
            $qrcodeQZ4 = new QRCode;

            $optionQZ4 = new QROptions;
            $optionQZ4->quietzoneSize = 4;
            $qrcodeQZ4->setOptions($optionQZ4);
            echo '<img src="'.($qrcodeQZ4)->render($data).'" alt="QR Code" />';
          ?></pre>
        </details>
        <details>
          <summary>5</summary>
          <pre><?php
            $qrcodeQZ5 = new QRCode;

            $optionQZ5 = new QROptions;
            $optionQZ5->quietzoneSize = 5;
            $qrcodeQZ5->setOptions($optionQZ5);
            echo '<img src="'.($qrcodeQZ5)->render($data).'" alt="QR Code" />';
          ?></pre>
        </details>
        <details>
          <summary>5</summary>
          <pre><?php
            $qrcodeQZ5 = new QRCode;

            $optionQZ5 = new QROptions;
            $optionQZ5->quietzoneSize = 5;
            $qrcodeQZ5->setOptions($optionQZ5);
            echo '<img src="'.($qrcodeQZ5)->render($data).'" alt="QR Code" />';
          ?></pre>
        </details>
      </details>
      <details>
        <summary>drawCircularModules</summary>
        <details open>
          <summary></summary>
          <pre><?php
            $qrcodeC = new QRCode;

            $optionC = new QROptions;
            $optionC->outputType = "GDIMAGE_WEBP";
            $optionC->addLogoSpace = true;

            $qrcodeC->setOptions($optionC);
            echo '<img src="'.($qrcodeC)->render($data).'" alt="QR Code" />';
          ?></pre>
        </details>
        <details>
          <summary></summary>

        </details>
      </details>
    </h2>
  </body>
</html>
