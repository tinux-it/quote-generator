export const getMethodDisplayName = (method: string): string => {
    switch (method) {
        case 'email':
            return 'Email';
        case 'whatsapp':
            return 'WhatsApp Message';
        case 'browser':
            return 'Website Push Notification';
        default:
            return method.charAt(0).toUpperCase() + method.slice(1);
    }
};

export const validateSubscriptionForm = (
        selectedMethods: Record<string, boolean>,
    email: string,
    phone: string
): string | null => {
    // Get array of selected methods
    const selectedMethodsArray = Object.keys(selectedMethods).filter(
        (method) => selectedMethods[method]
    );

    if (selectedMethodsArray.length === 0) {
        return 'Please select at least one subscription method';
    }

    if (selectedMethods.email && !email) {
        return 'Please provide your email address';
    }

    if (selectedMethods.whatsapp && !phone) {
        return 'Please provide your phone number';
    }

    return null;
};