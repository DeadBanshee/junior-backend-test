<template> 
  <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white dark:text-white dark:bg-slate-800 p-6 rounded-lg shadow-xl w-full max-w-md text-center">
      <h2 class="text-lg font-semibold mb-4">Are you sure you want to delete the contact?</h2>
      <p class="text-sm mb-6">
        The contact will be notified, this action cannot be undone.
      </p>
      <div class="flex justify-center gap-4">
        <button
          @click="$emit('confirm')"
          class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition"
        >
          Yes, delete
        </button>
        <button
          @click="$emit('close')"
          class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400 transition"
        >
          Cancel
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useContactsStore } from '@/stores/contact'

const store = useContactsStore()

function submit() {
  store.editContact(store.form.id, store.form)
}
</script>