<script setup>
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import { useCartStore } from '@/store/cart';
import CheckOut from '@/Components/CheckOut.vue';
import { useModalStore } from '@/store/modal';


const cartStore = useCartStore();
const modalStore = useModalStore();
</script>

<template>
  <div>
    <!-- Shopping Cart Button -->
    <button @click="modalStore.toggleCart" class="fixed bottom-4 right-4 p-3 bg-green-100 text-black rounded-full shadow-lg hover:bg-green-300 transition-colors delay-300">
        <svg class="h-8 w-8 transition-transform hover:rotate-180 duration-300" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
            viewBox="0 0 512.001 512.001" fill="none" xml:space="preserve">
            <polygon style="fill:#CFF09E;" points="146.858,390.654 451.109,390.654 479.051,232.428 118.916,232.428 "/>
            <path style="fill:#507C5C;" d="M508.441,122.223c-2.891-3.446-7.159-5.436-11.657-5.436h-70.498c-8.404,0-15.215,6.812-15.215,15.215c0,8.403,6.812,15.215,15.215,15.215h52.361l-12.361,69.996H131.681l-12.361-69.996h222.774c8.404,0,15.215-6.812,15.215-15.215s-6.812-15.215-15.215-15.215H113.481L94.327,15.065C92.973,7.874,86.692,2.666,79.374,2.666H15.215C6.812,2.666,0,9.478,0,17.881s6.812,15.215,15.215,15.215h51.541l65.118,360.205c1.284,7.27,7.602,12.569,14.984,12.569h66.943c20.135,0,36.517,16.382,36.517,36.517s-16.382,36.517-36.517,36.517s-36.517-16.382-36.517-36.517c0-8.404-6.812-15.215-15.215-15.215c-8.403,0-15.215,6.812-15.215,15.215c0,36.916,30.032,66.948,66.948,66.948s66.948-30.032,66.948-66.948c0-13.466-4.011-26.006-10.879-36.517h114.791c20.135,0,36.517,16.382,36.517,36.517s-16.382,36.517-36.517,36.517s-36.517-16.382-36.517-36.517c0-8.404-6.812-15.215-15.215-15.215s-15.215,6.812-15.215,15.215c0,36.916,30.032,66.948,66.948,66.948s66.948-30.032,66.948-66.948c0-13.466-4.011-26.006-10.879-36.517h10.38c7.383,0,13.7-5.3,14.984-12.569l27.942-158.227l17.734-100.427C512.551,130.218,511.332,125.669,508.441,122.223z M438.345,375.44H159.622l-22.568-127.796h323.859L438.345,375.44z"/>
        </svg>
    </button>

    <!-- Popup Modal -->
    <TransitionRoot as="template" :show="modalStore.cartOpen">
      <Dialog class="relative z-10" @close="modalStore.cartOpen = false">
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
                          <button type="button" class="relative -m-2 p-2 text-green-400 hover:text-green-500" @click="modalStore.cartOpen = false">
                            <span class="absolute -inset-0.5" />
                            <span class="sr-only">Close panel</span>
                            <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                          </button>
                        </div>
                      </div>

                      <div v-if="cartStore.totalItems > 0" class="mt-8">
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
                                    <p class="ml-4">{{ 'SAR ' + (product.price * product.quantity).toFixed(2) }}</p>
                                  </div>
                                  <p class="mt-1 text-sm text-green-500">{{ product.color }}</p>
                                </div>
                                <div class="flex flex-1 items-end justify-between text-sm">
                                  <p class="text-green-500">Qty {{ product.quantity }}</p>
                                  <button @click="cartStore.incrementQuantity(product.id)" class="mt-2 px-4 py-2 bg-green-500 hover:bg-green-700 transition-colors delay-300 text-white rounded">+</button>
                                  <button v-if="product.quantity > 1" @click="cartStore.decrementQuantity(product.id)" class="mt-2 px-4 py-2 bg-green-500 hover:bg-green-700 transition-colors delay-300 text-white rounded">-</button>
                                  <button 
                                    v-else 
                                    @click="cartStore.removeProduct(product.id)" 
                                    class="mt-2 px-2 py-2 bg-red-500 hover:bg-red-700 transition-colors delay-300 text-white rounded flex items-center justify-center">
                                    <svg height="20px" width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 511.998 511.998" xml:space="preserve" fill="#000000">
                                      <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                      <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                      <g id="SVGRepo_iconCarrier"> 
                                          <polygon style="fill:#8c8c8c;" points="178.652,462.067 110.276,462.067 82.918,106.177 178.652,106.177"></polygon> 
                                          <path style="fill:#535050;" d="M311.198,70.475c-8.484,0-15.365-6.88-15.365-15.365V30.73H189.232V55.11 c0,8.484-6.88,15.365-15.365,15.365s-15.365-6.88-15.365-15.365V15.365C158.503,6.88,165.383,0,173.867,0h137.331 c8.484,0,15.365,6.88,15.365,15.365V55.11C326.563,63.596,319.684,70.475,311.198,70.475z"></path> 
                                          <path style="fill:#8c8c8c;" d="M380.052,319.948l16.391-213.769H300.71v267.369C313.965,342.592,344.435,320.72,380.052,319.948z"></path> 
                                          <g> 
                                              <path style="fill:#535050;" d="M470.304,392.923c-8.484,0-15.365,6.88-15.365,15.365c0,40.242-32.741,72.983-72.983,72.983 c-40.243,0-72.984-32.741-72.984-72.983c0-34.479,24.522-63.845,57.028-71.208c0.011-0.002,0.02-0.005,0.031-0.006 c2.303-0.521,4.645-0.93,7.022-1.223c0.048-0.006,0.095-0.011,0.143-0.017c1.119-0.135,2.245-0.244,3.377-0.329 c0.081-0.006,0.164-0.014,0.246-0.018c1.183-0.083,2.374-0.14,3.571-0.166c8.077-0.171,14.554-6.544,15.005-14.475l15.282-199.302 h26.991c8.484,0,15.365-6.88,15.365-15.365s-6.88-15.365-15.365-15.365h-41.224h-95.735H178.652H82.918H41.695 c-8.484,0-15.365,6.88-15.365,15.365s6.88,15.365,15.365,15.365h26.994l26.268,341.704c0.615,8.005,7.291,14.186,15.32,14.186 h68.376h47.866c8.484,0,15.365-6.88,15.365-15.365c0-8.484-6.88-15.365-15.365-15.365h-32.501V121.542h91.327v248.965 c-4.648,11.891-7.103,24.653-7.103,37.779c0,57.188,46.526,103.712,103.714,103.712s103.712-46.525,103.712-103.712 C485.669,399.802,478.788,392.923,470.304,392.923z M316.075,121.542h63.782l-14.131,184.302c-0.069,0.011-0.137,0.026-0.206,0.035 c-0.931,0.147-1.856,0.32-2.781,0.492c-0.273,0.052-0.545,0.103-0.817,0.158c-16.835,3.283-32.529,10.675-45.846,21.666V121.542 H316.075z M163.287,446.703h-38.782L99.509,121.542h63.779v325.161H163.287z"></path> 
                                              <path style="fill:#535050;" d="M403.685,408.297l7.968-7.968c6-6,6-15.729,0-21.73c-6.001-5.998-15.727-5.998-21.73,0l-7.968,7.968 l-7.968-7.968c-5.998-5.995-15.724-5.998-21.73,0c-6,6-6,15.729,0,21.73l7.968,7.968l-7.968,7.968c-6,6-6,15.729,0,21.73 c3.001,2.999,6.933,4.5,10.864,4.5c3.932,0,7.864-1.501,10.864-4.5l7.968-7.968l7.968,7.968c3.001,2.999,6.933,4.5,10.864,4.5 c3.932,0,7.864-1.501,10.864-4.5c6-6,6-15.729,0-21.73L403.685,408.297z"></path> 
                                          </g> 
                                      </g>
                                  </svg>                                  
                                  </button>
                                  <div class="flex">
                                    <button type="button" class="font-medium text-lime-600 hover:text-lime-500" @click="cartStore.removeProduct(product.id)">Remove</button>
                                  </div>
                                </div>
                              </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div v-else class="flex flex-col items-center justify-center p-6 text-center bg-gray-100 rounded-lg">
                        <p class="text-lg font-semibold text-gray-700">Your cart is empty</p>
                        <p class="mt-2 text-sm text-gray-500">It looks like you haven't added any items to your cart yet.</p>
                        <button @click="modalStore.cartOpen = false" class="mt-4 px-4 py-2 bg-indigo-500 text-white font-medium rounded hover:bg-indigo-600 transition-colors">
                          Continue Shopping
                        </button>
                      </div>                      
                    </div>

                    <div v-if="cartStore.totalItems > 0" class="border-t border-green-200 px-4 py-6 sm:px-6">
                      <div class="flex justify-between text-base font-medium text-green-900">
                        <p>Subtotal</p>
                        <p class="text-green-700">{{ 'SAR ' + cartStore.totalPrice.toFixed(2) }}</p>
                      </div>
                      <p class="mt-0.5 text-sm text-green-500">Shipping and taxes calculated at checkout.</p>
                      <div class="mt-6 flex justify-center">
                        <CheckOut />
                      </div>
                      <div class="mt-6 flex justify-center text-center text-sm text-green-500">
                        <p>
                          or{{ ' ' }}
                          <button id="close" type="button" class="font-medium text-green-600 hover:text-green-500" @click="modalStore.cartOpen = false">
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
