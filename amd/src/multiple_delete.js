define(['jquery', 'core/ajax', 'core/notification'], function($, Ajax, Notification) {
    
  function init() {
      const buttonLinks = document.getElementById('delete-selected-training-links');
      const buttonLu = document.getElementById('delete-selected-lu-to-lu');
      const buttonCourses = document.getElementById('delete-selected-courses-not-in-architecture');

      const allCheckboxesLinks = document.querySelectorAll('input[name="checkbox-training-links"]');
      const allCheckboxesLu = document.querySelectorAll('input[name="checkbox-lu-to-lu"]');
      const allCheckboxesCourses = document.querySelectorAll('input[name="checkbox-courses-not-in-architecture"]');

      function disableButton(button, checkboxes) {
          button.disabled = !Array.from(checkboxes).some(checkbox => checkbox.checked);
      }

      disableButton(buttonLinks, allCheckboxesLinks);
      disableButton(buttonLu, allCheckboxesLu);
      disableButton(buttonCourses, allCheckboxesCourses);

      function setupCheckboxHandler(allCheckboxes, button) {
          allCheckboxes.forEach(function(checkbox) {
              checkbox.addEventListener('change', function() {
                  disableButton(button, allCheckboxes);
                  checkbox.closest('tr').classList.toggle('trainingarchitecture-tr-selected-lu', checkbox.checked);
              });
          });
      }

      setupCheckboxHandler(allCheckboxesLinks, buttonLinks);
      setupCheckboxHandler(allCheckboxesLu, buttonLu);
      setupCheckboxHandler(allCheckboxesCourses, buttonCourses);

      function deleteSelected(button, checkboxes, methodName) {
        button.addEventListener("click", function(e) {
            e.preventDefault(); // Empêche le rechargement
            
            let selectedIds = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);
    
            if (selectedIds.length === 0) {
                Notification.alert("Aucun élément sélectionné");
                return;
            }
    
            console.log("Envoi des IDs :", selectedIds); // Debug
    
            Ajax.call([{
                methodname: methodName,
                args: { selectedIds: selectedIds },
                fail: function(error) {
                    console.error("Erreur AJAX :", error);
                    Notification.exception(error);
                }
            }])[0].done(function(response) {
                if (!response || !response.redirectUrl) {
                    throw new Error("Réponse invalide");
                }
                window.location.href = response.redirectUrl;
            });
        });
    }
    

      deleteSelected(buttonLinks, allCheckboxesLinks, 'local_training_architecture_multiple_delete_training_links');
      deleteSelected(buttonLu, allCheckboxesLu, 'local_training_architecture_multiple_delete_lu_to_lu');
      deleteSelected(buttonCourses, allCheckboxesCourses, 'local_training_architecture_delete_courses_not_in_architecture');
  }

  return {
      init: init
  };
});
