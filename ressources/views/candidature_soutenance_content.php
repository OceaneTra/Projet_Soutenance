<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidater à la soutenance</title>
</head>

<body class="bg-gradient-to-br from-[#f6f7ff] to-[#e9ebfa] min-h-screen">
    <!-- Shapes d'arrière-plan -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>

    <div class="container max-w-6xl mx-auto px-6 py-12 md:px-4 md:py-8">
        <div class="header text-center mb-12">
            <h1 class="text-4xl font-bold text-text-dark mb-4 md:text-3xl text-green-500">Candidature à la soutenance
            </h1>
            <p class="text-lg text-text-light max-w-2xl mx-auto md:text-base">Vérifiez votre éligibilité et accédez aux
                comptes rendus de la commission d'évaluation.</p>
        </div>

        <div class="cards-container grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Card 1 - Simulateur d'éligibilité -->
            <div class="card">
                <div class="card-content p-10 py-8 flex flex-col items-center text-center h-full">
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-text-dark mb-4">Simulateur d'éligibilité</h2>
                    <p class="text-text-light mb-8 flex-grow text-lg leading-relaxed">Vérifiez si vous remplissez les
                        conditions requises pour candidater à la soutenance et obtenez un
                        aperçu instantané de votre statut.</p>
                    <a href="?page=candidature_soutenance&action=simulateur_eligibilite
                    " class="card-btn">
                        <span>
                            Vérifier mon éligibilité
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="M12 5l7 7-7 7"></path>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>

            <!-- Card 2 - Compte rendu -->
            <div class="card">
                <div class="card-content p-10 py-8 flex flex-col items-center text-center h-full">
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-text-dark mb-4">Compte rendu</h2>
                    <p class="text-text-light mb-8 flex-grow text-lg leading-relaxed">Consultez le compte rendu détaillé
                        des évaluations et des recommandations formulées par les
                        membres de la commission suite à votre demande.</p>
                    <a href="?page=candidature_soutenance&action=compte_rendu_etudiant" class="card-btn">
                        <span>
                            Consulter mon compte rendu
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="M12 5l7 7-7 7"></path>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>