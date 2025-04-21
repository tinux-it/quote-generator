// src/app/page.tsx
"use client"

import { useState, useEffect } from "react";
import { motion } from 'framer-motion';
import { fetchAvailableMethods, subscribeUser } from './service/SubscriptionService';
import { getMethodDisplayName, validateSubscriptionForm } from './utils/subscriptionUtils';

export default function Home() {
    const [availableMethods, setAvailableMethods] = useState<string[]>([]);
    const [selectedMethods, setSelectedMethods] = useState<Record<string, boolean>>({});
    const [loading, setLoading] = useState<boolean>(true);
    const [submitting, setSubmitting] = useState<boolean>(false);
    const [error, setError] = useState<string | null>(null);
    const [successMessage, setSuccessMessage] = useState<string | null>(null);
    const [email, setEmail] = useState('');
    const [phoneNumber, setPhoneNumber] = useState('');


    const toggleMethod = (method: string) => {
        setSelectedMethods({
            ...selectedMethods,
            [method]: !selectedMethods[method]
        });
    };

    // Initialize the selectedMethods state when availableMethods changes
    useEffect(() => {
        if (availableMethods.length > 0) {
            const initialState: Record<string, boolean> = {};
            availableMethods.forEach(method => {
                initialState[method] = false;
            });
            setSelectedMethods(initialState);
        }
    }, [availableMethods]);

    // Fetch available methods on component mount
    useEffect(() => {
        const loadMethods = async () => {
            try {
                setLoading(true);
                const methods = await fetchAvailableMethods();
                setAvailableMethods(methods);
                setError(null);
            } catch (err) {
                console.error("Error loading methods:", err);
                setError("Failed to load subscription methods");
            } finally {
                setLoading(false);
            }
        };

        loadMethods();
    }, []);

    // Helper function to check if method requires additional input
    const needsPhoneInput = selectedMethods.whatsapp;

    const handleSubscribe = async (p0: { email: string | null; phoneNumber: string | null; methods: string[]; }) => {
        // Clear previous messages
        setError(null);
        setSuccessMessage(null);
        console.log(email)

        // Validate form
        const validationError = validateSubscriptionForm(selectedMethods, email, phoneNumber);
        if (validationError) {
            setError(validationError);
            return;
        }

        try {
            // Show loading state
            setSubmitting(true);

            // Prepare data
            const selectedMethodsArray = Object.keys(selectedMethods).filter(method => selectedMethods[method]);

            // Call service function
            await subscribeUser({
                email: selectedMethods.email ? email : null,
                phoneNumber: selectedMethods.whatsapp ? phoneNumber : null,
                methods: selectedMethodsArray
            });

            // Reset form
            setEmail('');
            setPhoneNumber('');
            const resetMethods: Record<string, boolean> = {};
            availableMethods.forEach(method => {
                resetMethods[method] = false;
            });
            setSelectedMethods(resetMethods);

            // Show success message
            setSuccessMessage("Successfully subscribed! You'll start receiving motivational quotes soon.");
        } catch (err) {
            setError('Failed to subscribe. Please try again.');
        } finally {
            setSubmitting(false);
        }
    };

    return (
        <div className="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white flex flex-col items-center justify-center px-4">
            <motion.div
                initial={{ opacity: 0, y: -20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.8 }}
                className="text-center mb-12"
            >
                <h1 className="text-4xl md:text-6xl font-bold mb-4">
                    Start Your Day Inspired
                </h1>
                <p className="text-lg text-gray-300">
                    Get a daily motivational quote delivered your way.
                </p>
            </motion.div>

            <div className="w-full max-w-xl bg-gray-800/60 backdrop-blur-md border border-gray-700 rounded-2xl shadow-xl p-8 space-y-6">
                {loading ? (
                    <div className="text-center py-4">
                        <div className="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500 mx-auto"></div>
                        <p className="mt-2">Loading available subscription methods...</p>
                    </div>
                ) : (
                    <>
                        <div className="space-y-4">
                            <h2 className="text-xl font-semibold">Choose your preferred method:</h2>
                            {availableMethods.length === 0 ? (
                                <p className="text-gray-400">No subscription methods available at the moment.</p>
                            ) : (
                                <div className="space-y-3">
                                    {availableMethods.map((method) => (
                                        <div key={method} className="flex items-center justify-between">
                                            <label className="cursor-pointer">{getMethodDisplayName(method)}</label>
                                            <input
                                                type="checkbox"
                                                checked={selectedMethods[method] || false}
                                                onChange={() => toggleMethod(method)}
                                                className="h-5 w-5 cursor-pointer"
                                            />
                                        </div>
                                    ))}
                                </div>
                            )}
                        </div>
                        <div>
                            <label className="block mb-1">Email Address</label>
                            <input
                                type="email"
                                placeholder="you@example.com"
                                className="mt-1 w-full px-4 py-2 rounded bg-gray-700 text-white"
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                            />
                        </div>
                        {needsPhoneInput && (
                            <div>
                                <label className="block mb-1">Phone Number</label>
                                <input
                                    type="tel"
                                    placeholder="0611603656"
                                    className="mt-1 w-full px-4 py-2 rounded bg-gray-700 text-white"
                                    value={phoneNumber}
                                    onChange={(e) => setPhoneNumber(e.target.value)}
                                />
                            </div>
                        )}

                        {error && (
                            <div className="text-red-400 text-center p-2 bg-red-900/30 rounded-md">
                                {error}
                            </div>
                        )}

                        {successMessage && (
                            <div className="text-green-400 text-center p-2 bg-green-900/30 rounded-md">
                                {successMessage}
                            </div>
                        )}

                        <button
                            className="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4"
                            onClick={handleSubscribe}
                            disabled={submitting || availableMethods.length === 0}
                        >
                            {submitting ? "Subscribing..." : "Subscribe Now"}
                        </button>
                    </>
                )}
            </div>

            <footer className="mt-12 text-sm text-gray-500">
                We respect your privacy. Your info is safe with us.
            </footer>
        </div>
    );
}