document.addEventListener('DOMContentLoaded', function () {
    const emblaNode = document.querySelector('.embla');
    const viewportNode = emblaNode.querySelector('.embla__viewport');

    const embla = EmblaCarousel(viewportNode, {
        loop: true,
        align: 'start',
        dragFree: false,
    });

    const prevBtn = emblaNode.querySelector('.embla__prev');
    const nextBtn = emblaNode.querySelector('.embla__next');

    prevBtn.addEventListener('click', embla.scrollPrev);
    nextBtn.addEventListener('click', embla.scrollNext);
});