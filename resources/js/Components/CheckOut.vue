<script setup>
import { ref, defineEmits } from 'vue';
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import { useCartStore } from '@/store/cart';

const cartStore = useCartStore();
const emit = defineEmits(['checkout']);
const open = ref(false);

const toggleModal = () => {
  open.value = !open.value;
};

const form = ref({
  name: '',
  email: '',
  address: '',
  city: '',
  state: '',
  zip: '',
  cardNumber: '',
  expiryDate: '',
  cvv: ''
});

const submitForm = () => {
  console.log('Form submitted:', form.value);

  form.value = {
    name: '',
    email: '',
    address: '',
    city: '',
    state: '',
    zip: '',
    cardNumber: '',
    expiryDate: '',
    cvv: ''
  };
};

const handleCheckout = () => {
    emit('checkout');
    open.value = !open.value;
  };
</script>

<template>
    <div>
      <button @click="handleCheckout" class="px-4 py-2 bg-green-500 text-white rounded font-medium hover:bg-green-600 transition-colors duration-300">
        Checkout
      </button>
  
      <!-- Popup Modal -->
      <TransitionRoot as="template" :show="open">
        <Dialog class="fixed inset-0 z-10 overflow-y-auto" @close="open = false">
          <div class="flex items-center justify-center min-h-screen p-4">
            <TransitionChild
              as="template"
              enter="ease-in-out duration-300"
              enter-from="opacity-0 scale-95"
              enter-to="opacity-100 scale-100"
              leave="ease-in duration-200"
              leave-from="opacity-100 scale-100"
              leave-to="opacity-0 scale-95"
            >
              <DialogPanel class="bg-white rounded-lg p-6 shadow-xl w-full max-w-md">
                <button type="button" class="absolute top-4 right-4 p-2 text-green-400 hover:text-green-500" @click="open = false">
                  <span class="sr-only">Close panel</span>
                  <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                </button>
                <h1 class="text-2xl font-bold mb-6 text-center">Checkout</h1>
  
                <form @submit.prevent="submitForm" class="space-y-4">
                  <div>
                    <label for="name" class="block text-sm font-medium text-green-700">Full Name:</label>
                    <input type="text" id="name" v-model="form.name" required class="mt-1 block w-full px-3 py-2 border border-green-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                  </div>
                  <div>
                    <label for="email" class="block text-sm font-medium text-green-700">Email Address:</label>
                    <input type="email" id="email" v-model="form.email" required class="mt-1 block w-full px-3 py-2 border border-green-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                  </div>
                  <div>
                    <label for="address" class="block text-sm font-medium text-green-700">Address:</label>
                    <input type="text" id="address" v-model="form.address" required class="mt-1 block w-full px-3 py-2 border border-green-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                  </div>
                  <div>
                    <label for="city" class="block text-sm font-medium text-green-700">City:</label>
                    <input type="text" id="city" v-model="form.city" required class="mt-1 block w-full px-3 py-2 border border-green-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                  </div>
                  <div>
                    <label for="state" class="block text-sm font-medium text-green-700">State:</label>
                    <input type="text" id="state" v-model="form.state" required class="mt-1 block w-full px-3 py-2 border border-green-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                  </div>
                  <div>
                    <label for="zip" class="block text-sm font-medium text-green-700">Zip Code:</label>
                    <input type="text" id="zip" v-model="form.zip" required class="mt-1 block w-full px-3 py-2 border border-green-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                  </div>
                  <div>
                    <label for="cardNumber" class="block text-sm font-medium text-green-700">Card Number:</label>
                    <input type="text" id="cardNumber" v-model="form.cardNumber" required class="mt-1 block w-full px-3 py-2 border border-green-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                  </div>
                  <div>
                    <label for="expiryDate" class="block text-sm font-medium text-green-700">Expiry Date (MM/YY):</label>
                    <input type="text" id="expiryDate" v-model="form.expiryDate" required class="mt-1 block w-full px-3 py-2 border border-green-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                  </div>
                  <div>
                    <label for="cvv" class="block text-sm font-medium text-green-700">CVV:</label>
                    <input type="text" id="cvv" v-model="form.cvv" required class="mt-1 block w-full px-3 py-2 border border-green-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                  </div>
                  <button type="submit" class="w-full mt-4 px-4 py-2 bg-green-500 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 hover:bg-green-600 transition-colors duration-300">
                    Complete Purchase
                  </button>
                </form>
              </DialogPanel>
            </TransitionChild>
          </div>
        </Dialog>
      </TransitionRoot>
    </div>
  </template>
  
  <style scoped>
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.3s ease;
  }
  .fade-enter, 
  .fade-leave-to {
    opacity: 0;
  }
  </style>
  