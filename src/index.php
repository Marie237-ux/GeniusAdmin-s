<?php
require_once __DIR__ . '/config/database.php';

// Vérifier si l'utilisateur est connecté
requireLogin();

$page = 'dashboard';
$user_name = $_SESSION['user_name'] ?? 'Utilisateur';
$user_email = $_SESSION['user_email'] ?? '';
$user_role = $_SESSION['user_role'] ?? 'utilisateur';
?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>
      Avenir Dashboard
    </title>
    <link rel="stylesheet" href="./assets/style.css" />
    <script defer src="./assets/bundle.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  </head>
  <body
    x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}"
  >
    <!-- ===== Preloader Start ===== -->
    <?php include __DIR__ . '/partials/preloader.php'; ?>
    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
      <!-- ===== Sidebar Start ===== -->
      <?php include __DIR__ . '/partials/sidebar.php'; ?>
      <!-- ===== Sidebar End ===== -->

      <!-- ===== Content Area Start ===== -->
      <div
        class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto"
      >
        <!-- Small Device Overlay Start -->
        <?php include __DIR__ . '/partials/overlay.php'; ?>
        <!-- Small Device Overlay End -->

        <!-- ===== Header Start ===== -->
        <?php include __DIR__ . '/partials/header.php'; ?>
        <!-- ===== Header End ===== -->

        <!-- ===== Main Content Start ===== -->
        <main>
          <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
            
         

            <div class="grid grid-cols-12 gap-4 md:gap-6">
              <div class="col-span-12 space-y-6 xl:col-span-7">
                <!-- TODO: Convert widgets to PHP partials -->
                <!-- < ?php include __DIR__ . '/partials/metric-group/metric-group-01.php'; ? > -->

                <!-- ====== Chart One Start -->
                <!-- < ?php include __DIR__ . '/partials/chart/chart-01.php'; ? > -->
                <!-- ====== Chart One End -->
              </div>
              <div class="col-span-12 xl:col-span-5">
                <!-- ====== Chart Two Start -->
                <!-- < ?php include __DIR__ . '/partials/chart/chart-02.php'; ? > -->
                <!-- ====== Chart Two End -->
              </div>

              <!-- System Status -->
              <div class="col-span-12">
                <!-- ====== Chart Three Start -->
                <!-- < ?php include __DIR__ . '/partials/chart/chart-03.php'; ? > -->
                <!-- ====== Chart Three End -->
              </div>
              </div>

              <div class="col-span-12 xl:col-span-7">
                <!-- ====== Table One Start -->
                <!-- < ?php include __DIR__ . '/partials/table/table-01.php'; ? > -->
                <!-- ====== Table One End -->
              </div>
            </div>
          </div>
        </main>
        <!-- ===== Main Content End ===== -->
      </div>
      <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->
  </body>
</html>
