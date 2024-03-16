SIH 2020

Folder Structure:
/assets - contains assets of required for the project like fonts, audio etc
/backend - Contains the PHP and Python Backend Code
	/audio_operation - php files for operations on the audio like getting the audio
			   Files named as (captchaNomenclatureName)_(whatThisFileDoes).php
	/image_operation - php files for operations on the captch images like displaying the image, formatting the image. 
			   Files named as (captchaNomenclatureName)_(whatThisFileDoes).php
	/validation - php files for validating the captcha.
		     Files named as (captchaNomenclatureName)_(whatThisFileDoes).php
	/captcha_pages - different php files which contain the front-end html for displaying the various captcha types
			 Files named as (captchaNomenclatureName).php
/backup - (Kept as a backup to not delete any important files while migrating) backup of the previous folder structure

index.html - Index file which contains list of various captchas to choose from
	
