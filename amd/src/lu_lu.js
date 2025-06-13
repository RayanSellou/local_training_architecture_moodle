define(['jquery', 'core/ajax'], function($, Ajax) {

    function init() {
        const luCourseField = document.querySelector('#fitem_id_luToLuCourseId');
        let number_lus = localStorage.getItem('numberOfLus') || 0;
        let luCourse = localStorage.getItem('luCourse');

        if (luCourse !== 'true') {
            luCourseField.style.display = 'none';
        }

        let iterator = parseInt(number_lus) + 1;

        for (let i = iterator; i <= 2; i++) {
            document.querySelector('#fitem_id_luToLuId' + i).style.display = 'none';
        }

        document.querySelector('#id_luToLuTrainingId').addEventListener('change', function() {
            let trainingId = this.value;

            for (let i = 1; i <= 2; i++) {
                document.querySelector('#fitem_id_luToLuId' + i).style.display = 'none';
            }
            luCourseField.style.display = 'none';

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
