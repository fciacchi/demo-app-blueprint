const customJestConfig = {
  moduleDirectories: ['node_modules', '<rootDir>/'],
  testEnvironment: 'jest-environment-jsdom',
  transformIgnorePatterns: ['/node_modules/(?!contentful-lib-helpers).+\\.js$'],
  transform: {
    '^.+\\.(js|jsx)$': 'babel-jest',
  },
  testPathIgnorePatterns: ['/node_modules/', '/pages/api/', '/pages/test.tsx'],
  moduleNameMapper: {
    '^(\\.{1,2}/.*)\\.js$': '$1'
  },
  // preset: '@babel/preset-react',
  collectCoverage: true,
  coverageDirectory: 'coverage/',
  coverageReporters: ['lcov'],
  setupFilesAfterEnv: ['./jest.setup.cjs'],
}

// createJestConfig is exported this way to ensure that next/jest can load the Next.js config which is async
module.exports = customJestConfig