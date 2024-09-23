<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tienda Virtual eCommerce</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="../build/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="../build/img/favicon.ico">

    <link rel="stylesheet" href="../build/css/bootstrap.min.css">
    <link rel="stylesheet" href="../build/css/templatemo.css">
    <link rel="stylesheet" href="../build/css/custom.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="../build/css/fontawesome.min.css">
</head>

<body>
    <?php 
        include_once __DIR__ .'/templates/header.php';
        echo $contenido;
        include_once __DIR__ .'/templates/footer.php'; 
    ?>
    <!-- Inicio Script -->
    <script src="../build/js/jquery-1.11.0.min.js"></script>
    <script src="../build/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="../build/js/bootstrap.bundle.min.js"></script>
    <script src="../build/js/templatemo.js"></script>
    <script src="../build/js/custom.js"></script>
    <!-- Fin Script -->
</body>

</html>