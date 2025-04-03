<div class="auth-container">
    <div class="auth-header">
        <div class="auth-logo">
            <i class="fas fa-basketball"></i>
        </div>
        <h2>Connexion</h2>
        <p class="text-muted">Accédez à votre compte NBA Predictor</p>
    </div>

    <!-- Social Login Buttons -->
    <div class="social-login mb-4">
        <a href="#" class="btn-social btn-google mb-2">
            <i class="fab fa-google me-2"></i> Connexion avec Google
        </a>
        <a href="#" class="btn-social btn-facebook">
            <i class="fab fa-facebook-f me-2"></i> Connexion avec Facebook
        </a>
    </div>

    <!-- Divider -->
    <div class="divider">
        <span>OU</span>
    </div>

    <!-- Login Form -->
    <form action="index.php?page=login-process" method="POST">
        <!-- Email Field -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <!-- Password Field -->
        <div class="mb-3 position-relative">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <span class="password-toggle" id="password-toggle">
                <i class="far fa-eye"></i>
            </span>
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe">
                <label class="form-check-label" for="rememberMe">
                    Se souvenir de moi
                </label>
            </div>
            <a href="#" class="text-decoration-none">Mot de passe oublié?</a>
        </div>

        <!-- Submit Button -->
        <div class="d-grid gap-2 mt-4">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-sign-in-alt me-2"></i> Connexion
            </button>
        </div>
    </form>

    <!-- Register Link -->
    <div class="text-center mt-4">
        <p>Vous n'avez pas de compte? <a href="index.php?page=register" class="text-decoration-none">S'inscrire</a></p>
    </div>
</div>

<script>
    // Toggle password visibility
    document.getElementById('password-toggle').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>