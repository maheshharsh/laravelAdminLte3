// src/Pages/Index.tsx

import React, { ReactNode, useEffect, useState } from "react";
import { Link, Head } from "@inertiajs/react";
import Carousel from "../components/Carousel";
import CommodityCard from "../components/CommodityCard";
import Advertisement from "../components/Advertisment";
import NewsHeadlines from "../components/NewsHeadlines";
import NewsBlock from "../components/NewsBlock";
import { Card, CardContent } from "../components/ui/card";
import { Badge } from "../components/ui/badge";
import { Clock } from "lucide-react";
import Navbar from "../components/Navbar";

interface Article {
    created_at: ReactNode;
    id: number;
    title: string;
    slug: string;
    content: string;
    category: { name: string };
    image?: string;
}

interface Props {
    articles: Article[];
}

interface CommodityPrices {
    gold: number;
    silver: number;
    crudeOil: number;
    naturalGas?: number;
    lastUpdated: string;
    created_at: string;
}

const Index: React.FC<Props> = ({ articles }) => {
    const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
    const [currentRoute, setCurrentRoute] = useState(window.location.pathname);
    const isActive = (route: string) => currentRoute === route;

    const [prices, setPrices] = useState<CommodityPrices>({
        gold: 0,
        silver: 0,
        crudeOil: 0,
        lastUpdated: "",
        created_at: "",
    });

    useEffect(() => {
        const fetchPrices = async () => {
            try {
                const mockPrices = {
                    gold: Math.random() * 10 + 50,
                    silver: Math.random() * 0.5 + 0.7,
                    crudeOil: Math.random() * 10 + 70,
                    lastUpdated: new Date().toLocaleTimeString(),
                    created_at: new Date().toLocaleTimeString(),
                };
                setPrices(mockPrices);
            } catch (error) {
                setPrices({
                    gold: 58.32,
                    silver: 0.72,
                    crudeOil: 78.45,
                    lastUpdated: new Date().toLocaleTimeString(),
                    created_at: new Date().toLocaleTimeString(),
                });
            }
        };

        fetchPrices();
        const interval = setInterval(fetchPrices, 300000);
        return () => clearInterval(interval);
    }, []);

    const carouselItems = [
        {
            image: "https://images.unsplash.com/photo-1586339949916-3e9457bef6d3",
            category: "BREAKING",
            title: "Global Summit Addresses Climate Change",
            content: "World leaders gather to discuss urgent climate action plans...",
        },
        {
            image: "https://images.unsplash.com/photo-1518770660439-4636190af475",
            category: "TECHNOLOGY",
            title: "New AI Breakthrough Revolutionizes Healthcare",
            content: "Researchers develop AI that can predict diseases with 95% accuracy...",
        },
        {
            image: "https://images.unsplash.com/photo-1540747913346-19e32dc3e97e",
            category: "SPORTS",
            title: "National Team Wins Championship After Decade",
            content: "Historic victory celebrated nationwide as underdogs take the title...",
        },
    ].map((item, index) => (
        <div key={index} className="h-96 relative overflow-hidden rounded-lg">
            <img
                src={`${item.image}?auto=format&fit=crop&w=800&h=400&q=80`}
                alt={item.category}
                className="w-full h-full object-cover absolute inset-0"
                onError={(e) => {
                    e.currentTarget.src = `https://via.placeholder.com/800x400?text=${item.category}+Image`;
                }}
            />
            <div className="absolute inset-0 bg-black bg-opacity-40 flex items-end p-6">
                <div className="text-white">
                    <span
                        className={`${
                            item.category === "BREAKING"
                                ? "bg-red-600"
                                : item.category === "TECHNOLOGY"
                                ? "bg-blue-600"
                                : "bg-green-600"
                        } text-xs font-semibold px-2 py-1 rounded`}
                    >
                        {item.category}
                    </span>
                    <h2 className="text-3xl font-bold mt-2">{item.title}</h2>
                    <p className="mt-2">{item.content}</p>
                </div>
            </div>
        </div>
    ));

    return (
        <>
            <Head title="News Portal" />
            <Navbar currentRoute={""} />
            {/* Page layout */}
            <div className="flex pt-16 h-screen overflow-hidden">

                {/* Left Advertisement - Fixed */}
                <div className="w-1/6 fixed left-0 top-2 bottom-0 bg-white overflow-hidden z-40">
                    <Advertisement
                        firstImage="https://images.unsplash.com/photo-1586339949916-3e9457bef6d3"
                        secondImage="https://images.unsplash.com/photo-1586339949916-3e9457bef6d3"
                        thirdImage="https://images.unsplash.com/photo-1586339949916-3e9457bef6d3"
                        forthImage="https://images.unsplash.com/photo-1586339949916-3e9457bef6d3"
                    />
                </div>

                {/* Main Content - Scrollable */}
                <main className="w-4/6 mx-[16.67%] overflow-y-auto h-full px-4 pb-16">
                    {/* Commodity Cards */}
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-4 my-5">
                        <CommodityCard icon={<span>💰</span>} name="Gold (24K)" value={prices.gold} unit="/g" color="yellow" />
                        <CommodityCard icon={<span>🥈</span>} name="Silver" value={prices.silver} unit="/g" color="gray" />
                        <CommodityCard icon={<span>🛢️</span>} name="Crude Oil" value={prices.crudeOil} unit="/barrel" color="blue" />
                    </div>

                    {/* Carousel */}
                    <section>
                        <h1 className="text-3xl font-bold my-2">Latest News</h1>
                        <Carousel items={carouselItems} autoPlay={true} interval={5000} showControls={true} showIndicators={true} />
                    </section>

                    {/* News */}
                    <NewsHeadlines />

                    <div className="flex gap-2 mt-4">
                        <NewsBlock />
                        <NewsBlock />
                    </div>

                    {/* Featured News */}
                    <section className="my-8 rounded shadow-md p-5">
                        <h2 className="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">
                            Featured News
                        </h2>
                        <div className="grid md:grid-cols-2 gap-6">
                            {articles.map((article) => (
                                <Card key={article.id} className="hover:shadow-lg transition-shadow">
                                    <div className="relative">
                                        <img
                                            src="https://images.unsplash.com/photo-1586339949916-3e9457bef6d3"
                                            alt={article.title}
                                            className="w-full h-48 object-cover"
                                        />
                                        <div className="absolute top-3 left-3">
                                            <Badge variant="secondary">{article.category.name}</Badge>
                                        </div>
                                    </div>
                                    <CardContent className="p-4">
                                        <h4 className="font-bold text-gray-900 mb-2 line-clamp-2">
                                            {article.title}
                                        </h4>
                                        <p className="text-gray-600 text-sm mb-4 line-clamp-2">
                                            {article.content.substring(0, 100)}
                                        </p>
                                        <div className="flex justify-between text-xs text-gray-500">
                                            <div className="flex items-center">
                                                <Clock className="h-3 w-3 mr-1" />
                                                {article.created_at}
                                            </div>
                                        </div>
                                    </CardContent>
                                </Card>
                            ))}
                        </div>
                    </section>
                </main>

                {/* Right Advertisement - Fixed */}
                <div className="w-1/6 fixed right-0 top-2 bottom-0 bg-white overflow-hidden z-40">
                    <Advertisement
                        firstImage="https://images.unsplash.com/photo-1586339949916-3e9457bef6d3"
                        secondImage="https://images.unsplash.com/photo-1586339949916-3e9457bef6d3"
                    />
                </div>
            </div>
        </>
    );
};

export default Index;
