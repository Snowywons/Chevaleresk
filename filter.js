var filter = document.querySelectorAll(".filter");

filter.forEach((item)=> {
    item.addEventListener("click", ()=> {
        var filterSelect = item.nextElementSibling;

        if (filterSelect.classList.contains("hidden"))
        {
            item.classList.add("opened");
            filterSelect.classList.remove("hidden");
        }
        else
        {
            item.classList.remove("opened");
            filterSelect.classList.add("hidden");
        }
    })
});