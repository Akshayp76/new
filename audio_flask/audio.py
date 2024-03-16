from pydub import AudioSegment
from base64 import b64encode
import sys
import os

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
