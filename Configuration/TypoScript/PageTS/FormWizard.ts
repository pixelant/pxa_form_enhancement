mod.wizards {
    form {
        defaults {
            tabs {
                form.accordions.postProcessor {
                    showPostProcessors := addToList( saveForm)
                    postProcessors {
                        saveForm {
                            showProperties = pid, defaultName, uploadFolder, storageUid, fieldsToSaveAsTitle
                        }
                    }
                }

                elements.accordions.basic.showButtons := addToList( recaptcha)

                options.accordions.validation {
                    showRules := addToList( recaptcha)
                    rules {
                        recaptcha {
                            showProperties = message, error, breakOnError, showMessage
                        }
                    }
                }
            }
        }

        elements {
            recaptcha {
                showAccordions = label, attributes, validation
                accordions {
                    attributes {
                        showProperties = name, id, class
                    }
                    validation {
                        showRules = recaptcha
                    }
                }
            }
        }
    }
}
