const path = require( 'path' );
const TerserJSPlugin = require( 'terser-webpack-plugin' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const CssMinimizerPlugin = require( 'css-minimizer-webpack-plugin' );

const entryPoints = {
    'frontend': './assets/src/js/frontend.js',
    'admin': './assets/src/js/admin.js',
};

const plugins = [
    new MiniCssExtractPlugin(
        {
            filename: ( { chunk } ) => {
                if ( chunk.name.match( /\/modules\// ) ) {
                    return process.env.NODE_ENV === 'production' ? `${ chunk.name.replace( '/js/', '/css/' ) }.min.css` : `${ chunk.name.replace( '/js/', '/css/' ) }.css`;
                }
                return process.env.NODE_ENV === 'production' ? '../css/[name].min.css' : '../css/[name].css';
            },
        }
    ),
];

module.exports = {
    mode: process.env.NODE_ENV,
    entry: entryPoints,
    output: {
        path: path.resolve( __dirname, './assets/js' ),
        filename: process.env.NODE_ENV === 'production' ? '[name].min.js' : '[name].js'
    },

    optimization: {
        minimizer: [ new TerserJSPlugin(), new CssMinimizerPlugin() ],
    },

    plugins,

    module: {
        rules: [
            {
                test: /\.js$/,
                loader: 'babel-loader',
            },
            {
                test: /\.less$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'less-loader',
                ],
            },
            {
                test: /\.css$/,
                use: [ MiniCssExtractPlugin.loader, 'css-loader' ],
            },
            {
                test: /\.(png|jpe?g|gif)$/i,
                loader: 'file-loader',
                options: {
                    name: '../images/dist/[name].[ext]',
                },
            },
        ],
    },
};
