import { ref, watch } from 'vue'

export function useTheme() {
    const theme = ref(localStorage.getItem('theme') || 'light')

    const applyTheme = (value) => {
        document.documentElement.setAttribute('data-bs-theme', value)
    }

    applyTheme(theme.value)

    watch(theme, (newVal) => {
        localStorage.setItem('theme', newVal)
        applyTheme(newVal)
    })

    const toggleTheme = () => {
        theme.value = theme.value === 'dark' ? 'light' : 'dark'
    }

    return { theme, toggleTheme }
}
