import { useState, useEffect, useRef } from 'react';

interface CarouselProps {
  items: React.ReactNode[];
  autoPlay?: boolean;
  interval?: number;
  showControls?: boolean;
  showIndicators?: boolean;
  adaptiveHeight?: boolean;
  maxHeight?: string;
  minHeight?: string;
}

const Carousel = ({
  items,
  autoPlay = true,
  interval = 3000,
  showControls = true,
  showIndicators = true,
  adaptiveHeight = false,
  maxHeight = '500px',
  minHeight = '200px',
}: CarouselProps) => {
  const [currentIndex, setCurrentIndex] = useState(0);
  const [carouselHeight, setCarouselHeight] = useState<string>(minHeight);
  const carouselRef = useRef<HTMLDivElement>(null);

  const nextSlide = () => {
    setCurrentIndex((prevIndex) => 
      prevIndex === items.length - 1 ? 0 : prevIndex + 1
    );
  };

  const prevSlide = () => {
    setCurrentIndex((prevIndex) => 
      prevIndex === 0 ? items.length - 1 : prevIndex - 1
    );
  };

  // Auto-play effect
  useEffect(() => {
    if (!autoPlay) return;

    const timer = setInterval(() => {
      nextSlide();
    }, interval);

    return () => clearInterval(timer);
  }, [currentIndex, autoPlay, interval]);

  // Adaptive height effect
  useEffect(() => {
    if (!adaptiveHeight || !carouselRef.current) return;

    const updateHeight = () => {
      const currentSlide = carouselRef.current?.children[0]?.children[currentIndex] as HTMLElement;
      if (currentSlide) {
        const img = currentSlide.querySelector('img');
        if (img) {
          // Wait for image to load if not already loaded
          if (img.complete) {
            const aspectRatio = img.naturalHeight / img.naturalWidth;
            const containerWidth = carouselRef.current?.offsetWidth || 0;
            let calculatedHeight = containerWidth * aspectRatio;
            
            // Apply max and min height constraints
            const maxHeightPx = parseInt(maxHeight);
            const minHeightPx = parseInt(minHeight);
            
            if (calculatedHeight > maxHeightPx) {
              calculatedHeight = maxHeightPx;
            } else if (calculatedHeight < minHeightPx) {
              calculatedHeight = minHeightPx;
            }
            
            setCarouselHeight(`${calculatedHeight}px`);
          } else {
            img.onload = () => {
              const aspectRatio = img.naturalHeight / img.naturalWidth;
              const containerWidth = carouselRef.current?.offsetWidth || 0;
              let calculatedHeight = containerWidth * aspectRatio;
              
              // Apply max and min height constraints
              const maxHeightPx = parseInt(maxHeight);
              const minHeightPx = parseInt(minHeight);
              
              if (calculatedHeight > maxHeightPx) {
                calculatedHeight = maxHeightPx;
              } else if (calculatedHeight < minHeightPx) {
                calculatedHeight = minHeightPx;
              }
              
              setCarouselHeight(`${calculatedHeight}px`);
            };
          }
        }
      }
    };

    updateHeight();
    
    // Also update on window resize
    window.addEventListener('resize', updateHeight);
    return () => window.removeEventListener('resize', updateHeight);
  }, [currentIndex, adaptiveHeight, maxHeight, minHeight]);

  return (
    <div 
      ref={carouselRef}
      className="relative w-full overflow-hidden rounded-lg transition-all duration-300"
      style={{ 
        height: adaptiveHeight ? carouselHeight : 'auto',
        minHeight: adaptiveHeight ? minHeight : 'auto'
      }}
    >
      {/* Carousel items container */}
      <div 
        className={`flex transition-transform duration-500 ease-in-out ${
          adaptiveHeight ? 'h-full' : ''
        }`}
        style={{ transform: `translateX(-${currentIndex * 100}%)` }}
      >
        {items.map((item, index) => (
          <div 
            key={index} 
            className={`w-full flex-none ${adaptiveHeight ? 'h-full' : ''}`}
          >
            {item}
          </div>
        ))}
      </div>

      {/* Rest of your carousel controls... */}
      {showControls && (
        <>
          <button 
            onClick={prevSlide}
            className="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 text-white p-2 rounded-full hover:bg-black/50 focus:outline-none"
            aria-label="Previous slide"
          >
            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
            </svg>
          </button>
          <button 
            onClick={nextSlide}
            className="absolute right-4 top-1/2 -translate-y-1/2 bg-black/30 text-white p-2 rounded-full hover:bg-black/50 focus:outline-none"
            aria-label="Next slide"
          >
            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </>
      )}

      {showIndicators && (
        <div className="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
          {items.map((_, index) => (
            <button
              key={index}
              onClick={() => setCurrentIndex(index)}
              className={`h-2 w-2 rounded-full transition-all ${index === currentIndex ? 'bg-white w-6' : 'bg-white/50'}`}
              aria-label={`Go to slide ${index + 1}`}
            />
          ))}
        </div>
      )}
    </div>
  );
};

export default Carousel;