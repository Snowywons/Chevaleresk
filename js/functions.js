//Les fonctions générales

function redirect(url) {
    document.location.href = url;
}

function GetPageName() {
    let name = window.location.href.split(".php")[0].split('/');
    name = name[name.length - 1];
    return name;
}

function GetSiblingContainerId(fromId, siblingGroupName) {
    let array = fromId.split('_');
    let containerId = array.length > 0 ? array[0] : "";
    return containerId + "_" + siblingGroupName;
}

function GetParentNode(node, n = 1, classList = "") {
    let parent = node.parentElement;
    while (n-- && parent && !parent.classList.contains(classList)) {
        parent = parent.parentElement;
    }
    return parent;
}

function ServerRequest(method, url, request, onSuccess, onFailure, NWPP = true) {

    if (NWPP)
        NotifyWithPopup("Traitement de la demande...");

    let requete = new XMLHttpRequest();
    requete.open(method, url, true);
    requete.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    requete.send(request);

    requete.onreadystatechange = function () {
        if (requete.readyState === 4) {
            if (requete.status === 200) {
                onSuccess(requete);
            } else {
                onFailure(requete);
            }
        }
    }
}