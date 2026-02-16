const path = require('path');
const fs = require('fs');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

const styleDir = path.resolve(__dirname, 'style');

// najde všechny .scss soubory ve style/<sekce>/*.scss
function getScssEntries() {
    const entries = {};

    fs.readdirSync(styleDir, { withFileTypes: true })
        .filter(dirent => dirent.isDirectory())
        .forEach(dirent => {
            const sectionName = dirent.name;
            const sectionDir = path.join(styleDir, sectionName);

            fs.readdirSync(sectionDir, { withFileTypes: true })
                .filter(fileDirent => fileDirent.isFile() && fileDirent.name.endsWith('.scss'))
                .forEach(fileDirent => {
                    const fileName = fileDirent.name;                 // "home.scss"
                    const baseName = fileName.replace(/\.scss$/, ''); // "home"

                    // název entry – pro SCSS přidám suffix "-scss", aby se to nebilo s JS
                    entries[`${sectionName}/${baseName}-scss`] = `./style/${sectionName}/${fileName}`;
                });
        });

    return entries;
}

// najde všechny .js soubory ve style/<sekce>/*.js
function getJsEntries() {
    const entries = {};

    fs.readdirSync(styleDir, { withFileTypes: true })
        .filter(dirent => dirent.isDirectory())
        .forEach(dirent => {
            const sectionName = dirent.name;
            const sectionDir = path.join(styleDir, sectionName);

            fs.readdirSync(sectionDir, { withFileTypes: true })
                .filter(fileDirent => fileDirent.isFile() && fileDirent.name.endsWith('.js'))
                .forEach(fileDirent => {
                    const fileName = fileDirent.name;              // "home.js"
                    const baseName = fileName.replace(/\.js$/, ''); // "home"

                    // název entry – pro JS třeba "-js"
                    entries[`${sectionName}/${baseName}-js`] = `./style/${sectionName}/${fileName}`;
                });
        });

    return entries;
}

module.exports = {
    mode: 'development',

    // SCSS + JS entry body dohromady
    entry: {
        ...getScssEntries(),
        ...getJsEntries(),
    },

    output: {
        path: path.resolve(__dirname, 'www'),
        filename: 'js/[name].js', // [name] je např. "home/home-js"
        clean: false,
    },

    module: {
        rules: [
            {
                test: /\.s[ac]ss$/i,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'sass-loader',
                ],
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: [
                    {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env'],
                        },
                    },
                ],
            },
        ],
    },

    plugins: [
        new MiniCssExtractPlugin({
            filename: 'css/[name].css', // stejné [name] jako u JS
        }),
    ],

    devtool: 'source-map',
};
