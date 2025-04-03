<div class="auth-container">
    <div class="auth-header">
        <div class="auth-logo">
            <i class="fas fa-basketball"></i>
        </div>
        <h2>Créer un compte</h2>
        <p class="text-muted">Rejoignez NBA Predictor pour accéder à toutes les fonctionnalités</p>
    </div>

    <!-- Social Register Buttons -->
    <div class="social-login mb-4">
        <a href="#" class="btn-social btn-google mb-2">
            <i class="fab fa-google me-2"></i> S'inscrire avec Google
        </a>
        <a href="#" class="btn-social btn-facebook">
            <i class="fab fa-facebook-f me-2"></i> S'inscrire avec Facebook
        </a>
    </div>

    <!-- Divider -->
    <div class="divider">
        <span>OU</span>
    </div>

    <!-- Register Form -->
    <form action="index.php?page=register-process" method="POST">
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
            <div class="password-requirements">
                <p class="mb-1">Le mot de passe doit contenir :</p>
                <ul>
                    <li id="length-check"><i class="fas fa-times-circle me-1"></i> Au moins 8 caractères</li>
                    <li id="uppercase-check"><i class="fas fa-times-circle me-1"></i> Au moins une lettre majuscule</li>
                    <li id="lowercase-check"><i class="fas fa-times-circle me-1"></i> Au moins une lettre minuscule</li>
                    <li id="number-check"><i class="fas fa-times-circle me-1"></i> Au moins un chiffre</li>
                    <li id="special-check"><i class="fas fa-times-circle me-1"></i> Au moins un caractère spécial</li>
                </ul>
            </div>
        </div>

        <!-- Confirm Password Field -->
        <div class="mb-3 position-relative">
            <label for="confirmPassword" class="form-label">Confirmer le mot de passe</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
            <span class="password-toggle" id="confirm-password-toggle">
                <i class="far fa-eye"></i>
            </span>
            <div id="password-match" class="invalid-feedback">
                Les mots de passe ne correspondent pas.
            </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="termsCheck" name="termsCheck" required>
                <label class="form-check-label" for="termsCheck">
                    J'accepte les <a href="#" class="text-decoration-none">termes et conditions</a> et la <a href="#" class="text-decoration-none">politique de confidentialité</a>
                </label>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="d-grid gap-2 mt-4">
            <button type="submit" class="btn btn-primary btn-lg" id="register-btn">
                <i class="fas fa-user-plus me-2"></i> S'inscrire
            </button>
        </div>
    </form>

    <!-- Login Link -->
    <div class="text-center mt-4">
        <p>Vous avez déjà un compte? <a href="index.php?page=login" class="text-decoration-none">Se connecter</a></p>
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
    
    document.getElementById('confirm-password-toggle').addEventListener('click', function() {
        const passwordInput = document.getElementById('confirmPassword');
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
    
    // Password validation
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword');
    const registerBtn = document.getElementById('register-btn');
    
    const lengthCheck = document.getElementById('length-check');
    const uppercaseCheck = document.getElementById('uppercase-check');
    const lowercaseCheck = document.getElementById('lowercase-check');
    const numberCheck = document.getElementById('number-check');
    const specialCheck = document.getElementById('special-check');
    
    password.addEventListener('input', function() {
        const value = this.value;
        
        // Length check
        if (value.length >= 8) {
            lengthCheck.classList.add('valid-requirement');
            lengthCheck.innerHTML = '<i class="fas fa-check-circle me-1"></i> Au moins 8 caractères';
        } else {
            lengthCheck.classList.remove('valid-requirement');
            lengthCheck.innerHTML = '<i class="fas fa-times-circle me-1"></i> Au moins 8 caractères';
        }
        
        // Uppercase check
        if (/[A-Z]/.test(value)) {
            uppercaseCheck.classList.add('valid-requirement');
            uppercaseCheck.innerHTML = '<i class="fas fa-check-circle me-1"></i> Au moins une lettre majuscule';
        } else {
            uppercaseCheck.classList.remove('valid-requirement');
            uppercaseCheck.innerHTML = '<i class="fas fa-times-circle me-1"></i> Au moins une lettre majuscule';
        }
        
        // Lowercase check
        if (/[a-z]/.test(value)) {
            lowercaseCheck.classList.add('valid-requirement');
            lowercaseCheck.innerHTML = '<i class="fas fa-check-circle me-1"></i> Au moins une lettre minuscule';
        } else {
            lowercaseCheck.classList.remove('valid-requirement');
            lowercaseCheck.innerHTML = '<i class="fas fa-times-circle me-1"></i> Au moins une lettre minuscule';
        }
        
        // Number check
        if (/[0-9]/.test(value)) {
            numberCheck.classList.add('valid-requirement');
            numberCheck.innerHTML = '<i class="fas fa-check-circle me-1"></i> Au moins un chiffre';
        } else {
            numberCheck.classList.remove('valid-requirement');
            numberCheck.innerHTML = '<i class="fas fa-times-circle me-1"></i> Au moins un chiffre';
        }
        
        // Special character check
        if (/[!@#$%^&*(),.?":{}|<>]/.test(value)) {
            specialCheck.classList.add('valid-requirement');
            specialCheck.innerHTML = '<i class="fas fa-check-circle me-1"></i> Au moins un caractère spécial';
        } else {
            specialCheck.classList.remove('valid-requirement');
            specialCheck.innerHTML = '<i class="fas fa-times-circle me-1"></i> Au moins un caractère spécial';
        }
        
        // Check if passwords match
        if (confirmPassword.value && confirmPassword.value !== value) {
            confirmPassword.classList.add('is-invalid');
        } else if (confirmPassword.value) {
            confirmPassword.classList.remove('is-invalid');
        }
    });
    
    confirmPassword.addEventListener('input', function() {
        if (this.value !== password.value) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
</script>