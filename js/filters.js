//Récupération des différents conteneurs
let filters = document.getElementById("filters");
let inputs = document.querySelectorAll("#filters input[type='checkbox']");

//Permet d'ouvrir et de fermer le conteneur des inputs (filters)
let filterContainer = document.getElementById("filterContainer");
if (filterContainer !== null) {
    filterContainer.addEventListener("click", () => {
        if (filters.classList.contains("hidden")) {
            filterContainer.classList.add("opened");
            filters.classList.remove("hidden");
        } else {
            filterContainer.classList.remove("opened");
            filters.classList.add("hidden");
        }
    });
}

//Permet de réinitialiser la sélection des filtres et de mettre à jour le contenu du store
let resetFilterContainer = document.getElementById("resetFilterContainer");
if (resetFilterContainer !== null) {
    resetFilterContainer.addEventListener("click", () => {
        inputs.forEach((item) => item.checked = true);

        if (!filterContainer.classList.contains("hidden")) {
            filterContainer.classList.remove("opened");
            filters.classList.add("hidden");
        }

        let targetAlias = GetUrlParamVal("alias");
        UpdateStoreContentOnFilter(GetFiltersString(), targetAlias, GetPageName());
    });
}

//Permet de mettre à jour le contenu du store lorsqu'un filtre est sélectionné
inputs.forEach((item) =>
    item.addEventListener("change", () => {
        let targetAlias = GetUrlParamVal("alias");
        UpdateStoreContentOnFilter(GetFiltersString(), targetAlias, GetPageName())
    }));

//Permet d'obtenir une chaine de caractères composée des filtres sélectionnés
function GetFiltersString() {
    let str = "";
    let filters = document.querySelectorAll(".filters input[type='checkbox']");
    for (let i = 0; i < filters.length; i++) {
        str += filters[i].checked ? "'" + filters[i].id + "'" : null;
        if (i < filters.length - 1) str += ",";
    }
    return str;
}