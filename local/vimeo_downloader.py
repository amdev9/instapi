#!/usr/bin/python2.7
USER_AGENT = "Mozilla/5.0"
import subprocess
import sys
import re
import json

WGET_BASE = ['curl','-A',USER_AGENT,'-s','-o']

if 0==subprocess.call(['wget','--version']):
    QUIET_WGET = ['wget','-U',USER_AGENT,'-q','-O','-']
    TARGET_WGET = ['wget','-U',USER_AGENT,'-O']
elif 0==subprocess.call(['curl','--version']):
    QUIET_WGET = ['curl','-A',USER_AGENT,'-s']
    TARGET_WGET = ['curl','-A',USER_AGENT,'-o']
else:
    print "no downloader found"
    sys.exit(5)


vimeo_id = sys.argv[1]
try:
    xml = subprocess.check_output(QUIET_WGET+['http://vimeo.com/'+vimeo_id])
except:
    print "download of video page failed"
    sys.exit(1)
xml = xml.split("\n")
for l in xml:
    if "clip_page_config" in l:
        config_line = l
    if 'meta property="og:title' in l:
        caption_line = l
confurljson = re.sub(".*clip_page_config[^{]*","",config_line)[:-1]
caption = re.sub(".*content=.","",caption_line)[:-2]
try:
    myjson = json.loads(confurljson)
except ValueError:
    print "no valid json found in clip_page_config"
    print confurljson
    sys.exit(4)
try:
    configurl = myjson['player']['config_url']
except KeyError:
    print "json for player embedding unexpected"
    sys.exit(3)
try:
    theconfig = subprocess.check_output(QUIET_WGET+[configurl])
except:
    print "download of player configuration failed"
    sys.exit(1)
try:
    video_url_json = json.loads(theconfig)["request"]["files"]["progressive"]
except KeyError:
    print "unexpected player configuration json format"
    sys.exit(3)
except ValueError:
    print "no valid json found in player configuration"
    sys.exit(4)
res_url = {}
for v in video_url_json:
    try:
        print "available quality ",v['quality']
        res_url[v['quality']] = v['url']
    except KeyError:
        print "unexpected player configuration json format"
        sys.exit(3)
besturl = res_url[max(res_url)]
quality = max(res_url)
print "chose ",v['quality']," as best resolution"

filename=caption+"-("+quality+"-"+vimeo_id+").flv"
filename=filename.replace("/","_")
try:
    subprocess.check_call(TARGET_WGET+[filename,besturl])
except:
    print "download of video failed"
    print "call was: ", TARGET_WGET+[filename,besturl]
    sys.exit(2)
sys.exit(0)
