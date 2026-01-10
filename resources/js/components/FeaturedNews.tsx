import { Article } from "../components/news/type";
import { useLanguage } from "../context/LanguageContext";
import NewsCard from "./NewsCard";

interface FeaturedNewsProps {
    articles: Article[];
}

export default function FeaturedNews({ articles }: FeaturedNewsProps) {
    const { t } = useLanguage();
    
    return (
        <section className="bg-white rounded-lg p-6">
            <h3 className="font-bold text-2xl md:text-3xl text-gray-800 mb-6 pb-2">
                {t('featured_news')}
            </h3>
            <div className="grid md:grid-cols-2 gap-6">
                {articles.map((article) => (
                    <NewsCard key={article.id} article={article} />
                ))}
            </div>
        </section>
    );
}
