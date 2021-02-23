function redirect(url)
{
    document.location.href = url;
}

function highlightCurrentNav()
{
    var url = document.location.href;
    var pos = url.search(".php");
    var table = url.slice(0, pos).split("/");
    var id = table[table.length - 1];

    var items = document.querySelectorAll(".mark");
    for (var i = 0; i < items.length; i++)
        items[i].classList.remove("mark");

    var item = document.getElementById(id);
    if (item)
    {
        while (item.nodeName !== "NAV")
            item = item.parentElement;
        item.classList.add("mark");
    }
}

highlightCurrentNav();