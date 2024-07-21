<script setup>
  import { ref } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  
  const form = useForm({
    name: '',
    description: '',
    price: '',
    quantity: '',
    image: null
  });
  
  const handleImageUpload = (event) => {
    form.image = event.target.files[0];
  };
  
  const submitForm = async () => {
    const formData = new FormData();
    formData.append('name', form.name);
    formData.append('description', form.description);
    formData.append('price', form.price);
    formData.append('quantity', form.quantity);
    if (form.image) {
      formData.append('image', form.image);
    }

    try {
    await form.post('/createproduct/store', {
      data: formData,
      headers: {
        'Content-Type': 'multipart/form-data',
      },
      onSuccess: () => {
        router.push({ name: 'products' });
      },
      onError: () => {
        alert('An error occurred while creating the product.');
      }
    });
  } catch (error) {
    console.error('Error:', error);
    alert('An error occurred while creating the product.');
  }
};
  </script>

<template>
  <div class="max-w-md mx-auto p-6 bg-green-100 bg-cover bg-center bg-no-repeat bg-[url('')] rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-center">Create Product</h1>

    <form @submit.prevent="submitForm" class="space-y-4">
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
        <input type="text" id="name" v-model="form.name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
      </div>
      <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
        <textarea id="description" v-model="form.description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
      </div>
      <div>
        <label for="price" class="block text-sm font-medium text-gray-700">Price:</label>
        <input type="text" id="price" v-model="form.price" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
      </div>
      <div>
        <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity:</label>
        <input type="text" id="quantity" v-model="form.quantity" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
      </div>
      <div>
        <label for="image" class="block text-sm font-medium text-gray-700">Image:</label>
        <input type="file" id="image" @change="handleImageUpload" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors duration-300">
      </div>
      <button type="submit" class="w-full mt-4 px-4 py-2 bg-blue-500 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 hover:bg-blue-600 transition-colors duration-300">
        Create Product
      </button>     
    </form>
  </div>
</template>
