<?php
require_once '../config/database.php';

// Vérifier si l'utilisateur est connecté et est admin
requireLogin();

$database = new Database();
$db = $database->getConnection();

// Récupérer le rôle de l'utilisateur connecté
$query = "SELECT role FROM utilisateurs WHERE id = :user_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$current_user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$current_user || $current_user['role'] !== 'admin') {
    header('Location: /Avenir/src/index.php');
    exit();
}

$message = '';
$error = '';

// Traitement des actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'update_role':
                $user_id = $_POST['user_id'];
                $new_role = $_POST['new_role'];
                
                $query = "UPDATE utilisateurs SET role = :role WHERE id = :user_id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':role', $new_role);
                $stmt->bindParam(':user_id', $user_id);
                
                if ($stmt->execute()) {
                    $message = "Rôle mis à jour avec succès !";
                } else {
                    $error = "Erreur lors de la mise à jour du rôle.";
                }
                break;
                
            case 'update_status':
                $user_id = $_POST['user_id'];
                $new_status = $_POST['new_status'];
                
                $query = "UPDATE utilisateurs SET statut = :statut WHERE id = :user_id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':statut', $new_status);
                $stmt->bindParam(':user_id', $user_id);
                
                if ($stmt->execute()) {
                    $message = "Statut mis à jour avec succès !";
                } else {
                    $error = "Erreur lors de la mise à jour du statut.";
                }
                break;
                
            case 'delete_user':
                $user_id = $_POST['user_id'];
                
                // Vérifier que l'utilisateur ne se supprime pas lui-même
                if ($user_id == $_SESSION['user_id']) {
                    $error = "Vous ne pouvez pas supprimer votre propre compte.";
                    break;
                }
                
                $query = "DELETE FROM utilisateurs WHERE id = :user_id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':user_id', $user_id);
                
                if ($stmt->execute()) {
                    $message = "Utilisateur supprimé avec succès !";
                } else {
                    $error = "Erreur lors de la suppression de l'utilisateur.";
                }
                break;
        }
    }
}

