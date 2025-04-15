document.addEventListener('DOMContentLoaded', function() {
    // Toggle mobile menu
    const mobileMenuButton = document.querySelector('.md\\:hidden button');
    if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', function() {
            const sidebar = document.querySelector('.hidden.md\\:flex');
            sidebar.classList.toggle('hidden');
        });
    }

    // Update faculty name when changed
    const facultySelect = document.getElementById('faculty-select');
    if (facultySelect) {
        facultySelect.addEventListener('change', function() {
            document.getElementById('current-faculty').textContent = this.value;
        });
    }

    // Simulate UE card hover effects
    const ueCards = document.querySelectorAll('.ue-card');
    ueCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 10px 25px -5px rgba(0, 0, 0, 0.1)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.boxShadow = '';
        });
    });
});

// Modal functions
function openUeModal() {
    document.getElementById('ueModal').classList.remove('hidden');
}

function closeUeModal() {
    document.getElementById('ueModal').classList.add('hidden');
}

function confirmUeSelection() {
    const selectedOption = document.querySelector('input[name="ueOption"]:checked');
    if (selectedOption) {
        alert('UE sélectionnée avec succès!');
        closeUeModal();
    } else {
        alert('Veuillez sélectionner une UE');
    }
}