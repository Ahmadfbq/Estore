import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

export const useCartStore = defineStore('cart', () => {
  const cartItems = ref([
  {
    id: 8,
    name: 'Throwback Hip Bag',
    href: '#',
    color: 'Salmon',
    price: 90,
    quantity: 1,
    imageSrc: 'https://tailwindui.com/img/ecommerce-images/shopping-cart-page-04-product-01.jpg',
    imageAlt: 'Salmon orange fabric pouch with match zipper, gray zipper pull, and adjustable hip belt.',
  },
  {
    id: 9,
    name: 'Medium Stuff Satchel',
    href: '#',
    color: 'Blue',
    price: 30,
    quantity: 1,
    imageSrc: 'https://tailwindui.com/img/ecommerce-images/shopping-cart-page-04-product-02.jpg',
    imageAlt: 'Front of satchel with blue canvas body, black straps and handle, drawstring top, and front zipper pouch.',
  },
]);

  const addToCart = (product) => {
    const item = cartItems.value.find((item) => item.id === product.id);
    if (item) {
      item.quantity++;
    } else {
      cartItems.value.push({ ...product, quantity: 1 });
    }
  };

  const incrementQuantity = (productId) => {
    const item = cartItems.value.find((item) => item.id === productId);
    if (item) {
      item.quantity++;
    }
  };

  const decrementQuantity = (productId) => {
    const item = cartItems.value.find((item) => item.id === productId);
    if (item) {
      item.quantity--;
      if (item.quantity === 0) {
        removeProduct(productId);
      }
    }
  };

  const removeProduct = (productId) => {
    cartItems.value = cartItems.value.filter((item) => item.id !== productId);
  };

  const totalPrice = computed(() => {
    return cartItems.value.reduce((total, item) => total + item.price * item.quantity, 0);
  });

  return {
    cartItems,
    addToCart,
    incrementQuantity,
    decrementQuantity,
    removeProduct,
    totalPrice,
  };
});
