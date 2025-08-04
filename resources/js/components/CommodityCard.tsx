import React from 'react';

const CommodityCard = ({ title, price, unit, lastUpdated }: {
    title: string;
    price: number;
    unit?: string;
    lastUpdated: string;
}) => (
    <div className="bg-blue-400 p-3 rounded-lg shadow-lg flex items-center justify-center">
        <div className="text-center">
            <h3 className="font-medium text-gray-600 uppercase">{title}</h3>
            <p className="text-xl font-bold">
                ₹{price.toFixed(2)}{unit}
            </p>
            <p className="text-sm text-gray-500">{lastUpdated}</p>
        </div>
    </div>
);

export default CommodityCard;