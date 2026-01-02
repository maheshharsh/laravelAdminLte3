// src/Pages/Index.tsx

import React, { ReactNode, useEffect, useState } from "react";
import { Link, Head } from "@inertiajs/react";
import AppLayout from "../layouts/AppLayout";
import ImageCarousel from "../components/ImageCarousel";
import CommodityCard from "../components/CommodityCard";
import NewsHeadlines from "../components/NewsHeadlines";
import NewsBlock from "../components/NewsBlock";
import { Card, CardContent } from "../components/ui/card";
import { Badge } from "../components/ui/badge";
import { Clock } from "lucide-react";

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

    const carouselImages = [
        {
            src: "https://images.unsplash.com/photo-1586339949916-3e9457bef6d3?auto=format&fit=crop&w=1200&q=80",
            alt: "Global Summit Addresses Climate Change",
            title: "Global Summit Addresses Climate Change",
            description: "World leaders gather to discuss urgent climate action plans..."
        },
        {
            src: "https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80",
            alt: "New AI Breakthrough Revolutionizes Healthcare",
            title: "New AI Breakthrough Revolutionizes Healthcare",
            description: "Researchers develop AI that can predict diseases with 95% accuracy..."
        },
        {
            src: "https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?auto=format&fit=crop&w=1200&q=80",
            alt: "National Team Wins Championship After Decade",
            title: "National Team Wins Championship After Decade",
            description: "Historic victory celebrated nationwide as underdogs take the title..."
        }
    ];

    return (
        <AppLayout currentRoute="">
            <Head title="News Portal" />
            {/* Commodity Cards */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4 my-5">
                <CommodityCard title="Gold (24K)" price={prices.gold} unit="/g" lastUpdated={prices.lastUpdated} />
                <CommodityCard title="Silver" price={prices.silver} unit="/g" lastUpdated={prices.lastUpdated} />
                <CommodityCard title="Crude Oil" price={prices.crudeOil} unit="/barrel" lastUpdated={prices.lastUpdated} />
            </div>

            {/* Carousel */}
            <section>
                <h1 className="text-3xl font-bold my-2">Latest News</h1>
                <ImageCarousel 
                    images={carouselImages} 
                    autoPlay={true} 
                    interval={5000} 
                    showControls={true} 
                    showIndicators={true}
                    adaptiveHeight={true}
                    maxHeight={500}
                    minHeight={300}
                    objectFit="cover"
                />
            </section>

            {/* News */}
            <NewsHeadlines headlines={[]} />

            <div className="flex gap-2 mt-4">
                <NewsBlock title="Breaking News" category="news" articles={[]} />
                <NewsBlock title="Sports" category="sports" articles={[]} />
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
        </AppLayout>
    );
};

export default Index;
