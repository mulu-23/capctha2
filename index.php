<?php
session_start();
$result = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userInput = strtoupper(trim($_POST['captcha'] ?? ''));
    $result = ($userInput === ($_SESSION['captcha'] ?? '')) ? 'Правильно' : 'Не правильно';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
</head>
<body>
    <h1>Регистрация</h1>
    <img src="captcha.php?<?php echo time(); ?>" alt="CAPTCHA"><br><br>
    <form method="post">
        <label>Введите строку:</label><br>
        <input type="text" name="captcha" required>
        <button type="submit">OK</button>
    </form>
    <?php if ($result): ?>
        <h3><?php echo $result; ?></h3>
    <?php endif; ?>
</body>
</html>