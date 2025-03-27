import getLUList from './lu_list';

const luCourseField = document.getElementById('fitem_id_luToLuCourseId');
let lus = localStorage.getItem('numberOfLus');
let luCourse = localStorage.getItem('luCourse');

// Hide fields
luCourseField.style.display = 'none';
let number_lus = 0;

if(lus) {
    number_lus = lus;
}

if (luCourse === 'true') {
    luCourseField.style.display = '';
}

let iterator = (parseInt(number_lus) + 1);

for (let i = iterator; i <= 2 ; i++) {
    document.getElementById('fitem_id_luToLuId' + i).style.display = 'none';
}

document.getElementById('id_luToLuTrainingId').addEventListener('change', function() {
    let trainingId = this.value;

    // Hide
    for (let i = 1; i <= 2 ; i++) {
        document.getElementById('fitem_id_luToLuId' + i).style.display = 'none';
    }
    luCourseField.style.display = 'none';

    getLUList(trainingId).then(luList => {
        localStorage.setItem('numberOfLus', luList.length);
        localStorage.setItem('luCourse', 'true');

        for (let i = 0; i < luList.length; i++) {
            let luField = document.getElementById('fitem_id_luToLuId' + (i + 1));
            if (luField) {
                luField.style.display = '';
            }
        }

        luCourseField.style.display = '';
    });

});