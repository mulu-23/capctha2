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

$line_color1 = imagecolorallocate($img, 0, 0, 0);      
$line_color2 = imagecolorallocate($img, 50, 50, 50);  
$pixel_color = imagecolorallocate($img, 80, 80, 80);

// Рисуем линии черными оттенками
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
$colors = [
    imagecolorallocate($img, 0, 0, 255),       // Синий
    imagecolorallocate($img, 0, 128, 0),       // Зеленый
    imagecolorallocate($img, 255, 165, 0),     // Оранжевый
    imagecolorallocate($img, 128, 0, 128),     // Фиолетовый
    imagecolorallocate($img, 255, 192, 203),    // Розовый
    imagecolorallocate($img, 0, 255, 255),      // Голубой
    imagecolorallocate($img, 255, 255, 0),      // Желтый
    imagecolorallocate($img, 165, 42, 42),      // Коричневый
];

for ($i = 0; $i < 5; $i++) {
    $size = rand(16, 22);
    $angle = rand(-10, 10);
    $x = 15 + $i * 35;
    $y = rand(25, 35);
    
    if ($i == $redIndex) {
        // Эта буква всегда красная
        $color = imagecolorallocate($img, 255, 0, 0);
    } else {
        // Остальные буквы — случайные яркие цвета из массива
        $color = $colors[array_rand($colors)];
    }
    
    imagettftext($img, $size, $angle, $x, $y, $color, $font, $code[$i]);
}

imagejpeg($img);
imagedestroy($img);
?>
