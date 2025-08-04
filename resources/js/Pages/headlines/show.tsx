import React from "react";
import { Head, Link } from "@inertiajs/react";

import AppLayout from "../../layouts/AppLayout";
interface HeadlinesProps {
    id: number;
    title: string;
    content: string;
    category_name: string;
    slug: string;
    time?: string;
}

function show({ headlines }: { headlines: HeadlinesProps }) {
    return (
        <AppLayout currentRoute={""}>
            <Head title="Headline" />

            <div className="mx-auto my-8 px-4 sm:px-6 lg:px-8">
                {/* Header Section */}
                <div className="mb-6">
                    <Link
                        href="/"
                        className="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium mb-4 transition-colors duration-200"
                    >
                        <svg
                            className="w-4 h-4 mr-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth={2}
                                d="M15 19l-7-7 7-7"
                            />
                        </svg>
                        Back 
                    </Link>

                    <h1 className="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight mb-3">
                        {headlines.title}
                    </h1>
                    <div className="flex justify-between items-center space-x-4">
                        <span className="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                            {headlines.category_name}
                        </span>
                        <div className="flex items-center text-sm text-gray-500">
                            <svg
                                className="w-4 h-4 mr-1"
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
                            {headlines.time}
                        </div>
                    </div>
                </div>

                {/* Content Section */}
                <div className="prose prose-lg max-w-none text-gray-700 bg-white ">
                    <p>{headlines.content}</p>
                </div>
            </div>
        </AppLayout>
    );
}

export default show;
