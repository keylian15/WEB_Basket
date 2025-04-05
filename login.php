<?php
session_start(); // Démarrage de la session
// print_r($_SESSION);
// exit();
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$db = require(dirname(__FILE__) . '/lib/mypdo.php');
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>NBA Predictor - Connexion</title>
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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        
        .login-card {
            max-width: 450px;
            width: 100%;
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1e5799 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .login-body {
            padding: 2rem;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(23, 64, 139, 0.25);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.6rem 1.5rem;
            font-weight: 500;
        }
        
        .btn-primary:hover {
            background-color: #0d2f64;
            border-color: #0d2f64;
        }
        
        .form-floating > label {
            color: #6c757d;
        }
        
        .login-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        
        .footer {
            background-color: var(--primary-color);
            color: white;
            padding: 2rem 0;
            margin-top: auto;
        }
        
        .social-icon {
            font-size: 1.5rem;
            margin: 0 0.5rem;
            transition: color 0.3s, transform 0.3s;
        }
        
        .social-icon:hover {
            color: rgba(255, 255, 255, 0.8);
            transform: scale(1.2);
        }
    </style>
</head>

<body>
    <!-- Login Container -->
    <div class="login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="login-card">
                        <div class="login-header">
                            <i class="fas fa-basketball-ball login-icon"></i>
                            <h1 class="h3">NBA Predictor</h1>
                            <p class="lead mb-0">Accédez à votre portail de prédictions NBA</p>
                        </div>
                        <div class="login-body">
                            <form action="check_login.php" method="post">
                                <div class="mb-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="uname" name="uname" placeholder="Identifiant" required>
                                        <label for="uname"><i class="fas fa-user me-2"></i>Identifiant</label>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="psw" name="psw" placeholder="Mot de passe" required>
                                        <label for="psw"><i class="fas fa-lock me-2"></i>Mot de passe</label>
                                    </div>
                                </div>
                                <div class="d-grid gap-2">
                                    <?php if (is_null($db)) { ?>
                                        <button type="submit" class="btn btn-primary btn-lg" name="connect" disabled>
                                            <i class="fas fa-exclamation-triangle me-2"></i>Connexion impossible
                                        </button>
                                        <div class="alert alert-danger mt-3">
                                            <i class="fas fa-database me-2"></i>Impossible de se connecter à la base de données
                                        </div>
                                    <?php } else { ?>
                                        <button type="submit" class="btn btn-primary btn-lg" name="connect">
                                            <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                                        </button>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <?php
        if (is_array($_SESSION['mesgs']) && is_array($_SESSION['mesgs']['confirm'])) {
            foreach ($_SESSION['mesgs']['confirm'] as $index => $mesg) {
        ?>
                <div class="toast show bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true" id="confirmToast<?= $index ?>">
                    <div class="toast-header bg-success text-white">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong class="me-auto">Confirmation</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        <?= $mesg; ?>
                    </div>
                </div>
        <?php
            }
            unset($_SESSION['mesgs']['confirm']);
        }

        if (is_array($_SESSION['mesgs']) && is_array($_SESSION['mesgs']['errors'])) {
            foreach ($_SESSION['mesgs']['errors'] as $index => $err) {
        ?>
                <div class="toast show bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true" id="errorToast<?= $index ?>">
                    <div class="toast-header bg-danger text-white">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong class="me-auto">Erreur</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        <?= $err; ?>
                    </div>
                </div>
        <?php
            }
            unset($_SESSION['mesgs']['errors']);
        }
        ?>
    </div>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <div class="mb-3">
                <a href="#" class="text-white me-3"><i class="fab fa-facebook-f social-icon"></i></a>
                <a href="#" class="text-white me-3"><i class="fab fa-twitter social-icon"></i></a>
                <a href="#" class="text-white me-3"><i class="fab fa-instagram social-icon"></i></a>
                <a href="#" class="text-white me-3"><i class="fab fa-youtube social-icon"></i></a>
                <a href="#" class="text-white"><i class="fab fa-linkedin-in social-icon"></i></a>
            </div>
            <p class="mb-0">© 2025 NBA Predictor. Tous droits réservés.</p>
        </div>
    </footer>

    <!-- Script pour les toasts (alertes) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialisation des toasts Bootstrap
            var toastElList = [].slice.call(document.querySelectorAll('.toast'));
            var toastList = toastElList.map(function(toastEl) {
                var toast = new bootstrap.Toast(toastEl, {
                    autohide: true,
                    delay: 5000
                });
                return toast;
            });
            
            // Auto-fermeture après 5 secondes
            setTimeout(function() {
                toastList.forEach(toast => toast.hide());
            }, 5000);
        });
    </script>
</body>

</html>