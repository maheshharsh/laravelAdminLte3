import React from "react";

interface AdvertisementProps {
    adv_image?: string;
    title?: string;
}

const Advertisement: React.FC<AdvertisementProps> = ({ adv_image, title }) => {
    return (
        <div className="bg-slate-100 py-5 px-2 text-white font-bold text-center">
            <div className="rounded-xl overflow-hidden shadow-lg hover:scale-105 transition-transform duration-300">
                {adv_image ? (
                    <img
                        src={adv_image}
                        alt={title || "Advertisement"}
                        className="w-full h-48 object-cover"
                        loading="lazy"
                    />
                ) : (
                    <div className="w-full h-48 flex items-center justify-center bg-gray-200 text-gray-500">
                        <span className="text-sm font-medium">
                            {title || "No Image Available"}
                        </span>
                    </div>
                )}
            </div>
        </div>
    );
};

export default Advertisement;