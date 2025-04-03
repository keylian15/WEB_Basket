<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $config['app_name'] ?? 'Hello World MVC' ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        header {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 1rem;
        }
        
        main {
            flex: 1;
            text-align: center;
            padding: 2rem;
        }
        
        .message {
            font-size: 3rem;
            margin: 2rem 0;
            color: #3498db;
        }
    </style>
</head>
<body>
    <header>
        <h1><?= $config['app_name'] ?? 'Hello World MVC' ?></h1>
    </header>
    
    <main>