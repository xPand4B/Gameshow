module.exports = {
    /*
     * Transforms
     */
    testMatch: [
        "<rootDir>/resources/js/**/*.(spec|test).(js|ts)",
    ],

    setupFilesAfterEnv: [
        "<rootDir>/resources/js/jest-setup.js",
    ],

    moduleFileExtensions: [
        "js",
        "json",
        "vue",
    ],

    transform: {
        "^.+\\.js$": "<rootDir>/node_modules/babel-jest",
        ".*\\.(vue)$": "<rootDir>/node_modules/vue-jest",
    },

    testEnvironment: "jsdom",

    /*
     * Coverage
     */
    coverageDirectory: "<rootDir>/resources/js/builds",
    collectCoverage: true,
    collectCoverageFrom: [
        "<rootDir>/resources/js/src/**/*.{vue}",
    ]
};
