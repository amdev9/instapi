# -*- coding: utf-8 -*-
import subprocess
import os, errno
from moviepy.editor import *



def silentremove(filename):
    try:
        os.remove(filename)
    except OSError as e: # this would be "except OSError, e:" before Python 2.6
        if e.errno != errno.ENOENT: # errno.ENOENT = no such file or directory
            raise # re-raise exception if a different error occured


for filename in os.listdir(os.path.dirname(os.path.abspath(__file__))):
  base_file, ext = os.path.splitext(filename)
  if ext == ".flv":
    os.rename(filename, "3" + ".flv")


subprocess.call('ffmpeg -i 3.flv  -vf  scale=-1:640 mov_bit.mp4', shell=True)
subprocess.call('ffmpeg -i mov_bit.mp4  -filter:v "crop=640:640:200:100" mov.mp4', shell=True)
if os.path.isfile("mov.mp4") == True:
  video = VideoFileClip("mov.mp4").subclip(20,50)

 
  # Make the text. Many more options are available.
  txt_clip = ( TextClip("@mosmagazinefitness",fontsize=70,color='white', font='Brandon-Grotesque-Regular-Regular')
             .set_pos((10,500))
             .set_duration(5) )

  result = CompositeVideoClip([video, txt_clip]) # Overlay text on video

  result.write_videofile("mosmagazinefitness.mp4",fps=30,codec='libx264', 
    audio_codec='aac', 
    temp_audiofile='temp-audio.m4a', 
    remove_temp=True) 
  # subprocess.call('ffmpeg -i mosmagazinefitness.mp4 -c:v libx264 -crf 18 mosmagazinefitness_.mp4', shell=True)
  # subprocess.call('ffmpeg -i mosmagazinefitness.mp4 -r 30 -pix_fmt yuv420p -c:v libx264 -profile:v baseline -level 3.0 -preset slow mosmagazinefitness_final.mp4', shell=True)


# silentremove('./mosmagazinefitness.mp4')
silentremove('./mov_bit.mp4')
silentremove('./mov.mp4')




# a = TextClip.list('font')
# print a



# ffmpeg -i Dat\ ass\ by\ Lukomsky-HD.mp4  -vf scale=-1:640  mov_scale1640_bit.mp4
# ffmpeg -i mov_scale1640_bit.mp4  -filter:v "crop=640:640:200:100" mov.mp4


#afinfo mov.mp4 | grep "bit rate"

# ffmpeg -i Dat\ ass\ by\ Lukomsky-HD.mp4  -vf scale=-1:640 -b:v 128k -bufsize 128k mov_scale1640_bit.mp4



#final #######
#ffmpeg -i [nameoffile] -r 30 -pix_fmt yuv420p -c:v libx264 -profile:v baseline -level 3.0 -preset slow short_inst1.mp4
# ffmpeg -i input.wmv -ss 00:00:30.0 -c copy -t 00:00:10.0 




 
# ffmpeg -i mov.mp4 -c:v libx264 -crf 23 output.mp4
