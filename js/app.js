document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('auth-modal');
    const openModalButtons = document.querySelectorAll('.btn-login, .btn-purchase');
    const closeModalButton = document.querySelector('.close-modal');
    const tabLinks = document.querySelectorAll('.tab-link');
    const tabContents = document.querySelectorAll('.tab-content');
    const forgotPasswordLink = document.querySelector('.forgot-password-link');
    const signupTitle = document.getElementById('signup-title');
    const passIdInput = document.getElementById('signup-pass-id');

    // Function to switch tabs
    function switchTab(targetTabId) {
        tabLinks.forEach(link => {
            link.classList.toggle('active', link.dataset.tab === targetTabId);
        });
        tabContents.forEach(content => {
            content.classList.toggle('active', content.id === targetTabId);
        });
    }

    // Open modal
    openModalButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            modal.style.display = 'flex';

            if (button.classList.contains('btn-purchase')) {
                // If a purchase button was clicked, go to signup tab
                const card = button.closest('.pass-card');
                const passName = card.querySelector('h2').textContent;
                const passId = card.dataset.passId; // We'll add this dataset attribute next
                
                signupTitle.textContent = `Purchase ${passName}`;
                passIdInput.value = passId;
                switchTab('signup');
            } else {
                // Otherwise, go to login tab
                signupTitle.textContent = 'Create Your Account';
                passIdInput.value = '';
                switchTab('login');
            }
        });
    });

    // Close modal
    closeModalButton.addEventListener('click', () => {
        modal.style.display = 'none';
    });
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Handle tab switching
    tabLinks.forEach(link => {
        link.addEventListener('click', () => switchTab(link.dataset.tab));
    });

    // Handle "Forgot Password" link
    forgotPasswordLink.addEventListener('click', (e) => {
        e.preventDefault();
        switchTab(forgotPasswordLink.dataset.tab);
    });
});