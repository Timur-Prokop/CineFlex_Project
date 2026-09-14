const passwordInput = document.getElementById('password');
const togglePassword = document.getElementById('toggle-password');

if (passwordInput && togglePassword) {
    togglePassword.addEventListener('mousedown', () => {
        const isPassword = passwordInput.type === 'password';

        passwordInput.type = isPassword ? 'text' : 'password';

        togglePassword.textContent = isPassword ? 'Hide' : 'Show';
        togglePassword.setAttribute(
            'aria-label',
            isPassword ? 'Hide password' : 'Show password'
        );
    });

    togglePassword.addEventListener('mouseup', () => {
        const isPassword = passwordInput.type === 'password';

        passwordInput.type = isPassword ? 'text' : 'password';

        togglePassword.textContent = isPassword ? 'Hide' : 'Show';
        togglePassword.setAttribute(
            'aria-label',
            isPassword ? 'Hide password' : 'Show password'
        );
    });
}
