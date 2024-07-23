<script setup>
  import { ref, computed } from 'vue';
  import { useProductStore } from '@/store/product';
  
  const emit = defineEmits(['update:searchQuery']);
  const searchQuery = ref('');
  const showSuggestions = ref(false);
  const productStore = useProductStore();
  
  const onInput = () => {
    emit('update:searchQuery', searchQuery.value);
  };
  
  const hideSuggestions = () => {
    setTimeout(() => {
      showSuggestions.value = false;
    }, 200);
  };
  
  const selectSuggestion = (product) => {
    searchQuery.value = product.name;
    emit('update:searchQuery', product.name);
    showSuggestions.value = false;
  };
  
  const filteredProducts = computed(() => {
    if (!searchQuery.value) return [];
    return productStore.products.filter((product) =>
      product.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  });
</script>

<template>
    <div class="relative flex justify-center mb-4">
      <div class="relative flex group">
        <input
          v-model="searchQuery"
          @input="onInput"
          @focus="showSuggestions = true"
          @blur="hideSuggestions"
          type="text"
          placeholder="Search..."
          class="search-input flex w-10 h-10 pl-10 pr-3 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-green-500 transition-all duration-300 ease-in-out hover:bg-green-200 hover:border-green-400 hover:shadow-lg"
        />
        <div class="absolute inset-y-0 left-1 flex items-center pl-3 pointer-events-none">
          <svg
            class="absolute left-3 top-1/2 transform -translate-y-1/2 w-6 h-6 text-gray-500"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
            ></path>
          </svg>
        </div>
        <ul
          v-if="showSuggestions && filteredProducts.length"
          class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg"
        >
          <li
            v-for="product in filteredProducts"
            :key="product.id"
            class="px-4 py-2 text-gray-700 hover:bg-green-100 cursor-pointer"
            @mousedown.prevent="selectSuggestion(product)"
          >
            {{ product.name }}
          </li>
        </ul>
      </div>
    </div>
</template>

<style scoped>
.search-input {
    width: 2.5rem;
    transition: background-color 0.3s ease-in-out, border-color 0.3s ease-in-out;
  }
  .search-input:hover,
  .search-input:focus {
    background-color: #f0f0f0;
    border-color: #a0a0a0;
    width: 100%; 
  }
</style>
