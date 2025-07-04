import { defineStore } from 'pinia'
import axios from 'axios'
import { router } from '@inertiajs/vue3'

export const useContactsStore = defineStore('contacts', {
  state: () => ({
    showModal: false,
    showEditModal: false,
    form: {
      name: '',
      email: '',
      phone: '',
      id: null
    },
  }),
  actions: {
    async createContact(form) {
      try {
        const response = await axios.post('/contacts', form)
        console.log('Contact created:', response.data)
        this.showModal = false

        router.visit('/contacts', {
          only: ['contacts'],
          preserveScroll: true,
          preserveState: true,
        })
        
      } catch (error) {
        console.error('Error creating contact:', error.response?.data)
        alert('Please check the form for errors. If the email is already registered, you will not be able to create a new contact with that email.')
      }
    },
    async searchContact(query, signal) {
      try {
        const response = await axios.post('/contacts/search', { query }, { signal })
        return response.data
      } catch (error) {
        if (axios.isCancel(error)) {
          console.warn('Search request canceled')
        } else {
          console.error('Error searching contacts:', error.response?.data)
        }
      }
    },
    async deleteContact(contact_id) {
      try {
        const response = await axios.delete(`/contacts/${contact_id}`)
        console.log('Contact deleted:', response.data)

        router.visit('/contacts', {
          only: ['contacts'],
          preserveScroll: true,
          preserveState: true,
        })
      } catch (error) {
        console.error('Error deleting contact:', error.response?.data)
      }
    },
    async editContact(contact_id, form) {
      try {
        const response = await axios.put(`/contacts/${contact_id}`, form)
        console.log('Contact edited:', response.data)

        router.visit('/contacts', {
          only: ['contacts'],
          preserveScroll: true,
          preserveState: true,
        })
      this.showEditModal = false
      } catch (error) {
        console.error('Error editing contact:', error.response?.data)
      }
    },

    openEditModal(contact_name, contact_email, contact_phone, contact_id) {

      this.showEditModal = true

      this.form = {
        name: contact_name,
        email: contact_email,
        phone: contact_phone,
        id: contact_id,
      }

    },
    closeEditModal() {

      this.showEditModal = false

      this.form = {}

    },

    toggleModal() {
      this.showModal = !this.showModal
    },

},
})
