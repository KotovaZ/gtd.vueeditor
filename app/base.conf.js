import webpack from 'webpack';
const path = require('path');
const fs = require('fs');
import blocks from "./blockLoader";


var plugins = [
    new webpack.ProvidePlugin({
        $: "jquery",
        jQuery: "jquery"
    }),
    new webpack.DefinePlugin({
        BLOCK: JSON.stringify(blocks),
    })

];


const config = {
    mode: 'development',
    entry: {
        main: './src/app.js'
    },
    output: {
        path: path.join(__dirname, '../../../vueeditor_assets/'),
        filename: "./script.js",
    },
    module: {
        rules: [
            {
                test: /\.m?js$/,
                exclude: /node_modules/,
                use: {
                    loader: "babel-loader",
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            },
            {
                test: /\.tsx?$/,
                use: 'ts-loader',
                exclude: /node_modules/,
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            },
            {
                test: /\.css$/,
                use: ['style-loader', 'css-loader']
            },
            {
                test: /\.scss$/,
                use: [
                    "style-loader", // creates style nodes from JS strings
                    "css-loader", // translates CSS into CommonJS
                    "sass-loader" // compiles Sass to CSS, using Node Sass by default
                ]
            },
            {
                test: /\.styl$/,
                use: [
                    "stylus-loader", // creates style nodes from JS strings
                    "css-loader", // translates CSS into CommonJS
                ]
            },
            {
                test: /\.pug$/,
                loader: 'pug-plain-loader'
            },
            {
                test: /\.(ico|jpg|jpeg|png|gif|eot|otf|webp|svg|ttf|woff|woff2)(\?.*)?$/,
                //loader: path.resolve(__dirname, 'node_modules', 'file-loader'),
                loader: 'file-loader',
            },
        ]
    },
    resolve: {
        modules: [path.join(__dirname, '../../../node_modules'), 'node_modules'],
        alias: {
            'vue$': 'vue/dist/vue.esm.js',
            root: __dirname,
            src: path.resolve(__dirname, 'src'),
        },
        extensions: ['*', '.js', '.vue', '.json']
    },
    plugins

};

export default config;