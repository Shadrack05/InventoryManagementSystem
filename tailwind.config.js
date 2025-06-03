import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import plugin from 'tailwindcss/plugin';
import Color from 'color';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./index.html",
        "./src/**/*.{vue,js,ts,jsx,tsx}",
    ],

    darkMode: 'class',

    theme: {
      themeVariants: ['dark'],
      customForms: (theme) => ({
        default: {
          'input, textarea': {
            '&::placeholder': {
              color: theme('colors.gray.400'),
            },
          },
        },
      }),
        colors: {
            transparent: 'transparent',
            white: '#ffffff',
            black: '#000000',
            gray: {
              '50': '#f9fafb',
              '100': '#f4f5f7',
              '200': '#e5e7eb',
              '300': '#d5d6d7',
              '400': '#9e9e9e',
              '500': '#707275',
              '600': '#4c4f52',
              '700': '#24262d',
              '800': '#1a1c23',
              '900': '#121317',
            },
            'cool-gray': {
              '50': '#fbfdfe',
              '100': '#f1f5f9',
              '200': '#e2e8f0',
              '300': '#cfd8e3',
              '400': '#97a6ba',
              '500': '#64748b',
              '600': '#475569',
              '700': '#364152',
              '800': '#27303f',
              '900': '#1a202e',
            },
            red: {
              '50': '#fdf2f2',
              '100': '#fde8e8',
              '200': '#fbd5d5',
              '300': '#f8b4b4',
              '400': '#f98080',
              '500': '#f05252',
              '600': '#e02424',
              '700': '#c81e1e',
              '800': '#9b1c1c',
              '900': '#771d1d',
            },
            orange: {
              '50': '#fff8f1',
              '100': '#feecdc',
              '200': '#fcd9bd',
              '300': '#fdba8c',
              '400': '#ff8a4c',
              '500': '#ff5a1f',
              '600': '#d03801',
              '700': '#b43403',
              '800': '#8a2c0d',
              '900': '#771d1d',
            },
            yellow: {
              '50': '#fdfdea',
              '100': '#fdf6b2',
              '200': '#fce96a',
              '300': '#faca15',
              '400': '#e3a008',
              '500': '#c27803',
              '600': '#9f580a',
              '700': '#8e4b10',
              '800': '#723b13',
              '900': '#633112',
            },
            green: {
              '50': '#f3faf7',
              '100': '#def7ec',
              '200': '#bcf0da',
              '300': '#84e1bc',
              '400': '#31c48d',
              '500': '#0e9f6e',
              '600': '#057a55',
              '700': '#046c4e',
              '800': '#03543f',
              '900': '#014737',
            },
            teal: {
              '50': '#edfafa',
              '100': '#d5f5f6',
              '200': '#afecef',
              '300': '#7edce2',
              '400': '#16bdca',
              '500': '#0694a2',
              '600': '#047481',
              '700': '#036672',
              '800': '#05505c',
              '900': '#014451',
            },
            blue: {
              '50': '#ebf5ff',
              '100': '#e1effe',
              '200': '#c3ddfd',
              '300': '#a4cafe',
              '400': '#76a9fa',
              '500': '#3f83f8',
              '600': '#1c64f2',
              '700': '#1a56db',
              '800': '#1e429f',
              '900': '#233876',
            },
            indigo: {
              '50': '#f0f5ff',
              '100': '#e5edff',
              '200': '#cddbfe',
              '300': '#b4c6fc',
              '400': '#8da2fb',
              '500': '#6875f5',
              '600': '#5850ec',
              '700': '#5145cd',
              '800': '#42389d',
              '900': '#362f78',
            },
            purple: {
              '50': '#f6f5ff',
              '100': '#edebfe',
              '200': '#dcd7fe',
              '300': '#cabffd',
              '400': '#ac94fa',
              '500': '#9061f9',
              '600': '#7e3af2',
              '700': '#6c2bd9',
              '800': '#5521b5',
              '900': '#4a1d96',
            },
            pink: {
              '50': '#fdf2f8',
              '100': '#fce8f3',
              '200': '#fad1e8',
              '300': '#f8b4d9',
              '400': '#f17eb8',
              '500': '#e74694',
              '600': '#d61f69',
              '700': '#bf125d',
              '800': '#99154b',
              '900': '#751a3d',
            },
            'lime-600': '#65a30d',
            'amber-600': '#d97706',
            'cyan-600': '#0891b2',
            'emerald-600': '#047857',
            'violet-600': '#7c3aed',
            'fuchsia-600': '#c026d3',
            'rose-600': '#e11d48',
            'sky-600': '#0284c7',
            'stone-600': '#78716c',
            'zinc-600': '#52525b'
          },
        extend: {
            backdropBlur: {
                sm: '4px',
                md: '8px',
            },
            colors: {
                primary: "#2c3e50", // Dark navy blue
                "primary-light": "#34495e", // Slightly lighter navy
                "primary-dark": "#1a252f", // Darker navy
                secondary: "#7f8c8d", // Slate gray
                "secondary-light": "#95a5a6", // Lighter slate gray
                "secondary-dark": "#707b7c", // Darker slate gray
                accent: "#e67e22", // Vibrant orange
                "accent-light": "#f39c12", // Lighter orange
                "accent-dark": "#d35400", // Darker orange
                background: "#f4f4f4", // Light gray
                white: "#ffffff",
                black: "#000000",
                'lime-600': '#65a30d',
                'amber-600': '#d97706',
                'cyan-600': '#0891b2',
                'emerald-600': '#047857',
                'violet-600': '#7c3aed',
                'fuchsia-600': '#c026d3',
                'rose-600': '#e11d48',
                'sky-600': '#0284c7',
                'stone-600': '#78716c',
                'zinc-600': '#52525b',
            },
            fontFamily: {
                heading: ["Poppins", "Arial", "sans-serif"],
                body: ["Nunito", "Verdana", "sans-serif"],
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                xs: "0.875rem", // 14px
                sm: "1rem", // 16px
                base: "clamp(1rem, 2.5vw, 1.125rem)", // 18px
                lg: "1.25rem", // 20px
                xl: "1.5rem", // 24px
                "2xl": "1.875rem", // 30px
                "3xl": "2.25rem", // 36px
                "4xl": "3rem", // 48px
            },
            screens: {
                xs: "480px", // Extra small screens (custom)
                sm: "640px", // Small screens
                md: "768px", // Medium screens (tablet)
                lg: "1024px", // Large screens (laptop)
                xl: "1280px", // Extra large screens (desktop)
                "2xl": "1536px", // Large desktop screens
            },
            maxHeight: {
                '0': '0',
                xl: '36rem',
            },
        },
    },
    safelist: [
        'bg-lime-600', 'bg-amber-600', 'bg-cyan-600', 'bg-emerald-600',
        'bg-violet-600', 'bg-fuchsia-600', 'bg-rose-600', 'bg-sky-600',
        'bg-stone-600', 'bg-zinc-600', 'grid-cols-3'
      ],
    variants: {
        backgroundColor: [
          'hover',
          'focus',
          'active',
          'odd',
          'dark',
          'dark:hover',
          'dark:focus',
          'dark:active',
          'dark:odd',
        ],
        display: ['responsive', 'dark'],
        textColor: [
          'focus-within',
          'hover',
          'active',
          'dark',
          'dark:focus-within',
          'dark:hover',
          'dark:active',
        ],
        placeholderColor: ['focus', 'dark', 'dark:focus'],
        borderColor: ['focus', 'hover', 'dark', 'dark:focus', 'dark:hover'],
        divideColor: ['dark'],
        boxShadow: ['focus', 'dark:focus'],
      },
      plugins: [
        require('@tailwindcss/forms'),
        plugin(({ addUtilities, e, theme, variants }) => {
          const newUtilities = {}
          Object.entries(theme('colors')).map(([name, value]) => {
            if (name === 'transparent' || name === 'current') return
            const color = value[300] ? value[300] : value
            const hsla = Color(color).alpha(0.45).hsl().string()

            newUtilities[`.shadow-outline-${name}`] = {
              'box-shadow': `0 0 0 3px ${hsla}`,
            }
          })

          addUtilities(newUtilities, variants('boxShadow'))
        }),
      ],
};
