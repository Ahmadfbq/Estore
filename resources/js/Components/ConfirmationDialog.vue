<template>
    <TransitionRoot as="template" :show="open" @close="closeDialog">
      <Dialog as="div" class="fixed inset-0 z-10 overflow-y-auto" @close="closeDialog">
        <div class="flex items-center justify-center min-h-screen px-4 text-center">
          <TransitionChild
            as="div"
            enter="ease-out duration-300"
            enter-from="transform scale-95"
            enter-to="transform scale-100"
            leave="ease-in duration-200"
            leave-from="transform scale-100"
            leave-to="transform scale-95"
          >
            <DialogPanel class="max-w-md w-full p-6 bg-white rounded-lg shadow-lg">
              <DialogTitle as="h3" class="text-xl font-semibold text-gray-900 mb-4">
                Are you sure you want to delete this product?
              </DialogTitle>
              <div class="flex gap-4 mt-4 justify-center">
                <button
                  @click="confirm"
                  class="px-4 py-2 text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  Confirm
                </button>
                <button
                  @click="closeDialog"
                  class="px-4 py-2 text-white bg-red-600 rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                >
                  Cancel
                </button>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </Dialog>
    </TransitionRoot>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
  
  const props = defineProps({
    open: Boolean
  });
  
  const emit = defineEmits(['close', 'confirm']);
  
  const closeDialog = () => {
    emit('close');
  };
  
  const confirm = () => {
    emit('confirm');
  };
  </script>
  
  <style scoped>
  /* Ensure the dialog panel has no unnecessary padding or margin */
  </style>
  