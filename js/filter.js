let filterContainers = document.querySelectorAll(".filterContainer");
filterContainers.forEach((item) => {
    item.addEventListener("click", () => {
        let filters = item.nextElementSibling;

        if (filters.classList.contains("hidden")) {
            item.classList.add("opened");
            filters.classList.remove("hidden");
        } else {
            item.classList.remove("opened");
            filters.classList.add("hidden");
        }
    })
});