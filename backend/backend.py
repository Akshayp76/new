from flask import Flask
from flask import request
import cv2
from keras.models import load_model
import numpy as np
from PIL import Image
import base64
import imutils
import io
from collections import deque
import os
from pydub import AudioSegment
from base64 import b64encode
import sys

app = Flask(__name__)
objmodel = load_model('../models/QuickDraw.h5')
nummodel = load_model('../models/dg.h5')
@app.route("/")
def home():
    arr = ["dog", "cat", "cow", "sheep", "lion", "tiger", "monkey", "donkey"
           , "hibiscus", "tulip", "rose", "lotus", "sunflower", "apple", "lemon"
           , "orange", "fig", "grapes", "banana", "kiwi", "peach", "potato", "spinach"
           , "mushroom", "cabbage", "beetroot", "corn", "carrot", "plum", "apricot"
           , "broccoli", "cauliflower", "olive", "sun", "moon", "venus", "mercury"
           , "earth", "mars", "jupiter", "saturn", "uranus", "neptune", "january"
           , "february", "march", "april", "may", "june", "july", "september", "october"
           , "november", "december", "sunday", "monday", "tuesday", "wednesday", "thursday"
           , "friday", "saturday", "is", "are", "was", "were", "will", "animal", "flower"
           , "fruit", "flower", "planet", "month"]
    #arr = ["a", "b", "c", "d", "e", "f", "g", "h"]
    respString = ",".join(arr)
    return respString 

def keras_predict(model, image):
    processed = keras_process_image(image)
    pred_probab = model.predict(processed)[0]
    pred_class = list(pred_probab).index(max(pred_probab))
    return max(pred_probab), pred_class


def keras_process_image(img):
    cv2.imwrite("temp/input.png", img)
    image_x = 28
    image_y = 28

    print(img.shape)


    #Cut to required area
    hsv = cv2.cvtColor(img, cv2.COLOR_BGR2HSV)
    s = hsv[:, :, 1]
    ret, thresh = cv2.threshold(s, 0, 255, cv2.THRESH_BINARY+cv2.THRESH_OTSU)
    contours = cv2.findContours(thresh, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_NONE)
    contours = imutils.grab_contours(contours)
    try:
        c = max(contours, key=cv2.contourArea)
        x, y, w, h = cv2.boundingRect(c)
        out = img[y:y+h+8, x:x+w+8, :].copy()
    except:
        out = img
    #cv2.imwrite("imageCropped.png", out);

    #dilating the image
    kernel = cv2.getStructuringElement(cv2.MORPH_RECT, (9,9))
    dilate = cv2.dilate(out, kernel, iterations=1)
    kernel = np.ones((5,5),np.uint8)
    erosion = cv2.erode(dilate,kernel,iterations = 1)
    cv2.imwrite("temp/imageDilated.png", erosion)

    #Convert to grayscale 
    img = cv2.cvtColor(dilate, cv2.COLOR_BGR2GRAY)
    cv2.imwrite("temp/imageGrayscale.png", img);


    """
    cv2.drawContours(img, contours, -1, (0, 255, 0), 2)
    x, y, w, h = cv2.boundingRect(contours[0])
    thresh[y:y+h, x:x+w] = 255 - thresh[y:y+h, x:x+w]
    """

    img = cv2.resize(img, (image_x, image_y))
    #img = cv2.bitwise_not(img)
    #print("after resizing: " + str(img.shape))
    cv2.imwrite("temp/imageToSaveResized.png", img);
    img = np.array(img, dtype=np.float32)
    img = np.reshape(img, (-1, image_x, image_y, 1))

    # Image.fromarray(img).save('final.png')
    return img

def readb641(base64_string):
    sbuf = io.StringIO()
    sbuf.write(base64.b64decode(base64_string))
    pimg = Image.open(sbuf)
    return cv2.cvtColor(np.array(pimg), cv2.COLOR_RGB2BGR)

def readb64(uri):
    #encoded_data = uri.split(',')[1]
    encoded_data = uri
    #print(len(encoded_data))
    with open("temp/imageToSave.png", "wb") as fh:
            fh.write(base64.b64decode(encoded_data))
    nparr = np.fromstring(base64.b64decode(encoded_data), np.uint8)
    #print(nparr)
    img = cv2.imdecode(nparr, cv2.IMREAD_COLOR)
    cv2.imwrite("temp/imageToSaveCvized.png", img);
    return img

def audiomerge(sound1, sound2):
    sound1 = AudioSegment.from_file(sound1) #noise
    sound2 = AudioSegment.from_file(sound2) #audio
    sound_q = sound1 - 20
    sound1_len = len(sound_q)
    sound2_len = len(sound2)
    print("length of noise", sound1_len)
    print("length of audio", sound2_len)
    diff = sound2_len - sound1_len
    if(sound2_len < sound1_len):
        diff = sound1_len - sound2_len
        print("Background noise len is more")
        sound_q = sound_q[:sound2_len]
        diff = 0
    while (diff):
        if (diff < sound1_len):
            sound_q = sound_q + sound_q[:diff]
            diff = 0
        else:
            x = int(diff / sound1_len)
            repeat = sound_q * x
            sound_q = sound_q + repeat
            diff = diff - x * sound1_len
    # print(len2)
    combined = sound_q.overlay(sound2)
    len1 = len(combined)
    print(len1)
    combined.export("com.wav", format='wav')

    
    f = open("com.wav", "rb")
    enc = b64encode(f.read())
    f.close()
    base64audio = str(enc,'ascii', 'ignore')
    #print(base64audio)
    if os.path.exists("com.wav"):
        os.remove("com.wav")
    #if os.path.exists(base_location + "assets/audio/tts.wav"):
    #    os.remove(base_location + "assets/audio/tts.wav")
    return base64audio


@app.route("/objpredict/", methods=['GET', 'POST'])
def objpredict():
    img = request.form["img"]
    #img = cv2.imread(img)
    cvimg = readb64(img)
    pred_probab, pred_class = keras_predict(objmodel, cvimg)
    print(pred_class, pred_probab)
    return str(pred_class)

@app.route("/numpredict/", methods=['GET', 'POST'])
def numpredict():
    img = request.form["img"]
    #img = cv2.imread(img)
    cvimg = readb64(img)
    pred_probab, pred_class = keras_predict(nummodel, cvimg)
    print(pred_class, pred_probab)
    return str(pred_class)

@app.route('/audio/', methods=['POST'])
def shellFun():
    return audiomerge(request.form['noise'], request.form['sound'])

if __name__ == "__main__":
    app.run(debug=True)
