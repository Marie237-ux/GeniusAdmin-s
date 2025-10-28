<!-- Sidebar simplifiée par rôle -->
<aside
  :class="sidebarToggle ? 'translate-x-0 lg:w-[80px]' : '-translate-x-full'"
  class="fixed left-0 top-0 z-50 flex h-screen w-72 flex-col bg-gradient-to-b from-slate-900 to-slate-800 shadow-2xl transition-all duration-300 ease-in-out lg:static lg:translate-x-0"
  @click.outside="sidebarToggle = false"
>
  <!-- Header avec logo -->
  <div class="flex items-center justify-between px-6 py-4 border-b border-slate-700">
    <a href="./../home.php" class="flex items-center space-x-3">
      <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600">
        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
      </div>
      <span :class="sidebarToggle ? 'lg:hidden' : ''" class="text-xl font-bold text-white">Avenir</span>
    </a>
    <button @click.stop="sidebarToggle = !sidebarToggle" class="lg:hidden text-slate-400 hover:text-white">
      <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </div>

  <!-- Navigation par rôle -->
  <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-2 scrollbar-thin scrollbar-thumb-slate-600 scrollbar-track-slate-800">
    
    <?php
    $userRole = $_SESSION['user_role'] ?? 'guichetier';
    ?>

    <!-- ==================== ADMIN ==================== -->
    <?php if ($userRole === 'admin'): ?>
    
    <!-- Dashboard Admin -->
    <a href="dashboard-admin.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-300 hover:bg-blue-600 hover:text-white transition-colors bg-blue-500/10 border-l-4 border-blue-500">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
      </svg>
      <span :class="sidebarToggle ? 'lg:hidden' : ''">Tableau de Bord</span>
    </a>

   
  

    <!-- Service Gestion Colis - MISE EN AVANT -->
    <div x-data="{ openPackages: false }" class="space-y-1">
      <button @click="openPackages = !openPackages" class="w-full flex items-center justify-between space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-white hover:bg-blue-700 transition-colors bg-blue-600 border-l-4 border-blue-400">
        <div class="flex items-center space-x-3">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
          </svg>
          <span :class="sidebarToggle ? 'lg:hidden' : ''">Service Colis</span>
        </div>
        <svg :class="openPackages ? 'rotate-90' : ''" class="h-4 w-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>
      <div x-show="openPackages" x-collapse class="ml-20 space-y-1">
        <a href="expedition-colis-admin.php" class="flex items-center space-x-3 rounded-lg px-3 py-2 text-xs text-white hover:bg-blue-700 hover:text-white transition-colors">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
          </svg>
          <span>Toutes les Expéditions</span>
        </a>
        <a href="suivi-colis-admin.php" class="flex items-center space-x-3 rounded-lg px-3 py-2 text-xs text-white hover:bg-blue-700 hover:text-white transition-colors">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
          </svg>
          <span>Suivi Global Colis</span>
        </a>
        <a href="gestion-agents-colis.php" class="flex items-center space-x-3 rounded-lg px-3 py-2 text-xs text-white hover:bg-blue-700 hover:text-white transition-colors">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
          <span>Gestion Agents Colis</span>
        </a>
        <a href="tarifs-colis.php" class="flex items-center space-x-3 rounded-lg px-3 py-2 text-xs text-white hover:bg-blue-700 hover:text-white transition-colors">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>Tarification Colis</span>
        </a>
        <a href="statistiques-colis.php" class="flex items-center space-x-3 rounded-lg px-3 py-2 text-xs text-white hover:bg-blue-700 hover:text-white transition-colors">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
          </svg>
          <span>Statistiques Colis</span>
        </a>
      </div>
    </div>

    <!-- Transport Passagers -->
    <div x-data="{ openPassengers: false }" class="space-y-1">
      <button @click="openPassengers = !openPassengers" class="w-full flex items-center justify-between space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
        <div class="flex items-center space-x-3">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
          <span :class="sidebarToggle ? 'lg:hidden' : ''">Transport Passagers</span>
        </div>
        <svg :class="openPassengers ? 'rotate-90' : ''" class="h-4 w-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>
      <div x-show="openPassengers" x-collapse class="ml-20 space-y-1">
        <a href="reservations-admin.php" class="flex items-center space-x-3 rounded-lg px-3 py-2 text-xs text-white hover:bg-slate-700 hover:text-white transition-colors">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 8h6m6 0v8a2 2 0 01-2 2H6a2 2 0 01-2-2v-8a2 2 0 012-2h8a2 2 0 012 2z" />
          </svg>
          <span>Toutes les Réservations</span>
        </a>
        <a href="embarquements-admin.php" class="flex items-center space-x-3 rounded-lg px-3 py-2 text-xs text-white hover:bg-slate-700 hover:text-white transition-colors">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
          </svg>
          <span>Suivi Embarquements</span>
        </a>
        <a href="billets-admin.php" class="flex items-center space-x-3 rounded-lg px-3 py-2 text-xs text-white hover:bg-slate-700 hover:text-white transition-colors">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5z" />
          </svg>
          <span>Gestion des Billets</span>
        </a>
      </div>
    </div>

    <!-- Flotte & Planning -->
    <div x-data="{ openFleet: false }" class="space-y-1">
      <button @click="openFleet = !openFleet" class="w-full flex items-center justify-between space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
        <div class="flex items-center space-x-3">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
          </svg>
          <span :class="sidebarToggle ? 'lg:hidden' : ''">Flotte & Planning</span>
        </div>
        <svg :class="openFleet ? 'rotate-90' : ''" class="h-4 w-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>
      <div x-show="openFleet" x-collapse class="ml-20 space-y-1">
        <a href="gestion-vehicules.php" class="flex items-center space-x-3 rounded-lg px-3 py-2 text-xs text-white hover:bg-slate-700 hover:text-white transition-colors">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
          </svg>
          <span>Gestion Véhicules</span>
        </a>
        <a href="programmation.php" class="flex items-center space-x-3 rounded-lg px-3 py-2 text-xs text-white hover:bg-slate-700 hover:text-white transition-colors">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>Programmation Voyages</span>
        </a>
        <a href="location-bus.php" class="flex items-center space-x-3 rounded-lg px-3 py-2 text-xs text-white hover:bg-slate-700 hover:text-white transition-colors">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          <span>Location Bus</span>
        </a>
      </div>
    </div>

    <!-- Finances & Rapports -->
    <div x-data="{ openFinance: false }" class="space-y-1">
      <button @click="openFinance = !openFinance" class="w-full flex items-center justify-between space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
        <div class="flex items-center space-x-3">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          <span :class="sidebarToggle ? 'lg:hidden' : ''">Finances & Rapports</span>
        </div>
        <svg :class="openFinance ? 'rotate-90' : ''" class="h-4 w-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>
      <div x-show="openFinance" x-collapse class="ml-20 space-y-1">
        <a href="transactions-admin.php" class="flex items-center space-x-3 rounded-lg px-3 py-2 text-xs text-white hover:bg-slate-700 hover:text-white transition-colors">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
          </svg>
          <span>Toutes les Transactions</span>
        </a>
        <a href="rapports-financiers.php" class="flex items-center space-x-3 rounded-lg px-3 py-2 text-xs text-white hover:bg-slate-700 hover:text-white transition-colors">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          <span>Rapports Financiers</span>
        </a>
        <a href="statistiques-generales.php" class="flex items-center space-x-3 rounded-lg px-3 py-2 text-xs text-white hover:bg-slate-700 hover:text-white transition-colors">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <span>Statistiques Générales</span>
        </a>
 
      </div>

        <!-- Configuration & Réglages -->
    <div x-data="{ openConfig: false }" class="space-y-1">
      <button @click="openConfig = !openConfig" class="w-full flex items-center justify-between space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
        <div class="flex items-center space-x-3">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          <span :class="sidebarToggle ? 'lg:hidden' : ''">Configuration</span>
        </div>
        <svg :class="openConfig ? 'rotate-90' : ''" class="h-4 w-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>
      <div x-show="openConfig" x-collapse class="ml-20 space-y-1">
        <a href="gestion-villes.php" class="flex items-center space-x-3 rounded-lg px-3 py-2 text-xs text-white hover:bg-slate-700 hover:text-white transition-colors">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          <span>Gestion Villes</span>
        </a>
        <a href="gestion-trajets.php" class="flex items-center space-x-3 rounded-lg px-3 py-2 text-xs text-white hover:bg-slate-700 hover:text-white transition-colors">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
          </svg>
          <span>Gestion Trajets</span>
        </a>
        <a href="gestion-vehicules.php" class="flex items-center space-x-3 rounded-lg px-3 py-2 text-xs text-white hover:bg-slate-700 hover:text-white transition-colors">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
          </svg>
          <span>Création Bus</span>
        </a>
        <a href="tarification.php" class="flex items-center space-x-3 rounded-lg px-3 py-2 text-xs text-white hover:bg-slate-700 hover:text-white transition-colors">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>Tarification</span>
        </a>
        <a href="points-vente.php" class="flex items-center space-x-3 rounded-lg px-3 py-2 text-xs text-white hover:bg-slate-700 hover:text-white transition-colors">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
          </svg>
          <span>Points de Vente</span>
        </a>
      </div>


      <!-- Journal des Actions -->
 <a href="journal-actions.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      <span :class="sidebarToggle ? 'lg:hidden' : ''">Journal des Actions</span>
    </a>

     <!-- ==================== CONTROLEUR ==================== -->
      <?php elseif ($userRole === 'controleur'): ?>

