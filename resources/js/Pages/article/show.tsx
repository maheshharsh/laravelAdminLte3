import React from "react";
import { Head, Link } from "@inertiajs/react";
import AppLayout from "../../layouts/AppLayout";
import { Badge } from "../../components/ui/badge";
import { Clock } from "lucide-react";
import sanitizeHtml from "sanitize-html";
import NewsCarousel from "../../components/Carousel";

// Extend Article type to include media
interface Media {
  path: string;
  alt?: string;
}

interface Article {
  title: string;
  content: string;
  image?: string;
  category_name: string;
  published_at: string;
  media: Media[];
}

interface ShowProps {
  article: Article;
}

const defaultImage = "/images/default_image.jpg";

export default function Show({ article }: ShowProps) {
  // Sanitize HTML content to prevent XSS
  const sanitizedContent = sanitizeHtml(article.content, {
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

  // Handle image errors
  const handleImageError = (e: React.SyntheticEvent<HTMLImageElement>) => {
    console.log(`Failed to load image:`, e.currentTarget.src);
    e.currentTarget.src = defaultImage;
  };

  return (
    <AppLayout currentRoute="article.show">
      <Head title={article.title} />

      <div className="mx-auto my-8 px-4 sm:px-6 lg:px-8">
        {/* Header Section */}
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

        {/* Featured Image */}
        <div className="mb-6">
          <img
            src={article.image ? article.image : defaultImage}
            alt={article.title}
            className="w-full h-64 sm:h-96 object-cover rounded-xl"
            onError={handleImageError}
          />
        </div>

        <div className="mb-6">
          <div className="flex justify-between items-center space-x-4">
            <Badge
              variant="secondary"
              className="bg-blue-200 text-blue-900"
            >
              {article.category_name}
            </Badge>
            <div className="flex items-center text-sm text-gray-500">
              <Clock className="h-4 w-4 mr-1" />
              {article.published_at}
            </div>
          </div>
          <h1 className="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight mt-3">
            {article.title}
          </h1>
        </div>

        {/* News Carousel */}
        {article.media.length > 0 ? (
          <NewsCarousel
            items={article.media.map((media, index) => (
              <img
                key={index}
                src={media.path ? media.path : defaultImage}
                alt={media.alt || `${article.title} media ${index + 1}`}
                className="w-full h-64 object-cover rounded-xl"
                onError={handleImageError}
              />
            ))}
            autoPlay={true}
            interval={3000}
            showControls={true}
            showIndicators={true}
          />
        ) : (
          undefined
        )}

        {/* Content Section */}
        <div
          className="prose prose-lg max-w-none text-gray-700 bg-white p-6 rounded-xl"
          dangerouslySetInnerHTML={{ __html: sanitizedContent }}
        />
      </div>
    </AppLayout>
  );
}