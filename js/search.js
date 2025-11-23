(function () {
    function debounce(fn, wait = 200) {
    let t;
        return function(...args) {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    const input = document.getElementById('filtroAlumnos');
    const btnBuscar = document.getElementById('btnBuscar');
    const btnLimpiar = document.getElementById('btnLimpiar');
    const tbody = document.getElementById('tablaAlumnosBody');

    if (!input || !tbody) return;

    function filtrar() {
        const q = input.value.trim().toLowerCase();
        const rows = tbody.querySelectorAll('tr');
        if (q === '') {
            rows.forEach(r => r.style.display = '');
            return;
        }
        rows.forEach(row => {
            const cellsText = Array.from(row.querySelectorAll('td'))
            .slice(0,4) // solo columnas visbles (nombre, dni, telefono, plan)
            .map(td => td.innerText.toLowerCase())
            .join(' ');
            row.style.display = cellsText.includes(q) ? '' : 'none';
        });
    }

    const filtrarDebounced = debounce(filtrar, 150);

    
    input.addEventListener('input', filtrarDebounced);
    btnBuscar.addEventListener('click', filtrar);
    btnLimpiar.addEventListener('click', () => {
        input.value = '';
        filtrar();
        input.focus();
    });

    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            filtrar();
        }
    });
})();