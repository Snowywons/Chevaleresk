let showEvaluationsButtons = document.querySelectorAll(".showEvaluations");

showEvaluationsButtons.forEach((item)=> {
    item.addEventListener("click", ()=> {
        document.location.href = "./Evaluation.php?idItem=" + item.id.split('_')[0];
    })
});
