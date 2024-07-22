<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import { useProductStore } from '@/store/product';

const productStore = useProductStore();
const open = ref(false);

const toggleModal = () => {
  open.value = !open.value;
};

const form = ref({
  name: '',
  description: '',
  price: '',
  quantity: '',
  image: null
});

const handleImageUpload = (event) => {
  form.value.image = event.target.files[0];
};

const submitForm = () => {
  // Create a new product object
  const newProduct = {
    id: productStore.products.length + 1, // Incremental ID
    name: form.value.name,
    href: '#',
    imageSrc: form.value.image ? URL.createObjectURL(form.value.image) : '', // Use object URL for image
    imageAlt: `Front of ${form.value.name}`,
    price: form.value.price,
    color: '', // Placeholder if you have color information
    quantity: form.value.quantity,
  };

  // Add the new product to the store
  productStore.products.push(newProduct);
  
  // Optionally, clear the form
  form.value = {
    name: '',
    description: '',
    price: '',
    quantity: '',
    image: null
  };

  // Close the modal
  toggleModal();
};
</script>

<template>
  <div>
    <button @click="toggleModal" class="mb-4 px-4 py-2 bg-blue-500 text-white rounded font-medium hover:bg-gray-500 transition-colors delay-300">
      Add Product
    </button>

    <!-- Popup Modal -->
    <TransitionRoot as="template" :show="open">
      <Dialog class="fixed inset-0 z-10 overflow-y-auto" @close="open = false">
        <div class="flex items-center justify-center min-h-screen">
          <TransitionChild
            as="template"
            enter="ease-out duration-300"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="ease-in duration-200"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <DialogPanel class="bg-green-100 rounded-lg p-6 shadow-xl">
              <button type="button" class="relative -m-2 p-2 text-gray-400 hover:text-gray-500" @click="open = false">
                <span class="absolute -inset-0.5" />
                <span class="sr-only">Close panel</span>
                <XMarkIcon class="h-6 w-6" aria-hidden="true" />
              </button>
              <h1 class="text-2xl font-bold mb-6 text-center">Create Product</h1>

              <form @submit.prevent="submitForm" class="space-y-4">
                <div>
                  <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                  <input type="text" id="name" v-model="form.name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                  <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
                  <textarea id="description" v-model="form.description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>
                <div>
                  <label for="price" class="block text-sm font-medium text-gray-700">Price:</label>
                  <input type="text" id="price" v-model="form.price" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                  <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity:</label>
                  <input type="text" id="quantity" v-model="form.quantity" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                  <label for="image" class="block text-sm font-medium text-gray-700">Image:</label>
                  <input type="file" id="image" @change="handleImageUpload" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors duration-300">
                </div>
                <button type="submit" class="w-full mt-4 px-4 py-2 bg-blue-500 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 hover:bg-blue-600 transition-colors duration-300">
                  Create Product
                </button>
              </form>
            </DialogPanel>
          </TransitionChild>
        </div>
      </Dialog>
    </TransitionRoot>
  </div>
</template>


<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter, 
.fade-leave-to {
  opacity: 0;
}
</style>
