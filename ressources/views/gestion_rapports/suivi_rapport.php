<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des Rapports</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .stat-card i {
        font-size: 24px;
        margin-right: 10px;
        color: #4a90e2;
    }

    .stat-card h3 {
        margin: 0;
        font-size: 14px;
        color: #666;
    }

    .stat-card p {
        margin: 5px 0 0;
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }

    .main-content {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .filters {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .filters select,
    .filters input {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .filters input {
        flex: 1;
        padding-left: 35px;
    }

    .search-icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
    }

    .report-item {
        padding: 20px 0;
        border-bottom: 1px solid #eee;
    }

    .report-item:last-child {
        border-bottom: none;
    }

    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .report-title {
        font-size: 16px;
        font-weight: bold;
        margin: 0;
    }

    .report-date {
        font-size: 14px;
        color: #666;
        margin: 5px 0 0;
    }

    .status {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .status.en-cours {
        background: #e3f2fd;
        color: #1976d2;
    }

    .status.en-revision {
        background: #fff3e0;
        color: #f57c00;
    }

    .status.valide {
        background: #e8f5e9;
        color: #388e3c;
    }

    .status.a-corriger {
        background: #ffebee;
        color: #d32f2f;
    }

    .timeline {
        margin-left: 20px;
        padding-left: 20px;
        border-left: 2px solid #eee;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-dot {
        position: absolute;
        left: -31px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #4a90e2;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 12px;
    }

    .timeline-content {
        margin-left: 10px;
    }

    .timeline-title {
        font-size: 14px;
        font-weight: 500;
        margin: 0;
    }

    .timeline-date {
        font-size: 12px;
        color: #666;
        margin: 2px 0 0;
    }

    .progress-bar {
        height: 4px;
        background: #eee;
        border-radius: 2px;
        margin-top: 8px;
    }

    .progress-bar-fill {
        height: 100%;
        background: #4a90e2;
        border-radius: 2px;
    }
    </style>
</head>

<body>
    <div class="container">
        <!-- Statistiques -->
        <div class="stats-grid">
            <div class="stat-card">
                <div style="display: flex; align-items: center;">
                    <i class="fas fa-file-alt"></i>
                    <div>
                        <h3>En Cours</h3>
                        <p>5</p>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div style="display: flex; align-items: center;">
                    <i class="fas fa-clock"></i>
                    <div>
                        <h3>En Révision</h3>
                        <p>3</p>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div style="display: flex; align-items: center;">
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <h3>Validés</h3>
                        <p>8</p>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div style="display: flex; align-items: center;">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <h3>À Corriger</h3>
                        <p>2</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="main-content">
            <h2 style="margin: 0 0 20px;">Suivi des Rapports</h2>

            <!-- Filtres -->
            <div class="filters">
                <select>
                    <option value="">Tous les statuts</option>
                    <option value="en_cours">En cours</option>
                    <option value="en_revision">En révision</option>
                    <option value="valide">Validé</option>
                    <option value="a_corriger">À corriger</option>
                </select>
                <div style="position: relative; flex: 1;">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" placeholder="Rechercher un rapport...">
                </div>
            </div>

            <!-- Liste des rapports -->
            <div class="reports-list">
                <!-- Rapport 1 -->
                <div class="report-item">
                    <div class="report-header">
                        <div>
                            <h3 class="report-title">Rapport de Stage - Développement Web</h3>
                            <p class="report-date">Soumis le 15 Mars 2024</p>
                        </div>
                        <span class="status en-revision">En révision</span>
                    </div>

                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="timeline-content">
                                <h4 class="timeline-title">Soumission du rapport</h4>
                                <p class="timeline-date">15 Mars 2024 - 14:30</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-dot">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="timeline-content">
                                <h4 class="timeline-title">Vérification initiale</h4>
                                <p class="timeline-date">16 Mars 2024 - 09:15</p>
                                <p style="margin: 5px 0 0; font-size: 13px; color: #666;">Document conforme aux normes
                                </p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-dot">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="timeline-content">
                                <h4 class="timeline-title">Évaluation par le jury</h4>
                                <p class="timeline-date">En cours</p>
                                <div class="progress-bar">
                                    <div class="progress-bar-fill" style="width: 60%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-dot">
                                <i class="fas fa-hourglass"></i>
                            </div>
                            <div class="timeline-content">
                                <h4 class="timeline-title">Validation finale</h4>
                                <p class="timeline-date">En attente</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rapport 2 -->
                <div class="report-item">
                    <div class="report-header">
                        <div>
                            <h3 class="report-title">Mémoire de Master - Intelligence Artificielle</h3>
                            <p class="report-date">Soumis le 10 Mars 2024</p>
                        </div>
                        <span class="status a-corriger">À corriger</span>
                    </div>

                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="timeline-content">
                                <h4 class="timeline-title">Soumission du rapport</h4>
                                <p class="timeline-date">10 Mars 2024 - 11:20</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-dot" style="background: #d32f2f;">
                                <i class="fas fa-times"></i>
                            </div>
                            <div class="timeline-content">
                                <h4 class="timeline-title">Vérification initiale</h4>
                                <p class="timeline-date">11 Mars 2024 - 15:45</p>
                                <p style="margin: 5px 0 0; font-size: 13px; color: #d32f2f;">Corrections nécessaires :
                                    formatage et bibliographie</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-dot" style="background: #9e9e9e;">
                                <i class="fas fa-hourglass"></i>
                            </div>
                            <div class="timeline-content">
                                <h4 class="timeline-title">Évaluation par le jury</h4>
                                <p class="timeline-date">En attente</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-dot" style="background: #9e9e9e;">
                                <i class="fas fa-hourglass"></i>
                            </div>
                            <div class="timeline-content">
                                <h4 class="timeline-title">Validation finale</h4>
                                <p class="timeline-date">En attente</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterSelect = document.querySelector('select');
        const searchInput = document.querySelector('input[type="text"]');

        filterSelect.addEventListener('change', filterReports);
        searchInput.addEventListener('input', filterReports);

        function filterReports() {
            const status = filterSelect.value;
            const search = searchInput.value.toLowerCase();
            console.log('Filtrage par:', {
                status,
                search
            });
        }
    });
    </script>
</body>

</html>