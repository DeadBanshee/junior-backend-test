<template>

  <Head title="Contacts List" />

  <div class="min-h-screen w-full animate-gradient bg-gradient-to-tr from-blue-900 to-green-900 bg-[length:200%_200%] p-4">

    <div class="flex justify-center items-center h-full">
      <div class="w-full max-w-6xl bg-white/90 dark:bg-slate-800/90 rounded-2xl shadow-2xl backdrop-blur-md p-8 overflow-hidden">
        
        <h1 class="text-4xl font-extrabold text-slate-800 dark:text-white mb-6 tracking-tight hover:text-green-700 transition-all cursor-default">
          Contacts
        </h1>

        <button
            class="bg-green-600 hover:bg-green-700 hover:scale-105 transition-all text-white px-4 py-2 rounded shadow"
            @click="modal.toggleModal()"
          >
            Add Contact
          </button>

          
          <p class="text-gray-700 mt-5 dark:text-gray-300 font-bold  text-sm cursor-default hover:brightness-150 transition-all ">Total Contacts: {{ contacts.total }}</p>

      <div class="flex flex-col justify-center items-center m-5">
          <AddContactModal v-if="modal.showModal" @close="modal.toggleModal()" />
          <EditContactModal v-if="modal.showEditModal" @close="modal.closeEditModal()" />
          <DeleteContactModal
            v-if="showDeleteModal"
            @close="showDeleteModal = false"
            @confirm="deleteContactConfirmed"
          />
      </div>

      <div class="flex flex-col justify-center items-center m-5">
        <input type="text" v-model="searchQuery" placeholder="Search Contacts"
          class="w-full max-w-md px-4 py-2 border border-gray-300 dark:bg-slate-600 dark:text-white dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 transition-all mb-4">
      </div>

        <div class="overflow-x-auto rounded-lg shadow">
          <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-600">
            <thead class="bg-slate-800 text-white text-sm uppercase tracking-wider">
              <tr>
                <th class="px-6 py-4 text-left">Name</th>
                <th class="px-6 py-4 text-left">Email</th>
                <th class="px-6 py-4 text-left">Phone</th>
                <th class="px-6 py-4 text-left">Edit</th>
                <th class="px-6 py-4 text-left">Delete</th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-100 dark:divide-gray-700">
              <tr
                v-for="contact in (contactsList?.data || contacts.data)"
                :key="contact.id"
                class="hover:bg-green-50 dark:hover:bg-slate-700 transition duration-150"
              >
                <td @click="copyToClipboard(contact.name)" class="px-6 py-4 text-gray-900 dark:text-white cursor-pointer transition-all hover:text-green-600 flex items-center gap-2">
                  <div :class="getRandomColor()" class="w-10 h-10 rounded-full flex items-center justify-center">{{ getFirstLetters(contact.name) }}</div>
                  {{ contact.name }}
                </td>
                <td @click="copyToClipboard(contact.email)" class="px-6 py-4 text-gray-700 dark:text-gray-300 cursor-pointer transition-all hover:text-green-600">
                  {{ contact.email }}
                </td>
                <td @click="copyToClipboard(contact.phone)" class="px-6 py-4 text-gray-700 dark:text-gray-300 cursor-pointer transition-all hover:text-green-600">
                  {{ contact.phone }}
                </td>
                <td @click="modal.openEditModal(contact.name, contact.email, contact.phone, contact.id)" class="px-6 py-4 text-gray-700 dark:text-gray-300 cursor-pointer transition-all hover:brightness-150">
                  <img src="../../img/edit.png" alt="Edit Icon" class="w-6 h-6 inline-block">
                </td>
                <td @click="confirmDelete(contact)" class="px-6 py-4 text-gray-700 dark:text-gray-300 cursor-pointer transition-all hover:brightness-150">
                  <img src="../../img/bin.png" alt="Delete Icon" class="w-6 h-6 inline-block">
                </td>
              </tr>
            </tbody>
          </table>

        </div>



        <div class="mt-6 flex justify-end gap-2">
          <button
            v-if="contacts.prev_page_url"
            @click="goTo(contacts.prev_page_url)"
            class="px-4 py-2 bg-slate-200 hover:bg-slate-300 dark:bg-blue-400 dark:hover:bg-blue-600 text-sm rounded-lg shadow transition"
          >
            Previous
          </button>
          <button
            v-if="contacts.next_page_url"
            @click="goTo(contacts.next_page_url)"
            class="px-4 py-2 bg-slate-200 hover:bg-slate-300 dark:bg-blue-400 dark:hover:bg-blue-600 text-sm rounded-lg shadow transition"
          >
            Next
          </button>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, defineProps } from 'vue'
import { Head, router as inertiaRouter } from '@inertiajs/vue3'
import { useContactsStore } from '../../stores/contact.js'
import AddContactModal from '../../components/AddContactModal.vue'
import EditContactModal from '../../components/EditContactModal.vue'
import DeleteContactModal from '../../components/DeleteContactModal.vue'
import debounce from 'lodash/debounce'

defineProps({ contacts: Object })

const modal = useContactsStore()
const searchQuery = ref('')
const contactsList = ref(null)

// GET FIRST LETTERS
const getFirstLetters = (name) => {
  return name.split(' ').map(word => word.charAt(0).toUpperCase()).join('')
}

const getRandomColor = () => {
  const randomIndex = Math.floor(Math.random() * tailwindColors.length)
  return tailwindColors[randomIndex]
}

const tailwindColors = [
  'bg-red-500',
  'bg-green-500',
  'bg-blue-500',
  'bg-yellow-500',
  'bg-purple-500',
  'bg-pink-500',
  'bg-indigo-500',
  'bg-teal-500',
  'bg-orange-500',
]


// HANDLE CONTACT DELETION
const showDeleteModal = ref(false)
const contactToDelete = ref(null)

function confirmDelete(contact) {
  contactToDelete.value = contact
  showDeleteModal.value = true
}

function deleteContactConfirmed() {
  if (contactToDelete.value) {
    modal.deleteContact(contactToDelete.value.id)
  }
  showDeleteModal.value = false
}

// HANDLE CONTACT PAGINATION
function goTo(url) {
  inertiaRouter.visit(url)
}


// HANDLE CONTACT SEARCH
let controller = null

watch(
  searchQuery,
  debounce(async (newQuery) => {
    if (controller) {
      controller.abort()
    }

    if (newQuery.trim() === '') {
      contactsList.value = null
      return
    }

    controller = new AbortController()

    const result = await modal.searchContact(newQuery, controller.signal)
    contactsList.value = result
  }, 300)
)

// HANDLE COPY TO CLIPBOARD FUNCTION
const copyToClipboard = (text) => {
  navigator.clipboard.writeText(text).then(() => {
    console.log('Text copied:', text)
  }).catch(err => {
    console.error('Error copying text:', err)
  })
}
</script>