<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Gestion Scolaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
        }
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #667eea;
        }
        .btn-primary {
            background-color: #667eea;
            border-color: #667eea;
        }
        .btn-primary:hover {
            background-color: #5a67d8;
            border-color: #5a67d8;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">
                <i class="fas fa-graduation-cap me-2"></i>Gestion Scolaire
            </a>
            <div class="navbar-nav ms-auto">
                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Connexion</a>
                <a href="{{ route('register') }}" class="btn btn-primary"></a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Bienvenue sur Gestion Scolaire</h1>
            <p class="lead mb-4">La solution complète pour gérer votre établissement scolaire</p>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5">Commencer</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col">
                    <h2 class="fw-bold">Fonctionnalités Principales</h2>
                    <p class="text-muted">Découvrez toutes les fonctionnalités de notre plateforme</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <h5 class="card-title">Gestion des Cours</h5>
                            <p class="card-text">Créez et gérez facilement les matières par niveau et attribuez les enseignants.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <h5 class="card-title">Emploi du Temps</h5>
                            <p class="card-text">Générez automatiquement les emplois du temps et gérez les salles de classe.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h5 class="card-title">Notes & Évaluations</h5>
                            <p class="card-text">Saisissez et calculez automatiquement les moyennes des élèves.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <h5 class="card-title">Communication</h5>
                            <p class="card-text">Messagerie interne entre enseignants, administration et parents.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <h5 class="card-title">Gestion Financière</h5>
                            <p class="card-text">Générez des factures et gérez les paiements en ligne.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h5 class="card-title">Portail Parents</h5>
                            <p class="card-text">Accès aux notes, absences et emploi du temps pour les parents.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-light py-5">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Prêt à transformer la gestion de votre établissement ?</h2>
            <p class="lead mb-4">Rejoignez dès aujourd'hui notre plateforme complète de gestion scolaire</p>
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5">Créer un compte</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Gestion Scolaire</h5>
                    <p>La solution tout-en-un pour la gestion de votre établissement scolaire.</p>
                </div>
                <div class="col-md-6 text-end">
                    <p>&copy; 2024 Gestion Scolaire. Tous droits réservés.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
