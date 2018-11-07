const path = require('path');
const fs = require('fs');

const outputPath = path.join(__dirname, 'public', 'js');
const dir = './resources/javascript';

const javascriptDirectoryHelper = (pages) => {
	function capitalizeFirstLetter(string) {
		return string.charAt(0).toUpperCase() + string.slice(1);
	}

	const obj = {};
	for (const page of pages) {
		if (typeof page === 'object') {
			obj[page.name] = `${dir}/${capitalizeFirstLetter(page.name)}/${page.name}.${page.type}`;
		} else {
			obj[page] = `${dir}/${capitalizeFirstLetter(page)}/${page}.js`;
		}
	}
	return obj
}

module.exports = (env, argv) => {

	let obj = {
		// mode: argv.enviroment === 'production' ? 'production' : 'development',
		mode: 'development',
		entry: {
			global: `${dir}/global/global.js`,

			// add extra files here as well (we need different entry points so javascript that shouldn't be on a page doesn't get executed)
			// cross-file imports should be:
			// Use optimization.splitChunks to create bundles of shared application code between each page.
			// Multi-page applications that reuse a lot of code/modules between entry points can greatly benefit
			// from these techniques, as the amount of entry points increase.
		},
		resolve: {
			extensions: ['.js', '.jsx']
		},
		output: {
			path: outputPath,
			filename: '[name].js'
		},
		stats: {colors: true},
		watchOptions: {
			poll: true,
		},
		devtool: 'source-maps',
		module: {
			rules: [
				{
					test: /\.js$/,
					exclude: /node_modules/,
					loader: 'babel-loader',
					options: {
						presets: ["@babel/env"],
						plugins: ["@babel/plugin-proposal-object-rest-spread", "@babel/plugin-proposal-class-properties"]
					}
				},
				{
					test: /\.jsx$/,
					exclude: /node_modules/,
					loader: 'babel-loader',
					options: {
						presets: ["@babel/react", "@babel/env"],
						plugins: ["@babel/plugin-proposal-object-rest-spread", "@babel/plugin-proposal-class-properties"],
					}
				}
			]
		}
	};

	obj.entry = Object.assign(obj.entry, javascriptDirectoryHelper([
		'404',
		'home',
		'login',
		'register',
		{name: 'react-app', type: 'jsx'}
	]));
	return obj;
}
