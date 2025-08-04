import React from "react";
import { Link } from "@inertiajs/react";
import { Article } from "./news/type";
import sanitizeHtml from "sanitize-html";

interface NewsBlockProps {
  title: string;
  category: string;
  articles: Article[];
}

function NewsBlock({ title, category, articles }: NewsBlockProps) {
    // Sanitize HTML content for safe rendering
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

    // Default image URL (use a public asset or external placeholder)
    const defaultImage = "/images/default_image.jpg"; // Adjust to match your public directory structure

    return (
        <div className="mx-auto p-4">
            <div className="border-l-4 border-red-600 pl-3 mb-6">
                <h3 className="font-bold text-2xl md:text-3xl text-gray-800">
                    {title}
                </h3>
            </div>

            {articles.length === 0 ? (
                <p className="text-gray-500">No articles available for {title}.</p>
            ) : (
                <div className="flex flex-col gap-6">
                    {/* Featured News */}
                    {articles[0] && (
                        <div className="relative group">
                            <div className="overflow-hidden ">
                                <img
                                    src={
                                        articles[0].image ||
                                        defaultImage 
                                    }
                                    alt={articles[0].title}
                                    className="w-full h-64 md:h-80 object-cover transition-transform duration-500 group-hover:scale-105"
                                    onError={(e) => {
                                        console.log(`Failed to load image for ${articles[0].title}:`, e.currentTarget.src);
                                        e.currentTarget.src = defaultImage;
                                    }}
                                />
                                <div className="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                                <div className="absolute bottom-0 left-0 p-4 text-white">
                                    <span className="bg-red-600 text-xs font-semibold px-2 py-1 rounded">
                                        {articles[0].category_name}
                                    </span>
                                    <h4 className="text-xl md:text-2xl font-bold mt-2 leading-tight">
                                        <Link
                                            href={`/articles/${articles[0].id}`}
                                            className="hover:underline"
                                        >
                                            {articles[0].title}
                                        </Link>
                                    </h4>
                                    <p className="text-sm text-gray-300 mt-1">
                                        {articles[0].published_at}
                                    </p>
                                </div>
                            </div>
                        </div>
                    )}

                    {/* News List */}
                    <div className="w-full space-y-4">
                        {articles.slice(articles[0] && articles.length > 1 ? 1 : 0, 4).map((article) => (
                            <div
                                key={article.id}
                                className="flex gap-4 pb-4 border-b border-gray-200 last:border-0 group"
                            >
                                <div className="w-20 h-20 flex-shrink-0 overflow-hidden rounded">
                                    <img
                                        src={
                                            article.image ||
                                            defaultImage 
                                        }
                                        alt={article.title}
                                        className="w-full h-full object-cover group-hover:scale-110 transition-transform"
                                        onError={(e) => {
                                            console.log(`Failed to load image for ${article.title}:`, e.currentTarget.src);
                                            e.currentTarget.src = defaultImage;
                                        }}
                                    />
                                </div>
                                <div className="flex-1">
                                    <h5 className="font-semibold text-gray-800 group-hover:text-red-600 transition-colors">
                                        <Link
                                            href={`/articles/${article.id}`}
                                            className="hover:underline"
                                        >
                                            {article.title}
                                        </Link>
                                    </h5>
                                    <p
                                        className="text-sm text-gray-700 mt-1 line-clamp-2"
                                        dangerouslySetInnerHTML={{
                                            __html: sanitizeContent(article.content),
                                        }}
                                    />
                                    <p className="text-xs text-gray-500 mt-1">
                                        {article.published_at}
                                    </p>
                                    <span className="inline-block mt-2 text-xs font-medium px-2 py-1 bg-gray-100 rounded-full">
                                        #{category.toLowerCase()} trending
                                    </span>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            )}
        </div>
    );
}

export default NewsBlock;