const passwordInput = document.getElementById('password');
const togglePassword = document.getElementById('toggle-password');

const passwordConfirmationInput = document.getElementById('password_confirmation');
const togglePasswordConfirmation = document.getElementById('toggle-password-confirmation');


if (passwordInput && togglePassword) {
    togglePassword.addEventListener('click', () => {
        const isPassword = passwordInput.type === 'password';

        passwordInput.type = isPassword ? 'text' : 'password';

        togglePassword.textContent = isPassword ? 'Hide' : 'Show';

        togglePassword.setAttribute(
            'aria-label',
            isPassword ? 'Hide password' : 'Show password'
        );
    });
}


if (passwordConfirmationInput && togglePasswordConfirmation) {
    togglePasswordConfirmation.addEventListener('click', () => {
        const isPassword = passwordConfirmationInput.type === 'password';

        passwordConfirmationInput.type = isPassword ? 'text' : 'password';

        togglePasswordConfirmation.textContent = isPassword ? 'Hide' : 'Show';

        togglePasswordConfirmation.setAttribute(
            'aria-label',
            isPassword ? 'Hide password' : 'Show password'
        );
    });
}
