const profileButton = document.getElementById('profileButton');
const profileDropdown = document.getElementById('profileDropdown');

if (profileButton && profileDropdown) {

    profileButton.addEventListener('click', (event) => {
        event.stopPropagation();

        const isOpen = profileDropdown.classList.toggle('open');

        profileButton.setAttribute(
            'aria-expanded',
            isOpen ? 'true' : 'false'
        );
    });

    document.addEventListener('click', () => {
        profileDropdown.classList.remove('open');

        profileButton.setAttribute(
            'aria-expanded',
            'false'
        );
    });

    profileDropdown.addEventListener('click', (event) => {
        event.stopPropagation();
    });
}
