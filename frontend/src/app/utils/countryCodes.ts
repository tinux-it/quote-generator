// src/utils/countryCodes.ts
export const countryCodes = [
    { code: '+1', country: 'US', flag: '🇺🇸' },  // United States
    { code: '+31', country: 'NL', flag: '🇳🇱' }, // Netherlands
    { code: '+44', country: 'GB', flag: '🇬🇧' }, // United Kingdom
    { code: '+49', country: 'DE', flag: '🇩🇪' }, // Germany
    { code: '+33', country: 'FR', flag: '🇫🇷' }, // France
    { code: '+39', country: 'IT', flag: '🇮🇹' }, // Italy
    { code: '+34', country: 'ES', flag: '🇪🇸' }, // Spain
    { code: '+32', country: 'BE', flag: '🇧🇪' }, // Belgium
    { code: '+41', country: 'CH', flag: '🇨🇭' }, // Switzerland
    { code: '+43', country: 'AT', flag: '🇦🇹' }, // Austria
    { code: '+45', country: 'DK', flag: '🇩🇰' }, // Denmark
    { code: '+46', country: 'SE', flag: '🇸🇪' }, // Sweden
    { code: '+47', country: 'NO', flag: '🇳🇴' }, // Norway
    { code: '+353', country: 'IE', flag: '🇮🇪' }, // Ireland
    { code: '+351', country: 'PT', flag: '🇵🇹' }, // Portugal
    { code: '+420', country: 'CZ', flag: '🇨🇿' }, // Czech Republic
    { code: '+48', country: 'PL', flag: '🇵🇱' }, // Poland
    { code: '+358', country: 'FI', flag: '🇫🇮' }, // Finland
    { code: '+1', country: 'CA', flag: '🇨🇦' },  // Canada (shares +1 with US)
];

// Optional: Add helper functions for country code handling
export const findCountryByCode = (code: string) => {
    return countryCodes.find(country => country.code === code);
};

export const getDefaultCountryCode = () => '+31'; // Netherlands as default