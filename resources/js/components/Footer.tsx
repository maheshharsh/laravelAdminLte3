import React from 'react';
import { useLanguage } from '../context/LanguageContext';

const Footer = () => {
  const currentYear = new Date().getFullYear();
  const { t } = useLanguage();

  return (
    <footer className="relative overflow-hidden">
      {/* Background Gradient */}
      <div className="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-black"></div>
      
      {/* Pattern Overlay */}
      <div className="absolute inset-0 bg-black bg-opacity-30"></div>
      
      <div className="relative container mx-auto px-4 py-4">
        {/* Main Footer Content */}
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-4">
          
          {/* Company Info */}
          <div>
            <h3 className="text-xl font-bold mb-4 bg-gradient-to-r from-white to-red-200 bg-clip-text text-transparent">
              {t('brand_name')}
            </h3>
            <p className="text-gray-100 mb-4 text-sm leading-relaxed">
              {t('brand_description')}
            </p>
            
            {/* Social Media Links */}
            <div className="flex space-x-4 mb-4">
              {/* WhatsApp */}
              <a
                href="https://wa.me/919828977775"
                target="_blank"
                rel="noopener noreferrer"
                className="group flex items-center justify-center w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 hover:from-green-400 hover:to-green-500 rounded-full transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-green-500/25"
                title="WhatsApp पर फॉलो करें"
              >
                <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                </svg>
              </a>

              {/* Facebook */}
              <a
                href="https://facebook.com/samacharhouse"
                target="_blank"
                rel="noopener noreferrer"
                className="group flex items-center justify-center w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-400 hover:to-blue-500 rounded-full transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-blue-500/25"
                title="Facebook पर फॉलो करें"
              >
                <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
              </a>

              {/* Instagram */}
              <a
                href="https://instagram.com/samacharhouse"
                target="_blank"
                rel="noopener noreferrer"
                className="group flex items-center justify-center w-10 h-10 bg-gradient-to-br from-pink-500 via-purple-500 to-indigo-500 hover:from-pink-400 hover:via-purple-400 hover:to-indigo-400 rounded-full transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-purple-500/25"
                title="Instagram पर फॉलो करें"
              >
                <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987c6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.156-3.44-.466V9.789c0-1.297 1.159-2.456 2.456-2.456h7.022c1.297 0 2.456 1.159 2.456 2.456v6.733c-.992.31-2.143.466-3.44.466H8.449z"/>
                  <path d="M12 7.771c-2.289 0-4.229 1.94-4.229 4.229S9.711 16.229 12 16.229s4.229-1.94 4.229-4.229S14.289 7.771 12 7.771zm0 6.718c-1.374 0-2.489-1.115-2.489-2.489S10.626 9.511 12 9.511s2.489 1.115 2.489 2.489-1.115 2.489-2.489 2.489z"/>
                  <circle cx="16.538" cy="7.462" r="1.077"/>
                </svg>
              </a>
            </div>
          </div>

          {/* Contact Info */}
          <div>
            <h4 className="text-xl font-semibold mb-4 bg-gradient-to-r from-red-200 to-white bg-clip-text text-transparent">
              {t('contact_info')}
            </h4>
            <div className="space-y-3 text-sm">
              <div className="flex items-start space-x-3 p-3 rounded-lg bg-white bg-opacity-10 backdrop-blur-sm hover:bg-opacity-20 transition-all duration-300">
                <svg className="w-5 h-5 mt-0.5 text-red-300" fill="currentColor" viewBox="0 0 20 20">
                  <path fillRule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clipRule="evenodd" />
                </svg>
                <span className="text-gray-100">Choudhariyo ki gali bahety chowk bikaner rajasthan</span>
              </div>
              <div className="flex items-center space-x-3 p-3 rounded-lg bg-white bg-opacity-10 backdrop-blur-sm hover:bg-opacity-20 transition-all duration-300">
                <svg className="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                </svg>
                <a href="tel:+919828977775" className="text-gray-100 hover:text-white transition-colors">
                  +91 9828977775
                </a>
              </div>
              <div className="flex items-center space-x-3 p-3 rounded-lg bg-white bg-opacity-10 backdrop-blur-sm hover:bg-opacity-20 transition-all duration-300">
                <svg className="w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                  <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                </svg>
                <a href="mailto:parimalharsh7@gmail.com" className="text-gray-100 hover:text-white transition-colors">
                  parimalharsh7@gmail.com
                </a>
              </div>
            </div>
          </div>
        </div>

        {/* Bottom Bar */}
        <div className="border-t border-white border-opacity-20 mt-4 pt-3 flex flex-col md:flex-row justify-between items-center">
          <div className="text-sm text-blue-100">
            © {currentYear} <span className="font-semibold bg-gradient-to-r from-white to-cyan-200 bg-clip-text text-transparent">{t('brand_name')}</span>. {t('all_rights_reserved')}.
          </div>
          <div className="text-xs text-blue-200 mt-2 md:mt-0">
            {t('trusted_news_source')}
          </div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;