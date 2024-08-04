<script setup>
import { ref, watch, computed } from 'vue';
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import { useOrderStore } from '@/store/order';

const orderStore = useOrderStore();

const props = defineProps({
  order: Object,
  isOpen: Boolean
});
const emit = defineEmits(['update:isOpen']);

const open = ref(props.isOpen);

// Watch for changes in props.isOpen and update local `open` state
watch(() => props.isOpen, (newVal) => {
  open.value = newVal;
});

const close = () => {
  emit('update:isOpen', false);
};

const toggleModal = () => {
    open.value = !open.value;
};

</script>

<template>
    <div>
        <button @click="toggleModal" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
            View Details
        </button>
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
                        <div class="col-span-1 sm:col-span-8 lg:col-span-7">
                          <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ orderStore.orders.id }}</h2>
                          <section aria-labelledby="information-heading" class="mt-2">
                            <h3 id="information-heading" class="sr-only">Order information</h3>
                            <p class="text-2xl font-semibold text-gray-900">{{ 'SAR ' + orderStore.orders.total_price }}</p>
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