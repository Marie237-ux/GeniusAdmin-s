<!-- Profile Info Modal -->
<div x-show="isProfileInfoModal" x-transition class="fixed inset-0 z-[10000] flex items-center justify-center p-4">
  <div class="absolute inset-0 bg-black/50" @click="isProfileInfoModal = false"></div>
  <div class="relative w-full max-w-2xl rounded-2xl border border-gray-200 bg-white p-6 shadow-xl dark:border-gray-800 dark:bg-gray-900">
    <div class="mb-4 flex items-center justify-between">
      <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Edit Profile Info</h3>
      <button @click="isProfileInfoModal = false" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">✕</button>
    </div>
    <form class="space-y-4">
      <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <label class="block">
          <span class="mb-1 block text-sm text-gray-600 dark:text-gray-400">First Name</span>
          <input type="text" class="w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm dark:border-gray-700 dark:text-white/90" placeholder="John" />
        </label>
        <label class="block">
          <span class="mb-1 block text-sm text-gray-600 dark:text-gray-400">Last Name</span>
          <input type="text" class="w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm dark:border-gray-700 dark:text-white/90" placeholder="Doe" />
        </label>
        <label class="block md:col-span-2">
          <span class="mb-1 block text-sm text-gray-600 dark:text-gray-400">Email</span>
          <input type="email" class="w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm dark:border-gray-700 dark:text-white/90" placeholder="john@doe.com" />
        </label>
        <label class="block md:col-span-2">
          <span class="mb-1 block text-sm text-gray-600 dark:text-gray-400">Bio</span>
          <input type="text" class="w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm dark:border-gray-700 dark:text-white/90" placeholder="Team Manager" />
        </label>
      </div>
      <div class="flex items-center justify-end gap-2 pt-2">
        <button type="button" @click="isProfileInfoModal = false" class="rounded-full border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5">Cancel</button>
        <button type="submit" class="rounded-full bg-brand-600 px-4 py-2 text-sm font-medium text-white hover:bg-brand-700">Save</button>
      </div>
    </form>
  </div>
</div>
