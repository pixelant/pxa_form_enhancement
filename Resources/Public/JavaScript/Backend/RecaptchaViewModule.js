/**
 * Module: TYPO3/CMS/PxaFormEnhancement/Backend/RecaptchaViewModule
 */
define(['jquery',
    'TYPO3/CMS/Form/Backend/FormEditor/ViewModel'
], function ($, ViewModel) {
    'use strict';

    return (function ($, ViewModel) {

        /**
         * private
         *
         * @var object
         */
        var _formEditorApp;

        var _stageComponents;

        function _subscribeEvents() {

            /**
             * subscribe render template
             */
            getPublisherSubscriber().subscribe('view/stage/abstract/render/template/perform', function (topic, args) {
                var formElement = args[0],
                    template = args[1];

                _assert('function' === $.type(formElement.get), 'Something wrong with template in Reptcha view module', 1491468412);

                var type = formElement.get('type');

                if (type === 'Recaptcha') {
                    getStageComponents().renderSimpleTemplateWithValidators(formElement, template);
                }
            });
        }

        /**
         * @private
         *
         * @param test
         * @param message
         * @param messageCode
         * @return void
         */
        function _assert(test, message, messageCode) {
            return getFormEditorApp().assert(test, message, messageCode);
        }

        /**
         * @private
         *
         * @return object
         */
        function getPublisherSubscriber() {
            return getFormEditorApp().getPublisherSubscriber();
        }


        /**
         * Get Form Editor App
         *
         * @return {Object}
         * @private
         */
        function getFormEditorApp() {
            return _formEditorApp;
        }

        /**
         * @return {Object}
         */
        function getStageComponents() {
            return _stageComponents;
        }

        /**
         * init
         *
         * @param {Object} formEditorApp
         */
        function bootstrap(formEditorApp) {
            _formEditorApp = formEditorApp;
            _stageComponents = ViewModel.getStage();
            _subscribeEvents();
        }

        /**
         * Return public methods
         *
         * @return {Object}
         */
        return {
            bootstrap: bootstrap
        }

    })($, ViewModel);
});