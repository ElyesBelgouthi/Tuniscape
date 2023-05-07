const blocks = document.querySelectorAll('.scrollable');

blocks.forEach((block) => {
    const container = block;
    const leftButton = block.querySelector('.left-button');
    const rightButton = block.querySelector('.right-button');

    const scrollDistance = 200;

    leftButton.addEventListener('click', () => {
        container.scrollBy({
            left: -scrollDistance,
            behavior: 'smooth',
        });
    });

    rightButton.addEventListener('click', () => {
        container.scrollBy({
            left: scrollDistance,
            behavior: 'smooth',
        });
    });

    container.addEventListener('scroll', () => {
        if (container.scrollLeft === 0) {
            leftButton.style.opacity = 0;
        } else {
            leftButton.style.opacity = 1;
        }

        if (container.scrollLeft + container.clientWidth === container.scrollWidth) {
            rightButton.style.opacity = 0;
        } else {
            rightButton.style.opacity = 1;
        }
    });
});
