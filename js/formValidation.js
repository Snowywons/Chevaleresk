function RegEx(regex, element, id, text)
{
    if(!regex.test(element))
        document.getElementById(id).innerHTML = text;
}

function PasswordConfirm()
{
    let confirmBox = document.getElementById("confirmValidation");
    let password = document.getElementById("password");
    let confirmation = document.getElementById("passwordConfirm")

    confirmBox.innerHTML = password.value !== confirmation.value ?
        "Le mot de passe et sa confirmation doivent correspondre." : "";
}

function notEmpty(id)
{
    let toCheck = document.getElementById(id);
    let checkBox = document.getElementById(toCheck.id+"Validation");
    checkBox.innerHTML = toCheck.value.length == 0 ? "Ce champ ne peut être vide." : "";
}
