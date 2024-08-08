<script setup>
import { ref, watch } from 'vue';
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import axios from 'axios';
import Swal from 'sweetalert2';

const props = defineProps({
  order: {
    type: Object,
    default: () => ({
      id: null,
      total_price: 0,
      status: '',
      client: {
        name: '',
        phone: '',
        address: '',
        email: ''
      },
      payment_method: '',
      delivery_type: '',
      products: []
    })
  },
  isOpen: {
    type: Boolean,
    default: false
  }
});

const open = ref(props.isOpen);

// Watch for changes in props.isOpen and update local `open` state
watch(() => props.isOpen, (newVal) => {
  open.value = newVal;
});

const toggleModal = () => {
  open.value = !open.value;
};

const formatCurrency = (amount) => {
  return `SAR ${amount.toFixed(2)}`;
};

const updateStatus = async (status) => {
  try {
    await axios.patch(`/api/orders/${props.order.id}`, { status });
    Swal.fire('Success', 'Order status updated successfully', 'success');
  } catch (error) {
    console.error('Error updating status:', error);
    Swal.fire('Error', 'Failed to update order status', 'error');
  }
};
</script>

<template>
  <div>
    <button @click="toggleModal" class="text-indigo-600 hover:text-indigo-900 text-sm">
      View Details
    </button>

    <TransitionRoot as="template" :show="open">
      <Dialog class="relative z-10" @close="toggleModal">
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
                  @click="toggleModal">
                  <span class="sr-only">Close</span>
                  <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                </button>

                <div class="grid gap-6 sm:grid-cols-12 lg:gap-8">
                    <div class="col-span-1 sm:col-span-8 lg:col-span-7">
                      <h2 class="text-3xl font-bold text-gray-900 mb-2">Order ID: {{ props.order?.id }}</h2>
                      <section aria-labelledby="information-heading" class="mt-2">
                        <h3 id="information-heading" class="sr-only">Order information</h3>
                        <p class="text-2xl font-semibold text-gray-900">Total: {{ formatCurrency(props.order?.total_price) }}</p>
                        <p class="text-gray-700">Status: {{ props.order?.status }}</p>
                        <div class="mt-4">
                          <label for="status" class="block text-sm font-medium text-gray-700">Update Status</label>
                          <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" :props.order.status @change="updateStatus($event.target.value)">
                            <option value="Pending">Pending</option>
                            <option value="Confirmed">Confirmed</option>
                            <option value="Shipped">Shipped</option>
                            <option value="Delivered">Delivered</option>
                          </select>
                        </div>
                        <div class="mt-4">
                          <p class="text-lg font-semibold">Client Information</p>
                          <p class="text-gray-700">Name: {{ props.order?.client?.name }}</p>
                          <p class="text-gray-700">Phone: {{ props.order?.client?.phone }}</p>
                          <p class="text-gray-700">Address: {{ props.order?.client?.address }}</p>
                          <p class="text-gray-700">Email: {{ props.order?.client?.email }}</p>
                        </div>
                        <div class="mt-4">
                          <p class="text-lg font-semibold">Order Details</p>
                          <p class="text-gray-700">Payment Method: {{ props.order?.payment_method }}</p>
                          <p class="text-gray-700">Delivery Type: {{ props.order?.delivery_type }}</p>
                          <div v-if="props.order?.products && props.order.products.length">
                            <p class="text-lg font-semibold mt-4">Products</p>
                            <ul class="list-disc pl-5">
                              <li v-for="product in props.order.products" :key="product.id" class="text-gray-700">{{ product.name }} - {{ product.quantity }} x {{ formatCurrency(product.price) }}</li>
                            </ul>
                          </div>
                        </div>
                      </section>
                    </div>
                  </div>
                </div>
              </DialogPanel>
            </TransitionChild>
          </div>
        </Dialog>
      </TransitionRoot>
    </div>
  </template>