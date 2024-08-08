<script setup>
  import { ref, computed } from 'vue';
  import { useProductStore } from '@/store/product';
  import { XMarkIcon } from '@heroicons/vue/24/outline';
  import ConfirmationDialog from '@/Components/ConfirmationDialog.vue';
  import ProductCard from '@/Components/ProductCard.vue';
  import CreateProduct from '@/Components/CreateProduct.vue';
  import Cart from '@/Components/Cart.vue';
  import SearchBar from '@/Components/SearchBar.vue';

  const productStore = useProductStore();
  const selectedProduct = ref(null);
  const showDetails = ref(false);
  const showConfirmationDialog = ref(false);
  const searchQuery = ref('');
  
  const isAdmin = computed(() => {
    return window.$page.props.auth?.user?.role === 'admin';
  });

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

const filteredProducts = computed(() => {
  if (!searchQuery.value) {
    return productStore.products;
  }
  return productStore.products.filter(product =>
    product.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});
  </script>

<template>
    <div class="bg-white">
      <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <SearchBar v-model:searchQuery="searchQuery" />
        <h2 class="text-2xl font-bold tracking-tight text-green-900">Our Products</h2>
        <CreateProduct v-if="isAdmin" />
        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
          <div v-for="product in (searchQuery ? filteredProducts : productStore.products)" :key="product.id" class="group relative">
            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-green-200 lg:aspect-none lg:h-80">
              <img :src="product.imageSrc" :alt="product.imageAlt" class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
            </div>
            <div class="mt-4 flex justify-between">
              <div>
                <h3 class="text-sm text-green-700">
                    {{ product.name }}
                </h3>
                <p class="mt-1 text-sm text-green-500">{{ product.color }}</p>
              </div>
              <p class="text-sm font-medium text-green-900">{{ 'SAR ' + product.price }}</p>
            </div>
            <button 
              @click="viewProductDetails(product)" 
              class="mb-4 px-4 py-2 bg-green-500 text-white rounded font-medium hover:bg-green-600 transition-colors delay-300">
              View Product
            </button>
            <button
              v-if="isAdmin" 
              @click="confirmRemoveProduct(product)" 
              class="mb-4 absolute px-12 py-2 text-red-500  font-medium hover:text-red-700 transition-colors delay-300">
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
  