// const luCourseField = document.getElementById('fitem_id_luToLuCourseId');
// let lus = localStorage.getItem('numberOfLus');
// let luCourse = localStorage.getItem('luCourse');

// // Hide fields
// luCourseField.style.display = 'none';
// let number_lus = 0;

// if(lus) {
//     number_lus = lus;
// }

// if (luCourse === 'true') {
//     luCourseField.style.display = '';
// }

// let iterator = (parseInt(number_lus) + 1);

// for (let i = iterator; i <= 2 ; i++) {
//     document.getElementById('fitem_id_luToLuId' + i).style.display = 'none';
// }

// document.getElementById('id_luToLuTrainingId').addEventListener('change', function() {
//     let trainingId = this.value;

//     // Hide
//     for (let i = 1; i <= 2 ; i++) {
//         document.getElementById('fitem_id_luToLuId' + i).style.display = 'none';
//     }
//     luCourseField.style.display = 'none';

//     // Get number of levels (fields)
//     $.ajax({
//         url:'ajax/training_level.php',
//         type: 'POST',
//         data: { trainingId: trainingId },
//         success: function(response) {
//             localStorage.setItem('numberOfLus', response);
//             localStorage.setItem('luCourse', 'true');

//             for (let i = 1; i <= response ; i++) {
//                 document.getElementById('fitem_id_luToLuId' + i).style.display = '';
//             }

//             luCourseField.style.display = '';
//         },

//         error: handleAjaxError

//       });

// });

// Déclarer le module AMD
define(['jquery', 'core/ajax'], function($, Ajax) {

    function init() {
        const luCourseField = document.querySelector('#fitem_id_luToLuCourseId');
        let number_lus = localStorage.getItem('numberOfLus') || 0;
        let luCourse = localStorage.getItem('luCourse');

        // Cacher le champ
        if (luCourse !== 'true') {
            luCourseField.style.display = 'none';
        }

        let iterator = parseInt(number_lus) + 1;

        for (let i = iterator; i <= 2; i++) {
            document.querySelector('#fitem_id_luToLuId' + i).style.display = 'none';
        }

        document.querySelector('#id_luToLuTrainingId').addEventListener('change', function() {
            let trainingId = this.value;

            // Cacher les champs
            for (let i = 1; i <= 2; i++) {
                document.querySelector('#fitem_id_luToLuId' + i).style.display = 'none';
            }
            luCourseField.style.display = 'none';

            // Requête AJAX avec Moodle
            Ajax.call([{
                methodname: 'local_training_architecture_get_training_level',
                args: { trainingId: trainingId }
            }])[0].done(function(response) {
                localStorage.setItem('numberOfLus', response);
                localStorage.setItem('luCourse', 'true');

                for (let i = 1; i <= response; i++) {
                    document.querySelector('#fitem_id_luToLuId' + i).style.display = '';
                }

                luCourseField.style.display = '';
            }).fail(function(error) {
                console.error('Erreur AJAX:', error);
            });

        });
    }

    return {
        init: init
    };

});
