<?php
function renderUeCard(array $data): string
{
    // Définition des valeurs par défaut
    $defaults = [
        'code' => '',
        'title' => 'UE Sans Titre',
        'professor' => 'Professeur Non Défini',
        'ects' => '0',
        'isOptional' => false,
        'status' => 'in_progress', // Valeur par défaut raisonnable
        'score' => '0.0'
    ];

    // Fusion avec les valeurs par défaut
    $data = array_merge($defaults, $data);

    // Validation des types
    $data['isOptional'] = (bool)$data['isOptional'];
    $data['ects'] = (string)$data['ects'];
    $data['score'] = (string)$data['score'];

    // Détermination des classes CSS
    $borderColor = $data['isOptional'] ? 'border-blue-500' : 'border-indigo-500';
    $bgColor = $data['isOptional'] ? 'bg-blue-100' : 'bg-indigo-100';
    $textColor = $data['isOptional'] ? 'text-blue-800' : 'text-indigo-800';
    $badgeText = $data['isOptional']
        ? 'Optionnelle - ' . htmlspecialchars($data['ects']) . ' ECTS'
        : htmlspecialchars($data['ects']) . ' ECTS';

    // Gestion des différents états
    switch ($data['status']) {
        case 'validated':
            $statusIcon = 'fas fa-check';
            $statusText = 'Validée';
            $scoreText = htmlspecialchars($data['score']) . '/20';
            break;

        case 'in_progress':
            $statusIcon = 'fas fa-spinner animate-spin';
            $statusText = 'En cours';
            $scoreText = '';
            break;

        case 'to_choose':
            // Cas spécial pour UE à choisir
            return '
            <div class="ue-card bg-white rounded-lg shadow border-l-4 border-blue-500 overflow-hidden">
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Choix d\'UE optionnelle</h3>
                            <p class="text-sm text-gray-600 mt-1">À sélectionner</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            À choisir - ' . htmlspecialchars($data['ects']) . ' ECTS
                        </span>
                    </div>
                    <div class="mt-4">
                        <button onclick="openUeModal()" class="w-full flex items-center justify-center px-4 py-2 border border-dashed border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none">
                            <i class="fas fa-plus mr-2 text-blue-500"></i>
                            Sélectionner une UE
                        </button>
                    </div>
                </div>
            </div>';

        default:
            $statusIcon = 'fas fa-question-circle';
            $statusText = 'Statut Inconnu';
            $scoreText = '';
    }

    // Construction de la carte UE
    return '
    <div class="ue-card bg-white rounded-lg shadow border-l-4 ' . $borderColor . ' overflow-hidden">
        <div class="p-4">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">' .
        htmlspecialchars($data['code']) . ' - ' .
        htmlspecialchars($data['title']) . '</h3>
                    <p class="text-sm text-gray-600 mt-1">' .
        htmlspecialchars($data['professor']) . '</p>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' .
        $bgColor . ' ' . $textColor . '">
                    ' . $badgeText . '
                </span>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="mr-2 w-8 h-8 rounded-full ' . $bgColor . ' flex items-center justify-center">
                        <i class="' . $statusIcon . ' ' . ($data['isOptional'] ? 'text-blue-600' : 'text-indigo-600') . ' text-xs"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">' . $statusText . '</span>
                </div>
                ' . ($scoreText ? '<span class="text-sm font-bold ' .
            ($data['isOptional'] ? 'text-blue-600' : 'text-indigo-600') . '">' .
            $scoreText . '</span>' : '') . '
            </div>
        </div>
    </div>';
}
