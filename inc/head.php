<?php
// if (isset($_POST['cancel']))
//     header("location:index.php");
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>NBA Predictor - <?= $title_page; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-DQvkBjpPgn7RC31MCQoOeC9TI2kdqa4+BSgNMNj8v77fdC77Kj5zpWFTJaaAoMbC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-YUe2LzesAfftltw+PEaao2tjU/QATaW/rOitAq67e0CT0Zi2VVRL0oC4+gAaeBKu" crossorigin="anonymous"></script>
    
    <style>
        :root {
            --primary-color: #17408B;
            --secondary-color: #C9082A;
            --accent-color: #FFFFFF;
            --text-color: #333333;
            --light-bg: #f8f9fa;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            color: var(--text-color);
            background-color: #f5f5f5;
            padding-top: 70px; /* Pour la navbar fixed-top */
        }
        
        .navbar {
            background-color: var(--primary-color) !important;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: white !important;
        }
        
        nav .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
        }
        
        .nav-link:hover {
            color: white !important;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #0d2f64;
            border-color: #0d2f64;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            body {
                padding-top: 56px;
            }
        }
    </style>
</head>

<body>
    <header>
        <?php
        if ($authorized == true)
            include dirname(__FILE__) . '/top.php';
        ?>
    </header>