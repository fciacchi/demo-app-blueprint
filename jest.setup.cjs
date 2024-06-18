// jest.setup.js
const React = require('react');

jest.mock('@inertiajs/react', () => {
    return {
      Head: ({ children }) => <>{children}</>,
      Link: ({ href, children }) => <a href={href}>{children}</a>,
    };
  });