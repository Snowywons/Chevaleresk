const showEvaluationsButtons = document.querySelectorAll(".showEvaluations");
const evaluationsListButtons = document.querySelectorAll(".evaluationsListButton");
const itemEvaluationPreviewContainers = document.querySelectorAll(".itemEvaluationPreviewContainer");

showEvaluationsButtons.forEach((item)=> {
    item.addEventListener("click", ()=> {
        document.location.href = "../evaluations/evaluations.php?idItem=" + item.id.split('_')[0];
    })
});

evaluationsListButtons.forEach((item)=> {
    item.addEventListener("click", ()=> {
        document.location.href = "evaluations.php";
    })
});

itemEvaluationPreviewContainers.forEach((item)=> {
    item.addEventListener("click", ()=> {
        document.location.href = "./evaluations.php?idItem=" + item.id.split('_')[0];
    })
});
