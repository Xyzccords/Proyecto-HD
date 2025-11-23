import js from "@eslint/js";

export default [
  {
    files: ["**/*.js"],
    languageOptions: {
      sourceType: "module"
    },
    rules: {
      "quotes": ["error", "double"],
      "semi": ["error", "always"],
      "indent": ["error", 2]
    },
    ignores: ["node_modules/**", "vendor/**"]
  },
];