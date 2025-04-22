// src/app/page.tsx
"use client"

import { useState, useEffect } from "react";
import { motion } from 'framer-motion';
import { fetchAvailableMethods, subscribeUser, unsubscribeUser } from './service/SubscriptionService';
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
    const [isUnsubscribeMode, setIsUnsubscribeMode] = useState<boolean>(false);
    const [unsubscribeEmail, setUnsubscribeEmail] = useState<string>('');

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

    const handleSubscribe = async () => {
        // Clear previous messages
        setError(null);
        setSuccessMessage(null);

        // Validate form
        const validationError = validateSubscriptionForm(selectedMethods, email, phoneNumber);
        if (validationError) {
            setError(validationError);
            return;
        }

        try {
            setSubmitting(true);

            // Build data structure that directly matches the backend API
            const subscriptionData = {
                email: email,
                methods: {} as {
                    email?: string;
                    whatsapp?: string;
                    browser?: boolean;
                }
            };

            if (selectedMethods.email) {
                subscriptionData.methods.email = email;
            }

            if (selectedMethods.whatsapp) {
                subscriptionData.methods.whatsapp = phoneNumber;
            }

            if (selectedMethods.browser) {
                subscriptionData.methods.browser = true;
            }

            // Call service function with properly structured data
            await subscribeUser(subscriptionData);

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

    // Add this unsubscribe handler function
    const handleUnsubscribe = async () => {
        // Clear previous messages
        setError(null);
        setSuccessMessage(null);

        // Validate email
        if (!unsubscribeEmail || unsubscribeEmail.trim() === '') {
            setError('Please enter your email address to unsubscribe');
            return;
        }

        try {
            // Show loading state
            setSubmitting(true);

            // Call service function
            await unsubscribeUser(unsubscribeEmail);

            // Reset form
            setUnsubscribeEmail('');
            setIsUnsubscribeMode(false);

            // Show success message
            setSuccessMessage("Successfully unsubscribed. You'll no longer receive motivational quotes.");
        } catch (err) {
            setError('Failed to unsubscribe. Please try again.');
        } finally {
            setSubmitting(false);
        }
    };

    // Toggle between subscribe and unsubscribe modes
    const toggleUnsubscribeMode = () => {
        setIsUnsubscribeMode(!isUnsubscribeMode);
        // Clear fields and errors when switching modes
        setEmail('');
        setPhoneNumber('');
        setUnsubscribeEmail('');
        setError(null);
        setSuccessMessage(null);

        // Reset selected methods when switching to subscribe mode
        if (isUnsubscribeMode) {
            const resetMethods: Record<string, boolean> = {};
            availableMethods.forEach(method => {
                resetMethods[method] = false;
            });
            setSelectedMethods(resetMethods);
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

            {/* Mode Toggle */}
            <div className="mb-6 flex gap-4">
                <motion.button
                    onClick={() => setIsUnsubscribeMode(false)}
                    className={`px-6 py-2 rounded-full font-medium transition-colors ${!isUnsubscribeMode
                        ? 'bg-blue-600 text-white'
                        : 'bg-gray-700 hover:bg-gray-600 text-gray-300'}`}
                    whileHover={{ scale: 1.05 }}
                    whileTap={{ scale: 0.95 }}
                >
                    Subscribe
                </motion.button>
                <motion.button
                    onClick={() => setIsUnsubscribeMode(true)}
                    className={`px-6 py-2 rounded-full font-medium transition-colors ${isUnsubscribeMode
                        ? 'bg-red-600 text-white'
                        : 'bg-gray-700 hover:bg-gray-600 text-gray-300'}`}
                    whileHover={{ scale: 1.05 }}
                    whileTap={{ scale: 0.95 }}
                >
                    Unsubscribe
                </motion.button>
            </div>

            <div className="w-full max-w-xl bg-gray-800/60 backdrop-blur-md border border-gray-700 rounded-2xl shadow-xl p-8 space-y-6">
                {loading && !isUnsubscribeMode ? (
                    <div className="text-center py-4">
                        <div className="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500 mx-auto"></div>
                        <p className="mt-2">Loading available subscription methods...</p>
                    </div>
                ) : (
                    <>
                        {/* Unsubscribe Form */}
                        {isUnsubscribeMode ? (
                            <div className="space-y-6">
                                <h2 className="text-xl font-semibold text-center">Unsubscribe from Quotes</h2>
                                <p className="text-gray-400 text-center">
                                    We're sorry to see you go. Enter your email to unsubscribe.
                                </p>

                                <div>
                                    <label className="block mb-1">Email Address</label>
                                    <input
                                        type="email"
                                        placeholder="you@example.com"
                                        className="mt-1 w-full px-4 py-2 rounded bg-gray-700 text-white"
                                        value={unsubscribeEmail}
                                        onChange={(e) => setUnsubscribeEmail(e.target.value)}
                                    />
                                </div>

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

                                <motion.button
                                    className="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                    onClick={handleUnsubscribe}
                                    disabled={submitting}
                                    whileHover={{ scale: 1.02 }}
                                    whileTap={{ scale: 0.98 }}
                                >
                                    {submitting ? "Processing..." : "Unsubscribe"}
                                </motion.button>
                            </div>
                        ) : (
                            /* Subscribe Form */
                            <div className="space-y-6">
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

                                <motion.button
                                    className="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                    onClick={handleSubscribe}
                                    disabled={submitting || availableMethods.length === 0}
                                    whileHover={{ scale: 1.02 }}
                                    whileTap={{ scale: 0.98 }}
                                >
                                    {submitting ? "Subscribing..." : "Subscribe Now"}
                                </motion.button>
                            </div>
                        )}
                    </>
                )}
            </div>

            <footer className="mt-12 text-sm text-gray-500">
                We respect your privacy. Your info is safe with us.
            </footer>
        </div>
    );
}