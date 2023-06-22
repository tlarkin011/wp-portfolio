/*
 |----------------------------------------------------------------
 |  Document Ready Scripts
 |----------------------------------------------------------------
 */
jQuery(function($) {
    /*
     |----------------------------------------------------------------
     |  Auto checked all parent on taxonomy checkbox
     |----------------------------------------------------------------
     */
    $(".categorychecklist .selectit input").change(function() {
        var self = $(this);

        if (self.is(':checked')) {
            var parent = self.parents('.children').eq(0).prev('.selectit');

            if (parent.size()) {
                $('input', parent).prop('checked',true).change();
            }
        }
    });
});

/*
 |----------------------------------------------------------------
 |  Default the gravityform field size to "Large"
 |  and enable auto-complete on class field
 |----------------------------------------------------------------
 */
var gform_css_ready_classes = [
    'gf_full', 'gf_half', 'gf_third', 'gf_quarter',
    'gf_list_inline'
];

if (jQuery.isFunction(jQuery.fn.autocomplete)) {
    jQuery(".gforms_edit_form #field_css_class").autocomplete({
        source: gform_css_ready_classes,
        select: function(e, ui) {
            SetFieldProperty('cssClass', ui.item.value);
        }
    });
}

jQuery(document).on('gform_field_added', function(e, form, field) {
    var $field = jQuery("#field_" + field.id);
    $field.addClass("field_selected");

    SetFieldSize('large');

    if (jQuery.isFunction(jQuery.fn.autocomplete)) {
        jQuery("#field_css_class", $field).autocomplete({
            source: gform_css_ready_classes,
            select: function(e, ui) {
                SetFieldProperty('cssClass', ui.item.value);
            }
        });
    }

    $field.removeClass("field_selected");
});
