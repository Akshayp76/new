<html>
    <script>
         text2speech($string){
             $letters = explode($string);
             foreach($letters as $letter){ play_sound($letter); }
         }
         play_sound($letter){
             $letter."mp3".play();
             while($letter.isPlaying() == true){ /*wait for the sound to finish*/ }
         }
    </script>

    <form>
        <input type="text" name="text2READ"><input type="submit" onlick="text2speech(text2READ.getValue())">
    </form>
</html>
J
