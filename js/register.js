function updateValidation(element, valid) {
    if(valid) {
        element.classList.remove('errorField');
        return true; 
    }
    element.classList.add('errorField');
    return false;
}

function validateNotEmpty(id) {
    const element = document.getElementById(id);
    return updateValidation(element, element.value.length > 0);
}

function validateName(id) {
    const element = document.getElementById(id);
    return updateValidation(element, /([a-z\-]|\s)+/i.test(element.value));
}

function validateIdentical(passwordId, confirmId) {
    const password = document.getElementById(passwordId);
    const confirm = document.getElementById(confirmId);

    const passwordValid = updateValidation(password, password.value.length > 0 && password.value === confirm.value);
    const confirmValid = updateValidation(confirm, confirm.value.length > 0 && password.value === confirm.value);

    return passwordValid && confirmValid;
}

function validateForm(event) {

    let allValid = true;
    
    if(!validateNotEmpty('alias')) {
        allValid = false;
    }
    if(!validateName('firstName')) {
        allValid = false;
    }
    if(!validateName('lastName')) {
        allValid = false;
    }
    if(!validateIdentical('password', 'passwordConfirm')) {
        allValid = false;
    }

    return allValid;
}

function RegEx(regex, value)
{
    return regex.test(value);
}