# Form Enhancement

## Pixelant Form Enhancement `pxa_form_enhancement`

This extension extend standard TYPO3 form with next features:

 1. reCAPTCHA - protect website form from spam 
 2. Save form finisher - save email sent by users of your website

## Configuration

Use extension manager to install extension

Include TypoScript template. Include static (from extensions): "Pxa Form Enhancement (pxa_form_enhancement)".

Add reCAPTCHA site key and site secret constants. You can get these keys on [official page](https://www.google.com/recaptcha/intro/index.html).

```typoscript
#!typoscript

// Google ReCaptcha authentications
plugin.tx_pxaformenhancement.settings.siteKey = siteKeyHere
plugin.tx_pxaformenhancement.settings.siteSecret = siteSecret

#Optional (will be in current language by default if this is empty)
#plugin.tx_pxaformenhancement.settings.language =
```

### Hide reCAPTCHA on summary page and in email

ReCAPTCHA can be removed from summary page and emails using constants configuration. Set value of "hideRecaptchaOnSummaryPage"
constant to "1". Note that this option will change default path of summary and emails templates. 

``` typoscript
#!typoscript

plugin.tx_pxaformenhancement.settings.hideRecaptchaOnSummaryPage = 1
```

## Using reCAPTCHA

reCAPTCHA is available as new element in list of "Advanced elements". Add it to you website form and it will appear on a site automatically. **Don't forget to add Recaptcha validator to this element**.

## Using Save form post processor

If you need to save form sent by user, you need **to add a finisher** tab. Its name is "**Save form**".

Configure next Save form post processor fields:

 1. Name of record name - default record name
 2. Storage - storage of records (where to save emails)
