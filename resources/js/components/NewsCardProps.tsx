import React from "react";

interface NewsCardProps {
  imageUrl: string;
  title: string;
  content: string;
  category?: string;
  link?: string;
}

const NewsCard: React.FC<NewsCardProps> = ({ imageUrl, title, content, category, link }) => {
   // Default image URL (use a public asset or external placeholder)
   const defaultImage = "/images/default_image.jpg"; // Adjust to match your public directory structure

  return (
    <div className="border border-gray-300 mt-2 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-200">
      <img
        src={imageUrl ? imageUrl : defaultImage}
        alt={title}
        className="w-full h-48 object-cover"
      />
      <div className="p-4">
        {category && (
          <span className="inline-block bg-gray-200 text-gray-800 text-xs font-semibold px-2 py-1 rounded mb-2">
            {category}
          </span>
        )}
        <h3 className="text-lg font-semibold text-gray-900 mb-2">{title}</h3>
        <p className="text-gray-600 text-sm mb-4">{content}</p>
        {link && (
          <a
            href={link}
            className="text-blue-500 hover:underline text-sm"
            target="_blank"
            rel="noopener noreferrer"
          >
            Read More
          </a>
        )}
      </div>
    </div>
  );
};

export default NewsCard;