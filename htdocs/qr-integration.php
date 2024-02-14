<?php

/**
 * GdImage with logo output example
 *
 * @created      18.11.2020
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2020 smiley
 * @license      MIT
 *
 * @noinspection PhpComposerExtensionStubsInspection, PhpIllegalPsrClassPathInspection
 */

use chillerlan\QRCode\{QRCode, QROptions};
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\{QRGdImageWEBP, QRCodeOutputException};

require_once __DIR__.'/../vendor/autoload.php';

class QRImageWithLogo extends QRGdImageWEBP{

  /**
   * @param string|null $file
   * @param string|null $logo
   *
   * @return string
   * @throws \chillerlan\QRCode\Output\QRCodeOutputException
   */
   public function dump(string $file = null, string $logo = null):string{
     // set returnResource to true to skip further processing for now
     $this->options->returnResource = true;

     // of course, you could accept other formats too (such as resource or Imagick)
     // I'm not checking for the file type either for simplicity reasons (assuming PNG)
     if(!is_file($logo) || !is_readable($logo)){
       throw new QRCodeOutputException('invalid logo');
     }

     // there's no need to save the result of dump() into $this->image here
     parent::dump($file);

     $im = imagecreatefromwebp($logo);

     // get logo image size
     $w = imagesx($im);
     $h = imagesy($im);

     // set new logo size, leave a border of 1 module (no proportional resize/centering)
     $lw = (($this->options->logoSpaceWidth - 2) * $this->options->scale);
     $lh = (($this->options->logoSpaceHeight - 2) * $this->options->scale);

     // get the qrcode size
     $ql = ($this->matrix->getSize() * $this->options->scale);

     // scale the logo and copy it over. done!
     imagecopyresampled($this->image, $im, (($ql - $lw) / 2), (($ql - $lh) / 2), 0, 0, $lw, $lh, $w, $h);

     $imageData = $this->dumpImage();

     $this->saveToFile($imageData, $file);

     if($this->options->outputBase64){
       $imageData = $this->toBase64DataURI($imageData);
     }

     return $imageData;
   }


}

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

$qrcode = new QRCode($options);
$qrcode->addByteSegment('https://go.fvaj.ch');

$qrOutputInterface = new QRImageWithLogo(
  $options,
  $qrcode->getQRMatrix()
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
