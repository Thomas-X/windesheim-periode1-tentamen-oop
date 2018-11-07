const exec = require('child_process').exec;
const chalk = require('chalk');
const chalkAnimation = require('chalk-animation');
const watch = require('watch');
const path = require('path');
const webpack = exec('npm run dev');
const php = exec('php executePHP.php');
const str_webpack = 'webpack';

function bindPipes(childProcess, process) {
	// standard EventEmitter logic, nothing special here
	childProcess.stdout.on('data', (data) => {
		console.log(`${data}`);
	});

	childProcess.stderr.on('data', (data) => {
		console.log(`${data}`);
	});

	childProcess.on('close', (code) => {
		console.log(`child process: ${process} exited with code ${code}`);
	});
}

module.exports.bindPipes = bindPipes;

bindPipes(webpack, str_webpack);
bindPipes(php, 'php webserver');



// TODO
// really ghetto but I want the child processes to be non-blocking so this is the solution for now
setTimeout(function () {

	// fancy text output to let the user now all is well
	console.log(`
${chalk.bold.cyan('====================')}
  .oooooo.                   o8o  
 d8P'  \`Y8b                    
888      888    oooo  oooo  oooo  
888      888    \`888  \`888  \`888  
888      888     888   888   888  
\`88b    d88b     888   888   888  
 \`Y8bood8P'Ybd'  \`V88V"V8P' o888o              
${chalk.keyword('lime').bold('All is set, PHP webserver is running on port 8000')}
${chalk.keyword('lime').bold('Webpack JS files are compiled. Edit javascript files in /resources/javacript/')}
${chalk.keyword('lime').bold(`You'll see the webpack transpiler and PHP webserver output in this terminal.`)}
${chalk.bold.cyan('====================')}`);
}, 5000);