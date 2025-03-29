import { en } from './const/en.js';
import { bm } from './const/bm.js';

// Create a translations object
const translations = { en, bm };

// Get the user's preferred language from localStorage or default to 'en'
let currentLang = localStorage.getItem('preferredLanguage') || 'en';

// Function to update all text content
function updateContent(lang) {
  // Update active state of language buttons
  document.querySelectorAll('.lang-btn').forEach(btn => {
    btn.classList.remove('active');
    if (btn.getAttribute('data-lang') === lang) {
      btn.classList.add('active');
    }
  });

  // Update text content
  Object.keys(translations[lang]).forEach(key => {
    const elements = document.querySelectorAll(`[data-i18n="${key}"]`);
    elements.forEach(element => {
      element.innerHTML = translations[lang][key];
    });
  });

  // Store the selected language
  // localStorage.setItem('preferredLanguage', lang);
  currentLang = lang;

  // Update HTML lang attribute
  document.documentElement.lang = lang;
}

// Initialize language switcher
document.addEventListener('DOMContentLoaded', () => {
  // Add click handlers to language buttons
  document.querySelectorAll('.lang-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const newLang = btn.getAttribute('data-lang');
      updateContent(newLang);
    });
  });

  // Set initial language
  updateContent(currentLang);
});