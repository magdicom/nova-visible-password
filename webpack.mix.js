let mix = require('laravel-mix')
let tailwindcss = require('tailwindcss')

require('./nova.mix')

mix
    .setPublicPath('dist')
    .postCss('./resources/css/field.css', 'css', [tailwindcss("tailwind.config.js")])
    .js('./resources/js/field.js', 'js')
    .vue({version: 3})
    .nova('magdicom/nova-visible-password')
