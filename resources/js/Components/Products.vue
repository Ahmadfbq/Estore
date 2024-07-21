<script setup>
  import { ref, onMounted } from 'vue';
  import { Link } from '@inertiajs/vue3';
  import { usePage } from '@inertiajs/inertia-vue3';
  import { useCartStore } from '@/store/cart';
  import ProductCard from '@/Components/ProductCard.vue';
  import Cart from '@/Components/Cart.vue';
  
  


  const products = ref([
    {
      id: 1,
      name: 'Basic Tee',
      href: '#',
      imageSrc: 'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg',
      imageAlt: "Front of men's Basic Tee in black.",
      price: 35,
      color: 'Black',
      quantity: 0,
    },
    {
      id: 2,
      name: 'Basic Tee',
      href: '#',
      imageSrc: 'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-02.jpg',
      imageAlt: "Front of men's Basic Tee in black.",
      price: 35,
      color: 'White',
      quantity: 0,
    },
    {
      id: 3,
      name: 'Basic Tee',
      href: '#',
      imageSrc: 'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-03.jpg',
      imageAlt: "Front of men's Basic Tee in black.",
      price: 35,
      color: 'Gray',
      quantity: 0,
    },
    {
      id: 4,
      name: 'Water Bottel',
      href: '#',
      imageSrc: 'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-02.jpg',
      imageAlt: "Front of men's Basic Tee in black.",
      price: 35,
      color: 'Green',
      quantity: 0,
    },
    {
      id: 5,
      name: 'Female T-Shirt',
      href: '#',
      imageSrc: 'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-04.jpg',
      imageAlt: "Front of men's Basic Tee in black.",
      price: 35,
      color: 'Pink',
      quantity: 0,
    },
    {
      id: 6,
      name: 'Weired Bottel',
      href: '#',
      imageSrc: 'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-01.jpg',
      imageAlt: "Front of men's Basic Tee in black.",
      price: 35,
      color: 'Navy',
      quantity: 0,
    },
    {
      id: 7,
      name: 'Walet',
      href: '#',
      imageSrc: 'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-08.jpg',
      imageAlt: "Front of men's Basic Tee in black.",
      price: 35,
      color: 'Gray',
      quantity: 0,
    },
    {
      id: 8,
      name: 'Throwback Hip Bag',
      href: '#',
      imageSrc: 'https://tailwindui.com/img/ecommerce-images/shopping-cart-page-04-product-01.jpg',
      imageAlt: 'Salmon orange fabric pouch with match zipper, gray zipper pull, and adjustable hip belt.',
      price: 90,
      color: 'Salmon',
      quantity: 0,
    },
    {
      id: 9,
      name: 'Medium Stuff Satchel',
      href: '#',
      imageSrc: 'https://tailwindui.com/img/ecommerce-images/shopping-cart-page-04-product-02.jpg',
      imageAlt: 'Front of satchel with blue canvas body, black straps and handle, drawstring top, and front zipper pouch.',
      price: 30,
      color: 'Blue',
      quantity: 0,
    },
  ]);

  const loading = ref(false);
  const error = ref(null);
  const selectedProduct = ref(null);
  const showDetails = ref(false);

  const viewProductDetails = (product) => {
    selectedProduct.value = product;
    showDetails.value = true;
  };

  const cartStore = useCartStore();
  </script>

<template>
    <div class="bg-white">
      <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">Our Products</h2>
        <button type="button" class="mb-4 px-4 py-2 bg-blue-500 text-white rounded font-medium hover:bg-gray-500 transition-colors delay-300">
          <Link :href="route('createproduct')">
            Add Product
          </Link>
        </button>
        <div v-if="loading" class="mt-4 text-blue-500">Loading...</div>
        <div v-if="error" class="mt-4 text-red-500">Error: {{ error }}</div>
        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
          <div v-for="product in products" :key="product.id" class="group relative">
            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none lg:h-80">
              <img :src="product.imageSrc" :alt="product.imageAlt" class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
            </div>
            <div class="mt-4 flex justify-between">
              <div>
                <h3 class="text-sm text-gray-700">
                  <a :href="product.href">
                    <!-- <span aria-hidden="true" class="absolute inset-0" /> -->
                    {{ product.name }}
                  </a>
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
          </div>
        </div>
      </div>

      <!-- Product Detail Modal -->
    <ProductCard :product="selectedProduct" :isOpen="showDetails" @update:isOpen="showDetails = $event" />

     <!-- Shopping Cart Modal Component -->
     <Cart />
    </div>
  </template>
  