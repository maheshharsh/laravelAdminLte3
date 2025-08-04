import React from "react";
import { Head } from "@inertiajs/react";
import NewsHeadlines from "../../components/NewsHeadlines";
import NewsBlock from "../../components/NewsBlock";
import AppLayout from "../../layouts/AppLayout";
import { Article, HeadlinesProps } from "../../components/news/type";

interface Props {
    articles: Article[];
    headlines: HeadlinesProps[];
}

const Index: React.FC<Props> = ({ articles, headlines }) => {
    // Safely get the first category name
    const firstCategory = articles[0]?.category?.name || 
                         headlines[0]?.category_name || 
                         'General';

    // Filter articles by the first category
    const filteredArticles = articles.filter(
        article => article.category?.name === firstCategory
    );

    return (
        <AppLayout currentRoute="/sports">
            <Head title={firstCategory} />
            <h1 className="font-bold text-4xl px-4 py-4">
                {firstCategory}
            </h1>
            <div className="">
                <NewsHeadlines headlines={headlines} />
                <NewsBlock 
                    title={`${firstCategory} Developments`} 
                    category={firstCategory} 
                    articles={filteredArticles}
                />
            </div>
        </AppLayout>
    );
};

export default Index;