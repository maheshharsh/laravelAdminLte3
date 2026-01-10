export interface Article {
    media: any;
    id: number;
    title: string;
    slug: string;
    content: string;
    category: { name: string };
    featured_image?: string;
    image?: string;
    is_featured?: boolean;
    is_carousel?: boolean;
    created_at: string;
    published_at: string;
    excerpt: string;
    category_name: string;
    video_file?: string;
    video_thumbnail?: string;
    video_description?: string;
}

export interface HeadlinesProps {
    id: number;
    title: string;
    content: string;
    category_name: string;
    slug: string;
    time?: string;
    created_at: string;
    published_at?: string;
}
export interface CommodityPrices {
    title: string;
    price: number;
    created_at: string;
}

export interface AdvertisementProps {
    id: number;
    title: string;
    adv_image: string;
}

export interface FeaturedNewsProps {
    articles: Article[];
}

export interface NewsCardProps {
    article: Article;
}
