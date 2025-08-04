import React from "react";
import { Link } from "@inertiajs/react"; // Import Inertia's Link component
interface HeadlinesProps {
    id: number;
    title: string;
    content: string;
    category_name: string; // Changed from number to string
    slug: string;
    time?: string;
}

const NewsHeadlines = ({ headlines }: { headlines: HeadlinesProps[] }) => {  
    return (
        <div className="my-2 mx-auto p-4 md:p-6 bg-white rounded-xl ">
            <div className="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                <h2 className="text-2xl md:text-3xl font-bold text-gray-800">
                    Latest Headlines
                </h2>
            </div>

            <div className="space-y-4">
                {(headlines).map((headline, index) => (
                    <div
                        key={index}
                        className="group p-4 hover:bg-gray-50 rounded-xl transition-all duration-200 border border-gray-200 hover:border-blue-200 hover:shadow-sm"
                    >
                        <div className="flex flex-col md:flex-row">
                            {/* Category and Time */}
                            <div className="flex items-center mb-2 md:mb-0 ">
                                <span
                                    className={`inline-block px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800`}
                                >
                                    {headline.category_name}
                                </span>
                            </div>

                            {/* Headline Text */}
                            <div className="flex-1 md:px-4">
                                <h3 className="text-gray-800 group-hover:text-blue-600 cursor-pointer font-medium text-base md:text-lg leading-relaxed">
                                    {headline.title}
                                </h3>
                            </div>

                            {/* Time and Read More */}
                            <div className="flex items-center justify-between mt-2 md:mt-0 md:w-1/6 md:flex-col md:items-end">
                                <div className="flex items-center text-xs text-gray-500">
                                    <svg
                                        className="w-3 h-3 mr-1"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                    {headline.time}
                                </div>
                                <Link
                                    href={`/headline/${headline.id}`}
                                    className="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center md:mt-1"
                                >
                                    Read
                                    <svg
                                        className="w-4 h-4 ml-1"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2}
                                            d="M9 5l7 7-7 7"
                                        />
                                    </svg>
                                </Link>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default NewsHeadlines;