<!-- Dashboard Contrôleur -->
<a href="dashboard-controleur.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
  </svg>
  <span :class="sidebarToggle ? 'lg:hidden' : ''">Dashboard</span>
</a>

<!-- Accès au Contrôle Embarquement -->
<a href="controle-embarquement.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-white hover:bg-slate-700 hover:text-white transition-colors">
  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
  </svg>
  <span :class="sidebarToggle ? 'lg:hidden' : ''">Contrôle Embarquement</span>
</a>

<!-- Scan des Billets -->
<a href="scan-billets.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-white hover:bg-slate-700 hover:text-white transition-colors">
  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
  </svg>
  <span :class="sidebarToggle ? 'lg:hidden' : ''">Scan des Billets</span>
</a>

<!-- Liste d'Embarquement -->
<a href="liste-embarquement-controle.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-white hover:bg-slate-700 hover:text-white transition-colors">
  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
  </svg>
  <span :class="sidebarToggle ? 'lg:hidden' : ''">Liste d'Embarquement</span>
</a>

<!-- Validation Manuelle -->
<a href="validation-manuelle.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-white hover:bg-slate-700 hover:text-white transition-colors">
  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>
  <span :class="sidebarToggle ? 'lg:hidden' : ''">Validation Manuelle</span>
</a>

