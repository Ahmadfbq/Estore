import { defineStore } from 'pinia';
import { ref, onMounted } from 'vue';
import { useProductStore } from './product';

export const useOrderStore = defineStore ('order', () => {
    const productStore = useProductStore();

    const orders = ref([
        // {
        //   id: '12345', 
        //   total_price: 99.99,
        //   date: '2023-07-25', 
        //   status: 'Shipped', 
        // },
        // {
        //   id: '67890', 
        //   total_price: 49.99,
        //   date: '2023-07-20', 
        //   status: 'Pending', 
        // },
        // {
        //   id: '11223', 
        //   total_price: 29.99,
        //   date: '2023-07-18', 
        //   status: 'Delivered', 
        // },
      ]);

    const fetchOrdersData = async () => {
        try {
          const ordersResponse = await axios.get('/api/orders');
          orders.value.push(...ordersResponse.data);        
    
        } catch (error) {
          console.error('Error fetching orders data:', error);
        }
      };
      
      onMounted(() => {
        fetchOrdersData();
      });

    return {
        orders,
        fetchOrdersData,
    }
})