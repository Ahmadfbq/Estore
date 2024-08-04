import { defineStore } from 'pinia';
import { ref, onMounted } from 'vue';
import { useProductStore } from './product';

export const useOrderStore = defineStore ('order', () => {
    const productStore = useProductStore();

    const orders = ref([]);

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