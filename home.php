<?php
require_once __DIR__ . '/src/config/database.php';

// Variables pour l'utilisateur connecté
$user_connected = false;
$user_name = '';
$user_role = '';
$user_email = '';

// Vérifier si l'utilisateur est connecté
if (isLoggedIn()) {
    $user_connected = true;
    $user_name = $_SESSION['user_name'] ?? 'Utilisateur';
    $user_role = $_SESSION['user_role'] ?? '';
    $user_email = $_SESSION['user_email'] ?? '';
}
?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Avenir - Tableau de bord moderne</title>
    <link rel="stylesheet" href="./src/assets/style.css" />
    <script defer src="./src/assets/bundle.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  </head>
  <body x-data="{ darkMode: false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode')); $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{'dark bg-gray-900': darkMode === true}">
    
    <!-- Header -->
    <header class="relative z-50 bg-white/80 backdrop-blur-md border-b border-gray-200 dark:bg-gray-900/80 dark:border-gray-800">
      <div class="container mx-auto px-6">
        <div class="flex items-center justify-between h-16">
          <!-- Logo -->
          <div class="flex items-center space-x-3">
            <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
              </svg>
            </div>
            <span class="text-xl font-bold text-gray-900 dark:text-white">Avenir</span>
          </div>
          
          <!-- Navigation -->
          <nav class="hidden md:flex items-center space-x-8">
            <a href="#features" class="text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition-colors">Fonctionnalités</a>
            <a href="#about" class="text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition-colors">À propos</a>
            <a href="#contact" class="text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition-colors">Contact</a>
          </nav>
          
          <!-- Actions -->
          <div class="flex items-center space-x-4">
            <!-- Dark mode toggle -->
            <button @click="darkMode = !darkMode" class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
              <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
              </svg>
              <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
              </svg>
            </button>
            
            <?php if ($user_connected): ?>
              <!-- Menu utilisateur connecté -->
              <div class="flex items-center space-x-4">
                <span class="text-gray-700 dark:text-gray-300 font-medium">Bonjour, <?php echo htmlspecialchars(explode(' ', $user_name)[0]); ?></span>
                <a href="/Avenir/src/Auth/logout.php" class="inline-flex items-center px-4 py-2 bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-700 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 rounded-lg transition-all duration-200 font-medium">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                  </svg>
                  Déconnexion
                </a>
              </div>
            <?php else: ?>
              <!-- Menu utilisateur non connecté -->
              <a href="/Avenir/src/Auth/signin.php" class="px-4 py-2 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                Connexion
              </a>
              <a href="/Avenir/src/Auth/signup.php" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all transform hover:scale-105">
                S'inscrire
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </header>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 overflow-hidden">
      <!-- Background Elements -->
      <div class="absolute inset-0">
        <div class="absolute top-20 left-20 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
        <div class="absolute top-40 right-20 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse delay-1000"></div>
        <div class="absolute -bottom-8 left-40 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse delay-500"></div>
      </div>
      
      <div class="relative z-10 container mx-auto px-6 text-center">
        <div class="max-w-4xl mx-auto">
          <!-- Badge -->
          <div class="inline-flex items-center px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200 rounded-full text-sm font-medium mb-8">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Nouveau tableau de bord disponible
          </div>
          
          <?php if (!$user_connected): ?>
            <!-- Utilisateur non connecté -->
            <!-- Title -->
            <h1 class="text-5xl md:text-7xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
              Votre <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">futur</span> commence ici
            </h1>
            
            <!-- Subtitle -->
            <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 mb-12 leading-relaxed">
              Découvrez Avenir, le tableau de bord moderne et intuitif qui transforme 
              la façon dont vous gérez votre agence de voyages.
            </p>
            
            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6 mb-16">
              <a href="/Avenir/src/Auth/signup.php" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-lg font-semibold rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all transform hover:scale-105 shadow-lg hover:shadow-xl">
                Commencer gratuitement
              </a>
            </div>
          
          <?php else: ?>
            <!-- Utilisateur connecté -->
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
              Bienvenue, <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent"><?php echo htmlspecialchars(explode(' ', $user_name)[0]); ?></span>
            </h1>
            
            <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
              Accédez à votre espace de travail personnalisé
            </p>
            
            <!-- Blocs d'accès selon le rôle -->
            <div class="grid gap-6 md:grid-cols-2 max-w-4xl mx-auto mb-16">
              
              <?php if ($user_role === 'utilisateur'): ?>
                <!-- Utilisateur avec rôle 'utilisateur' - En attente -->
                <div class="col-span-full bg-yellow-50 dark:bg-yellow-900/20 border-2 border-yellow-200 dark:border-yellow-700 rounded-2xl p-8 text-center">
                  <div class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900/30 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                  <h3 class="text-2xl font-bold text-yellow-800 dark:text-yellow-200 mb-4">En attente d'attribution de rôle</h3>
                  <p class="text-yellow-700 dark:text-yellow-300 mb-6">
                    Votre compte est activé mais vous devez attendre qu'un administrateur vous attribue un rôle spécifique pour accéder au système.
                  </p>
                  <div class="text-sm text-yellow-600 dark:text-yellow-400">
                    Rôle actuel: <span class="font-medium">Utilisateur de base</span><br>
                    Veuillez patienter ou contactez l'administrateur.
                  </div>
                </div>
              
              <?php elseif ($user_role === 'admin'): ?>
                <!-- Administrateur - Accès complet -->
                <div class="bg-white dark:bg-gray-800 border-2 border-blue-200 dark:border-blue-700 rounded-2xl p-8 text-center hover:shadow-xl transition-all transform hover:scale-105">
                  <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                  </div>
                  <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Tableau de bord</h3>
                  <p class="text-gray-600 dark:text-gray-300 mb-6">
                    Accédez à votre espace de travail administrateur
                  </p>
                  <a href="/Avenir/src/index.php" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                    Tableau de bord
                  </a>
                </div>
                
                <!-- Bloc admin - Gestion des rôles -->
                <div class="bg-white dark:bg-gray-800 border-2 border-purple-200 dark:border-purple-700 rounded-2xl p-8 text-center hover:shadow-xl transition-all transform hover:scale-105">
                  <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/30 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                  </div>
                  <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Administration</h3>
                  <p class="text-gray-600 dark:text-gray-300 mb-6">
                    Gérez les utilisateurs et attribuez les rôles
                  </p>
                  <a href="/Avenir/src/admin/users.php" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold rounded-xl hover:from-purple-700 hover:to-pink-700 transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Gestion des rôles
                  </a>
                </div>
              
              <?php elseif ($user_role === 'agent courrier'): ?>
                <!-- Agent Courrier - Gestion des colis -->
                <div class="col-span-full bg-white dark:bg-gray-800 border-2 border-orange-200 dark:border-orange-700 rounded-2xl p-8 text-center hover:shadow-xl transition-all transform hover:scale-105">
                  <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900/30 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                  </div>
                  <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">📦 Service Courrier</h3>
                  <p class="text-gray-600 dark:text-gray-300 mb-6">
                    Gérez les expéditions, réceptions et livraisons de colis
                  </p>
                  <a href="/Avenir/src/index.php" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-blue-600 text-white font-semibold rounded-xl hover:from-green-700 hover:to-blue-700 transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Accéder au service colis
                  </a>
                  <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                    Rôle: <span class="font-medium text-orange-600 dark:text-orange-400">📦 Agent Courrier</span>
                  </div>
                </div>
              
              <?php elseif (!empty($user_role) && $user_role !== '' && $user_role !== null): ?>
                <!-- Autres rôles (guichetier, chauffeur, controleur, etc.) - Accès au dashboard uniquement -->
                <div class="col-span-full bg-white dark:bg-gray-800 border-2 border-green-200 dark:border-green-700 rounded-2xl p-8 text-center hover:shadow-xl transition-all transform hover:scale-105">
                  <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                  </div>
                  <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Tableau de bord</h3>
                  <p class="text-gray-600 dark:text-gray-300 mb-6">
                    Accédez à votre espace de travail et gérez vos activités
                  </p>
                  <a href="/Avenir/src/index.php" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-blue-600 text-white font-semibold rounded-xl hover:from-green-700 hover:to-blue-700 transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                    Accéder au dashboard
                  </a>
                  <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                    Rôle: <span class="font-medium capitalize"><?php echo htmlspecialchars($user_role); ?></span>
                  </div>
                </div>
              
              <?php else: ?>
                <!-- Utilisateur sans rôle défini -->
                <div class="col-span-full bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-700 rounded-2xl p-8 text-center">
                  <div class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                  </div>
                  <h3 class="text-2xl font-bold text-red-800 dark:text-red-200 mb-4">Compte non configuré</h3>
                  <p class="text-red-700 dark:text-red-300 mb-6">
                    Votre compte n'a pas encore de rôle attribué. Un administrateur doit vous assigner un rôle pour accéder au système.
                  </p>
                  <div class="text-sm text-red-600 dark:text-red-400">
                    Veuillez contacter l'administrateur pour obtenir l'accès.
                  </div>
                </div>
              <?php endif; ?>
            </div>
          <?php endif; ?>
          
         
      </div>
    </section>

   

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
      <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center justify-between">
          <div class="flex items-center space-x-3 mb-4 md:mb-0">
            <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
              </svg>
            </div>
            <span class="text-xl font-bold">Avenir</span>
          </div>
          
          <div class="text-center md:text-right">
            <p class="text-gray-400 mb-2">© 2024 Avenir. Tous droits réservés.</p>
            <p class="text-gray-500 text-sm">Votre futur commence ici</p>
          </div>
        </div>
      </div>
    </footer>

  </body>
</html>
