from pydub import AudioSegment
import sys
from base64 import b64encode
import os
import json

config_file = open('../config.json')
config = json.load(config_file);
base_location = config["base_location"]

noise = sys.argv[2]
audio = sys.argv[1]
sound1 = AudioSegment.from_file(audio)
sound2 = AudioSegment.from_file(noise)
#sound1 = AudioSegment.from_file("machine-gun-01.wav")
#sound2 = AudioSegment.from_file("sib.wav")
sound_q = sound2 - 20

sound1_len = len(sound_q)
sound2_len = len(sound2)
diff = sound2_len - sound1_len

if(diff < 0):
    diff = -1 * diff
if(sound2_len < sound1_len):
    sound_q = sound1[:diff]
    diff = 0
while(diff):
	if(diff < sound1_len):
                sound_q = sound_q + sound_q[:diff]
                diff = 0
	else:
		x = int(diff/sound1_len);
		repeat = sound_q * x
		sound_q = sound_q + repeat
		diff = diff - x*sound1_len
combined = sound_q.overlay(sound1)
len1 = len(combined)
combined.export(base_location + "assets/audio/combined.wav", format='wav') #change by appropriate location 

f = open(base_location + "assets/audio/combined.wav", "rb")
enc = b64encode(f.read())
f.close()
base64audio = str(enc,'ascii', 'ignore')
print(base64audio)
if os.path.exists(base_location + "assets/audio/combined.wav"):
    os.remove(base_location + "assets/audio/combined.wav")
if os.path.exists(base_location + "assets/audio/tts.wav"):
    os.remove(base_location + "assets/audio/tts.wav")
