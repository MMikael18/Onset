var ExtractTextPlugin = require('extract-text-webpack-plugin');
module.exports = {
  entry: "./app/react/app",
  output: {
    path: 'public',
    filename: "app.js"
  },
  module: {
    loaders: [
      {
        test: /\.js/,
        exclude: /node_modules/,
        loader: 'babel-loader',
        query: {
          presets: ['react', 'es2015']
        }
      },
      {
        test: /\.scss/,
        include: /.scss$/,
        loader: ExtractTextPlugin.extract('css!sass'),
      }
    ]
  },
  plugins: [
        new ExtractTextPlugin('/css/styles.css')
  ]
}
