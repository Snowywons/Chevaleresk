function highlightCurrentNav() {
    //Découpe la chaine URL pour obtenir le nom de la page
    let url = document.location.href;
    let pos = url.search(".php");
    let table = url.slice(0, pos).split("/");
    let id = table[table.length - 1];

    let navs = document.querySelectorAll(".mark");
    for (let i = 0; i < navs.length; i++)
        navs[i].classList.remove("mark");

    let elem = document.getElementById(id);
    if (elem) {
        while (elem.nodeName !== "NAV")
            elem = elem.parentElement;
        elem.classList.add("mark");
    }
}

highlightCurrentNav();