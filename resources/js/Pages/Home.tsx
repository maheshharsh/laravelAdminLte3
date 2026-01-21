import React, { useState, useEffect } from "react";
import { Head, Link } from "@inertiajs/react";
import AppLayout from "../layouts/AppLayout";
import CommodityCard from "../components/CommodityCard";
import NewsCarousel from "../components/Carousel";
import NewsHeadlines from "../components/NewsHeadlines";
import NewsBlock from "../components/NewsBlock";
import FeaturedNews from "../components/FeaturedNews";
import { useLanguage } from "../context/LanguageContext";
import {
    Article,
    HeadlinesProps,
    CommodityPrices,
} from "../components/news/type";
import sanitizeHtml from "sanitize-html";


interface Props {
    articles: Article[];
    headlines: HeadlinesProps[];
    commodities: CommodityPrices[];
}

export default function Home({ articles, headlines, commodities }: Props) {
    const { language, t } = useLanguage();
    
    // State for managing news display
    const [showAllNews, setShowAllNews] = useState(false);
    const [showAllHeadlines, setShowAllHeadlines] = useState(false);
    const [showAllFeatured, setShowAllFeatured] = useState(false);
    
    // Default image URL (use a public asset or external placeholder)
    const defaultImage = "/images/default_image.jpg"; // Adjust to match your public directory structure

    // Get featured articles for hero section with safe handling
    const featuredArticle = (articles && articles.length > 0) ? articles[0] : null;
    
    // News limits and display logic
    const maxNewsLimit = 10;
    const maxHeadlinesLimit = 10;
    const maxFeaturedLimit = 10;
    
    const displayedNews = showAllNews ? articles.slice(1) : articles.slice(1, maxNewsLimit + 1);
    const displayedHeadlines = showAllHeadlines ? headlines : headlines.slice(0, maxHeadlinesLimit);
    const featuredArticles = articles.filter(article => article.is_featured || false).slice(0, maxFeaturedLimit);
    const displayedFeatured = showAllFeatured ? featuredArticles : featuredArticles.slice(0, maxFeaturedLimit);
    const breakingNews = (headlines && headlines.length > 0) ? headlines.slice(0, 5) : [];

    // Format date function
    const formatDate = (dateString: string) => {
        try {
            const locale = language === 'hi' ? 'hi-IN' : 'en-IN';
            return new Date(dateString).toLocaleDateString(locale, {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        } catch (error) {
            return dateString;
        }
    };

    // Sanitize content function with error handling
    const sanitizeContent = (content: string) => {
        if (!content) return '';
        try {
            return sanitizeHtml(content, {
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
        } catch (error) {
            console.error('Content sanitization error:', error);
            return content || '';
        }
    };

    const carouselArticles = articles.filter((article) => article.is_carousel)
        .length > 0
        ? articles.filter((article) => article.is_carousel)
        : articles.slice(0, 5); // Show first 5 articles if no carousel articles

    const uniqueCategories = Array.from(
        new Set(
            articles.map((article) => article.category.name).filter(Boolean)
        )
    );

    return (
        <AppLayout currentRoute="/">
            <Head title={`${t('brand_name')} - ${t('home')}`} />

            <div className="editorial-container">
                {/* Breaking News Ticker */}
                {breakingNews.length > 0 && (
                    <div className="editorial-breaking-news">
                        <div className="editorial-breaking-label">{t('breaking_news')}</div>
                        <div className="editorial-breaking-content">
                            <div className="editorial-breaking-scroll">
                                {breakingNews.map((news, index) => (
                                    <span key={index} className="editorial-breaking-item">
                                        {news.title}
                                    </span>
                                ))}
                            </div>
                        </div>
                    </div>
                )}

                {/* Commodities/Market Prices Section */}
                {commodities && commodities.length > 0 && (
                    <section className="editorial-commodities-section">
                        <div className="editorial-section-header">
                            <h2 className="editorial-section-title">{t('brand_name')} - {t('commodities')}</h2>
                            <div className="editorial-section-divider"></div>
                        </div>
                        
                        <div className="editorial-commodities-grid">
                            {commodities.map((commodity, index) => (
                                <div key={index} className="commodity-card">
                                    <h3>{commodity.title}</h3>
                                    <p className="price">₹{parseFloat(String(commodity.price)).toFixed(2)}</p>
                                    {/* <p className="updated">{formatDate(commodity.updated_at)}</p> */}
                                </div>
                            ))}
                        </div>
                    </section>
                )}

                {/* 1. Main Carousel Section - First Priority */}
                {articles && articles.length > 0 && (
                    <section className="editorial-carousel-section">
                        <div className="editorial-section-header">
                            <h2 className="editorial-section-title">{t('headlines')}</h2>
                            <div className="editorial-section-divider"></div>
                        </div>
                        
                        <div className="editorial-carousel-wrapper">
                            <NewsCarousel
                                items={carouselArticles.map((article) => (
                                    <Link
                                        key={article.id}
                                        href={`/articles/${article.id}`}
                                        className="editorial-carousel-item"
                                    >
                                        <div className="editorial-carousel-image-wrapper">
                                            <img
                                                src={article.image || defaultImage}
                                                alt={article.title}
                                                className="editorial-carousel-image"
                                                onError={(e) => {
                                                    e.currentTarget.src = defaultImage;
                                                }}
                                            />
                                            <div className="editorial-carousel-overlay"></div>
                                        </div>
                                        <div className="editorial-carousel-content">
                                            <div className="editorial-carousel-category">
                                                {article.category.name}
                                            </div>
                                            <h3 className="editorial-carousel-title">{article.title}</h3>
                                            <p className="editorial-carousel-summary">
                                                {sanitizeContent(article.content).substring(0, 120)}...
                                            </p>
                                            <div className="editorial-carousel-meta">
                                                <span className="editorial-carousel-date">
                                                    {formatDate(article.created_at)}
                                                </span>
                                                <span className="editorial-carousel-readmore">
                                                    पढ़ें →
                                                </span>
                                            </div>
                                        </div>
                                    </Link>
                                ))}
                                autoPlay={true}
                                interval={5000}
                                showControls={true}
                                showIndicators={true}
                                adaptiveHeight={true}
                                maxHeight="600px"
                                minHeight="400px"
                            />
                        </div>
                    </section>
                )}

                {/* 2. Headlines Section */}
                {displayedHeadlines.length > 0 && (
                    <section className="editorial-headlines-section">
                        <div className="editorial-section-header">
                            <h2 className="editorial-section-title">मुख्य शीर्षक</h2>
                            <div className="editorial-section-divider"></div>
                        </div>
                        
                        <div className="editorial-headlines-grid">
                            {displayedHeadlines.map((headline, index) => (
                                <Link
                                    key={index}
                                    href={`/headline/${headline.id}`}
                                    className="editorial-headline-item"
                                >
                                    <h3 className="editorial-headline-title">{headline.title}</h3>
                                    <span className="editorial-headline-meta">
                                        {formatDate(headline.created_at)}
                                    </span>
                                </Link>
                            ))}
                        </div>
                        
                        {headlines.length > maxHeadlinesLimit && (
                            <div className="editorial-see-more">
                                <button 
                                    onClick={() => setShowAllHeadlines(!showAllHeadlines)}
                                    className="editorial-see-more-btn"
                                >
                                    {showAllHeadlines ? t('show_less') : t('see_more')} ({headlines.length - maxHeadlinesLimit} {t('more')})
                                </button>
                            </div>
                        )}
                    </section>
                )}

                {/* 3. Featured News Section */}
                {featuredArticles.length > 0 && (
                    <section className="editorial-featured-section">
                        <div className="editorial-section-header">
                            <h2 className="editorial-section-title">{t('featured_news')}</h2>
                            <div className="editorial-section-divider"></div>
                        </div>
                        
                        <div className="editorial-featured-grid">
                            {displayedFeatured.map((article) => (
                                <Link
                                    key={article.id}
                                    href={`/articles/${article.id}`}
                                    className="editorial-featured-card"
                                >
                                    <div className="editorial-featured-image-wrapper">
                                        <img
                                            src={article.image || defaultImage}
                                            alt={article.title}
                                            className="editorial-featured-image"
                                            onError={(e) => {
                                                e.currentTarget.src = defaultImage;
                                            }}
                                        />
                                        <div className="editorial-featured-category">
                                            {article.category.name}
                                        </div>
                                    </div>
                                    <div className="editorial-featured-content">
                                        <h3 className="editorial-featured-title">{article.title}</h3>
                                        <p className="editorial-featured-excerpt">
                                            {sanitizeContent(article.content).substring(0, 100)}...
                                        </p>
                                        <span className="editorial-featured-date">
                                            {formatDate(article.created_at)}
                                        </span>
                                    </div>
                                </Link>
                            ))}
                        </div>
                        
                        {featuredArticles.length > maxFeaturedLimit && (
                            <div className="editorial-see-more">
                                <button 
                                    onClick={() => setShowAllFeatured(!showAllFeatured)}
                                    className="editorial-see-more-btn"
                                >
                                    {showAllFeatured ? t('show_less') : t('see_more')} ({featuredArticles.length - maxFeaturedLimit} {t('more')})
                                </button>
                            </div>
                        )}
                    </section>
                )}

                {/* 4. Other News Section */}
                {displayedNews.length > 0 && (
                    <section className="editorial-other-news-section">
                        <div className="editorial-section-header">
                            <h2 className="editorial-section-title">{t('other_news')}</h2>
                            <div className="editorial-section-divider"></div>
                        </div>
                        
                        <div className="editorial-other-news-grid">
                            {displayedNews.map((article) => (
                                <Link
                                    key={article.id}
                                    href={`/articles/${article.id}`}
                                    className="editorial-other-news-card"
                                >
                                    <div className="editorial-other-news-image-wrapper">
                                        <img
                                            src={article.image || defaultImage}
                                            alt={article.title}
                                            className="editorial-other-news-image"
                                            onError={(e) => {
                                                e.currentTarget.src = defaultImage;
                                            }}
                                        />
                                        <div className="editorial-other-news-category">
                                            {article.category.name}
                                        </div>
                                    </div>
                                    <div className="editorial-other-news-content">
                                        <h3 className="editorial-other-news-title">{article.title}</h3>
                                        <p className="editorial-other-news-excerpt">
                                            {sanitizeContent(article.content).substring(0, 80)}...
                                        </p>
                                        <span className="editorial-other-news-date">
                                            {formatDate(article.created_at)}
                                        </span>
                                    </div>
                                </Link>
                            ))}
                        </div>
                        
                        {articles.length > maxNewsLimit + 1 && (
                            <div className="editorial-see-more">
                                <button 
                                    onClick={() => setShowAllNews(!showAllNews)}
                                    className="editorial-see-more-btn"
                                >
                                    {showAllNews ? t('show_less') : t('see_more')} ({articles.length - maxNewsLimit - 1} {t('more')})
                                </button>
                            </div>
                        )}
                    </section>
                )}
            </div>
        </AppLayout>
    );
}
