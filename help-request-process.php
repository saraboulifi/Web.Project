<?php
/**
 * help-request-process.php
 * Traitement simple des formes de demande d'aide (POST)
 */

require_once __DIR__ . '/Model/db.php';

// Récupérer l'action
$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : null);

try {
    // CREATE
    if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'help_type' => $_POST['help_type'] ?? '',
            'urgency_level' => $_POST['urgency_level'] ?? '',
            'situation' => $_POST['situation'] ?? '',
            'location' => $_POST['location'] ?? '',
            'contact_method' => $_POST['contact_method'] ?? '',
            'status' => $_POST['status'] ?? 'en_attente',
            'responsable' => $_POST['responsable'] ?? '',
        ];
        
        $id = createRequest($data);
        $_SESSION['message'] = 'Demande créée avec succès (ID: ' . $id . ')';
        header('Location: dashboard.php');
        exit;
    }
    
    // UPDATE
    if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = (int)($_POST['id'] ?? 0);
        if (!$id) throw new Exception('ID manquant');
        
        $data = [
            'help_type' => $_POST['help_type'] ?? '',
            'urgency_level' => $_POST['urgency_level'] ?? '',
            'situation' => $_POST['situation'] ?? '',
            'location' => $_POST['location'] ?? '',
            'contact_method' => $_POST['contact_method'] ?? '',
            'status' => $_POST['status'] ?? 'en_attente',
            'responsable' => $_POST['responsable'] ?? '',
        ];
        
        updateRequest($id, $data);
        $_SESSION['message'] = 'Demande mise à jour avec succès';
        header('Location: dashboard.php');
        exit;
    }
    
    // DELETE
    if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $id = (int)($_GET['id'] ?? 0);
        if (!$id) throw new Exception('ID manquant');
        
        deleteRequest($id);
        $_SESSION['message'] = 'Demande supprimée avec succès';
        header('Location: dashboard.php');
        exit;
    }
    
    // Par défaut, redirectionner vers le dashboard
    header('Location: dashboard.php');
    exit;
    
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header('Location: dashboard.php');
    exit;
}
?>
