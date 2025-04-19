// Fonction pour ouvrir une modale
function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Empêche le défilement du body
}

// Fonction pour fermer une modale
function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.body.style.overflow = 'auto'; // Réactive le défilement du body
}

// Gestionnaire pour le formulaire d'ajout
document.getElementById('addUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    // Récupérer les données du formulaire
    const formData = new FormData(this);
    
    // Ici, ajoutez votre logique pour envoyer les données au serveur
    console.log('Ajout utilisateur:', Object.fromEntries(formData));
    
    // Fermer la modale après soumission
    closeModal('addUserModal');
    // Réinitialiser le formulaire
    this.reset();
});

// Gestionnaire pour le formulaire de modification
document.getElementById('editUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    // Ici, ajoutez votre logique pour envoyer les données au serveur
    console.log('Modification utilisateur:', Object.fromEntries(formData));
    
    closeModal('editUserModal');
});

// Gestionnaire pour le formulaire de désactivation
document.getElementById('deactivateUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const userId = document.getElementById('deactivateUserId').value;
    
        // Ici, ajoutez votre logique pour désactiver l'utilisateur
    console.log('Désactivation utilisateur:', userId);
    
    closeModal('deactivateUserModal');
});

// Fonction pour pré-remplir le formulaire de modification
function editUser(userData) {
    // Remplir les champs du formulaire avec les données de l'utilisateur
    document.getElementById('editUserId').value = userData.id;
    document.getElementById('editNom').value = userData.nom;
    document.getElementById('editPrenom').value = userData.prenom;
    document.getElementById('editEmail').value = userData.email;
    document.getElementById('editRole').value = userData.role;
    
    // Ouvrir la modale
    openModal('editUserModal');
}

// Fonction pour initialiser la désactivation d'un utilisateur
function initDeactivateUser(userId) {
    document.getElementById('deactivateUserId').value = userId;
    openModal('deactivateUserModal');
}

// Fermer les modales si on clique sur l'overlay
document.addEventListener('click', function(e) {
    const modals = ['addUserModal', 'editUserModal', 'deactivateUserModal'];
    
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (e.target === modal) {
            closeModal(modalId);
        }
    });
});

// Fermer les modales avec la touche Echap
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modals = ['addUserModal', 'editUserModal', 'deactivateUserModal'];
        modals.forEach(modalId => closeModal(modalId));
    }
});

