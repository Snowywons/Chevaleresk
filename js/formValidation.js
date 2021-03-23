function RegEx(regex, element, id, text)
{
    if(!regex.test(element))
    {
        document.getElementById(id).innerHTML = text;
    }
}

function PasswordConfirm()
{
    let confirmBox = document.getElementById("confirmValidation");
    let password = document.getElementById("password");
    let confirmation = document.getElementById("passwordConfirm")
    if (password !== confirmation)
    {
        confirmBox.innerHTML = "Le mot de passe et sa confirmation doivent correspondre."
        
    }
    else {
        confirmBox.innerHTML = "";
    }

}

function notEmpty(id)
{
    let toCheck = document.getElementById(id);
    let checkBox = document.getElementById(toCheck.id+"Validation");
    if (toCheck.value.length == 0)
    {
        checkBox.innerHTML = "Ce champ ne peut être vide.";

    }
    else 
    {
        checkBox.innerHTML = "";
    }
}
