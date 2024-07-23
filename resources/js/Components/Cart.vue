<script setup>
import { ref } from 'vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import { useCartStore } from '@/store/cart';
import CheckOut from '@/Components/CheckOut.vue';


const cartStore = useCartStore();
const open = ref(false); 
const showCheckoutModal = ref(false);

const toggleModal = () => {
  open.value = !open.value;
};

const handleCheckout = () => {
  showCheckoutModal.value = true;
  
};
</script>

<template>
  <div>
    <!-- Shopping Cart Button -->
    <button @click="toggleModal" class="fixed bottom-4 right-4 p-3 bg-green-100 text-black rounded-full shadow-lg hover:bg-green-300 transition-colors delay-300">
        <svg class="h-8 w-8 transition-transform hover:rotate-180 duration-300" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
            viewBox="0 0 512.001 512.001" fill="none" xml:space="preserve">
            <polygon style="fill:#CFF09E;" points="146.858,390.654 451.109,390.654 479.051,232.428 118.916,232.428 "/>
            <path style="fill:#507C5C;" d="M508.441,122.223c-2.891-3.446-7.159-5.436-11.657-5.436h-70.498c-8.404,0-15.215,6.812-15.215,15.215c0,8.403,6.812,15.215,15.215,15.215h52.361l-12.361,69.996H131.681l-12.361-69.996h222.774c8.404,0,15.215-6.812,15.215-15.215s-6.812-15.215-15.215-15.215H113.481L94.327,15.065C92.973,7.874,86.692,2.666,79.374,2.666H15.215C6.812,2.666,0,9.478,0,17.881s6.812,15.215,15.215,15.215h51.541l65.118,360.205c1.284,7.27,7.602,12.569,14.984,12.569h66.943c20.135,0,36.517,16.382,36.517,36.517s-16.382,36.517-36.517,36.517s-36.517-16.382-36.517-36.517c0-8.404-6.812-15.215-15.215-15.215c-8.403,0-15.215,6.812-15.215,15.215c0,36.916,30.032,66.948,66.948,66.948s66.948-30.032,66.948-66.948c0-13.466-4.011-26.006-10.879-36.517h114.791c20.135,0,36.517,16.382,36.517,36.517s-16.382,36.517-36.517,36.517s-36.517-16.382-36.517-36.517c0-8.404-6.812-15.215-15.215-15.215s-15.215,6.812-15.215,15.215c0,36.916,30.032,66.948,66.948,66.948s66.948-30.032,66.948-66.948c0-13.466-4.011-26.006-10.879-36.517h10.38c7.383,0,13.7-5.3,14.984-12.569l27.942-158.227l17.734-100.427C512.551,130.218,511.332,125.669,508.441,122.223z M438.345,375.44H159.622l-22.568-127.796h323.859L438.345,375.44z"/>
        </svg>
    </button>

    <!-- Popup Modal -->
    <TransitionRoot as="template" :show="open">
      <Dialog class="relative z-10" @close="showCheckoutModal = false">
        <TransitionChild as="template" enter="ease-in-out duration-500" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-500" leave-from="opacity-100" leave-to="opacity-0">
          <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
        </TransitionChild>

        <div class="fixed inset-0 overflow-hidden">
          <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
              <TransitionChild as="template" enter="transform transition ease-in-out duration-500 sm:duration-700" enter-from="translate-x-full" enter-to="translate-x-0" leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0" leave-to="translate-x-full">
                <DialogPanel class="pointer-events-auto w-screen max-w-md">
                  <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                    <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                      <div class="flex items-start justify-between">
                        <DialogTitle class="text-lg font-medium text-green-900">Shopping Cart</DialogTitle>
                        <div class="ml-3 flex h-7 items-center">
                          <button type="button" class="relative -m-2 p-2 text-green-400 hover:text-green-500" @click="open = false">
                            <span class="absolute -inset-0.5" />
                            <span class="sr-only">Close panel</span>
                            <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                          </button>
                        </div>
                      </div>

                      <div class="mt-8">
                        <div class="flow-root">
                          <ul role="list" class="-my-6 divide-y divide-green-200">
                            <li v-for="product in cartStore.cartItems" :key="product.id" class="flex py-6">
                              <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-green-200">
                                <img :src="product.imageSrc" :alt="product.imageAlt" class="h-full w-full object-cover object-center" />
                              </div>

                              <div class="ml-4 flex flex-1 flex-col">
                                <div>
                                  <div class="flex justify-between text-base font-medium text-green-900">
                                    <h3>
                                      <a :href="product.href">{{ product.name }}</a>
                                    </h3>
                                    <p class="ml-4">{{ '$' + (product.price * product.quantity).toFixed(2) }}</p>
                                  </div>
                                  <p class="mt-1 text-sm text-green-500">{{ product.color }}</p>
                                </div>
                                <div class="flex flex-1 items-end justify-between text-sm">
                                  <p class="text-green-500">Qty {{ product.quantity }}</p>
                                  <button @click="cartStore.incrementQuantity(product.id)" class="mt-2 px-4 py-2 bg-green-500 hover:bg-green-700 transition-colors delay-300 text-white rounded">+</button>
                                  <button @click="cartStore.decrementQuantity(product.id)" class="mt-2 px-4 py-2 bg-green-500 hover:bg-green-700 transition-colors delay-300 text-white rounded">-</button>
                                  <div class="flex">
                                    <button type="button" class="font-medium text-lime-600 hover:text-lime-500" @click="cartStore.removeProduct(product.id)">Remove</button>
                                  </div>
                                </div>
                              </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>

                    <div class="border-t border-green-200 px-4 py-6 sm:px-6">
                      <div class="flex justify-between text-base font-medium text-green-900">
                        <p>Subtotal</p>
                        <p class="text-green-700">{{ '$' + cartStore.totalPrice.toFixed(2) }}</p>
                      </div>
                      <p class="mt-0.5 text-sm text-green-500">Shipping and taxes calculated at checkout.</p>
                      <div class="mt-6 flex justify-center">
                        <CheckOut
                          @checkout="handleCheckout"
                          :showModal="showCheckoutModal"
                          @close="showCheckoutModal = false"
                        />
                      </div>
                      <div class="mt-6 flex justify-center text-center text-sm text-green-500">
                        <p>
                          or{{ ' ' }}
                          <button id="close" type="button" class="font-medium text-green-600 hover:text-green-500" @click="open = false">
                              Continue Shopping
                            <span aria-hidden="true"> &rarr;</span>
                          </button>
                        </p>
                      </div>
                    </div>
                  </div>
                </DialogPanel>
              </TransitionChild>
            </div>
          </div>
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
