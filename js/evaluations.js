//Bouton Voir les évaluation pour un item sélectionné (Popup)
AddClickEventFor("showEvaluations",
    (item) => window.location.href = "../evaluations/evaluations.php?idItem=" + item.id.split('_')[0]);

//Bouton Voir la liste des items évalués
AddClickEventFor("evaluationsListButtonContainer",
    () => window.location.href = "../evaluations/evaluations.php");

let idClickedInputBeforeChange = 0;

//Permet de changer l'état de la barre d'étoile selon la position de la souris
function ChangeStarIcon(item, saveChange = false) {
    let starLabels = document.querySelectorAll("DIV.rating > LABEL");
    starLabels.forEach((item) => item.classList.remove("clicked"));

    let number = item.id.split('_')[0];
    if (saveChange) idClickedInputBeforeChange = number;
    for (let i = 1; i <= number; i++) {
        starLabels[i - 1].classList.add("clicked");
    }
}

//Permet de réinitialiser l'état de la barre d'étoile lorsque la souris n'y est plus
function ResetStarIconOnMouseOut() {
    let starLabels = document.querySelectorAll("DIV.rating > LABEL");
    starLabels.forEach((item) => item.classList.remove("clicked"));

    for (let i = 1; i <= idClickedInputBeforeChange; i++)
        starLabels[i - 1].classList.add("clicked");
}

//Permet de mettre à jour tous les événements (click, mouseenter, mouseout) liés aux barres d'étoiles
function UpdateAllStarbar() {
    idClickedInputBeforeChange = 0;

    let ratingInputs = document.querySelectorAll("DIV.rating > INPUT");
    ratingInputs.forEach((item) => {
        item.addEventListener('change', () => ChangeStarIcon(item, true));
    });

    let ratingLabels = document.querySelectorAll("DIV.rating > LABEL");
    ratingLabels.forEach((item) => {
        item.addEventListener('mouseenter', () => ChangeStarIcon(item));
        item.addEventListener('mouseout', () => ResetStarIconOnMouseOut());
    });
}

//Permet de mettre à jour le contenu des commentaires
function UpdateEvaluationContent(idItem) {
    let request = "submit=updateEvaluationContent" + "&idItem=" + idItem;
    ServerRequest("POST", "../server/httpRequestHandler.php", request,
        (requete) => {
            RemoveOldContainers("evaluationContainer");
            InsertHtmlTo(JSON.parse(requete.responseText), "evaluationsReference");

            UpdateAllStarbar();
            UpdateAllEvaluationSendButton();
        }, () => {
        }, false);
}

//Permet de mettre à jour l'événement (click) liés aux boutons d'envoi d'une évaluation
function UpdateAllEvaluationSendButton() {
    AddClickEventFor("evaluationSendButton", (item) => {
        let idItem = GetSplitedId(item.id, '_');
        let stars = idClickedInputBeforeChange;
        let comment= document.getElementById("commentArea").value;
        let request = "submit=sendEvaluation" + "&idItem=" + idItem + "&stars=" + stars + "&comment=" + comment;
        if (idItem !== "" && stars !== 0 && comment !== "") {
        ServerRequest("POST", "../server/httpRequestHandler.php", request,
            (requete) => {
                CloseAllPopups();
                CloseNotifier();
                NotifyWithPopup(requete.responseText);
                UpdateAllPopupExitButtons();
                UpdateEvaluationContent(idItem);
            }, () => {
            });
        } else {
            NotifyWithPopup("Impossible d'ajouter le commentaire.<br>Des informations sont manquantes.");
        }
    });
}

UpdateAllStarbar();
UpdateAllEvaluationSendButton();