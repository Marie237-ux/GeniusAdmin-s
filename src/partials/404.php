<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>
      404 Error Page | Avenir - Tailwind CSS Admin Dashboard Template
    </title>
  </head>
  <body
    x-data="{ page: 'page404', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}"
  >
    <!-- ===== Preloader Start ===== -->
    <?php include __DIR__ . '/preloader.php'; ?>
    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div
      class="relative z-1 flex min-h-screen flex-col items-center justify-center overflow-hidden p-6"
    >
      <!-- ===== Common Grid Shape Start ===== -->
      <!-- Grid shape background -->
    <div class="absolute inset-0 -z-1 opacity-5">
      <svg class="h-full w-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
            <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5"/>
          </pattern>
        </defs>
        <rect width="100" height="100" fill="url(#grid)" />
      </svg>
    </div>
      <!-- ===== Common Grid Shape End ===== -->

      <!-- Centered Content -->
      <div class="mx-auto w-full max-w-[242px] text-center sm:max-w-[472px]">
        <h1
          class="mb-8 text-title-md font-bold text-gray-800 dark:text-white/90 xl:text-title-2xl"
        >
          ERROR
        </h1>

        <div class="mx-auto mb-8 flex h-32 w-32 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/20">
          <svg class="h-16 w-16 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z" />
          </svg>
        </div>
        <div class="text-6xl font-bold text-gray-800 dark:text-white mb-4">404</div>

        <p
          class="mb-6 mt-10 text-base text-gray-700 dark:text-gray-400 sm:text-lg"
        >
          We can’t seem to find the page you are looking for!
        </p>

        <a
          href="index.php"
          class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-3.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
        >
          Back to Home Page
        </a>
      </div>
      <!-- Footer -->
      <p
        class="absolute bottom-6 left-1/2 -translate-x-1/2 text-center text-sm text-gray-500 dark:text-gray-400"
      >
        &copy; <span id="year"></span> - Avenir
      </p>
    </div>

    <!-- ===== Page Wrapper End ===== -->
  </body>
</html>
