document.addEventListener('DOMContentLoaded', () => {
    // --- Existing Modal and Form Logic ---
    const modal = document.getElementById('auth-modal');
    const openModalButtons = document.querySelectorAll('.user-profile[href="#login"], .btn-purchase');
    const closeModalButton = document.querySelector('.close-modal');
    const tabLinks = document.querySelectorAll('.tab-link');
    const signupTabLink = document.querySelector('.tab-link[data-tab="signup"]');
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
                // If a purchase button was clicked, show and switch to the signup tab
                signupTabLink.style.display = 'block'; // Make tab visible
                const card = button.closest('.pass-card');
                const passName = card.querySelector('h2').textContent;
                const passId = card.dataset.passId;
                
                signupTitle.textContent = `Purchase ${passName}`;
                passIdInput.value = passId;
                switchTab('signup');
            } else {
                // Otherwise, hide the signup tab and go to the login tab
                signupTabLink.style.display = 'none'; // Hide tab
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

    // Handle tab switching (only for visible tabs)
    tabLinks.forEach(link => {
        link.addEventListener('click', () => switchTab(link.dataset.tab));
    });

    // Handle "Forgot Password" link
    forgotPasswordLink.addEventListener('click', (e) => {
        e.preventDefault();
        switchTab(forgotPasswordLink.dataset.tab);
    });

    // --- New Floating Menu Language Switcher ---
    const langToggle = document.getElementById('lang-toggle');

    if (langToggle) { // Check if the element exists to avoid errors
        langToggle.addEventListener('change', function() {
            if (this.checked) {
                console.log('Language switched to English');
                // TODO: Add your language switching logic here for English
            } else {
                console.log('Language switched to Hungarian');
                // TODO: Add your language switching logic here for Hungarian
            }
        });
    }
});