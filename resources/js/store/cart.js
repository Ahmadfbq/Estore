import { defineStore } from 'pinia';
import { ref, computed, onMounted } from 'vue';
import { useProductStore } from './product';
import axios from 'axios';
import Swal from 'sweetalert2';

export const useCartStore = defineStore('cart', () => {
  const productStore = useProductStore();

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
    const productInStore = productStore.getProductById(product.id);

    if (productInStore && productInStore.quantity > 0) {
      if (item) {
        if (productInStore.quantity >= 1) {
          item.quantity++;
          productStore.updateProductQuantity(product.id, productInStore.quantity - 1);
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Not enough stock available.',
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
          });
        }
      } else {
        cartItems.value.push({ ...product, quantity: 1 });
        productStore.updateProductQuantity(product.id, productInStore.quantity - 1);
      }

      Swal.fire({
        icon: 'success',
        title: 'Added to Cart',
        text: `${product.name} has been added to your cart.`,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK',
      });
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

  const incrementQuantity = (productId) => {
    const item = cartItems.value.find((item) => item.id === productId);
    const productInStore = productStore.getProductById(productId);

    if (item && productInStore) {
      if (productInStore.quantity >= 1) {
        item.quantity++;
        productStore.updateProductQuantity(productId, productInStore.quantity - 1);
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Not enough stock available.',
          confirmButtonColor: '#d33',
          confirmButtonText: 'OK',
        });
      }
    }
  };

  const decrementQuantity = (productId) => {
    const item = cartItems.value.find((item) => item.id === productId);
    const productInStore = productStore.getProductById(productId);

    if (item && productInStore) {
      item.quantity--;
      productStore.updateProductQuantity(productId, productInStore.quantity + 1);

      if (item.quantity === 0) {
        removeProduct(productId);
      }
    }
  };

  const removeProduct = (productId) => {
    const item = cartItems.value.find((item) => item.id === productId);
    const productInStore = productStore.getProductById(productId);

    if (item && productInStore) {
      productStore.updateProductQuantity(productId, productInStore.quantity + item.quantity);
    }

    cartItems.value = cartItems.value.filter((item) => item.id !== productId);
  };

  const totalPrice = computed(() => {
    return cartItems.value.reduce((total, item) => total + item.price * item.quantity, 0);
  });

  const totalItems = computed(() => {
    return cartItems.value.reduce((total, item) => total + item.quantity, 0);
  });

  const fetchCartData = async () => {
    try {
      const cartResponse = await axios.get('/api/cart');
      cartItems.value.push(...cartResponse.data);        

    } catch (error) {
      console.error('Error fetching products data:', error);
    }
  };
  
  onMounted(() => {
    fetchCartData();
  });

  return {
    cartItems,
    addToCart,
    incrementQuantity,
    decrementQuantity,
    removeProduct,
    totalPrice,
    totalItems,
    fetchCartData,
  };
});
