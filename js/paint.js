{
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    //const clearCanvas = document.getElementById('clear-canvas');
    const radius = 10;
    let painting = false;
    resize();
    function resize() {
      context.canvas.width = window.innerWidth;
      context.canvas.height = window.innerHeight;
    }
    motion = [];

    function paintBackground() {
        context.fillStyle = 'black';
        context.fillRect(0, 0, canvas.width, canvas.height);
        context.fillStyle = 'red';
    }

    function putPoint(e) {
        if (!painting) return;
        motion.push([e.offsetX, e.offsetY]);
        context.lineTo(e.offsetX, e.offsetY);
        context.stroke();

        context.beginPath();
        context.arc(e.offsetX, e.offsetY, radius, 0, Math.PI * 2);
        context.fill();

        context.beginPath();
        context.moveTo(e.offsetX, e.offsetY);
    }

    function startStroke(e) {
        console.log('painting'); 
        painting = true;
        putPoint(e);
    }

    function endStroke() {
        painting = false;
        context.beginPath();
    }

    canvas.width = 200;
    canvas.height = 200;
    context.lineWidth = radius * 2;
    context.strokeStyle = 'red';

    paintBackground();

  /*
    canvas.addEventListener('mousedown', startStroke);
    canvas.addEventListener('mousemove', putPoint);
    canvas.addEventListener('mouseup', endStroke);
    canvas.addEventListener('mouseleave', endStroke);
    */
    document.addEventListener('mousedown', startStroke);
    document.addEventListener('mousemove', putPoint);
    document.addEventListener('mouseup', endStroke);
    document.addEventListener('mouseleave', endStroke);

    //clearCanvas.addEventListener('click', () => paintBackground());
}