<!-- Rapport de Journée -->
<a href="rapports-controleur.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-white hover:bg-slate-700 hover:text-white transition-colors">
  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2z" />
  </svg>
  <span :class="sidebarToggle ? 'lg:hidden' : ''">Rapports</span>
</a>


    <!-- ==================== AGENT COURRIER ==================== -->
    <?php elseif ($userRole === 'agent courrier'): ?>

    <!-- Dashboard Agent Coursier -->
    <a href="dashboard-coursier.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-300 hover:bg-blue-600 hover:text-white transition-colors bg-blue-500/10 border-l-4 border-blue-500">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
      </svg>
      <span :class="sidebarToggle ? 'lg:hidden' : ''">Tableau de Bord</span>
    </a>

    <!-- Dépôt Colis -->
    <a href="depot-colis.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-white hover:bg-slate-700 hover:text-white transition-colors">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
      </svg>
      <span :class="sidebarToggle ? 'lg:hidden' : ''">Dépôt Colis</span>
    </a>

    <!-- Gestion Colis -->
    <a href="gestion-colis.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-white hover:bg-slate-700 hover:text-white transition-colors">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
      </svg>
      <span :class="sidebarToggle ? 'lg:hidden' : ''">Gestion Colis</span>
    </a>

    <!-- Suivi Colis -->
    <a href="suivi-colis.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-white hover:bg-slate-700 hover:text-white transition-colors">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
      </svg>
      <span :class="sidebarToggle ? 'lg:hidden' : ''">Suivi Colis</span>
    </a>

    <!-- Livraison -->
    <a href="livraison-colis.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-white hover:bg-slate-700 hover:text-white transition-colors">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
      </svg>
      <span :class="sidebarToggle ? 'lg:hidden' : ''">Livraison</span>
    </a>

    <!-- Rapports Coursier -->
    <a href="rapports-coursier.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-white hover:bg-slate-700 hover:text-white transition-colors">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
      </svg>
      <span :class="sidebarToggle ? 'lg:hidden' : ''">Rapports</span>
    </a>

    <!-- ==================== GUICHETIER ==================== -->
    <?php elseif ($userRole === 'guichetier'): ?>

    <!-- Dashboard Guichetier -->
    <a href="dashboard-guichetier.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
      </svg>
      <span :class="sidebarToggle ? 'lg:hidden' : ''">Dashboard</span>
    </a>

    <!-- Vente Billets -->
    <a href="vente-billets.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-white hover:bg-slate-700 hover:text-white transition-colors">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
      </svg>
      <span :class="sidebarToggle ? 'lg:hidden' : ''">Vente Billets</span>
    </a>

    <!-- Enregistrement Bagages -->
    <a href="bagages.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-white hover:bg-slate-700 hover:text-white transition-colors">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
      </svg>
      <span :class="sidebarToggle ? 'lg:hidden' : ''">Bagages</span>
    </a>

  
    <!-- Bordereaux -->
    <a href="bordereaux.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-white hover:bg-slate-700 hover:text-white transition-colors">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
      </svg>
      <span :class="sidebarToggle ? 'lg:hidden' : ''">Bordereaux</span>
    </a>

    <!-- Rapports Guichetier -->
    <a href="rapports-guichetier.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-white hover:bg-slate-700 hover:text-white transition-colors">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
      </svg>
      <span :class="sidebarToggle ? 'lg:hidden' : ''">Rapports</span>
    </a>

    <!-- ==================== CHAUFFEUR ==================== -->
    <?php elseif ($userRole === 'chauffeur'): ?>

    <!-- Dashboard Chauffeur -->
    <a href="dashboard-chauffeur.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
      </svg>
      <span :class="sidebarToggle ? 'lg:hidden' : ''">Dashboard</span>
    </a>

    <!-- Ma Mission -->
    <a href="ma-mission.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-white hover:bg-slate-700 hover:text-white transition-colors">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
      </svg>
      <span :class="sidebarToggle ? 'lg:hidden' : ''">Ma Mission</span>
    </a>

    <!-- Liste Embarquement -->
    <a href="liste-embarquement.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-white hover:bg-slate-700 hover:text-white transition-colors">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
      </svg>
      <span :class="sidebarToggle ? 'lg:hidden' : ''">Liste Embarquement</span>
    </a>

    <!-- Suivi Voyage -->
    <a href="suivi-voyage.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-white hover:bg-slate-700 hover:text-white transition-colors">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
      </svg>
      <span :class="sidebarToggle ? 'lg:hidden' : ''">Suivi Voyage</span>
    </a>

    <!-- Dépenses -->
    <a href="depenses.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-white hover:bg-slate-700 hover:text-white transition-colors">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
      </svg>
      <span :class="sidebarToggle ? 'lg:hidden' : ''">Dépenses</span>
    </a>

    <!-- Signaler Incidents -->
    <a href="signaler-incidents.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-white hover:bg-slate-700 hover:text-white transition-colors">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M12 5a7 7 0 100 14 7 7 0 000-14z" />
      </svg>
      <span :class="sidebarToggle ? 'lg:hidden' : ''">Signaler Incidents</span>
    </a>

    <!-- Rapports -->
    <a href="rapports.php" class="flex items-center space-x-3 rounded-lg px-3 py-3 text-sm font-medium text-white hover:bg-slate-700 hover:text-white transition-colors">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2z" />
      </svg>
      <span :class="sidebarToggle ? 'lg:hidden' : ''">Rapports</span>
    </a>


   
    <?php endif; ?>

  </nav>

  <!-- Footer avec informations utilisateur -->
  <div class="border-t border-slate-700 p-4">
    <div class="flex items-center space-x-3">
      <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
        <span class="text-sm font-semibold text-white">
          <?php 
          $userName = $_SESSION['user_name'] ?? 'Utilisateur';
          echo strtoupper(substr($userName, 0, 2)); 
          ?>
        </span>
      </div>
      <div :class="sidebarToggle ? 'lg:hidden' : ''" class="flex-1 min-w-0">
        <p class="text-sm font-medium text-white truncate"><?php echo htmlspecialchars($userName); ?></p>
        <p class="text-xs text-slate-400 capitalize"><?php echo htmlspecialchars($userRole); ?></p>
      </div>
    </div>
  </div>
</aside>

<!-- Script Alpine.js pour la gestion des états -->
<script>
document.addEventListener('alpine:init', () => {
  Alpine.data('sidebar', () => ({
    sidebarToggle: false,
    init() {
      // Vérifier l'état du sidebar dans localStorage
      const savedState = localStorage.getItem('sidebarCollapsed');
      if (savedState === 'true') {
        this.sidebarToggle = true;
      }
      
      // Sauvegarder l'état quand il change
      this.$watch('sidebarToggle', (value) => {
        localStorage.setItem('sidebarCollapsed', value);
      });
    }
  }));
});
</script>