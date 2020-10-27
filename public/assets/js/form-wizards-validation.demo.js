

var handleBootstrapWizardsValidation = function() {
	"use strict";
	$("#wizard").bwizard({ 
        backBtnText: '&larr; Anterior',
        nextBtnText: 'Siguiente &rarr;',
        validating: function (e, ui) { 
	        if (ui.index == 0) {
	            // step-1 validation
                if (false === $('form[name="form-wizard"]').parsley().validate('wizard-step-1')) {
                    return false;
                }
	        } else if (ui.index == 1) {
	            // step-2 validation
                if (false === $('form[name="form-wizard"]').parsley().validate('wizard-step-2')) {
                    return false;
                }
	        } else if (ui.index == 2) {
	            // step-3 validation
                if (false === $('form[name="form-wizard"]').parsley().validate('wizard-step-3')) {
                    return false;
                }
	        } else if (ui.index == 3) {
	            // step-4 validation
                if (false === $('form[name="form-wizard"]').parsley().validate('wizard-step-4')) {
                    return false;
                }
	        }
	    } 
	});
};

var FormWizardValidation = function () {
	"use strict";
    return {
        //main function
        init: function () {
            handleBootstrapWizardsValidation();
        }
    };
}();