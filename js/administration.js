//Demande de soumission du formulaire de modification des informations d'un joueur
function UpdateProfile() {
    event.preventDefault();
    if (validateModifyProfileForm()) {

        let alias = document.getElementById("alias").value;
        let firstName = document.getElementById("firstName").value;
        let lastName = document.getElementById("lastName").value;
        let password = document.getElementById("password").value;

        let request = "submit=modifyProfileInformations" +
            "&alias=" + alias +
            "&firstName=" + firstName +
            "&lastName=" + lastName;

        if (password !== "default") request += "&password=" + password;

        ServerRequest("POST", "../server/httpRequestHandler.php", request, (requete) => {
            NotifyWithPopup(requete.responseText);
        }, () => {
        });
    }
}

//Demande de mise à jour du contenu du gestionnaire
function UpdateManagerContent() {
    ServerRequest("POST", "../server/httpRequestHandler.php", "submit=updateManagerContent",
        (requete) => {
            RemoveOldContainers("managerContainer");
            InsertHtmlTo(JSON.parse(requete.responseText), "managerReference");
        }, () => {
        }, false);
}

//Demande de création d'un popup de modification de solde
function UpdatePlayerBalance(alias, balance) {
    let request = "submit=createUpdatePlayerBalancePopup" + "&alias=" + alias + "&balance=" + balance;
    ServerRequest("POST", "../server/httpRequestHandler.php", request,
        (requete) => {
            CloseAllPopups();
            CloseNotifier();
            InsertHtmlTo(JSON.parse(requete.responseText), "popupReference");
        }, () => {
        });
}

function UpdatePlayerBalanceConfirm(alias) {
    let balance = document.getElementById(alias + "_playerBalance").value;
    if (balance >= 0) {
        let request = "submit=updatePlayerBalanceConfirm" + "&alias=" + alias + "&balance=" + balance;
        ServerRequest("POST", "../server/httpRequestHandler.php", request,
            (requete) => {
                NotifyWithPopup(requete.responseText);
                UpdateManagerContent();
            },
            () => {
            });
    } else {
        NotifyWithPopup("Quantité invalide");
    }
}

//Demande de création d'un popup de suppression de joueur
function DeletePlayer(alias) {
    let request = "submit=createDeletePlayerPopup" + "&alias=" + alias;
    ServerRequest("POST", "../server/httpRequestHandler.php", request,
        (requete) => {
            CloseAllPopups();
            CloseNotifier();
            InsertHtmlTo(JSON.parse(requete.responseText), "popupReference");
        }, () => {
        });
}

function DeletePlayerConfirm(alias) {
    let request = "submit=deletePlayerConfirm" + "&alias=" + alias;
    ServerRequest("POST", "../server/httpRequestHandler.php", request,
        (requete) => {
            NotifyWithPopup(requete.responseText);
            UpdateManagerContent();
        },
        () => {
        });
}