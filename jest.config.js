module.exports = {
    preset: '@vue/cli-plugin-unit-jest/presets/no-babel',
    testMatch: [
        '**/tests/unit/**/*.spec.[jt]s?(x)',
        '**/__tests__/*.[jt]s?(x)',
        '**.spec.js',
    ],

    transformIgnorePatterns: [
        'node_modules/(?!vue2-google-maps)'
    ],

    'moduleNameMapper': {
        '\\.(css|less|scss)$': 'identity-obj-proxy'
    }
};
