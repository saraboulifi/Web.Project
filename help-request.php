<?php
/**
 * help-request.php
 * Formulaire simple de demande d'aide - traitement côté serveur
 */

session_start();
require_once __DIR__ . '/Model/db.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    try {
        $data = [
            'help_type' => $_POST['help_type'] ?? '',
            'urgency_level' => $_POST['urgency_level'] ?? '',
            'situation' => $_POST['situation'] ?? '',
            'location' => $_POST['location'] ?? '',
            'contact_method' => $_POST['contact_method'] ?? '',
        ];
        
        $id = createRequest($data);
        $message = 'Votre demande d\'aide a été enregistrée avec succès. Notre équipe vous contactera bientôt.';
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demander de l'aide - PeaceConnect</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/components.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    
    <style>
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="navbar-content">
                <a href="index.html" class="navbar-brand">
                    <span>🕊️</span>
                    <span>PeaceConnect</span>
                </a>
                <button class="navbar-toggle" type="button">☰</button>
                <ul class="navbar-menu">
                    <li><a href="index.html">Accueil</a></li>
                    <li><a href="forum.html">Forum</a></li>
                    <li><a href="events.html">Événements</a></li>
                    <li><a href="dashboard.php" class="btn btn-outline">Admin</a></li>
                    <li><a href="help-request.php" class="active">Demander de l'aide</a></li>
                    <li><a href="profile.html">Mon Profil</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Formulaire de demande d'aide -->
    <section class="section">
        <div class="container" style="max-width: 900px;">
            <div class="section-title">
                <h1>Demander de l'aide</h1>
                <p>Remplissez le formulaire ci-dessous pour soumettre votre demande</p>
            </div>

            <!-- Messages -->
            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Formulaire de demande</h2>
                </div>
                
                <form method="post" action="help-request.php" style="padding: 1.5rem;">
                    <div class="form-group">
                        <label for="help_type" class="form-label">Type d'aide recherchée <span style="color:red;">*</span></label>
                        <select id="help_type" name="help_type" class="form-control" required>
                            <option value="">Sélectionner...</option>
                            <option value="legal">Aide juridique</option>
                            <option value="psychological">Soutien psychologique</option>
                            <option value="mediation">Médiation</option>
                            <option value="emergency">Urgence</option>
                            <option value="information">Information / Conseils</option>
                            <option value="other">Autre</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="urgency_level" class="form-label">Niveau d'urgence <span style="color:red;">*</span></label>
                        <select id="urgency_level" name="urgency_level" class="form-control" required>
                            <option value="">Sélectionner...</option>
                            <option value="low">Faible - Pas urgent</option>
                            <option value="medium">Moyen - Dans les prochains jours</option>
                            <option value="high">Élevé - Dans les prochaines heures</option>
                            <option value="critical">Critique - Immédiat</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="situation" class="form-label">Décrivez votre situation <span style="color:red;">*</span></label>
                        <textarea id="situation" name="situation" class="form-control" rows="8" required placeholder="Décrivez votre situation, vos besoins, et le type d'aide que vous recherchez..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="location" class="form-label">Localisation</label>
                        <input type="text" id="location" name="location" class="form-control" placeholder="Ville, région...">
                    </div>

                    <div class="form-group">
                        <label for="contact_method" class="form-label">Moyen de contact préféré <span style="color:red;">*</span></label>
                        <select id="contact_method" name="contact_method" class="form-control" required>
                            <option value="">Sélectionner...</option>
                            <option value="email">Email</option>
                            <option value="phone">Téléphone</option>
                            <option value="both">Email et téléphone</option>
                        </select>
                    </div>

                    <div style="padding: 1rem; background-color: #fff3cd; border-radius: 4px; margin-bottom: 1.5rem;">
                        <strong>Urgence :</strong> Si vous êtes en danger immédiat, appelez le 17 (police) ou le 112 (urgence européenne).
                    </div>

                    <button type="submit" name="submit" value="1" class="btn btn-primary" style="padding: 0.75rem 2rem; font-size: 1rem;">
                        Envoyer ma demande
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 PeaceConnect. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>
