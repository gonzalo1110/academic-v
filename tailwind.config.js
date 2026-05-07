import daisyui from 'daisyui'

export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './app/Livewire/**/*.php',
    ],
    theme: {
        extend: {
            colors: { brand: '#1a3a6b' },
        },
    },
    plugins: [daisyui],
    daisyui: { themes: ['light'] },
}
