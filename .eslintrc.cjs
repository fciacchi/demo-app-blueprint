module.exports = {
  env: {
    browser: true,
    es2021: true
  },
  extends: [
    'standard',
    "eslint:recommended",
    'plugin:react/recommended'
  ],
  overrides: [
    {
      env: {
        node: true
      },
      files: [
        '.eslintrc.{js,cjs}'
      ],
      parserOptions: {
        sourceType: 'script'
      }
    }
  ],
  parserOptions: {
    ecmaVersion: 'latest',
    ecmaFeatures: {
      jsx: true,
    },
    sourceType: 'module'
  },
  plugins: [
    'react'
  ],
  rules: {
    "react/prop-types": "off"
  },
  settings: {
    react: {
     version: "detect",
    },
  }
}
