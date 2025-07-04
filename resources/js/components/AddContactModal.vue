<template>
  <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl w-full max-w-md shadow-lg relative">
      <h2 class="text-lg font-bold mb-4">New Contact</h2>

      <form @submit.prevent="submit">
        <input v-model="form.name" type="text" placeholder="Name" class="mb-2 w-full p-2 border rounded" />
        <input v-model="form.email" type="email" placeholder="Email" class="mb-2 w-full p-2 border rounded" />
        <input v-model="form.phone" type="text" placeholder="Phone" class="mb-4 w-full p-2 border rounded" />

        <div class="flex justify-end gap-2">
          <button type="button" @click="$emit('close')" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Save</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useContactsStore } from '@/stores/contact'

const store = useContactsStore()

const form = ref({
  name: '',
  email: '',
  phone: ''
})

function submit() {
  store.createContact(form.value)
  form.value = { name: '', email: '', phone: '' }
}
</script>
