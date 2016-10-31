# Pixelant
[![TYPO3](https://img.shields.io/badge/TYPO3-8.4.0-orange.svg?style=flat-square)](https://typo3.org/)

# Pixelant Form Enhancement (pxa_form_enhancement) #

## What’s it is doing? ##
This extension extend standard TYPO3 form with next features:

 1. reCAPTCHA - protect website form from spam 
 2. save form post processor - save email sent by Frontend users of your website

## How to configure it ? ##
Use extension manager to install extension

Include TypoScript template. Include static (from extensions): "Pxa Form Enhancement (pxa_form_enhancement)".

Add reCAPTCHA site key and site secret constants. You can get these keys on [official page](https://www.google.com/recaptcha/intro/index.html). 

```
#!typoscript

plugin.tx_pxaformenhancement.settings.siteKey = siteKeyHere
plugin.tx_pxaformenhancement.settings.siteSecret = siteSecret
```

## Using reCAPTCHA ##

reCAPTCHA is available as new element in list of "Basic form elements". Add it to you website form and it will appear on a site automatically.

## Using Save form post processor ##

If you need to save form sent by Frontend user, you need to add it on "**Post Processors**" tab. Its name is "**Save form**".

Configure next Save form post processor fields:

 1. Pid - storage of records (where to save emails)
 2. Record name - default record name
 3. Upload folder - where to save uploaded  file by Frontend user. **!!! Notice** that you don't need to write default storage folder. For example if you are using default TYPO3 storage (fileadmin) and you want to save files in "fileadmin/user_upload", you need to fill in this field with just "user_upload". 
 4. Default storage - what TYPO3 storage to use
