define(['jquery', 'core/ajax'], function($, Ajax) {
    var sort = {
        init: function() {
            // Active element
            document.querySelectorAll('#lu1-table tbody tr').forEach((el) => {
                if (el.classList.contains('active-lu')) {
                    el.setAttribute('data-selected', '1');
                }
            });

            // Select all arrow buttons
            var arrowButtons1 = document.querySelectorAll('.arrow-button-1');
            var arrowButtons2 = document.querySelectorAll('.arrow-button-2');

            // Add event listener to each arrow button
            arrowButtons1.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    sort.handleArrowClick(button, 'level1');
                });
            });

            arrowButtons2.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    sort.handleArrowClick(button, 'level2');
                });
            });
        },

        handleArrowClick: function(button, level) {
            var luId = button.dataset.luid;
            var trainingId = button.dataset.trainingid;
            var granularityLevel = button.dataset.granularitylevel;
            var direction = button.classList.contains('up') ? 'up' : 'down';
            var row = button.closest('tr');
            var previousRow = row.previousElementSibling;
            var nextRow = row.nextElementSibling;
            var previousLuId = previousRow ? previousRow.querySelector(`.arrow-button-${level === 'level1' ? '1' : '2'}`).dataset.luid : null;
            var nextLuId = nextRow ? nextRow.querySelector(`.arrow-button-${level === 'level1' ? '1' : '2'}`).dataset.luid : null;
            
            sort.updateOrder(luId, direction, previousLuId, nextLuId, trainingId, granularityLevel, level);
        },

        updateOrder: function(luId, direction, previousLuId, nextLuId, trainingId, granularityLevel, level) {
            var luToMove = direction === 'up' ? previousLuId : nextLuId;
            if (luToMove) {
                Ajax.call([{ 
                    methodname: 'local_training_architecture_sort', 
                    args: { luId: luId, luToMove: luToMove, trainingId: trainingId, granularityLevel: granularityLevel, level: level }
                }])[0].done(function() {
                    sort.swapRows('lu-row-' + luId, 'lu-row-' + luToMove, direction);
                }).fail(function(error) {
                    console.error('AJAX Error:', error);
                });
            }
        },

        swapRows: function(classname1, classname2, direction) {
            var rows1 = document.querySelectorAll('[class*="' + classname1 + '"]');
            var rows2 = document.querySelectorAll('[class*="' + classname2 + '"]');
            
            if (rows1.length > 0 && rows2.length > 0) {
                var parent = rows1[0].parentNode;
                var row1 = rows1[0];
                var row2 = rows2[0];
    
                if (direction === 'up') {
                    parent.insertBefore(row2, row1.nextSibling);
                } else {
                    parent.insertBefore(row1, row2.nextSibling);
                }
            }
        }
    };

    return sort;
});
