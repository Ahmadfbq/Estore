<script setup>
  import { ref } from 'vue';
  import { Link } from '@inertiajs/vue3';
  import { useProductStore } from '@/store/product';
  import ConfirmationDialog from '@/Components/ConfirmationDialog.vue';
  import { XMarkIcon } from '@heroicons/vue/24/outline';
  import ProductCard from '@/Components/ProductCard.vue';
  import CreateProduct from '@/Components/CreateProduct.vue';
  import Cart from '@/Components/Cart.vue';


  const productStore = useProductStore();

  const loading = ref(false);
  const error = ref(null);
  const selectedProduct = ref(null);
  const showDetails = ref(false);
  const showConfirmationDialog = ref(false);

  const viewProductDetails = (product) => {
    selectedProduct.value = product;
    showDetails.value = true;
  };
  
  const confirmRemoveProduct = (product) => {
  selectedProduct.value = product;
  showConfirmationDialog.value = true;
};

const removeProduct = () => {
  if (selectedProduct.value) {
    productStore.products = productStore.products.filter(product => product.id !== selectedProduct.value.id);
    showConfirmationDialog.value = false;
    selectedProduct.value = null; // Clear selection after removal
  }
};
  </script>

<template>
    <div class="bg-white">
      <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">Our Products</h2>
        <CreateProduct />
        <div v-if="loading" class="mt-4 text-blue-500">Loading...</div>
        <div v-if="error" class="mt-4 text-red-500">Error: {{ error }}</div>
        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
          <div v-for="product in productStore.products" :key="product.id" class="group relative">
            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none lg:h-80">
              <img :src="product.imageSrc" :alt="product.imageAlt" class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
            </div>
            <div class="mt-4 flex justify-between">
              <div>
                <h3 class="text-sm text-gray-700">
                    {{ product.name }}
                </h3>
                <p class="mt-1 text-sm text-gray-500">{{ product.color }}</p>
              </div>
              <p class="text-sm font-medium text-gray-900">{{ '$' + product.price }}</p>
            </div>
            <button 
              @click="viewProductDetails(product)" 
              class="mb-4 px-4 py-2 bg-blue-500 text-white rounded font-medium hover:bg-blue-600 transition-colors delay-300">
              View Product
            </button>
            <button 
              @click="confirmRemoveProduct(product)" 
              class="mb-4 absolute px-12 py-2 text-red-500  font-medium hover:rotate-90 transition-transform delay-300">
              <span class="sr-only">Close panel</span>
              <XMarkIcon class="h-6 w-6" aria-hidden="true" />
            </button>
          </div>
        </div>
      </div>

      <!-- Product Detail Modal -->
    <ProductCard :product="selectedProduct" :isOpen="showDetails" @update:isOpen="showDetails = $event" />

     <!-- Shopping Cart Modal Component -->
     <Cart />
     
     <!-- Pupop for confirming the removal of the product -->
     <ConfirmationDialog
        :open="showConfirmationDialog"
        @confirm="removeProduct"
        @close="showConfirmationDialog = false"
      />

    </div>
  </template>
  