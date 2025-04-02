<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? e($title) : APP_NAME; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo asset('css/style.css'); ?>">
    
    <!-- Styles spécifiques à la page -->
    <?php if (isset($pageStyles)): ?>
        <?php foreach ($pageStyles as $style): ?>
            <link rel="stylesheet" href="<?php echo asset('css/' . $style . '.css'); ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    
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
        }
        
        .navbar {
            background-color: var(--primary-color) !important;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: white !important;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
        }
        
        .nav-link:hover {
            color: white !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #0d2f64;
            border-color: #0d2f64;
        }
        
        .footer {
            background-color: var(--primary-color);
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }
    </style>
</head>
<body>
    <!-- Début du contenu -->