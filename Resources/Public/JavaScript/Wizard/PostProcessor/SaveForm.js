Ext.namespace('TYPO3.Form.Wizard.Viewport.Left.Form.PostProcessors');

/**
 * The SaveForm post processor
 *
 * @class TYPO3.Form.Wizard.Viewport.Left.Form.PostProcessors.SaveForm
 * @extends TYPO3.Form.Wizard.Viewport.Left.Form.PostProcessors.PostProcessor
 */
TYPO3.Form.Wizard.Viewport.Left.Form.PostProcessors.SaveForm = Ext.extend(TYPO3.Form.Wizard.Viewport.Left.Form.PostProcessors.PostProcessor, {
    /**
     * @cfg {String} processor
     *
     * The name of this processor
     */
    processor: 'saveForm',

    /**
     * Constructor
     */
    initComponent: function() {
        var fields = this.getFieldsBySettings();
        var formItems = new Array();

        // Adds the specified events to the list of events which this Observable may fire.
        this.addEvents({
            'validation': true
        });

        Ext.iterate(fields, function(item, index, allItems) {
            switch(item) {
                case 'pid':
                    formItems.push({
                        fieldLabel: TYPO3.l10n.localize('postprocessor_properties_pid'),
                        name: 'pid',
                        allowBlank: false,
                        listeners: {
                            'triggerclick': {
                                scope: this,
                                fn: this.storeValue
                            }
                        }
                    });
                    break;
                case 'defaultName':
                    formItems.push({
                        fieldLabel: TYPO3.l10n.localize('postprocessor_properties_defaultName'),
                        name: 'defaultName',
                        allowBlank: true,
                        listeners: {
                            'triggerclick': {
                                scope: this,
                                fn: this.storeValue
                            }
                        }
                    });
                    break;
                case 'storageUid':
                    formItems.push({
                        fieldLabel: TYPO3.l10n.localize('postprocessor_properties_storageUid'),
                        name: 'storageUid',
                        allowBlank: true,
                        listeners: {
                            'triggerclick': {
                                scope: this,
                                fn: this.storeValue
                            }
                        }
                    });
                    break;
                case 'uploadFolder':
                    formItems.push({
                        fieldLabel: TYPO3.l10n.localize('postprocessor_properties_uploadFolder'),
                        name: 'uploadFolder',
                        allowBlank: true,
                        listeners: {
                            'triggerclick': {
                                scope: this,
                                fn: this.storeValue
                            }
                        }
                    });
                    break;
            }
        }, this);

        formItems.push({
            xtype: 'button',
            text: TYPO3.l10n.localize('button_remove'),
            handler: this.removePostProcessor,
            scope: this
        });

        var config = {
            items: [
                {
                    xtype: 'fieldset',
                    title: TYPO3.l10n.localize('postprocessor_' + this.processor),
                    autoHeight: true,
                    defaults: {
                        width: 128,
                        msgTarget: 'side'
                    },
                    defaultType: 'textfieldsubmit',
                    items: formItems
                }
            ]
        };

        // apply config
        Ext.apply(this, Ext.apply(this.initialConfig, config));

        // call parent
        TYPO3.Form.Wizard.Viewport.Left.Form.PostProcessors.PostProcessor.superclass.initComponent.apply(this, arguments);

        // Initialize clientvalidation event
        this.on('clientvalidation', this.validation, this);

        // Strange, but we need to call doLayout() after render
        this.on('afterrender', this.newOrExistingPostProcessor, this);
    },

    /**
     * Constructor
     *
     * Add the configuration object to this component
     * @param config
     */
    constructor: function(config) {
        Ext.apply(this, {
            configuration: {
                pid: '',
                defaultName: '',
                uploadFolder: 'user_upload',
                storageUid: '1'
            }
        });
        TYPO3.Form.Wizard.Viewport.Left.Form.PostProcessors.SaveForm.superclass.constructor.apply(this, arguments);
    }
});

Ext.reg('typo3-form-wizard-viewport-left-form-postprocessors-saveForm', TYPO3.Form.Wizard.Viewport.Left.Form.PostProcessors.SaveForm);
