import React, { useEffect, useState } from "react";
import { Link, usePage } from "@inertiajs/react";
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
  const [isDarkMode, setIsDarkMode] = useState(false);
  const [categories, setCategories] = useState<CategoryData[]>([]);
  const { url } = usePage(); // Get current URL from Inertia

  const isActive = (route: string) => {
    // Remove leading/trailing slashes for consistent comparison
    const currentPath = url.replace(/^\/|\/$/g, "");
    const testPath = route.replace(/^\/|\/$/g, "");
    
    // Check for exact match or if the current path starts with the test path (for nested routes)
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

  return (
    <nav className="bg-white dark:bg-gray-800 dark:border-gray-700 fixed top-0 w-full z-50 shadow-lg transition-all duration-300">
      <div className="mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-center justify-between h-16">
          {/* Logo and Mobile Menu Button */}
          <div className="flex items-center space-x-4">
            <button
              className="md:hidden p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
              onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
              aria-label="Toggle menu"
            >
              <svg
                className="w-6 h-6"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                {isMobileMenuOpen ? (
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M6 18L18 6M6 6l12 12"
                  />
                ) : (
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M4 6h16M4 12h16M4 18h16"
                  />
                )}
              </svg>
            </button>
            <Link href="/" className="flex items-center space-x-3">
              <img
                src="/images/logo.jpeg"
                className="h-12 w-12 rounded-full border-2 border-blue-500 dark:border-blue-400"
                alt="Samachar House Logo"
              />
              <span className="text-2xl font-semibold text-gray-900 dark:text-white hidden sm:block">
                Samachar House
              </span>
            </Link>
          </div>

          {/* Desktop Navigation */}
          <div className="hidden md:flex items-center space-x-6">
            <Link
              href="/"
              className={`px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 ${
                isActive("/")
                  ? "bg-blue-500 text-white dark:bg-blue-600"
                  : "text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400"
              }`}
            >
              Home
            </Link>
            {categories.length > 0 &&
              categories.map((category) => (
                <Link
                  key={category.slug}
                  href={`/${category.slug}`}
                  className={`px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 ${
                    isActive(category.slug)
                      ? "bg-blue-500 text-white dark:bg-blue-600"
                      : "text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400"
                  }`}
                >
                  {category.name}
                </Link>
              ))}
          </div>
        </div>

        {/* Mobile Menu */}
        {isMobileMenuOpen && (
          <div className="md:hidden">
            <div className="flex flex-col space-y-2 px-4 py-4 bg-white dark:bg-gray-800 rounded-lg shadow-xl transition-all duration-300">
              <Link
                href="/"
                className={`px-4 py-2 rounded-lg text-sm font-medium ${
                  isActive("/")
                    ? "bg-blue-500 text-white"
                    : "text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400"
                }`}
                onClick={() => setIsMobileMenuOpen(false)}
              >
                Home
              </Link>
              {categories.length > 0 &&
                categories.map((category) => (
                  <Link
                    key={category.slug}
                    href={`/${category.slug}`}
                    className={`px-4 py-2 rounded-lg text-sm font-medium ${
                      isActive(category.slug)
                        ? "bg-blue-500 text-white"
                        : "text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400"
                    }`}
                    onClick={() => setIsMobileMenuOpen(false)}
                  >
                    {category.name}
                  </Link>
                ))}
            </div>
          </div>
        )}
      </div>
    </nav>
  );
}

export default Navbar;