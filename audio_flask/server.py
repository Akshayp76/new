from flask import Flask, request, make_response, jsonify, send_file, send_from_directory, safe_join, abort
#from flask_cors import CORS
from flask import request
import audio

app = Flask(__name__) 
#CORS(app)

@app.route('/audio/', methods=['POST'])
def shellFun():
    return audio.audiomerge(request.form['noise'], request.form['sound'])

if __name__ == '__main__': 
	app.run(debug = True) 

