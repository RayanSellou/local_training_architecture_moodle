// /**
//  * Handle AJAX error by logging the error details.
//  *
//  * @param {XMLHttpRequest} xhr - The XMLHttpRequest object.
//  * @param {string} status - The status of the AJAX request.
//  * @param {Error} error - The error object.
//  */
// function handleAjaxError(xhr, status, error) {
//     console.error(xhr, status, error);
// }

// /**
//  * Removes accents from a string by normalizing it and replacing accents with their base characters.
//  *
//  * @param {string} str - The input string containing accented characters.
//  * @returns {string} The input string with accents removed.
//  */
// function removeAccents(str) {
//     return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
// }

// // Handle show/hide on tables
// document.addEventListener("DOMContentLoaded", function() {

//     // AJAX request to get lang string
//     $.ajax({
//         url:'ajax/lang.php',
//         type: 'POST',
//         data: {},
//         success: function(response) {
            
//             var headers = document.querySelectorAll(".trainingarchitecture-collapsible span");
//             headers.forEach(function(header) {
//                 header.addEventListener("click", function() {
//                     this.classList.toggle("active");
//                     var content = this.parentElement.querySelector('.table-container-training-architecture');

//                     if (content.style.display === "block") {
//                         content.style.display = "none";
//                         this.textContent = response.expand;
//                     } else {
//                         content.style.display = "block";
//                         this.textContent = response.collapse;
//                     }
//                 });
//             });

//         },

//         error: handleAjaxError

//     });
// });

// // Handle search
// document.addEventListener('DOMContentLoaded', function() {

//     var searchInputs = document.querySelectorAll('.trainingarchitecture-search-input');
//     searchInputs.forEach(function(searchInput) {
//         searchInput.addEventListener('keyup', function() {
//             var filter = removeAccents(searchInput.value);
//             var tableId = searchInput.dataset.tableId;
//             var rows = document.querySelectorAll('#' + tableId + ' table tbody tr');

//             rows.forEach(function(row) {
//                 var cells = row.querySelectorAll('td');
//                 var textContent = '';

//                 cells.forEach(function(cell) {
//                     textContent += removeAccents(cell.textContent) + ' ';
//                 });

//                 if (textContent.indexOf(filter) > -1) {
//                     row.style.display = '';
//                 } else {
//                     row.style.display = 'none';
//                 }
//             });
//         });
//     });
// });
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
     * Removes accents from a string.
     *
     * @param {string} str - The input string.
     * @returns {string} The string without accents.
     */
    function removeAccents(str) {
        return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
    }

    /**
     * Load language strings and initialize collapsible sections.
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
     * Initializes the search functionality.
     */
    function initSearch() {
        $(".trainingarchitecture-search-input").on("keyup", function() {
            var filter = removeAccents($(this).val());
            console.log("Filtre : ", filter);


            var tableId = $(this).data("table-id");
            var rows = $("#" + tableId + " table tbody tr");

            rows.each(function() {
                var textContent = "";
                $(this).find("td").each(function() {
                    var cellText = removeAccents($(this).text().toLowerCase());
                    console.log("Texte de la cellule : ", cellText); 
                    textContent += cellText + " ";
                });
                console.log("Texte de la ligne complète : ", textContent);
                // $(this).toggle(textContent.includes(filter));

                if (textContent.includes(filter)) {
                    console.log("Ligne visible : ", textContent);  // Affiche les lignes qui correspondent
                    $(this).show();
                } else {
                    console.log("Ligne masquée : ", textContent);  // Affiche les lignes masquées
                    $(this).hide();
                }

            });
        });
    }

    return {
        init: function() {
            $(document).ready(function() {
                initCollapsibles();
                initSearch();
            });
        }
    };
});


