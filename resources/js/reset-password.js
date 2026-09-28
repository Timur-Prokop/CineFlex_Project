document.getElementById('login-link').addEventListener('click', function () {
    const email = document.getElementById('password-reset-email').value;

    const url = new URL(this.href);

    if (email.trim() !== '') {
        url.searchParams.set('email', email);
    }

    this.href = url.toString();
});

document.getElementById('register-link').addEventListener('click', function () {
    const email = document.getElementById('password-reset-email').value;

    const url = new URL(this.href);

    if (email.trim() !== '') {
        url.searchParams.set('email', email);
    }

    this.href = url.toString();
});
