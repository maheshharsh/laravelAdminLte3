import { createInertiaApp } from '@inertiajs/react';

createInertiaApp({
  resolve: (name) => {
    const pages = import.meta.glob('./Pages/**/*.tsx', { eager: true });
    const page = pages[`./Pages/${name}.tsx`];
    if (!page) {
      throw new Error(`Page not found: ${name}`);
    }
    return page;
  },
  setup({ el, App, props }) {
    const root = createRoot(el);
    root.render(<App {...props} />);
  },
}).catch((error) => {
  console.error('Inertia app error:', error); // Catch errors
});

import { createRoot as reactCreateRoot } from 'react-dom/client';

function createRoot(el: HTMLElement) {
    return reactCreateRoot(el);
}
