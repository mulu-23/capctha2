<?php
session_start();
header('Content-Type: image/jpeg');

$characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
$code = '';
for ($i = 0; $i < 5; $i++) {
    $code .= $characters[rand(0, strlen($characters) - 1)];
}
$_SESSION['captcha'] = $code;

$img = imagecreatefromjpeg('noise.jpg');
$width = imagesx($img);
$height = imagesy($img);

$font = 'c:/windows/fonts/arial.ttf';

$line_color1 = imagecolorallocate($img, 150, 150, 150);
$line_color2 = imagecolorallocate($img, 100, 100, 100);
$pixel_color = imagecolorallocate($img, 80, 80, 80);

$lines = rand(5, 8);
for ($i = 0; $i < $lines; $i++) {
    $color = ($i % 2 == 0) ? $line_color1 : $line_color2;
    $thickness = rand(1, 3);
    imagesetthickness($img, $thickness);
    imageline(
        $img,
        rand(0, $width), rand(0, $height),
        rand(0, $width), rand(0, $height),
        $color
    );
}

imagesetthickness($img, 1);

for ($i = 0; $i < 150; $i++) {
    imagesetpixel(
        $img,
        rand(0, $width),
        rand(0, $height),
        $pixel_color
    );
}

$redIndex = rand(0, 4);

for ($i = 0; $i < 5; $i++) {
    $size = rand(16, 22);
    $angle = rand(-10, 10);
    $x = 15 + $i * 35;
    $y = rand(25, 35);
    
    if ($i == $redIndex) {
        $color = imagecolorallocate($img, 255, 0, 0);
    } else {
        $color = imagecolorallocate($img, 0, 0, 0);
    }
    
    imagettftext($img, $size, $angle, $x, $y, $color, $font, $code[$i]);
}

imagejpeg($img);
imagedestroy($img);
?>
