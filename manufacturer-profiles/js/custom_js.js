var formSubmitting = false;
var setFormSubmitting = function() { formSubmitting = true; };

    window.onload = function() {
        window.addEventListener("beforeunload", function (e) {
            if (formSubmitting) {
                return undefined;
            }
            (e || window.event).returnValue = 'message'; 
            return true; 
        });
    };


