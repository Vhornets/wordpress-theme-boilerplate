var App = {
    _settings: {},
    
    init: function() {
        this.initCarousels();
        this.validateForms();
    },

    initCarousels: function() {
        var self = this;

        $('[data-carousel]').each(function() {
            var $self = $(this);
            var opts = $self.data('carousel');

            $self.owlCarousel(self._settings[opts]);
        });
    },

    validateForms: function() {
        $('form').each(function() {
            $(this).validate({
                ignore: "",

                submitHandler: function(form) {
                    $(form).trigger('form.valid');
                }
            });
        });
    },
};