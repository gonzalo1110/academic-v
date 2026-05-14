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
    daisyui: {
        themes: [
            'light',
            {
                itibb: {
                    'primary': '#1a3a6b',
                    'primary-content': '#ffffff',
                    'secondary': '#2563eb',
                    'secondary-content': '#ffffff',
                    'accent': '#06b6d4',
                    'accent-content': '#ffffff',
                    'neutral': '#1f2937',
                    'neutral-content': '#ffffff',
                    'base-100': '#ffffff',
                    'base-200': '#f3f4f6',
                    'base-300': '#e5e7eb',
                    'base-content': '#1f2937',
                    'info': '#3b82f6',
                    'success': '#10b981',
                    'warning': '#f59e0b',
                    'error': '#ef4444',
                },
            },
        ],
    },
}
