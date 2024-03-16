import cv2
from keras.models import load_model
import numpy as np
from collections import deque
import os
#from google.colab.patches import cv2_imshow

model = load_model('QuickDraw.h5')


def main():
    img = cv2.imread('canvas2.png')
    pred_probab, pred_class = keras_predict(model, img)
    print(pred_class, pred_probab)
    cv2.imshow("img",img)

def keras_predict(model, image):
    processed = keras_process_image(image)
    print("processed: " + str(processed.shape))
    pred_probab = model.predict(processed)[0]
    pred_class = list(pred_probab).index(max(pred_probab))
    return max(pred_probab), pred_class


def keras_process_image(img):
    image_x = 28
    image_y = 28
    img = cv2.resize(img, (image_x, image_y))
    img = np.array(img, dtype=np.float32)
    img = np.reshape(img, (-1, image_x, image_y, 1))
    return img

keras_predict(model, np.zeros((50, 50, 1), dtype=np.uint8))
if __name__ == '__main__':
    main()
