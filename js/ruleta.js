document.addEventListener("DOMContentLoaded", () => {

    const canvas = document.getElementById("ruletaCanvas");
    if (!canvas) return;

    const ctx = canvas.getContext("2d");

    const size = 400;
    const radius = size / 2;
    const cx = radius;
    const cy = radius;

    const N = 37;
    const ang = (2 * Math.PI) / N;

    
    const rojos = [1,3,5,7,9,12,14,16,18,19,21,23,25,27,30,32,34,36];

    
    const sectores = [
        0, 32, 15, 19, 4, 21, 2, 25, 17, 34, 6,
        27, 13, 36, 11, 30, 8, 23, 10, 5,
        24, 16, 33, 1, 20, 14, 31, 9, 22,
        18, 29, 7, 28, 12, 35, 3, 26
    ];

    function dibujarRuleta(offset) {

        ctx.clearRect(0, 0, size, size);

        for (let i = 0; i < N; i++) {

            const numero = sectores[i];
            const inicio = offset + i * ang;
            const fin = inicio + ang;

            let color = "#000";
            if (numero === 0) color = "#0a5";
            else if (rojos.includes(numero)) color = "#c00";

            ctx.beginPath();
            ctx.moveTo(cx, cy);
            ctx.arc(cx, cy, radius, inicio, fin);
            ctx.fillStyle = color;
            ctx.fill();
            ctx.closePath();

            // texto
            const mid = (inicio + fin) / 2;
            const tx = cx + (radius * 0.72) * Math.cos(mid);
            const ty = cy + (radius * 0.72) * Math.sin(mid);

            ctx.save();
            ctx.translate(tx, ty);
            ctx.rotate(mid + Math.PI / 2);
            ctx.fillStyle = "#fff";
            ctx.font = "16px Arial";
            ctx.textAlign = "center";
            ctx.textBaseline = "middle";
            ctx.fillText(numero.toString(), 0, 0);
            ctx.restore();
        }
    }
    if (typeof NUMERO_GANADOR !== "number" || isNaN(NUMERO_GANADOR)) {
        dibujarRuleta(0);
        return;
    }

    const idx = sectores.indexOf(NUMERO_GANADOR);
    const centerAngle = idx * ang + (ang / 2);

    const targetAngle = -Math.PI / 2; 

    const vueltas = 4;
    const offsetFinal = (vueltas * 2 * Math.PI) + (targetAngle - centerAngle);

    let start = null;
    const duracion = 3000;

    function animar(timestamp) {
        if (!start) start = timestamp;
        const elapsed = timestamp - start;

        const t = Math.min(elapsed / duracion, 1);
        const easeOut = 1 - Math.pow(1 - t, 3);

        const offsetActual = easeOut * offsetFinal;

        dibujarRuleta(offsetActual);

        if (t < 1) {
            requestAnimationFrame(animar);
        }
    }

    requestAnimationFrame(animar);

const celdas = document.querySelectorAll(".celda");
const ficha = document.getElementById("ficha");
const numeroInput = document.getElementById("numeroInput");

celdas.forEach(celda => {
    celda.addEventListener("click", () => {

        const num = celda.dataset.num;
        numeroInput.value = num; 

        const rect = celda.getBoundingClientRect();
        const board = document.querySelector(".tablero").getBoundingClientRect();

        ficha.style.left = (rect.left - board.left + rect.width/2 - 15) + "px";
        ficha.style.top  = (rect.top - board.top + rect.height/2 - 15) + "px";

        ficha.style.display = "block";
    });
});


});