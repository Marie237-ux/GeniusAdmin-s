<div
  x-show="loaded"
  x-init="window.addEventListener('DOMContentLoaded', () => {setTimeout(() => loaded = false, 500)})"
  class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-black"
>
  <div class="flex flex-col items-center space-y-4">
    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-blue-600 animate-pulse">
      <svg class="h-8 w-8 text-white animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
      </svg>
    </div>
    <div class="text-lg font-semibold text-gray-800 dark:text-white">Chargement...</div>
  </div>
</div>
