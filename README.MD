# Pixelant
[![TYPO3](https://img.shields.io/badge/TYPO3-8.7.0-orange.svg?style=flat-square)](https://typo3.org/)

# Pixelant Form Enhancement (pxa_form_enhancement) #

## What’s it is doing? ##
This extension extend standard TYPO3 form with next features:

 1. reCAPTCHA - protect website form from spam 
 2. Save form finisher - save email sent by users of your website

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

reCAPTCHA is available as new element in list of "Advanced elements". Add it to you website form and it will appear on a site automatically. **Don't forget to add Recatcha validator to this element**.

## Using Save form post processor ##

If you need to save form sent by user, you need **to add a finisher** tab. Its name is "**Save form**".

Configure next Save form post processor fields:

 1. Name of record name - default record name
 2. Storage - storage of records (where to save emails)