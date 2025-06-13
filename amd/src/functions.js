define(['jquery', 'core/ajax'], function($, Ajax) {
    /**
     * Handle AJAX error by logging the error details.
     *
     * @param {XMLHttpRequest} xhr - The XMLHttpRequest object.
     * @param {string} status - The status of the AJAX request.
     * @param {Error} error - The error object.
     */
    function handleAjaxError(xhr, status, error) {
        console.error(xhr, status, error);
    }

    /**
     * Removes accents from a string by normalizing it and replacing accents with their base characters.
     *
     * @param {string} str - The input string containing accented characters.
     * @returns {string} The input string with accents removed.
     */
    function removeAccents(str) {
        return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
    }

    /**
     * Initializes the collapsible sections and sets up the expand/collapse functionality.
     */
    function initCollapsibles() {
        Ajax.call([{
            methodname: 'local_training_architecture_get_lang_strings',
            args: {},
            done: function(response) {
                $(".trainingarchitecture-collapsible span").on("click", function() {
                    $(this).toggleClass("active");
                    var content = $(this).parent().find('.table-container-training-architecture');

                    if (content.is(":visible")) {
                        content.hide();
                        $(this).text(response.expand);
                    } else {
                        content.show();
                        $(this).text(response.collapse);
                    }
                });
            },
            fail: handleAjaxError
        }]);
    }

    /**
     * Initializes the search functionality to filter table elements based on user input.
     */
    function initSearch() {
        $(document).on('keyup', '.trainingarchitecture-search-input', function() {
            var filter = removeAccents($(this).val().toLowerCase());
            var tableId = $(this).data('table-id');
            var $rows = $('#' + tableId).find('tr:not(:first)'); // Exclut l'en-tête
            
            $rows.each(function() {
                var text = removeAccents($(this).text().toLowerCase());
                $(this).toggle(text.includes(filter));
            });
        });
    }

    /**
     * Initializes all the necessary functionalities when the DOM is ready.
     */
    return {
        init: function() {
            $(document).ready(function() {
                initCollapsibles();
                initSearch();
            });
        }
    };
});