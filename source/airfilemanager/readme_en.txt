Translation by Google Translate
```````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````

A&R Filemanager

If you are using in your applications Tiny MCE editor then you know that this editor is really great, but it is supplied without a file manager (well, there is the manager, but not open source).
Our manager is perhaps not so extensive (and perhaps ever will?) But fulfills its role.
In short, what it can do:

# Well, you can browse the files. In two modes: list and thumbnail images
# upload files (up to 4 at a time)
# if the images are uploaded you can create a thumbnail automatically, possibly with an option to crop
# delete files and folders in bulk and recursively (even if filled)
# has a built-in filter file types, which means that it can show only those files which will fit Tiny MCE current function, or all files
# download files. Here note - the mechanism is implemented which does not allow to download any file from the server, but only those on which the manager operates. Kind of obvious, 
  but most of other managers has this terrible hole in security. I tested on localhost (Windows, Apache). The five tested, four no problem allowed to download any file to my C: drive. Terrible: (
# has a built-in cache for displayed thumbnails and self-purification of this cache.

And what does not:

# edit previously uploaded images
# edit text files
# maybe you have an idea ..?

Installation

It is trivial. Are you interested in one file - config.php. I know how annoying configuration of filemanagers can be. In our case manager may be limited to one entry in the config.php file. This entry will be relative path to the directory in which the manager has to read and write files.

Detailed Installation ;)

Step by step, discussing all the configuration options and the Tiny MCE configuration:

   1. Requirements

      You will need: a HTTPd server with support for PHP version 5.0.2 or later.
      The script uses modules and libraries: mb_string, GD2.

   2. Unzip the zip file into a directory of plug-ins

      In most cases it will look like this: tiny_mce/plugins/airfilemanager/
      ZIP file can be downloaded from: http://www.airmedia.pl/files/
      (grab ~ afm_SOMETHING.zip)

   3. Configure A&R Filemanager

      Options in the file 'config.php': Mandatory is only one - FILES_PATH.

      LANG - Language in which the manager is to be displayed. At present, there are 'en' - English, 'pl' - Polish, 'ru' - Russian

      FILES_PATH - Relative path to the directory in which the manager has to read and write files. The path must be relative to the directory where the file 'config.php' exists.

      VIEW_ALL - true - show all known files (media, images, texts, etc.). or false - only show files that can be inserted into the Tiny MCE.
                 Option set to false causes that when the user selects the Tiny MCE 'insert media' will see only the media files (swf, qt, mov, etc.). But not images or text files.
                 Despite the inclusion of this option, the manager will not executable files, or potentially dangerous.

      USE_CACHE - Once you use the thumbnail, to date they are created by the script. In the case of images with high resolution is needed for a large computing power.
                  And every once in a single directory such pictures will be in 20? 50? 100? A thousand? And given that the user can 'jump' on the directories is done with this serious performance problem.
                  That is why you should enable this option (true). Manager will create a directory where it will be detained once created thumbnails and cleaned it as necessary (manager hides the directory from the user).
                  By default, the cache is disabled (false) because the script is in the testing stage.

   4. Configure Tiny MCE

      You should add two things:

       * Inside tinyMCE.init ({...}) entry: file_browser_callback "airfilemanager"
       * JavaScript function:
       
function airfilemanager(field_name, url, type, win) {
 switch(type) { 
   case 'media':
   case 'image':
   case 'flash':
   case 'file':
     break;
   default:
     return !1;
 }
 tinyMCE.activeEditor.windowManager.open({ 
   url: "tiny_mce/plugins/airfilemanager/afm.php"+"?type="+type, 
   width: 780, 
   height: 500, 
   inline: "yes", 
   close_previous: "no"
  },{ window: win, input: field_name });
} 

Above function can be added anywhere in total, for example, in <head> section of file in which you have Tiny MCE, but I recommend it be included under the entry tinyMCE.init ({...}) to be at hand,  especially given that in itself is part of the configuration, for example, it can determine the size of the window manager.


