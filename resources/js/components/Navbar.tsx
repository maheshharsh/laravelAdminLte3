import React, { useEffect, useState } from "react";
import { Link, usePage } from "@inertiajs/react";
import { useLanguage } from "../context/LanguageContext";
import axios from "axios";

interface NavbarProps {
  currentRoute: string;
}

interface CategoryData {
  name: string;
  slug: string;
}

function Navbar({ currentRoute }: NavbarProps) {
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const [categories, setCategories] = useState<CategoryData[]>([]);
  const [currentDateTime, setCurrentDateTime] = useState(new Date());
  const { url } = usePage();
  const { language, setLanguage, t } = useLanguage();

  useEffect(() => {
    const timer = setInterval(() => {
      setCurrentDateTime(new Date());
    }, 60000);
    return () => clearInterval(timer);
  }, []);

  const isActive = (route: string) => {
    const currentPath = url.replace(/^\/|\/$/g, "");
    const testPath = route.replace(/^\/|\/$/g, "");
    return currentPath === testPath || currentPath.startsWith(`${testPath}/`);
  };

  useEffect(() => {
    const fetchCategories = async () => {
      try {
        const response = await axios.get("/categories");
        setCategories(response.data.data);
      } catch (error) {
        console.error("Error fetching categories:", error);
      }
    };
    fetchCategories();
  }, []);

  const formatDateTime = (date: Date) => {
    if (language === 'hi') {
      return {
        date: date.toLocaleDateString('hi-IN', {
          weekday: 'long',
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        }),
        time: date.toLocaleTimeString('hi-IN', {
          hour: '2-digit',
          minute: '2-digit'
        })
      };
    } else {
      return {
        date: date.toLocaleDateString('en-IN', {
          weekday: 'long',
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        }),
        time: date.toLocaleTimeString('en-IN', {
          hour: '2-digit',
          minute: '2-digit'
        })
      };
    }
  };

  const { date, time } = formatDateTime(currentDateTime);

  return (
    <>
      {/* Editorial Header */}
      <header className="editorial-header">
        {/* Top Bar with Date and Quick Info */}
        <div className="editorial-topbar">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="flex items-center justify-between h-10 text-sm">
              <div className="flex items-center space-x-4">
                <span className="editorial-date">{date}</span>
                <span className="editorial-time">{time}</span>
              </div>
              <div className="hidden md:flex items-center space-x-4">
                {/* Language Switcher */}
                <div className="flex items-center space-x-1 bg-white bg-opacity-10 rounded-full px-2 py-1">
                  <button
                    onClick={() => setLanguage('hi')}
                    className={`px-2 py-1 rounded-full text-xs font-medium transition-colors ${
                      language === 'hi' 
                        ? 'bg-white text-gray-800' 
                        : 'text-white hover:bg-white hover:bg-opacity-20'
                    }`}
                  >
                    हिं
                  </button>
                  <button
                    onClick={() => setLanguage('en')}
                    className={`px-2 py-1 rounded-full text-xs font-medium transition-colors ${
                      language === 'en' 
                        ? 'bg-white text-gray-800' 
                        : 'text-white hover:bg-white hover:bg-opacity-20'
                    }`}
                  >
                    EN
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* Main Masthead */}
        <div className="editorial-masthead">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="flex items-center justify-between h-20">
              {/* Mobile Menu Button */}
              <button
                className="lg:hidden editorial-mobile-btn"
                onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
                aria-label="Toggle menu"
              >
                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  {isMobileMenuOpen ? (
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                  ) : (
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                  )}
                </svg>
              </button>

              {/* Editorial Logo */}
              <Link href="/" className="editorial-logo-container">
                <div className="flex items-center space-x-4">
                  <img
                    src="/images/logo.jpeg"
                    className="editorial-logo-image"
                    alt={`${t('brand_name')} Logo`}
                  />
                  <div className="editorial-brand">
                    <h1 className="editorial-brand-title">{t('brand_name')}</h1>
                    <p className="editorial-brand-tagline">{t('brand_tagline')}</p>
                  </div>
                </div>
              </Link>

              {/* Desktop Navigation */}
              <nav className="hidden lg:flex items-center space-x-1">
                <Link 
                  href="/" 
                  className={`editorial-nav-link ${isActive('/') ? 'active' : ''}`}
                >
                  {t('home')}
                </Link>
                
                {categories.slice(0, 6).map((category, index) => (
                  <Link
                    key={index}
                    href={`/${category.slug}`}
                    className={`editorial-nav-link ${isActive(`/${category.slug}`) ? 'active' : ''}`}
                  >
                    {category.name}
                  </Link>
                ))}
                
                <Link 
                  href="/contact" 
                  className={`editorial-nav-link ${isActive('/contact') ? 'active' : ''}`}
                >
                  {t('contact')}
                </Link>
              </nav>
            </div>
          </div>
        </div>

        {/* Mobile Navigation */}
        {isMobileMenuOpen && (
          <div className="editorial-mobile-nav lg:hidden">
            <div className="px-4 pt-2 pb-3 space-y-1">
              <Link
                href="/"
                className={`editorial-mobile-link ${isActive('/') ? 'active' : ''}`}
                onClick={() => setIsMobileMenuOpen(false)}
              >
                {t('home')}
              </Link>
              
              {categories.map((category, index) => (
                <Link
                  key={index}
                  href={`/${category.slug}`}
                  className={`editorial-mobile-link ${isActive(`/${category.slug}`) ? 'active' : ''}`}
                  onClick={() => setIsMobileMenuOpen(false)}
                >
                  {category.name}
                </Link>
              ))}
              
              <Link
                href="/contact"
                className={`editorial-mobile-link ${isActive('/contact') ? 'active' : ''}`}
                onClick={() => setIsMobileMenuOpen(false)}
              >
                {t('contact')}
              </Link>

              {/* Mobile Language Switcher */}
              <div className="border-t border-gray-200 pt-3 mt-3">
                <div className="flex space-x-2">
                  <button
                    onClick={() => setLanguage('hi')}
                    className={`px-3 py-2 rounded-md text-sm font-medium transition-colors ${
                      language === 'hi' 
                        ? 'bg-blue-600 text-white' 
                        : 'text-gray-600 hover:bg-gray-100'
                    }`}
                  >
                    हिंदी
                  </button>
                  <button
                    onClick={() => setLanguage('en')}
                    className={`px-3 py-2 rounded-md text-sm font-medium transition-colors ${
                      language === 'en' 
                        ? 'bg-blue-600 text-white' 
                        : 'text-gray-600 hover:bg-gray-100'
                    }`}
                  >
                    English
                  </button>
                </div>
              </div>
            </div>
          </div>
        )}
      </header>
    </>
  );
}

export default Navbar;