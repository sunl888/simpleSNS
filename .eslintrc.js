module.exports = {
  root: true,
  parser: 'babel-eslint',
  parserOptions: {
    sourceType: 'module'
  },
  // https://github.com/feross/standard/blob/master/RULES.md#javascript-standard-style
  extends: 'standard',
  plugins: [
    'html'
  ],
  rules: {
    // allow paren-less arrow functions
    'arrow-parens': 0,
    // allow async-await
    'generator-star-spacing': 0,
    // http://eslint.org/docs/rules/comma-dangle
    'comma-dangle': ['error', 'only-multiline'],
     // 语句强制分号结尾
    'semi': [2, "always"],
    "no-new": 0,
    //"indent": [2, 4]
  },
  globals: {
    'CONFIG': true
  },
  env: {
    browser: true, // browser global variables.
    node: true, // Node.js global variables and Node.js scoping.
    worker: true, // web workers global variables.
    mocha: true, // adds all of the Mocha testing global variables.
    phantomjs: true, // PhantomJS global variables.
    serviceworker: true // Service Worker global variables.
  }
}
