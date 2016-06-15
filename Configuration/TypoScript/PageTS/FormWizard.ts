mod.wizards.form.defaults.tabs.form.accordions.postProcessor {
    showPostProcessors := addToList( saveForm)
    postProcessors {
        saveForm {
            showProperties = pid, defaultName, uploadFolder, storageUid
        }
    }
}