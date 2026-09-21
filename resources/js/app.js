import './bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';
import { gsap } from 'gsap';

window.addEventListener('DOMContentLoaded', () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!prefersReducedMotion) {
        AOS.init({
            once: true,
            duration: 600,
            easing: 'ease-out-cubic',
            offset: 20,
            delay: 40,
            mirror: false,
        });

        const sidebar = document.querySelector('aside');
        if (sidebar) {
            gsap.from(sidebar, {
                x: -30,
                opacity: 0,
                duration: 0.55,
                ease: 'power2.out',
            });
        }

        const header = document.querySelector('header');
        if (header) {
            gsap.from(header, {
                y: -16,
                opacity: 0,
                duration: 0.45,
                ease: 'power2.out',
            });
        }

        const mainShell = document.querySelector('main');
        if (mainShell) {
            const animatedItems = mainShell.querySelectorAll('.stat-card, .bg-white, form, table, .card-panel, .panel-block, .widget, .alert-box');
            gsap.from(animatedItems, {
                y: 24,
                opacity: 0,
                duration: 0.55,
                stagger: 0.08,
                ease: 'power2.out',
                clearProps: 'transform,opacity',
            });
        }

        document.querySelectorAll('.sidebar-link').forEach((link, index) => {
            gsap.from(link, {
                x: -12,
                opacity: 0,
                duration: 0.35,
                delay: index * 0.03,
                ease: 'power2.out',
            });
        });

        document.querySelectorAll('table tbody tr').forEach((row, index) => {
            gsap.from(row, {
                opacity: 0,
                y: 14,
                duration: 0.35,
                delay: 0.05 + index * 0.02,
                ease: 'power2.out',
            });
        });

        document.querySelectorAll('form').forEach((form, index) => {
            gsap.from(form, {
                opacity: 0,
                y: 16,
                duration: 0.42,
                delay: 0.08 + index * 0.04,
                ease: 'power2.out',
            });
        });
    }

    document.querySelectorAll('[data-button-glow]').forEach((button) => {
        button.addEventListener('mouseenter', () => {
            button.style.transform = 'translateY(-1px) scale(1.01)';
        });

        button.addEventListener('mouseleave', () => {
            button.style.transform = '';
        });
    });
});
