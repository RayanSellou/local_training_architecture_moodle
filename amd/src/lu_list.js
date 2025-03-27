/**
 * Récupère la liste des LU associées à une formation via un appel AJAX
 */
function getLUList(trainingId) {
    const token = "TON_TOKEN_ICI";  
    return fetch(`${M.cfg.wwwroot}/webservice/rest/server.php?wstoken=${token}&wsfunction=local_training_architecture_get_lu_list&moodlewsrestformat=json`, {
        method: 'POST',
        body: JSON.stringify({ trainingId }),
        headers: { "Content-Type": "application/json" }
    })
    .then(response => response.json())
    .catch(error => console.error("Erreur lors de la récupération des LU :", error));
}

export default getLUList;
