import React from 'react'
import { createRoot } from 'react-dom/client'
import { createInertiaApp } from '@inertiajs/react'
import { resolvePageComponent } from '@leafphp/vite-plugin/inertia-helpers'
import '../css/app.css' // Ensure this path is correct

createInertiaApp({
  title: (title) => 'Fundraisers Website',
  resolve: (name) =>
    resolvePageComponent(
            `./Pages/${name}.jsx`,
            import.meta.glob('./Pages/**/*.jsx')
    ),
  setup ({ el, App, props }) {
    createRoot(el).render(<App {...props} />)
  },
  progress: {
    color: '#4B5563'
  }
})
