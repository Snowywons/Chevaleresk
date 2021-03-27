AddClickEventFor("saveChanges", (item) => {
    let alias = document.getElementById("alias");
    let lastName = document.getElementById("lastName");
    let firstName = document.getElementById("firstName");
    let balance = document.getElementById("balance");
    let password = document.getElementById("password");
    let passwordConfirm = document.getElementById("passwordConfirm");

    let request = "submit=modifyProfileInformations" + "&alias=" + alias.value;
    if (lastName.value !== "") {
        request += "&lastName=" + lastName.value;
    } else {
        NotifyWithPopup( "Le nom est invalide.");
        return;
    }

    if (firstName.value !== "") {
        request += "&firstName=" + firstName.value;
    } else {
        NotifyWithPopup("Le prénom est invalide.");
        return;
    }

    if (balance.value >= 0) {
        request += "&balance=" + balance.value;
    } else {
        NotifyWithPopup("Le solde est invalide.");
        return;
    }

    if (password.value === "" || password.value !== passwordConfirm.value) {
        NotifyWithPopup("Le mot de passe est invalide.");
        return;
    }

    if (password.value !== "default") request += "&password=" + password.value;

    ServerRequest("POST", "../server/httpRequestHandler.php", request, (requete) => {
        NotifyWithPopup(requete.responseText);
    }, () => {
    });
});

//Permet de mettre à jour le contenu du gestionnaire
function UpdateManagerContent() {
    ServerRequest("POST", "../server/httpRequestHandler.php", "submit=updateManagerContent",
        (requete) => {
            RemoveOldContainers("managerContainer");
            InsertHtmlTo(JSON.parse(requete.responseText), "managerReference");

            UpdateAllLookButtons();
            UpdateAllModifyButtons();
            UpdateAllDeleteButtons();
        }, () => {
        }, false);
}