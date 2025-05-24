<?php
$nom_user = $_SESSION['nom_utilisateur'] ?? '';
$login_user = $_SESSION['login_utilisateur'] ?? '';
$statut_user = $_SESSION['statut_utilisateur'] ?? '';
$niveau_acces = $_SESSION['niveau_acces'] ?? '';
$lib_GU = $_SESSION['lib_GU'] ?? '';
$libelle_type_utilisateur = $_SESSION['type_utilisateur'] ?? '';
$libelle_niveau_acces = $_SESSION['niveau_acces'] ?? '';
$libelle_GU = $_SESSION['lib_GU'] ?? '';

// Récupération des informations spécifiques selon le type d'utilisateur
$specialite = $_SESSION['specialite'] ?? '';
$grade = $_SESSION['grade'] ?? '';
$fonction = $_SESSION['fonction'] ?? '';
$date_grade = $_SESSION['date_grade'] ?? '';
$date_fonction = $_SESSION['date_fonction'] ?? '';
$telephone = $_SESSION['telephone'] ?? '';
$poste = $_SESSION['poste'] ?? '';
$date_embauche = $_SESSION['date_embauche'] ?? '';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil utilisateur</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }
    </style>
</head>

<body class="bg-gray-50 min-h-screen font-sans text-gray-800" x-data="{
    formChanged: false,
    showNotification: false,
    currentTab: 'profile',
    saveChanges() {
        this.showNotification = true;
        this.formChanged = false;
        setTimeout(() => this.showNotification = false, 3000);
    }
}">
    <div class="container max-w-4xl mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-user-circle mr-2 text-green-600"></i> Mon Profil
            </h1>
            <p class="text-gray-600 mt-1">Gérez vos informations personnelles</p>
        </header>

        <!-- Tab Navigation -->
        <div class="flex border-b border-gray-200 mb-6">
            <button @click="currentTab = 'profile'"
                :class="{'text-green-600 border-green-600': currentTab === 'profile', 'text-gray-500 hover:text-gray-700': currentTab !== 'profile'}"
                class="py-2 px-4 font-medium text-sm border-b-2 -mb-px transition duration-150 ease-in-out">
                <i class="fas fa-user mr-2"></i> Informations
            </button>
            <button @click="currentTab = 'password'"
                :class="{'text-green-600 border-green-600': currentTab === 'password', 'text-gray-500 hover:text-gray-700': currentTab !== 'password'}"
                class="py-2 px-4 font-medium text-sm border-b-2 -mb-px transition duration-150 ease-in-out">
                <i class="fas fa-lock mr-2"></i> Mot de passe
            </button>
        </div>

        <!-- Profile Tab Content -->
        <div x-show="currentTab === 'profile'" class="fade-in">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">
                            Informations personnelles
                        </h3>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- First Column -->
                        <div>
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="nom">Nom
                                    complet</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <input id="nom" type="text" value="<?= $nom_user ?>" disabled
                                        class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="email">Email</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <input id="email" type="email" value="<?= $login_user ?>" disabled
                                        class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="gu">Groupe
                                    utilisateur</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <input id="gu" type="text" value="<?= $libelle_GU ?>" disabled
                                        class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                                </div>
                            </div>

                        </div>

                        <!-- Second Column -->
                        <div>
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-2"
                                    for="login">Identifiant</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                        <i class="fas fa-at"></i>
                                    </div>
                                    <input id="login" type="text" value="<?= $login_user ?>" disabled
                                        class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Type d'utilisateur</label>
                                <div class="relative  rounded-lg pl-3 pr-4 py-2  border border-gray-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-user-tag text-gray-400 mr-2"></i>
                                        <span><?= $libelle_type_utilisateur ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Niveau d'accès</label>
                                <div class="relative rounded-lg pl-3 pr-4 py-2  border border-gray-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-shield-alt text-gray-400 mr-2"></i>
                                        <span><?= $libelle_niveau_acces ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informations spécifiques selon le type d'utilisateur -->
                    <?php if ($libelle_type_utilisateur === 'Enseignant simple' || $libelle_type_utilisateur === 'Enseignant administratif'): ?>
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">
                            Informations professionnelles
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-5">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Spécialité</label>
                                    <div class="relative rounded-lg pl-3 pr-4 py-2 border border-gray-200">
                                        <div class="flex items-center">
                                            <i class="fas fa-graduation-cap text-gray-400 mr-2"></i>
                                            <span><?= htmlspecialchars($specialite) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Grade</label>
                                    <div class="relative rounded-lg pl-3 pr-4 py-2 border border-gray-200">
                                        <div class="flex items-center">
                                            <i class="fas fa-award text-gray-400 mr-2"></i>
                                            <span><?= htmlspecialchars($grade) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="mb-5">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Fonction</label>
                                    <div class="relative rounded-lg pl-3 pr-4 py-2 border border-gray-200">
                                        <div class="flex items-center">
                                            <i class="fas fa-briefcase text-gray-400 mr-2"></i>
                                            <span><?= htmlspecialchars($fonction) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date d'obtention du
                                        grade</label>
                                    <div class="relative rounded-lg pl-3 pr-4 py-2 border border-gray-200">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-check text-gray-400 mr-2"></i>
                                            <span><?= htmlspecialchars($date_grade) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date d'occupation de la
                                        fonction</label>
                                    <div class="relative rounded-lg pl-3 pr-4 py-2 border border-gray-200">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>
                                            <span><?= htmlspecialchars($date_fonction) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php elseif ($libelle_type_utilisateur === 'Personnel administratif'): ?>
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">
                            Informations professionnelles
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-5">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                                    <div class="relative rounded-lg pl-3 pr-4 py-2 border border-gray-200">
                                        <div class="flex items-center">
                                            <i class="fas fa-phone text-gray-400 mr-2"></i>
                                            <span><?= htmlspecialchars($telephone) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Poste</label>
                                    <div class="relative rounded-lg pl-3 pr-4 py-2 border border-gray-200">
                                        <div class="flex items-center">
                                            <i class="fas fa-briefcase text-gray-400 mr-2"></i>
                                            <span><?= htmlspecialchars($poste) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="mb-5">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date d'embauche</label>
                                    <div class="relative rounded-lg pl-3 pr-4 py-2 border border-gray-200">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>
                                            <span><?= htmlspecialchars($date_embauche) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Password Tab Content -->
        <div x-show="currentTab === 'password'" class="fade-in" x-transition>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">
                        Changer mon mot de passe
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="currentPassword">Mot de
                                passe actuel</label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <input id="currentPassword" type="password"
                                    class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="newPassword">Nouveau
                                    mot de passe</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                    <input id="newPassword" type="password"
                                        class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2"
                                    for="confirmPassword">Confirmer le mot de passe</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                    <input id="confirmPassword" type="password"
                                        class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button
                                class="px-4 py-2 bg-green-600 text-white font-medium hover:bg-green-700 rounded-lg shadow transition">
                                Mettre à jour le mot de passe
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password Requirements -->
            <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="text-sm font-medium text-blue-800 mb-2 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i> Exigences pour le mot de passe
                </h4>
                <ul class="text-xs text-blue-700 space-y-1">
                    <li class="flex items-center"><i class="fas fa-check-circle mr-2 text-green-500"></i>
                        Minimum 8
                        caractères</li>
                    <li class="flex items-center"><i class="fas fa-check-circle mr-2 text-green-500"></i> Au
                        moins une
                        majuscule</li>
                    <li class="flex items-center"><i class="fas fa-check-circle mr-2 text-green-500"></i> Au
                        moins un
                        chiffre</li>
                    <li class="flex items-center"><i class="fas fa-check-circle mr-2 text-green-500"></i> Au
                        moins un
                        caractère spécial</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Success Notification -->
    <div x-show="showNotification" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="fixed bottom-6 right-6 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <span>Modifications enregistrées avec succès</span>
    </div>
</body>

</html>