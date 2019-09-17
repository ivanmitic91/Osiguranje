<?php ob_start();
require_once 'init.php';
?>
<!DOCTYPE html>
<html lang="sr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link href="dist/css/datepicker.min.css" rel="stylesheet" type="text/css">
    <script src="dist/js/datepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="dist/js/i18n/datepicker.en.js"></script>
    <title>Putno Osiguranje - prijava</title>
</head>
<nav>
    <ul>
        <li><a href="<?php echo URLROOT; ?>/public/index">Zahtev za osiguranje</a> </li>
    </ul>
    <ul>
        <li><a href="<?php echo URLROOT; ?>/public/polise">Spisak polisa</a></li>
    </ul>
</nav>

<body onload="jsValidacija()">
    <div class="container">