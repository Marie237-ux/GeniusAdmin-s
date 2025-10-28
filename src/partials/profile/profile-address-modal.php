<!-- Profile Address Modal -->
<div x-show="isProfileAddressModal" x-transition class="fixed inset-0 z-[10000] flex items-center justify-center p-4">
  <div class="absolute inset-0 bg-black/50" @click="isProfileAddressModal = false"></div>
  <div class="relative w-full max-w-2xl rounded-2xl border border-gray-200 bg-white p-6 shadow-xl dark:border-gray-800 dark:bg-gray-900">
    <div class="mb-4 flex items-center justify-between">
      <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Edit Address</h3>
      <button @click="isProfileAddressModal = false" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">✕</button>
    </div>
    <form class="space-y-4">
      <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <label class="block">
          <span class="mb-1 block text-sm text-gray-600 dark:text-gray-400">Country</span>
          <input type="text" class="w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm dark:border-gray-700 dark:text-white/90" placeholder="Country" />
        </label>
        <label class="block">
          <span class="mb-1 block text-sm text-gray-600 dark:text-gray-400">City/State</span>
          <input type="text" class="w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm dark:border-gray-700 dark:text-white/90" placeholder="City/State" />
        </label>
        <label class="block">
          <span class="mb-1 block text-sm text-gray-600 dark:text-gray-400">Postal Code</span>
          <input type="text" class="w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm dark:border-gray-700 dark:text-white/90" placeholder="ZIP" />
        </label>
        <label class="block">
          <span class="mb-1 block text-sm text-gray-600 dark:text-gray-400">TAX ID</span>
          <input type="text" class="w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm dark:border-gray-700 dark:text-white/90" placeholder="TAX ID" />
        </label>
      </div>
      <div class="flex items-center justify-end gap-2 pt-2">
        <button type="button" @click="isProfileAddressModal = false" class="rounded-full border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg:white/5">Cancel</button>
        <button type="submit" class="rounded-full bg-brand-600 px-4 py-2 text-sm font-medium text-white hover:bg-brand-700">Save</button>
      </div>
    </form>
  </div>
</div>
