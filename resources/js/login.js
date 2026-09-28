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

document.getElementById('register-link').addEventListener('click', function () {
    const email = document.getElementById('login-email').value;

    const url = new URL(this.href);

    if (email.trim() !== '') {
    url.searchParams.set('email', email);
}

    this.href = url.toString();
});

document.getElementById('reset-password-link').addEventListener('click', function () {
    const email = document.getElementById('login-email').value;

    const url = new URL(this.href);

    if (email.trim() !== '') {
        url.searchParams.set('email', email);
    }

    this.href = url.toString();
});
