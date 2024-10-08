<script setup>
import { ref, watch, computed } from 'vue';
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import { useCartStore } from '@/store/cart';
import { useProductStore } from '@/store/product';
import axios from 'axios';
import Swal from 'sweetalert2';

const props = defineProps({
  product: Object,
  isOpen: Boolean
});
const emit = defineEmits(['update:isOpen']);

const open = ref(props.isOpen);

// Watch for changes in props.isOpen and update local `open` state
watch(() => props.isOpen, (newVal) => {
  open.value = newVal;
  if (newVal) {
    quantity.value = 1;
  }
});

const close = () => {
  emit('update:isOpen', false);
};

const quantity = ref(1);
const productStore = useProductStore();

const availableQuantity = computed(() => {
  const product = productStore.getProductById(props.product.id);
  return product ? product.quantity : 0;
});

const incrementQuantity = () => {
  if (quantity.value < availableQuantity.value) {
    quantity.value++;
  } else {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Not enough stock available.',
      confirmButtonColor: '#d33',
      confirmButtonText: 'OK',
    });
  }
};

const decrementQuantity = () => {
  if (quantity.value > 1) {
    quantity.value--;
  }
};


const addToCart = () => {
  const cartStore = useCartStore();
  const productInStore = productStore.getProductById(props.product.id);

  if (productInStore && quantity.value <= productInStore.quantity) {
    for (let i = 0; i < quantity.value; i++) {
      cartStore.addToCart(props.product);
    }
    productStore.updateProductQuantity(props.product.id, productInStore.quantity - quantity.value);

    Swal.fire({
      icon: 'success',
      title: 'Added to Cart',
      text: `${props.product.name} has been added to your cart.`,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'OK',
    });

    close();
  } else {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Not enough stock available.',
      confirmButtonColor: '#d33',
      confirmButtonText: 'OK',
    });
  }
};

const addToCart1 = async (productId) => {
  try {
    await axios.patch(`/api/cart/${props.product.id}`, { productId });
    Swal.fire('Success', 'Order status updated successfully', 'success');
    close();
  }
  catch (error) {
    console.error('Error adding to cart:', error);
    Swal.fire('Error', 'Failed to add the product to the cart', 'error');
  }
}
</script>

<template>
  <TransitionRoot as="template" :show="open">
    <Dialog class="relative z-10" @close="close">
      <TransitionChild 
        as="template" 
        enter="ease-out duration-300" 
        enter-from="opacity-0" 
        enter-to="opacity-100" 
        leave="ease-in duration-200" 
        leave-from="opacity-100" 
        leave-to="opacity-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
      </TransitionChild>

      <div class="fixed inset-0 z-10 flex items-center justify-center p-4 overflow-y-auto">
        <TransitionChild 
          as="template" 
          enter="ease-out duration-300" 
          enter-from="opacity-0 translate-y-4 md:translate-y-0 md:scale-95" 
          enter-to="opacity-100 translate-y-0 md:scale-100" 
          leave="ease-in duration-200" 
          leave-from="opacity-100 translate-y-0 md:scale-100" 
          leave-to="opacity-0 translate-y-4 md:translate-y-0 md:scale-95">
          <DialogPanel class="w-full max-w-4xl bg-white text-left shadow-2xl rounded-lg">
            <div class="relative p-6">
              <button 
                type="button" 
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors"
                @click="close">
                <span class="sr-only">Close</span>
                <XMarkIcon class="h-6 w-6" aria-hidden="true" />
              </button>

              <div class="grid gap-6 sm:grid-cols-12 lg:gap-8">
                <div class="col-span-1 sm:col-span-4 lg:col-span-5 rounded-lg overflow-hidden bg-gray-100">
                  <img :src="product.imageSrc" :alt="product.imageAlt" class="object-cover object-center w-full h-full" />
                </div>
                <div class="col-span-1 sm:col-span-8 lg:col-span-7">
                  <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ product.name }}</h2>
                  <section aria-labelledby="information-heading" class="mt-2">
                    <h3 id="information-heading" class="sr-only">Product information</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ 'SAR ' + product.price }}</p>
                    <div class="mt-4">
                      <p class="text-gray-700">Quantity</p>
                      <div class="flex items-center mt-2">
                        <button @click="decrementQuantity" class="px-4 py-2 bg-gray-200 text-gray-700 font-bold rounded-l-lg">-</button>
                        <span class="px-4 py-2 bg-gray-100 text-gray-900">{{ quantity }}</span>
                        <button @click="incrementQuantity" class="px-4 py-2 bg-gray-200 text-gray-700 font-bold rounded-r-lg">+</button>
                      </div>
                      <p v-if="availableQuantity < 5" class="text-red-500 mt-2">Only {{ availableQuantity }} left in stock!</p>
                    </div>
                  </section>
                </div>
              </div>
              <button 
                @click="addToCart1()" 
                class="mt-6 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-colors">
                Add to Cart
              </button>
            </div>
          </DialogPanel>
        </TransitionChild>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
