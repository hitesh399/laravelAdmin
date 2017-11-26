(function ($) {
    "use strict";

    var MultipleEmail = function(options) {

        this.init("multiple_email", options, MultipleEmail.defaults);
    };

    $.fn.editableutils.inherit(MultipleEmail, $.fn.editabletypes.abstractinput);


     $.extend(MultipleEmail.prototype, {

        render: function() {
            this.$input = this.$tpl.find("input")
        },
        value2html: function(e, i) {
            if (!e) return void $(i).empty();
            $(i).html(e)
        },
        html2value: function(t) {
            return null
        },
        value2input: function(t) {
            this.$input.val(t), this.$input.tagsinput({
                trimValue: !0,
                maxChars: 100,
                maxTags: 50
            });
            var e = this;
            this.$input.on("beforeItemAdd", function(t) {
                e.validateEmail(t.item) || (t.cancel = !0)
            })
        },
        validateEmail: function(t) {
            return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(t)
        },
        value2str: function(t) {
            return t
        },
        str2value: function(t) {
            return t.replaceAll(",", ", ")
        },
        destroy: function() {
            "tagsinput" == this.$input.data("role") && this.$input.tagsinput("destroy")
        }
    });

    MultipleEmail.defaults = $.extend({}, $.fn.editabletypes.abstractinput.defaults, {
        tpl: '<div class="editable-multiple_email form-group"><label><input type="text" data-role="tagsinput" name="multiple_email" class="form-control input-small multiple_email"></label></div>',
        inputclass: ""
    });

    $.fn.editabletypes.multiple_email = MultipleEmail;

}(window.jQuery));