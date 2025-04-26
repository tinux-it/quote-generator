import axios from 'axios';

const API_BASE_URL = process.env.API_URL || 'http://127.0.0.1:8000/api';

// Update the interface to match the new backend requirements
export interface SubscriptionData {
    email: string;
    methods: {
        email?: string;
        whatsapp?: string;
        browser?: boolean;
    };
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

export const unsubscribeUser = async (email: string) => {
    try {
        const response = await axios.post(`${API_BASE_URL}/unsubscribe`, { email });
        return response.data;
    } catch (error) {
        console.error('Error unsubscribing user:', error);
        throw error;
    }
};

