import React, { createContext, useContext, useState, useEffect } from 'react';

interface LanguageContextType {
    language: 'hi' | 'en';
    setLanguage: (lang: 'hi' | 'en') => void;
    t: (key: string) => string;
}

const LanguageContext = createContext<LanguageContextType | undefined>(undefined);

// Translation object
const translations = {
    hi: {
        // Navbar
        'home': 'मुख्य पृष्ठ',
        'contact': 'संपर्क',
        'news': 'समाचार',
        'politics': 'राजनीति',
        'sports': 'खेल',
        'business': 'व्यापार',
        'entertainment': 'मनोरंजन',
        'technology': 'तकनीक',
        'health': 'स्वास्थ्य',
        
        // Common
        'read_more': 'और पढ़ें',
        'see_more': 'और देखें',
        'share': 'साझा करें',
        'date': 'दिनांक',
        'time': 'समय',
        
        // Weather
        'clear_sky': 'साफ आसमान',
        'cloudy': 'बादल',
        'rainy': 'बारिश',
        'humidity': 'नमी',
        
        // Contact
        'contact_us': 'संपर्क करें',
        'contact_info': 'संपर्क जानकारी',
        'address': 'पता',
        'phone': 'फोन',
        'email': 'ईमेल',
        'send_message': 'संदेश भेजें',
        'name': 'नाम',
        'subject': 'विषय',
        'message': 'संदेश',
        'connect_with_us': 'हमसे जुड़ें और अपनी बात कहें',
        'about_us': 'हमारे बारे में',
        'enter_name': 'अपना नाम दर्ज करें',
        'enter_email': 'अपना ईमेल दर्ज करें',
        'enter_phone': 'अपना फोन नंबर दर्ज करें',
        'enter_subject': 'संदेश का विषय दर्ज करें',
        'enter_message': 'अपना संदेश यहाँ लिखें',
        'phone_number': 'फोन नंबर',
        
        // Footer
        'all_rights_reserved': 'सभी अधिकार सुरक्षित',
        'trusted_news_source': 'विश्वसनीय समाचार का स्रोत',
        'follow_on_whatsapp': 'WhatsApp पर फॉलो करें',
        'follow_on_facebook': 'Facebook पर फॉलो करें',
        'follow_on_instagram': 'Instagram पर फॉलो करें',
        
        // Home page sections
        'headlines': 'मुख्य समाचार',
        'featured_news': 'प्रमुख समाचार',
        'latest_news': 'ताज़ा खबरें',
        'other_news': 'अन्य समाचार',
        'breaking_news': 'ब्रेकिंग न्यूज़',
        'top_stories': 'मुख्य समाचार',
        'all_news': 'सभी समाचार',
        'commodities': 'कमोडिटीज़',
        'read_full_article': 'पूरा आर्टिकल पढ़ें',
        'no_news_available': 'कोई समाचार उपलब्ध नहीं',
        'load_more': 'और लोड करें',
        'show_less': 'कम दिखाएं',
        'more': 'और',
        'trending': 'ट्रेंडिंग',
        
        // Video
        'video': 'वीडियो',
        'play': 'प्ले करें',
        'pause': 'रोकें',
        'watch_video': 'वीडियो देखें',
        'video_news': 'वीडियो न्यूज़',
        
        // Brand
        'brand_name': 'समाचार हाउस',
        'brand_tagline': 'सत्य • निष्पक्ष • विश्वसनीय',
        'brand_description': 'आपका विश्वसनीय समाचार स्रोत। सत्य, निष्पक्षता और तत्काल सूचना के लिए हमसे जुड़ें।'
    },
    en: {
        // Navbar
        'home': 'Home',
        'contact': 'Contact',
        'news': 'News',
        'politics': 'Politics',
        'sports': 'Sports',
        'business': 'Business',
        'entertainment': 'Entertainment',
        'technology': 'Technology',
        'health': 'Health',
        
        // Common
        'read_more': 'Read More',
        'see_more': 'See More',
        'share': 'Share',
        'date': 'Date',
        'time': 'Time',
        
        // Weather
        'clear_sky': 'Clear Sky',
        'cloudy': 'Cloudy',
        'rainy': 'Rainy',
        'humidity': 'Humidity',
        
        // Contact
        'contact_us': 'Contact Us',
        'contact_info': 'Contact Information',
        'address': 'Address',
        'phone': 'Phone',
        'email': 'Email',
        'send_message': 'Send Message',
        'name': 'Name',
        'subject': 'Subject',
        'message': 'Message',
        'connect_with_us': 'Connect with us and share your thoughts',
        'about_us': 'About Us',
        'enter_name': 'Enter your name',
        'enter_email': 'Enter your email',
        'enter_phone': 'Enter your phone number',
        'enter_subject': 'Enter message subject',
        'enter_message': 'Write your message here',
        'phone_number': 'Phone Number',
        
        // Footer
        'all_rights_reserved': 'All Rights Reserved',
        'trusted_news_source': 'Trusted News Source',
        'follow_on_whatsapp': 'Follow on WhatsApp',
        'follow_on_facebook': 'Follow on Facebook',
        'follow_on_instagram': 'Follow on Instagram',
        
        // Home page sections
        'headlines': 'Headlines',
        'featured_news': 'Featured News',
        'latest_news': 'Latest News',
        'other_news': 'Other News',
        'breaking_news': 'Breaking News',
        'top_stories': 'Top Stories',
        'all_news': 'All News',
        'commodities': 'Commodities',
        'read_full_article': 'Read Full Article',
        'no_news_available': 'No news available',
        'load_more': 'Load More',
        'show_less': 'Show Less',
        'more': 'more',
        'trending': 'trending',
        
        // Video
        'video': 'Video',
        'play': 'Play',
        'pause': 'Pause',
        'watch_video': 'Watch Video',
        'video_news': 'Video News',
        
        // Brand
        'brand_name': 'समाचार हाउस',
        'brand_tagline': 'Truth • Unbiased • Reliable',
        'brand_description': 'Your trusted news source. Stay connected with us for truth, unbiased reporting, and instant information.',
    }
};

export const LanguageProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
    const [language, setLanguageState] = useState<'hi' | 'en'>('hi');

    useEffect(() => {
        const savedLanguage = localStorage.getItem('language') as 'hi' | 'en' | null;
        if (savedLanguage && (savedLanguage === 'hi' || savedLanguage === 'en')) {
            setLanguageState(savedLanguage);
        }
    }, []);

    const setLanguage = (lang: 'hi' | 'en') => {
        setLanguageState(lang);
        localStorage.setItem('language', lang);
    };

    const t = (key: string): string => {
        return (translations[language] as any)[key] || key;
    };

    return (
        <LanguageContext.Provider value={{ language, setLanguage, t }}>
            {children}
        </LanguageContext.Provider>
    );
};

export const useLanguage = () => {
    const context = useContext(LanguageContext);
    if (context === undefined) {
        throw new Error('useLanguage must be used within a LanguageProvider');
    }
    return context;
};