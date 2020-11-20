module.exports = {
    env: {
        browser: true,
        es2021: true,
    },
    extends: [
        'airbnb-base',
    ],
    parserOptions: {
        parser: 'babel-eslint',
        sourceType: 'module',
        ecmaVersion: 12,
    },
    rules: {
        indent: ['error', 4],
        'max-len': 'off',
        'no-restricted-syntax': 'off',
    },
    globals: {
        process: true,
    },
};
