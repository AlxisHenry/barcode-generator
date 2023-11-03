<?php

require __DIR__ . '/vendor/autoload.php';

use BarcodeBakery\Common\BCGFontFile;
use BarcodeBakery\Common\BCGColor;
use BarcodeBakery\Common\BCGDrawing;
use BarcodeBakery\Barcode\BCGcode128;

$code = $_GET['code'] ?? null;
if (defined('STDIN')) $code = $argv[1];
if ($code === null) die();

// Check if barcode already exists
if (file_exists(__DIR__ . '/barcodes//' . $code . '.png')) die();

$font = new BCGFontFile(__DIR__ . '/font.ttf', 18);
$colorBlack = new BCGColor(0, 0, 0);
$colorWhite = new BCGColor(255, 255, 255);

$barcode = new BCGcode128();
$barcode->setScale(2);
$barcode->setThickness(30);
$barcode->setForegroundColor($colorBlack);
$barcode->setBackgroundColor($colorWhite);
$barcode->setFont($font);
$barcode->setStart(null);
$barcode->setTilde(true);
$barcode->parse($code);
$drawing = new BCGDrawing($barcode, $colorWhite);
$drawing->finish(BCGDrawing::IMG_FORMAT_PNG, __DIR__ . '/barcodes//' . $code . '.png');
$drawing->destroy();