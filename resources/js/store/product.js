import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useProductStore = defineStore('product', () => {
    const products = ref([
        {
            id: 1,
            name: 'Basic Tee',
            href: '#',
            imageSrc: 'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg',
            imageAlt: "Front of men's Basic Tee in black.",
            price: 35,
            color: 'Black',
            quantity: 10,
          },
          {
            id: 2,
            name: 'Basic Tee',
            href: '#',
            imageSrc: 'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-02.jpg',
            imageAlt: "Front of men's Basic Tee in white.",
            price: 35,
            color: 'White',
            quantity: 7,
          },
          {
            id: 3,
            name: 'Basic Tee',
            href: '#',
            imageSrc: 'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-03.jpg',
            imageAlt: "Front of men's Basic Tee in gray.",
            price: 35,
            color: 'Gray',
            quantity: 5,
          },
          {
            id: 4,
            name: 'Water Bottle',
            href: '#',
            imageSrc: 'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-02.jpg',
            imageAlt: "Front of men's Basic Tee in black.",
            price: 10,
            color: 'Green',
            quantity: 3,
          },
          {
            id: 5,
            name: 'Female T-Shirt',
            href: '#',
            imageSrc: 'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-04.jpg',
            imageAlt: "Front of women's Basic Tee in pink.",
            price: 35,
            color: 'Pink',
            quantity: 12,
          },
          {
            id: 6,
            name: 'Weird Bottle',
            href: '#',
            imageSrc: 'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-01.jpg',
            imageAlt: "Front of men's Basic Tee in black.",
            price: 5,
            color: 'Navy',
            quantity: 14,
          },
          {
            id: 7,
            name: 'Wallet',
            href: '#',
            imageSrc: 'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-08.jpg',
            imageAlt: "Front of men's Basic Tee in black.",
            price: 15,
            color: 'Gray',
            quantity: 9,
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
            quantity: 18,
          },
    ]);

    const removeProduct = (productId) => {
        if (confirm('Are you sure you want to delete this product?')) {
            products.value = products.value.filter(product => product.id !== productId);
        }
    };

    const getProductById = (productId) => {
        return products.value.find(product => product.id === productId);
    };

    const updateProductQuantity = (productId, newQuantity) => {
      const product = getProductById(productId);
      if (product) {
          product.quantity = newQuantity;
      }
  };

    return {
        products,
        removeProduct,
        getProductById,
        updateProductQuantity,
    };
});
