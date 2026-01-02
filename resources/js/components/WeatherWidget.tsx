import React, { useState, useEffect } from 'react';
import { useLanguage } from '../context/LanguageContext';

interface WeatherData {
    temperature: number;
    condition: string;
    humidity: number;
    city: string;
    icon: string;
}

const WeatherWidget: React.FC = () => {
    const { language, t } = useLanguage();
    const [weather, setWeather] = useState<WeatherData>({
        temperature: 28,
        condition: language === 'hi' ? 'साफ आसमान' : 'Clear Sky',
        humidity: 65,
        city: language === 'hi' ? 'बीकानेर' : 'Bikaner',
        icon: '☀️'
    });

    // Update weather data when language changes
    useEffect(() => {
        setWeather(prev => ({
            ...prev,
            condition: language === 'hi' ? 'साफ आसमान' : 'Clear Sky',
            city: language === 'hi' ? 'बीकानेर' : 'Bikaner'
        }));
    }, [language]);

    return (
        <div className="flex items-center space-x-3 text-sm">
            <div className="flex items-center space-x-2 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">
                <span className="text-lg">{weather.icon}</span>
                <div className="flex flex-col">
                    <span className="font-semibold text-gray-800">
                        {Math.round(weather.temperature)}°C
                    </span>
                    <span className="text-xs text-gray-600">
                        {weather.city}
                    </span>
                </div>
            </div>
        </div>
    );
};

export default WeatherWidget;