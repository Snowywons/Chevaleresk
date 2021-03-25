let filterContainers = document.querySelectorAll(".filterContainer");
filterContainers.forEach((item) => {
    item.addEventListener("click", () => {
        let filters = document.querySelectorAll(".filters")[0];

        if (filters.classList.contains("hidden")) {
            item.classList.add("opened");
            filters.classList.remove("hidden");
        } else {
            item.classList.remove("opened");
            filters.classList.add("hidden");
        }
    })
});

let resetFilterContainers = document.querySelectorAll(".resetFilterContainer");
resetFilterContainers.forEach((item) => {
    item.addEventListener("click", () => {
        let filterContainer = document.querySelectorAll(".filterContainer")[0];
        let filters = document.querySelectorAll(".filters")[0];
        let inputs = document.querySelectorAll(".filters > input[type='checkbox']");

        inputs.forEach((item) => {
            item.checked = true;
        });

        if (!filterContainer.classList.contains("hidden")) {
            filterContainer.classList.remove("opened");
            filters.classList.add("hidden");
        }

        UpdateStoreContentOnFilter(GetPageName(), GetFiltersString());
    })
});

let filters = document.querySelectorAll(".filters > input[type='checkbox']");
filters.forEach((item) => {
    item.addEventListener("change", () => {
        UpdateStoreContentOnFilter(GetPageName(), GetFiltersString());
    })
});

function GetPostURL()
{
    let postURL = window.location.href.split(".php")[0].split('/');
    postURL = postURL[postURL.length - 1];
    postURL = "../store/" + postURL + "Update.php";
    return postURL;
}

function GetPageName()
{
    let name = window.location.href.split(".php")[0].split('/');
    name = name[name.length - 1];
    return name;
}

function GetFiltersString()
{
    let str = "";
    let filters = document.querySelectorAll(".filters > input[type='checkbox']");
    for (let i = 0; i < filters.length; i++) {
        str += "'";
        if (filters[i].checked)
            str += filters[i].id;
        str += "'";
        if (i < filters.length - 1)
            str += ",";
    }
    return str;
}

function UpdateStoreContentOnFilter(sender, filtersStr)
{
    let requete = new XMLHttpRequest();
    //OUVERTURE de la requête AJAX de type POST
    requete.open('POST', "../store/storeUpdate", true);
    //Construction du header
    requete.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //ENVOIS de la requête
    requete.send("submit=setFilters" + "&sender=" + sender + "&filters=" + filtersStr);

    //Selon l'état de la requête
    requete.onreadystatechange = function () {
        switch (requete.readyState) {
            // 0 requête non initialisée
            // 1 connexion au serveur établie
            // 2 requête reçue
            // 3 requête en cours de traitement
            case 4: // 4 requête terminée et réponse reçue
                if (requete.responseText.trim() !== '')
                {
                    let records = JSON.parse(requete.responseText);

                    RemoveStoreContainer();
                    SetStoreContainer(records);
                }
                break;
        }
    };
}