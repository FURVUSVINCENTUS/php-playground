<?php

declare(strict_types=1);

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Output\{QRGdImageWEBP, QRImageWithLogo};

require_once __DIR__.'/../vendor/autoload.php';

$options = new QROptions(
  [
    'eccLevel' => "H",
    'outputBase64' => "false",
    'scale' => 12,
    'imageTransparent' => "true",
    'outputType' => "GDIMAGE_WEBP",
    'version' => 5,
    'addLogoSpace' => "true",
    'logoSpaceWidth' => 13,
    'logoSpaceHeight' => 13,
  ]
);

$qrOutputInterface = new QRImageWithLogo(
  $options,
  (new QRCode($options))->render('https://go.fvaj.ch')
);

$qrcode = $qrOutputInterface->dump(
  null,
  __DIR__.'/octocat.webp'
);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Create QR Codes in PHP</title>
  <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
<h1>Creating QR Codes in PHP</h1>
<div class="container">
  <img src='<?= $qrcode ?>' alt='QR Code' width='300' height='300'>
</div>
</body>
</html>
