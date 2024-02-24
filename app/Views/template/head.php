<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- TITULO DE LA PAGINA -->
    <title>LearnDo - <?php echo strtoupper(service('uri')->getSegment(1)); ?> </title>
    <!-- LOGO -->
    <link rel="icon" type="image/png" href="<?php echo base_url('public/assets/images/Logo.png'); ?>">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- Retoques CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/style.css'); ?>">

    <!-- FUENTES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:wght@500&display=swap"
        rel="stylesheet">

    <!-- ICONOS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

   <!-- Jquery -->
   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>    

   <!-- Link del JSON -->
   <link rel="manifest" href="manifest.json">

</head>