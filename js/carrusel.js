const items = document.querySelectorAll('.carrusel-item');
const prevBtn = document.querySelector('.prev');
const nextBtn = document.querySelector('.next');
let index = 0;

function mostrarItem(n) {
    items.forEach((item, i) => {
        item.classList.remove('active');
        if (i === n) {
            item.classList.add('active');
        }
    });
}

prevBtn.addEventListener('click', () => {
    index = (index > 0) ? index - 1 : items.length - 1;
    mostrarItem(index);
});

nextBtn.addEventListener('click', () => {
    index = (index < items.length - 1) ? index + 1 : 0;
    mostrarItem(index);
});

mostrarItem(index);
