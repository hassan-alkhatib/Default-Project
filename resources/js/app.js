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

    document.querySelectorAll('[data-counter]').forEach((el) => {
        const target = parseFloat((el.dataset.value || '0').replace(/,/g, ''));
        const decimals = Math.min(parseInt(el.dataset.decimals || '0', 10), 2);
        const format = (value) =>
            value.toLocaleString('en-US', {
                minimumFractionDigits: decimals,
                maximumFractionDigits: decimals,
            });

        if (prefersReducedMotion) {
            el.textContent = format(target);
            return;
        }

        const state = { val: 0 };
        gsap.to(state, {
            val: target,
            duration: 1.2,
            ease: 'power2.out',
            onUpdate() {
                el.textContent = format(state.val);
            },
        });
    });

    document.querySelectorAll('.alert-box').forEach((alertEl) => {
        setTimeout(() => {
            alertEl.classList.add('is-hiding');
            setTimeout(() => alertEl.remove(), 450);
        }, 4200);
    });

    if (!prefersReducedMotion) {
        const overlay = document.createElement('div');
        overlay.className = 'page-transition-overlay';
        document.body.appendChild(overlay);

        document.querySelectorAll('a[href]').forEach((link) => {
            link.addEventListener('click', (e) => {
                if (link.closest('form')) return;
                if (link.target && link.target !== '_self') return;
                if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey || e.button !== 0) return;
                if (link.hasAttribute('onclick') || link.hasAttribute('download')) return;

                const href = link.getAttribute('href');
                if (!href || href === '#' || href.startsWith('#') || /^javascript:/i.test(href)) return;
                if (href.startsWith('mailto:') || href.startsWith('tel:')) return;

                const url = new URL(href, window.location.origin);
                if (url.origin !== window.location.origin) return;

                e.preventDefault();
                overlay.classList.add('is-active');
                setTimeout(() => {
                    window.location.href = url.href;
                }, 220);
            });
        });
    }

    document.querySelectorAll('form').forEach((form) => {
        const method = (form.getAttribute('method') || 'get').toLowerCase();
        if (method === 'get') return;

        form.addEventListener('submit', () => {
            const btn = form.querySelector('button[type="submit"]');
            if (!btn || btn.dataset.avoidLoading !== undefined) return;

            btn.disabled = true;
            if (!btn.dataset.originalLabel) {
                btn.dataset.originalLabel = btn.innerHTML;
            }
            btn.innerHTML = `<span class="spinner"></span> ${btn.dataset.loadingText || 'جارٍ الحفظ...'}`;
        });
    });
});
