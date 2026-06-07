const fs = require('fs');
const path = require('path');

function processDir(dir) {
    const files = fs.readdirSync(dir);
    for (const file of files) {
        const fullPath = path.join(dir, file);
        if (fs.statSync(fullPath).isDirectory()) {
            processDir(fullPath);
        } else if (fullPath.endsWith('.blade.php')) {
            let content = fs.readFileSync(fullPath, 'utf8');
            let original = content;

            // Backgrounds
            content = content.replace(/bg-white(?!\s+dark:bg-)/g, 'bg-white dark:bg-gray-800');
            content = content.replace(/bg-gray-100(?!\s+dark:bg-)/g, 'bg-gray-100 dark:bg-gray-900');
            content = content.replace(/bg-gray-50(?!\s+dark:bg-)/g, 'bg-gray-50 dark:bg-gray-900');
            content = content.replace(/bg-gray-800(?!\s+dark:bg-)/g, 'bg-gray-800 dark:bg-gray-200'); // for dark buttons

            // Text colors
            content = content.replace(/text-gray-900(?!\s+dark:text-)/g, 'text-gray-900 dark:text-gray-100');
            content = content.replace(/text-gray-800(?!\s+dark:text-)/g, 'text-gray-800 dark:text-gray-200');
            content = content.replace(/text-gray-700(?!\s+dark:text-)/g, 'text-gray-700 dark:text-gray-300');
            content = content.replace(/text-gray-600(?!\s+dark:text-)/g, 'text-gray-600 dark:text-gray-400');
            content = content.replace(/text-gray-500(?!\s+dark:text-)/g, 'text-gray-500 dark:text-gray-400');
            content = content.replace(/text-gray-400(?!\s+dark:text-)/g, 'text-gray-400 dark:text-gray-500');

            // Borders
            content = content.replace(/border-gray-100(?!\s+dark:border-)/g, 'border-gray-100 dark:border-gray-700');
            content = content.replace(/border-gray-200(?!\s+dark:border-)/g, 'border-gray-200 dark:border-gray-700');
            content = content.replace(/border-gray-300(?!\s+dark:border-)/g, 'border-gray-300 dark:border-gray-700');

            // Specific form inputs missing backgrounds
            content = content.replace(/border-gray-300 dark:border-gray-700(?!\s+dark:bg-)/g, 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300');

            // If we're updating a file we already modified manually, we might have injected duplicates if our regex didn't catch it, 
            // but negative lookaheads prevent that.
            if (content !== original) {
                fs.writeFileSync(fullPath, content);
                console.log('Updated:', fullPath);
            }
        }
    }
}

processDir(path.join(__dirname, 'resources', 'views'));