// Récupérer tous les utilisateurs
$query = "SELECT id, prenom, nom, email, role, statut, created_at FROM utilisateurs ORDER BY created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page = 'users';
$user_name = $_SESSION['user_name'] ?? 'Utilisateur';
$user_email = $_SESSION['user_email'] ?? '';
?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Gestion des utilisateurs | Avenir</title>
    <link rel="stylesheet" href="../assets/style.css" />
    <script defer src="../assets/bundle.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Heroicons pour les icônes modernes -->
    <script src="https://unpkg.com/heroicons@2.0.18/24/outline/index.js" type="module"></script>
    <!-- Animate.css pour les animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
      .user-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.85));
      }
      .dark .user-card {
        background: linear-gradient(145deg, rgba(36, 40, 59, 0.95), rgba(36, 40, 59, 0.85));
        border: 1px solid rgba(255, 255, 255, 0.05);
      }
      .user-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.1);
      }
      .dark .user-card:hover {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(255, 255, 255, 0.1);
      }
      .search-input {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
      }
      .dark .search-input {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
        background: rgba(36, 40, 59, 0.8);
        border-color: rgba(255, 255, 255, 0.1);
      }
      .search-input:focus {
        transform: scale(1.02);
        box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
      }
      .dark .search-input:focus {
        box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.4), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
        border-color: rgba(102, 126, 234, 0.5);
      }
      .status-badge {
        animation: pulse 3s ease-in-out infinite;
      }
      .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        position: relative;
        overflow: hidden;
      }
      .dark .gradient-bg {
        background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
      }
      .gradient-bg::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 50%, rgba(255, 255, 255, 0.1) 100%);
        animation: shimmer 3s ease-in-out infinite;
      }
      .dark .gradient-bg::before {
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.05) 0%, transparent 50%, rgba(255, 255, 255, 0.05) 100%);
      }
      @keyframes shimmer {
        0%, 100% { transform: translateX(-100%); }
        50% { transform: translateX(100%); }
      }
      .glass-effect {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
      }
      .dark .glass-effect {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
      }
      .soft-shadow {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
      }
      .soft-border {
        border-radius: 20px;
      }
      .avatar-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
      }
      .role-badge {
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }
      .dark .role-badge {
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
      }
      .action-button {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
      }
      .dark .action-button {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
        background: rgba(36, 40, 59, 0.8) !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
        color: #ffffff !important;
      }
      .dark .action-button option {
        background: #24283b !important;
        color: #ffffff !important;
      }
      .action-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
      }
      .dark .action-button:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.4);
        background: rgba(36, 40, 59, 0.9) !important;
      }
      .table-row {
        transition: all 0.3s ease;
      }
      .table-row:hover {
        background: linear-gradient(90deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
        transform: scale(1.01);
      }
      .dark .table-row:hover {
        background: linear-gradient(90deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
      }
      .filter-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
      }
      .dark .filter-container {
        background: rgba(36, 40, 59, 0.95);
        border: 1px solid rgba(255, 255, 255, 0.1);
      }
      .modal-overlay {
        backdrop-filter: blur(8px);
      }
      .dark .modal-overlay {
        background: rgba(0, 0, 0, 0.7);
      }
      /* Styles spécifiques pour les select en mode sombre */
      .dark select {
        background: #24283b !important;
        color: #ffffff !important;
        border-color: rgba(255, 255, 255, 0.2) !important;
      }
      .dark select option {
        background: #24283b !important;
        color: #ffffff !important;
      }
      /* Styles pour le tableau en mode sombre */
      .dark .table-container {
        background: rgba(36, 40, 59, 0.95);
        border: 1px solid rgba(255, 255, 255, 0.1);
      }
      .dark .table-container th {
        background: rgba(55, 65, 81, 0.8);
        color: #ffffff;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      }
      .dark .table-container td {
        color: #e5e7eb;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
      }
      .dark .table-container tr:hover {
        background: rgba(55, 65, 81, 0.3);
      }
    </style>
  </head>
  <body x-data="{ 
    page: 'users', 
    loaded: true, 
    darkMode: false, 
    stickyMenu: false, 
    sidebarToggle: false, 
    scrollTop: false,
    searchTerm: '',
    selectedRole: '',
    selectedStatus: '',
    viewMode: 'cards',
    showModal: false,
    selectedUser: null,
    actionType: ''
  }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode')); $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{'dark bg-gray-900': darkMode === true}">
    
    <!-- ===== Preloader Start ===== -->
    <include src="../partials/preloader.php"></include>
    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
      <!-- ===== Sidebar Start ===== -->
      <include src="../partials/sidebar.php"></include>
      <!-- ===== Sidebar End ===== -->

      <!-- ===== Content Area Start ===== -->
      <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
        <!-- ===== Header Start ===== -->
        <include src="../partials/header.php"></include>
        <!-- ===== Header End ===== -->

        <!-- ===== Main Content Start ===== -->
        <main>
          <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
            <!-- Header avec gradient moderne -->
            <div class="mb-8 rounded-2xl gradient-bg p-8 text-white animate__animated animate__fadeInDown">
              <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                  <div class="flex items-center gap-4 mb-4">
                    <a href="../../home.php" class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 rounded-xl text-white transition-all duration-200 backdrop-blur-sm border border-white/20">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                      </svg>
                      Retour à l'accueil
                    </a>
                  </div>
                  <h1 class="text-3xl font-bold mb-2">👥 Gestion des utilisateurs</h1>
                  <p class="text-white/80">Gérez les utilisateurs, leurs rôles et statuts en toute simplicité</p>
                </div>
                <div class="flex items-center gap-4">
                  <!-- Bouton de basculement de thème -->
                  <div class="flex items-center gap-2">
                    <span class="text-xs text-white/70" x-text="darkMode ? 'Mode sombre' : 'Mode clair'"></span>
                    <button 
                      @click="darkMode = !darkMode" 
                      class="glass-effect rounded-lg p-3 text-white hover:bg-white/20 transition-all duration-300 transform hover:scale-110"
                      :title="darkMode ? 'Passer au thème clair' : 'Passer au thème sombre'"
                      :aria-label="darkMode ? 'Passer au thème clair' : 'Passer au thème sombre'"
                    >
                      <svg x-show="!darkMode" class="w-5 h-5 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                      </svg>
                      <svg x-show="darkMode" class="w-5 h-5 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                      </svg>
                    </button>
                  </div>
                  
                  <div class="glass-effect rounded-lg px-4 py-2">
                    <span class="text-2xl font-bold"><?php echo count($users); ?></span>
                    <span class="text-sm block">Utilisateurs</span>
                  </div>
                  <nav class="text-white/80">
                    <ol class="flex items-center gap-2">
                      <li><a href="../index.php" class="hover:text-white transition-colors">Dashboard</a></li>
                      <li>→</li>
                      <li class="text-white">Utilisateurs</li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>

            <!-- Messages avec animations -->
            <?php if ($message): ?>
              <div class="mb-6 rounded-xl border border-green-300 bg-green-50 p-4 text-green-800 dark:border-green-600 dark:bg-green-900/20 dark:text-green-400 animate__animated animate__bounceIn">
                <div class="flex items-center gap-3">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <?php echo htmlspecialchars($message); ?>
                </div>
              </div>
            <?php endif; ?>

            <?php if ($error): ?>
              <div class="mb-6 rounded-xl border border-red-300 bg-red-50 p-4 text-red-800 dark:border-red-600 dark:bg-red-900/20 dark:text-red-400 animate__animated animate__shakeX">
                <div class="flex items-center gap-3">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                  </svg>
                  <?php echo htmlspecialchars($error); ?>
                </div>
              </div>
            <?php endif; ?>

            <!-- Barre de recherche et filtres modernes -->
            <div class="mb-8 rounded-2xl filter-container shadow-lg p-6 animate__animated animate__fadeInUp">
              <div class="flex flex-col lg:flex-row gap-6 items-center justify-between">
                <!-- Recherche -->
                <div class="flex-1 max-w-md">
                  <div class="relative">
                    <input 
                      type="text" 
                      x-model="searchTerm"
                      placeholder="🔍 Rechercher un utilisateur..."
                      class="search-input w-full rounded-xl border border-gray-300 dark:border-strokedark bg-gray-50 dark:bg-form-input py-3 px-4 pl-12 text-black dark:text-white focus:border-primary focus:outline-none"
                    >
                    <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                  </div>
                </div>

                <!-- Filtres -->
                <div class="flex gap-4 items-center">
                  <select x-model="selectedRole" class="rounded-xl border border-gray-300 dark:border-strokedark bg-gray-50 dark:bg-form-input py-2 px-4 text-black dark:text-white focus:border-primary action-button">
                    <option value="">Tous les rôles</option>
                    <option value="admin">👑 Admin</option>
                    <option value="guichetier">🏪 Guichetier</option>
                    <option value="chauffeur">🚌 Chauffeur</option>
                    <option value="controleur">🎫 Contrôleur</option>
                    <option value="agent courrier">📦 Agent Courrier</option>
                    <option value="utilisateur">👤 Utilisateur</option>
                  </select>

                  <select x-model="selectedStatus" class="rounded-xl border border-gray-300 dark:border-strokedark bg-gray-50 dark:bg-form-input py-2 px-4 text-black dark:text-white focus:border-primary action-button">
                    <option value="">Tous les statuts</option>
                    <option value="actif">✅ Actif</option>
                    <option value="inactif">❌ Inactif</option>
                    <option value="suspendu">⚠️ Suspendu</option>
                  </select>

                  <!-- Toggle vue -->
                  <div class="flex rounded-xl bg-gray-100 dark:bg-gray-700 p-1 shadow-inner">
                    <button 
                      @click="viewMode = 'cards'"
                      :class="viewMode === 'cards' ? 'bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow-md' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white'"
                      class="px-4 py-2 rounded-lg transition-all duration-200 font-medium"
                    >
                      📱 Cartes
                    </button>
                    <button 
                      @click="viewMode = 'table'"
                      :class="viewMode === 'table' ? 'bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow-md' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white'"
                      class="px-4 py-2 rounded-lg transition-all duration-200 font-medium"
                    >
                      📊 Tableau
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Vue en cartes (par défaut) -->
            <div x-show="viewMode === 'cards'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 animate__animated animate__fadeIn">
              <?php foreach ($users as $index => $user): ?>
              <div 
                class="user-card rounded-2xl bg-white dark:bg-boxdark shadow-lg p-6 animate__animated animate__fadeInUp"
                style="animation-delay: <?php echo $index * 0.1; ?>s"
                x-show="
                  (searchTerm === '' || '<?php echo strtolower($user['prenom'] . ' ' . $user['nom'] . ' ' . $user['email']); ?>'.includes(searchTerm.toLowerCase())) &&
                  (selectedRole === '' || '<?php echo $user['role']; ?>' === selectedRole) &&
                  (selectedStatus === '' || '<?php echo $user['statut']; ?>' === selectedStatus)
                "
              >
                <!-- Avatar et infos principales -->
                <div class="text-center mb-4">
                  <div class="relative inline-block">
                    <div class="w-20 h-20 rounded-full avatar-gradient flex items-center justify-center text-white text-2xl font-bold mx-auto mb-3">
                      <?php echo strtoupper(substr($user['prenom'], 0, 1) . substr($user['nom'], 0, 1)); ?>
                    </div>
                    <!-- Badge de statut -->
                    <div class="absolute -bottom-1 -right-1">
                      <?php if ($user['statut'] === 'actif'): ?>
                        <div class="w-6 h-6 bg-green-500 rounded-full border-2 border-white status-badge"></div>
                      <?php elseif ($user['statut'] === 'suspendu'): ?>
                        <div class="w-6 h-6 bg-yellow-500 rounded-full border-2 border-white status-badge"></div>
                      <?php else: ?>
                        <div class="w-6 h-6 bg-red-500 rounded-full border-2 border-white"></div>
                      <?php endif; ?>
                    </div>
                  </div>
                  
                  <h3 class="text-lg font-semibold text-black dark:text-white mb-1">
                    <?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?>
                  </h3>
                  <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                    <?php echo htmlspecialchars($user['email']); ?>
                  </p>
                  
                  <!-- Badge rôle -->
                  <div class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium role-badge
                    <?php 
                      switch($user['role']) {
                        case 'admin': echo 'bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400'; break;
                        case 'guichetier': echo 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400'; break;
                        case 'chauffeur': echo 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400'; break;
                        case 'controleur': echo 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400'; break;
                        case 'agent courrier': echo 'bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-400'; break;
                        default: echo 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400';
                      }
                    ?>">
                    <?php 
                      switch($user['role']) {
                        case 'admin': echo '👑'; break;
                        case 'guichetier': echo '🏪'; break;
                        case 'chauffeur': echo '🚌'; break;
                        case 'controleur': echo '🎫'; break;
                        case 'agent courrier': echo '📦'; break;
                        default: echo '👤';
                      }
                    ?>
                    <?php echo ucfirst($user['role']); ?>
                  </div>
                </div>

                <!-- Informations supplémentaires -->
                <div class="space-y-3 mb-4">
                  <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Statut:</span>
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium
                      <?php 
                        echo $user['statut'] === 'actif' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 
                            ($user['statut'] === 'suspendu' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400' : 
                             'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400');
                      ?>">
                      <?php 
                        echo $user['statut'] === 'actif' ? '✅' : 
                            ($user['statut'] === 'suspendu' ? '⚠️' : '❌');
                      ?>
                      <?php echo ucfirst($user['statut']); ?>
                    </span>
                  </div>
                  
                  <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Inscription:</span>
                    <span class="text-black dark:text-white">
                      <?php echo date('d/m/Y', strtotime($user['created_at'])); ?>
                    </span>
                  </div>
                </div>

                <!-- Actions -->
                <div class="space-y-3">
                  <form method="POST" class="w-full">
                    <input type="hidden" name="action" value="update_role">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <select 
                      name="new_role" 
                      onchange="this.form.submit()" 
                      class="w-full soft-border border border-gray-300 dark:border-strokedark bg-gray-50 dark:bg-form-input py-2 px-3 text-sm text-black dark:text-white focus:border-primary focus:outline-none action-button"
                    >
                      <option value="utilisateur" <?php echo $user['role'] === 'utilisateur' ? 'selected' : ''; ?>>👤 Utilisateur</option>
                      <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>👑 Admin</option>
                      <option value="guichetier" <?php echo $user['role'] === 'guichetier' ? 'selected' : ''; ?>>🏪 Guichetier</option>
                      <option value="chauffeur" <?php echo $user['role'] === 'chauffeur' ? 'selected' : ''; ?>>🚌 Chauffeur</option>
                      <option value="controleur" <?php echo $user['role'] === 'controleur' ? 'selected' : ''; ?>>🎫 Contrôleur</option>
                      <option value="agent courrier" <?php echo $user['role'] === 'agent courrier' ? 'selected' : ''; ?>>📦 Agent Courrier</option>
                    </select>
                  </form>

                  <form method="POST" class="w-full">
                    <input type="hidden" name="action" value="update_status">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <select 
                      name="new_status" 
                      onchange="this.form.submit()" 
                      class="w-full rounded-lg border border-gray-300 dark:border-strokedark bg-gray-50 dark:bg-form-input py-2 px-3 text-sm text-black dark:text-white focus:border-primary focus:outline-none transition-all"
                    >
                      <option value="actif" <?php echo $user['statut'] === 'actif' ? 'selected' : ''; ?>>✅ Actif</option>
                      <option value="inactif" <?php echo $user['statut'] === 'inactif' ? 'selected' : ''; ?>>❌ Inactif</option>
                      <option value="suspendu" <?php echo $user['statut'] === 'suspendu' ? 'selected' : ''; ?>>⚠️ Suspendu</option>
                    </select>
                  </form>

                  <?php if ($user['id'] != $_SESSION['user_id']): ?>
                  <button 
                    onclick="confirmDelete(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?>')"
                    class="w-full px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all duration-200 flex items-center justify-center gap-2 text-sm font-medium"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Supprimer
                  </button>
                  <?php endif; ?>
                </div>
              </div>
              <?php endforeach; ?>
            </div>

            <!-- Vue tableau (alternative) -->
            <div x-show="viewMode === 'table'" class="rounded-2xl bg-white dark:bg-boxdark shadow-lg overflow-hidden animate__animated animate__fadeIn table-container">
              <div class="overflow-x-auto">
                <table class="w-full">
                  <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                      <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Utilisateur</th>
                      <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                      <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rôle</th>
                      <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Statut</th>
                      <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Inscription</th>
                      <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200 dark:divide-strokedark">
                    <?php foreach ($users as $user): ?>
                    <tr 
                      class="table-row hover:bg-gray-50 dark:hover:bg-meta-4"
                      x-show="
                        (searchTerm === '' || '<?php echo strtolower($user['prenom'] . ' ' . $user['nom'] . ' ' . $user['email']); ?>'.includes(searchTerm.toLowerCase())) &&
                        (selectedRole === '' || '<?php echo $user['role']; ?>' === selectedRole) &&
                        (selectedStatus === '' || '<?php echo $user['statut']; ?>' === selectedStatus)
                      "
                    >
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                          <div class="w-10 h-10 rounded-full avatar-gradient flex items-center justify-center text-white text-sm font-bold">
                            <?php echo strtoupper(substr($user['prenom'], 0, 1) . substr($user['nom'], 0, 1)); ?>
                          </div>
                          <div class="ml-4">
                            <div class="text-sm font-medium text-black dark:text-white">
                              <?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                        <?php echo htmlspecialchars($user['email']); ?>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <form method="POST" class="inline-block">
                          <input type="hidden" name="action" value="update_role">
                          <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                          <select name="new_role" onchange="this.form.submit()" class="rounded-lg border border-gray-300 dark:border-strokedark bg-gray-50 dark:bg-form-input py-1 px-2 text-sm text-black dark:text-white focus:border-primary action-button">
                            <option value="utilisateur" <?php echo $user['role'] === 'utilisateur' ? 'selected' : ''; ?>>👤 Utilisateur</option>
                            <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>👑 Admin</option>
                            <option value="guichetier" <?php echo $user['role'] === 'guichetier' ? 'selected' : ''; ?>>🏪 Guichetier</option>
                            <option value="chauffeur" <?php echo $user['role'] === 'chauffeur' ? 'selected' : ''; ?>>🚌 Chauffeur</option>
                            <option value="controleur" <?php echo $user['role'] === 'controleur' ? 'selected' : ''; ?>>🎫 Contrôleur</option>
                            <option value="agent courrier" <?php echo $user['role'] === 'agent courrier' ? 'selected' : ''; ?>>📦 Agent Courrier</option>
                          </select>
                        </form>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <form method="POST" class="inline-block">
                          <input type="hidden" name="action" value="update_status">
                          <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                          <select name="new_status" onchange="this.form.submit()" class="rounded-lg border border-gray-300 dark:border-strokedark bg-gray-50 dark:bg-form-input py-1 px-2 text-sm text-black dark:text-white focus:border-primary action-button">
                            <option value="actif" <?php echo $user['statut'] === 'actif' ? 'selected' : ''; ?>>✅ Actif</option>
                            <option value="inactif" <?php echo $user['statut'] === 'inactif' ? 'selected' : ''; ?>>❌ Inactif</option>
                            <option value="suspendu" <?php echo $user['statut'] === 'suspendu' ? 'selected' : ''; ?>>⚠️ Suspendu</option>
                          </select>
                        </form>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                        <?php echo date('d/m/Y', strtotime($user['created_at'])); ?>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                          <?php if ($user['id'] != $_SESSION['user_id']): ?>
                          <button 
                            onclick="confirmDelete(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?>')"
                            class="px-3 py-1 bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 text-white rounded-lg transition-all duration-200 flex items-center gap-1 text-xs"
                          >
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Supprimer
                          </button>
                          <?php else: ?>
                          <span class="text-xs text-gray-400 dark:text-gray-500">Compte actuel</span>
                          <?php endif; ?>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </main>
        <!-- ===== Main Content End ===== -->
      </div>
      <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->

    <!-- Modal de confirmation de suppression -->
    <div id="deleteModal" class="fixed inset-0 modal-overlay bg-black bg-opacity-50 hidden items-center justify-center z-50 animate__animated">
      <div class="bg-white dark:bg-boxdark rounded-2xl p-8 max-w-md w-full mx-4 animate__animated animate__bounceIn">
        <div class="text-center">
          <div class="w-16 h-16 bg-red-100 dark:bg-red-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-black dark:text-white mb-2">Confirmer la suppression</h3>
          <p class="text-gray-600 dark:text-gray-400 mb-6">
            Êtes-vous sûr de vouloir supprimer l'utilisateur <span id="deleteUserName" class="font-semibold"></span> ?
            <br><span class="text-sm text-red-600 dark:text-red-400">Cette action est irréversible.</span>
          </p>
          <div class="flex gap-4 justify-center">
            <button onclick="closeDeleteModal()" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg transition-all duration-200">
              Annuler
            </button>
            <form id="deleteForm" method="POST" class="inline">
              <input type="hidden" name="action" value="delete_user">
              <input type="hidden" name="user_id" id="deleteUserId">
              <button type="submit" class="px-6 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all duration-200">
                Supprimer
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script>
      function confirmDelete(userId, userName) {
        document.getElementById('deleteUserId').value = userId;
        document.getElementById('deleteUserName').textContent = userName;
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
      }

      function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
      }

      // Fermer le modal en cliquant à l'extérieur
      document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
          closeDeleteModal();
        }
      });

      // Amélioration des animations au scroll
      window.addEventListener('scroll', function() {
        const cards = document.querySelectorAll('.user-card');
        cards.forEach(card => {
          const rect = card.getBoundingClientRect();
          if (rect.top < window.innerHeight && rect.bottom > 0) {
            card.style.transform = 'translateY(0)';
            card.style.opacity = '1';
          }
        });
      });

      // Gestion améliorée des thèmes
      document.addEventListener('alpine:init', () => {
        Alpine.store('theme', {
          dark: JSON.parse(localStorage.getItem('darkMode')) || false,
          toggle() {
            this.dark = !this.dark;
            localStorage.setItem('darkMode', JSON.stringify(this.dark));
            this.updateTheme();
          },
          updateTheme() {
            if (this.dark) {
              document.documentElement.classList.add('dark');
            } else {
              document.documentElement.classList.remove('dark');
            }
          }
        });
      });

      // Appliquer le thème au chargement
      window.addEventListener('DOMContentLoaded', function() {
        const darkMode = JSON.parse(localStorage.getItem('darkMode')) || false;
        if (darkMode) {
          document.documentElement.classList.add('dark');
        }
      });

      // Animation d'entrée pour les éléments
      const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
      };

      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
          }
        });
      }, observerOptions);

      // Observer les cartes utilisateur
      document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.user-card');
        cards.forEach(card => {
          card.style.opacity = '0';
          card.style.transform = 'translateY(20px)';
          observer.observe(card);
        });
      });
    </script>
  </body>
</html>
