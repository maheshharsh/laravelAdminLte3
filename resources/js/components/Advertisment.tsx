import React from "react";

interface AdvertisementProps {
    adv_image?: string;
    title?: string;
    className?: string;
}

import React, { useState } from "react";

interface AdvertisementProps {
    adv_image?: string;
    title?: string;
    className?: string;
}

const Advertisement: React.FC<AdvertisementProps> = ({ 
    adv_image, 
    title, 
    className = "" 
}) => {
    const [imageLoaded, setImageLoaded] = useState(false);
    const [imageError, setImageError] = useState(false);

    const handleImageLoad = () => {
        setImageLoaded(true);
    };

    const handleImageError = (e: React.SyntheticEvent<HTMLImageElement, Event>) => {
        setImageError(true);
        setImageLoaded(true);
        e.currentTarget.src = `https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=Ad+Image`;
    };

    return (
        <div className={`advertisement-container bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-10 ${className}`}>
            {/* Advertisement Container */}
            <div className="relative group">
                {adv_image ? (
                    <div className="w-full h-40 sm:h-48 lg:ad-desktop overflow-hidden relative">
                        {/* Loading state */}
                        {!imageLoaded && (
                            <div className="absolute inset-0 flex items-center justify-center bg-gray-100">
                                <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-400"></div>
                            </div>
                        )}
                        
                        <img
                            src={adv_image}
                            alt={title || "Advertisement"}
                            className={`advertisement-image w-full h-full object-contain bg-gray-50 transition-opacity duration-300 ${
                                imageLoaded ? 'opacity-100' : 'opacity-0'
                            }`}
                            loading="lazy"
                            onLoad={handleImageLoad}
                            onError={handleImageError}
                        />
                        
                        {/* Error state overlay */}
                        {imageError && imageLoaded && (
                            <div className="absolute top-2 right-2 bg-red-100 text-red-600 text-xs px-2 py-1 rounded">
                                Failed to load
                            </div>
                        )}
                    </div>
                ) : (
                    <div className="w-full h-40 sm:h-48 lg:ad-desktop flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                        <div className="text-center p-4">
                            <div className="w-12 h-12 mx-auto mb-2 bg-gray-300 rounded-full flex items-center justify-center">
                                <svg className="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span className="text-xs font-medium text-gray-500 block">
                                {title || "Advertisement"}
                            </span>
                        </div>
                    </div>
                )}
                
                {/* Title overlay for images (optional) */}
                {title && adv_image && imageLoaded && !imageError && (
                    <div className="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <p className="text-white text-sm font-medium text-center truncate">
                            {title}
                        </p>
                    </div>
                )}
            </div>
        </div>
    );
};

export default Advertisement;