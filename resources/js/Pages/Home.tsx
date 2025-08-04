import React, { useState, useEffect } from "react";
import { Head, Link } from "@inertiajs/react";
import AppLayout from "../layouts/AppLayout";
import CommodityCard from "../components/CommodityCard";
import NewsCarousel from "../components/Carousel";
import NewsHeadlines from "../components/NewsHeadlines";
import NewsBlock from "../components/NewsBlock";
import FeaturedNews from "../components/FeaturedNews";
import {
    Article,
    HeadlinesProps,
    CommodityPrices,
} from "../components/news/type";
import sanitizeHtml from "sanitize-html";
import axios from "axios";


interface Props {
    articles: Article[];
    headlines: HeadlinesProps[];
    commodities: CommodityPrices[];
}

export default function Home({ articles, headlines, commodities }: Props) {
    // Default image URL (use a public asset or external placeholder)
    const defaultImage = "/images/default_image.jpg"; // Adjust to match your public directory structure

    // // API fetch functions
    // const fetchGoldPrice = async (): Promise<number> => {
    //     try {
    //         // Example using MetalPriceAPI
    //         const response = await axios.get(
    //             `https://api.metalpriceapi.com/v1/latest?api_key=3bab9b90ee57aac3b9b5d9e45277e892&base=XAU&currencies=USD`
    //             // `https://api.metalpriceapi.com/v1/latest?api_key=${process.env.METAL_PRICE_API_KEY}&base=XAU&currencies=USD`
    //         );
    //         // Convert from per ounce to per gram (1 oz = 31.1035 g)
    //         return response.data.rates.USD / 31.1035;
    //     } catch (error) {
    //         console.error("Error fetching gold price:", error);
    //         return 58.32; // Fallback value
    //     }
    // };

    // const fetchSilverPrice = async (): Promise<number> => {
    //     try {
    //         // Example using MetalPriceAPI
    //         const response = await axios.get(
    //             `https://api.metalpriceapi.com/v1/latest?api_key=3bab9b90ee57aac3b9b5d9e45277e892&base=XAG&currencies=USD`
    //         );
    //         // Convert from per ounce to per gram (1 oz = 31.1035 g)
    //         return response.data.rates.USD / 31.1035;
    //     } catch (error) {
    //         console.error("Error fetching silver price:", error);
    //         return 0.72; // Fallback value
    //     }
    // };

    // const fetchCrudeOilPrice = async (): Promise<number> => {
    //     try {
    //         // Example using Alpha Vantage
    //         const response = await axios.get(
    //             `https://www.alphavantage.co/query?function=WTI&interval=daily&apikey=3DX1TEWZZ03H1DV9`
    //             // `https://www.alphavantage.co/query?function=WTI&interval=daily&apikey=${process.env.ALPHA_VANTAGE_API_KEY}`
    //         );
    //         // Get the latest price from the time series
    //         const latestData = response.data.data[0];
    //         return parseFloat(latestData.value);
    //     } catch (error) {
    //         console.error("Error fetching crude oil price:", error);
    //         return 78.45; // Fallback value
    //     }
    // };

    // Rest of your component remains the same...
    const sanitizeContent = (content: string) =>
        sanitizeHtml(content, {
            allowedTags: sanitizeHtml.defaults.allowedTags.concat([
                "img",
                "h1",
                "h2",
                "h3",
                "h4",
                "h5",
                "h6",
                "ul",
                "ol",
                "li",
                "a",
                "p",
                "b",
                "i",
                "strong",
                "em",
            ]),
            allowedAttributes: {
                a: ["href", "target", "rel"],
                img: ["src", "alt", "width", "height"],
            },
        });

    const carouselArticles = articles.filter((article) => article.is_carousel)
        .length
        ? articles.filter((article) => article.is_carousel)
        : articles.slice(0, 3);

    const uniqueCategories = Array.from(
        new Set(
            articles.map((article) => article.category.name).filter(Boolean)
        )
    );

    return (
        <AppLayout currentRoute="/">
            <Head title="News Portal" />

            <div className="grid grid-cols-1 md:grid-cols-6 text-center gap-4 my-5">
                {commodities.map((commoditie, index) => (
                    <CommodityCard
                        title={commoditie.title}
                        price={commoditie.price}
                        // unit="/g"
                        lastUpdated={commoditie.created_at}
                    />
                ))}
            </div>

            {/* Rest of your JSX remains the same */}
            <div>
                <section>
                    <h1 className="text-3xl font-bold mb-4">Latest News</h1>
                    {carouselArticles.length > 0 ? (
                        <NewsCarousel
                            items={carouselArticles.map((article, index) => (
                                <Link
                                    key={index}
                                    href={`/articles/${article.id}`}
                                    className="relative w-full h-96 bg-gray-100 rounded-lg overflow-hidden block"
                                >
                                    <img
                                        src={
                                            article.image
                                                ? article.image
                                                : defaultImage
                                        }
                                        alt={article.title}
                                        className="w-full h-full object-cover"
                                    />

                                    <div className="absolute bottom-0 left-0 right-0 bg-black/50 text-white p-4">
                                        <h2 className="text-2xl font-bold mb-2">
                                            {article.title}
                                        </h2>
                                        <div
                                            className="text-sm line-clamp-3"
                                            dangerouslySetInnerHTML={{
                                                __html: sanitizeContent(
                                                    article.content
                                                ),
                                            }}
                                        />
                                    </div>
                                </Link>
                            ))}
                            autoPlay={true}
                            interval={3000}
                            showControls={true}
                            showIndicators={true}
                        />
                    ) : (
                        <p className="text-gray-500">
                            No carousel articles available.
                        </p>
                    )}
                </section>

                {/* news haeline section */}
                <NewsHeadlines headlines={headlines} />

                {/* feature news section */}
                <FeaturedNews
                    articles={articles.filter((article) => article.is_featured)}
                />

                {/* news block section */}
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                    {uniqueCategories.length > 0 ? (
                        uniqueCategories.map((category, index) => (
                            <NewsBlock
                                key={index}
                                title={`${category} News`}
                                category={category.toLowerCase()}
                                articles={articles
                                    .filter((a) => a.category.name === category)
                                    .slice(0, 4)}
                            />
                        ))
                    ) : (
                        <p className="text-gray-500">
                            No categories available.
                        </p>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}
