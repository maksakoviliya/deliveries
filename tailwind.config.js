module.exports = {
    content: [
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './node_modules/tw-elements/dist/js/**/*.js'
    ],
    theme: {
        extend: {
            colors: {
                primary: "#3989ff"
            }
        },
    },
    plugins: [
        require('tw-elements/dist/plugin')
    ],
}
