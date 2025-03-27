define(['core/ajax'], function(Ajax) {

    function handleAjaxError(error) {
        console.error(error);
    }

    function removeAccents(str) {
        return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
    }

    function initCollapsibleHeaders() {
        // Faire un appel AJAX via Moodle pour récupérer les strings de langue
        Ajax.call([{
            methodname: 'local_training_architecture_get_lang_strings',
            args: {},
            done: function(response) {
                var headers = document.querySelectorAll(".trainingarchitecture-collapsible span");
                headers.forEach(function(header) {
                    header.addEventListener("click", function() {
                        this.classList.toggle("active");
                        var content = this.parentElement.querySelector('.table-container-training-architecture');

                        if (content.style.display === "block") {
                            content.style.display = "none";
                            this.textContent = response.expand;
                        } else {
                            content.style.display = "block";
                            this.textContent = response.collapse;
                        }
                    });
                });
            },
            fail: handleAjaxError
        }]);
    }

    function initSearch() {
        var searchInputs = document.querySelectorAll('.trainingarchitecture-search-input');
        searchInputs.forEach(function(searchInput) {
            searchInput.addEventListener('keyup', function() {
                var filter = removeAccents(searchInput.value);
                var tableId = searchInput.dataset.tableId;
                var rows = document.querySelectorAll('#' + tableId + ' table tbody tr');

                rows.forEach(function(row) {
                    var cells = row.querySelectorAll('td');
                    var textContent = '';

                    cells.forEach(function(cell) {
                        textContent += removeAccents(cell.textContent) + ' ';
                    });

                    if (textContent.indexOf(filter) > -1) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    }

    return {
        init: function() {
            initCollapsibleHeaders();
            initSearch();
        }
    };
});
