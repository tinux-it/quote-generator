import axios from 'axios';

const API_BASE_URL = 'http://127.0.0.1:8001/api';

export interface SubscriptionData {
    email: string | null;
    phoneNumber: string | null;
    methods: string[];
}

export const fetchAvailableMethods = async (): Promise<string[]> => {
    try {
        const response = await axios.get(`${API_BASE_URL}/subscription-methods`);
        return response.data.subscriptionMethods;
    } catch (error) {
        console.error('Error fetching available methods:', error);
        throw error;
    }
};

export const subscribeUser = async (data: SubscriptionData) => {
    try {
        const response = await axios.post(`${API_BASE_URL}/subscribe`, data);
        return response.data;
    } catch (error) {
        console.error('Error subscribing user:', error);
        throw error;
    }
};