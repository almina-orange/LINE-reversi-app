<?php
// read all library from composer
require_once __DIR__.'/vendor/autoload.php';

// define mixed image base size
define('GD_BASE_SIZE', 700);

// make mixed image base
$destinationImage = imagecreatefrompng('imgs/reversi_board.png');

// // get stone positions
$stones = json_decode($_REQUEST['stones']);

for ($i=0; $i < count($sotnes); $i++) {
  $row = $stones[$i];
  for ($j=0; $j < count($row); $j++) {
    // make stones
    if ($row[$j] == 1) {
      $stoneImage = imagecreatefrompng('imgs/reversi_stone_white.png');
    } elseif ($row[$j] == 2) {
      $stoneImage = imagecreatefrompng('imgs/reversi_stone_black.png');
    }

    // mix
    if ($row[$j] > 0) {
      $imageX = 9 + (int)($j * 87.5);
      $imageY = 9 + (int)($j * 87.5);
      imagecopy($destinationImage, $stoneImage, $imageX, $imageY, 0, 0, 70,70);
      imagedestroy($stoneImage);
    }
  }
}

// get requested size
$size = $_REQUEST['size'];

if ($size == GD_BASE_SIZE) {
  $out = $destinationImage;
} else {
  // make empty image by requested size
  $out = imagecreatetruecolor($size, $size);

  // resize and mix
  imagecopyresampled($out, $destinationImage, 0, 0, 0, 0, $size, $size, GD_BASE_SIZE, GD_BASE_SIZE);
}

// buufer enable
ob_start();
imagepng($out, null, 9);

// get from buffer
$content = ob_get_contents();
ob_end_clean();

// set type of output
header('Content-type: image/png');
echo $content;
?>
