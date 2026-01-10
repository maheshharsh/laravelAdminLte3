import { useState, useEffect, useRef } from 'react';

interface ImageItem {
  src: string;
  alt?: string;
  title?: string;
  description?: string;
}

interface ImageCarouselProps {
  images: ImageItem[];
  autoPlay?: boolean;
  interval?: number;
  showControls?: boolean;
  showIndicators?: boolean;
  adaptiveHeight?: boolean;
  maxHeight?: number;
  minHeight?: number;
  objectFit?: 'cover' | 'contain' | 'fill' | 'scale-down' | 'none';
  className?: string;
}

const ImageCarousel = ({
  images,
  autoPlay = true,
  interval = 3000,
  showControls = true,
  showIndicators = true,
  adaptiveHeight = true,
  maxHeight = 500,
  minHeight = 200,
  objectFit = 'cover',
  className = '',
}: ImageCarouselProps) => {
  const [currentIndex, setCurrentIndex] = useState(0);
  const [carouselHeight, setCarouselHeight] = useState<number>(minHeight);
  const [imagesLoaded, setImagesLoaded] = useState<boolean[]>(new Array(images.length).fill(false));
  const carouselRef = useRef<HTMLDivElement>(null);

  const nextSlide = () => {
    setCurrentIndex((prevIndex) => 
      prevIndex === images.length - 1 ? 0 : prevIndex + 1
    );
  };

  const prevSlide = () => {
    setCurrentIndex((prevIndex) => 
      prevIndex === 0 ? images.length - 1 : prevIndex - 1
    );
  };

  // Auto-play effect
  useEffect(() => {
    if (!autoPlay || images.length <= 1) return;

    const timer = setInterval(() => {
      nextSlide();
    }, interval);

    return () => clearInterval(timer);
  }, [currentIndex, autoPlay, interval, images.length]);

  // Handle image load
  const handleImageLoad = (index: number, img: HTMLImageElement) => {
    setImagesLoaded(prev => {
      const newLoaded = [...prev];
      newLoaded[index] = true;
      return newLoaded;
    });

    // Update height if this is the current image and adaptive height is enabled
    if (index === currentIndex && adaptiveHeight && carouselRef.current) {
      const containerWidth = carouselRef.current.offsetWidth;
      const aspectRatio = img.naturalHeight / img.naturalWidth;
      let calculatedHeight = containerWidth * aspectRatio;
      
      // Apply constraints
      if (calculatedHeight > maxHeight) {
        calculatedHeight = maxHeight;
      } else if (calculatedHeight < minHeight) {
        calculatedHeight = minHeight;
      }
      
      setCarouselHeight(calculatedHeight);
    }
  };

  // Update height when current index changes
  useEffect(() => {
    if (!adaptiveHeight || !carouselRef.current || !imagesLoaded[currentIndex]) return;

    const updateHeight = () => {
      const currentImg = carouselRef.current?.querySelector(`[data-slide="${currentIndex}"] img`) as HTMLImageElement;
      if (currentImg && currentImg.complete) {
        const containerWidth = carouselRef.current?.offsetWidth || 0;
        const aspectRatio = currentImg.naturalHeight / currentImg.naturalWidth;
        let calculatedHeight = containerWidth * aspectRatio;
        
        // Apply constraints
        if (calculatedHeight > maxHeight) {
          calculatedHeight = maxHeight;
        } else if (calculatedHeight < minHeight) {
          calculatedHeight = minHeight;
        }
        
        setCarouselHeight(calculatedHeight);
      }
    };

    updateHeight();
    
    // Handle window resize
    const handleResize = () => updateHeight();
    window.addEventListener('resize', handleResize);
    return () => window.removeEventListener('resize', handleResize);
  }, [currentIndex, adaptiveHeight, maxHeight, minHeight, imagesLoaded]);

  if (images.length === 0) {
    return (
      <div className={`flex items-center justify-center bg-gray-200 rounded-lg ${className}`} style={{ height: minHeight }}>
        <p className="text-gray-500">No images to display</p>
      </div>
    );
  }

  return (
    <div 
      ref={carouselRef}
      className={`relative w-full overflow-hidden rounded-lg transition-all duration-300 ${className}`}
      style={{ 
        height: adaptiveHeight ? `${carouselHeight}px` : 'auto',
        minHeight: `${minHeight}px`
      }}
    >
      {/* Images container */}
      <div 
        className="flex h-full transition-transform duration-500 ease-in-out"
        style={{ transform: `translateX(-${currentIndex * 100}%)` }}
      >
        {images.map((image, index) => (
          <div 
            key={index}
            data-slide={index}
            className="w-full h-full flex-none relative"
          >
            <img
              src={image.src}
              alt={image.alt || `Slide ${index + 1}`}
              className={`w-full h-full object-${objectFit}`}
              onLoad={(e) => handleImageLoad(index, e.currentTarget)}
              onError={(e) => {
                // Fallback image
                e.currentTarget.src = `https://via.placeholder.com/800x400/f3f4f6/9ca3af?text=Image+${index + 1}`;
              }}
            />
            
            {/* Overlay content */}
            {(image.title || image.description) && (
              <div className="absolute inset-0 bg-black bg-opacity-30 flex items-end p-6">
                <div className="text-white">
                  {image.title && (
                    <h3 className="text-xl font-bold mb-2">{image.title}</h3>
                  )}
                  {image.description && (
                    <p className="text-sm opacity-90">{image.description}</p>
                  )}
                </div>
              </div>
            )}
          </div>
        ))}
      </div>

      {/* Controls */}
      {showControls && images.length > 1 && (
        <>
          <button 
            onClick={prevSlide}
            className="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 text-white p-2 rounded-full hover:bg-black/50 focus:outline-none focus:ring-2 focus:ring-white/20 transition-colors"
            aria-label="Previous slide"
          >
            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
            </svg>
          </button>
          <button 
            onClick={nextSlide}
            className="absolute right-4 top-1/2 -translate-y-1/2 bg-black/30 text-white p-2 rounded-full hover:bg-black/50 focus:outline-none focus:ring-2 focus:ring-white/20 transition-colors"
            aria-label="Next slide"
          >
            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </>
      )}

      {/* Indicators */}
      {showIndicators && images.length > 1 && (
        <div className="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
          {images.map((_, index) => (
            <button
              key={index}
              onClick={() => setCurrentIndex(index)}
              className={`h-2 rounded-full transition-all focus:outline-none focus:ring-2 focus:ring-white/20 ${
                index === currentIndex 
                  ? 'bg-white w-6' 
                  : 'bg-white/50 w-2 hover:bg-white/70'
              }`}
              aria-label={`Go to slide ${index + 1}`}
            />
          ))}
        </div>
      )}

      {/* Loading indicator for current image */}
      {!imagesLoaded[currentIndex] && (
        <div className="absolute inset-0 flex items-center justify-center bg-gray-100">
          <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-600"></div>
        </div>
      )}
    </div>
  );
};

export default ImageCarousel;