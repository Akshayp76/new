{
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    //const clearCanvas = document.getElementById('clear-canvas');
    const msg1 = 'Draw an uppercase letter';
    const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var letter = null;

    function setListeners(model) {
        canvas.addEventListener('mouseup', () => predict(model));
        // canvas.addEventListener('mouseleave', () => predict(model));
    }

    function predict(model) {
      console.log('predicting');
      console.log(motion);
      var minX = 10000;
      var minY = 10000;
      var maxX = -1;
      var maxY = -1;
      motion.forEach(ele => {
        if(ele[0] < minX) {
          minX = ele[0];
        } 
        if(ele[0] > maxX) {
          maxX = ele[0];
        }
        if(ele[1] < minY) {
          minY = ele[1];
        }
        if(ele[1] > maxY) {
          maxY = ele[1];
        }
      });
      console.log(minX, minY, maxX, maxY);
        let canvasPixels = context.getImageData(0, 0, canvas.width, canvas.height);
        //let canvasPixels = context.getImageData(minX - 5, minY -5 , maxX-minX + 5, maxY-minY);
        let canvasPixelsTensor = tf.browser.fromPixels(canvasPixels, 1);
        //canvasPixelsTensor = tf.image.crop_to_bounding_box(canvasPixelsTensor, minY, minX, maxY - minY, maxX - minX);
        canvasPixelsTensor = tf.image.resizeBilinear(canvasPixelsTensor, [28, 28]);
        canvasPixelsTensor = canvasPixelsTensor.toFloat().mul(tf.tensor1d([1 / 255])).expandDims(0);

        let results = model.predict(canvasPixelsTensor);

        results.data().then(data => {
            data = Array.from(data);

            let letterScores = data.map((elem, i) => {
                return { letter: letters[i], value: elem };
            });
            letterScores.sort((a, b) => b.value - a.value);
            let top3 = letterScores.slice(0, 3);
            letter = top3[0];
        });
    }

    //clearCanvas.addEventListener('click', resetText);

  tf.loadLayersModel('http://localhost/captcha-alternative/models/model.json').then(setListeners);
}
