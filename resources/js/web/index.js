function updateTheme() {
    const header = document.querySelector('.header');
    const menu = document.querySelector('.menu');

    if (header) {
        const rect = header.getBoundingClientRect();

        const elementUnderHeader = document.elementFromPoint(
            rect.left + rect.width / 2,
            rect.bottom + 1
        );

        const sectionUnderHeader = elementUnderHeader?.closest('.theme-section');

        if (sectionUnderHeader) {
            if (sectionUnderHeader.classList.contains('dark')) {
                header.classList.add('dark');
                header.classList.remove('light');
            } else {
                header.classList.add('light');
                header.classList.remove('dark');
            }
        }
    }

    if (menu) {
        const rect = menu.getBoundingClientRect();
        const elementUnderMenu = document.elementFromPoint(
            rect.left + rect.width / 2,
            rect.bottom + 1
        );

        const sectionUnderMenu = elementUnderMenu?.closest('.theme-section');

        if (sectionUnderMenu) {
            if (sectionUnderMenu.classList.contains('dark')) {
                menu.classList.add('dark');
                menu.classList.remove('light');
            } else {
                menu.classList.add('light');
                menu.classList.remove('dark');
            }
        }
    }
}

let ticking = false;

function onScroll() {
    if (!ticking) {
        requestAnimationFrame(() => {
            updateTheme();
            ticking = false;
        });
        ticking = true;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    updateTheme();

    window.addEventListener('scroll', onScroll);
});

window.addEventListener('load', () => {
    updateTheme();
});