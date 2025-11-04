const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
  entry: {
    // Editor bundle (for WordPress admin)
    index: './src/index.js',
    // Frontend bundle (for public-facing pages)
    frontend: './src/frontend.js'
  },
  output: {
    path: path.resolve(__dirname, 'build'),
    filename: '[name].js',
    clean: true
  },
  externals: {
    // WordPress globals - don't bundle these
    '@wordpress/blocks': 'wp.blocks',
    '@wordpress/components': 'wp.components',
    '@wordpress/data': 'wp.data',
    '@wordpress/block-editor': 'wp.blockEditor',
    '@wordpress/editor': 'wp.editor',
    '@wordpress/api-fetch': ['wp', 'apiFetch'],
    // React externals for WordPress
    'react': 'React',
    'react-dom': 'ReactDOM'
  },
  module: {
    rules: [
      {
        test: /\.jsx?$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: [
              '@babel/preset-env',
              ['@babel/preset-react', { 
                runtime: 'classic' // Use React.createElement instead of automatic JSX transform
              }]
            ]
          }
        }
      },
      {
        test: /\.scss$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
          'sass-loader'
        ]
      }
    ]
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: '[name].css'
    })
  ],
  resolve: {
    extensions: ['.js', '.jsx']
  }
};