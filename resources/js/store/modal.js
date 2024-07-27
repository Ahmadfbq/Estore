import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useModalStore = defineStore('modal', () => {
  const cartOpen = ref(false);
  const checkoutOpen = ref(false);

  const toggleCart = () => {
    cartOpen.value = !cartOpen.value;
  };

  const toggleCheckout = () => {
    checkoutOpen.value = !checkoutOpen.value;
  };
  

  return {
    cartOpen,
    checkoutOpen,
    toggleCart,
    toggleCheckout,
  };
});
