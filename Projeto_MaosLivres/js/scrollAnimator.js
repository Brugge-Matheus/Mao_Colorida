// adicione a classe useScrollAnimator no elemento que deseja animar.
// adicione o atributo data-animation com o nome da classe da animação que você deseja utilizar. Existem 20 animações já inseridas.


/* 1. Bouncing ball - .bounce*/
/* 2. Spinning circle - .spin */
/* 3. Fading in - .fade-in */
/* 4. Fading out - .fade-out */
/* 5. Sliding in from left - .slide-in-left */
/* 6. Sliding in from right - .slide-in-right */
/* 7. Zoom in - .zoom-in */
/* 8. Zoom out - .zoom-out */
/* 9. Pulse - .pulse */
/* 10. Shake - .shake */
/* 11. Rotate - .rotate */
/* 12. Flip horizontal - .flip-h*/
/* 13. Flip vertical - .flip-v */
/* 14. Blink - .blink */
/* 15. Slide up - .slide-up */
/* 16. Slide down - .slide-down */
/* 17. Swing - .swing */
/* 18. Flash - .flash */
/* 19. Jiggle - .jiggle */
/* 20. Pop - .pop */
  

const animator = document.querySelectorAll('.useScrollAnimator');

function animarElemento(elemento, nomeAnimacao) {
    elemento.classList.add(nomeAnimacao);
}

function cancelarElemento(elemento, nomeAnimacao) {
    elemento.classList.remove(nomeAnimacao);
}

const options = {
    rootMargin: '0px',
    threshold: 0.1,
};

const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        entry.target.classList.add(`${entry.target.dataset.animation}-init`);
        if (entry.isIntersecting) {
            animarElemento(entry.target, entry.target.dataset.animation);
        }else{
            
            if(!entry.target.dataset["animateonce"]){
                cancelarElemento(entry.target, entry.target.dataset.animation);
            }
        }
    });
}, options);

animator.forEach(animado => {
    observer.observe(animado);
});