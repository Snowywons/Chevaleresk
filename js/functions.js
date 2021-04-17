//Les fonctions générales
function redirect(url) {
    document.location.href = url;
}

function GetPageName() {
    let name = window.location.href.split(".php")[0].split('/');
    name = name[name.length - 1];
    return name;
}

function GetUrlParamVal(paramName) {
    let output = "";
    let url = window.location.href.split("?");
    if (url.length > 1) {
        url = url[1];
        let params = url.split("&");
        for (let i = 0; i < params.length; i++) {
            let val = params[i].split("=");
            if ((paramName) === val[0]) {
                output = val[1];
                break;
            }
        }
    }
    return output;
}

function GetSplitedId(id, delimiter) {
    return id === "" ? "" : id.split(delimiter)[0];
}

function GetSiblingContainerId(id, siblingClassName) {
    return GetSplitedId(id, '_') + "_" + siblingClassName;
}


function RemoveOldContainers(className) {
    let oldContainers = document.querySelectorAll("." + className);
    for (let i = 0; i < oldContainers.length; i++)
        oldContainers[i].remove();
}

function InsertHtmlTo(html, elementId) {
    let ref = document.getElementById(elementId);
    if (ref) ref.insertAdjacentHTML('beforeend', html);
}

function AddClickEventFor(className, action) {
    let elements = document.querySelectorAll("." + className);
    elements.forEach((item) => {
        if (item.getAttribute('listener') !== 'true') {
            item.addEventListener("click", (e) => {
                e.preventDefault();
                action(item, e);
            });
            item.setAttribute('listener', 'true');
        }
    });
}

//Nécessite popups.js
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