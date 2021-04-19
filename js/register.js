function updateValidation(element, valid) {
    if (valid) {
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
    return updateValidation(element, /^[a-z]([a-z\-]|\s)*$/i.test(element.value));
}

function validateAlias() {
    return validateNotEmpty('alias');
}

function validateFirstName() {
    if (!validateNotEmpty('firstName')) {
        return false;
    } else if (!validateName('firstName')) {
        document.getElementById('firstNameValidation').innerHTML = "Format invalide";
        return false;
    } else {
        document.getElementById('firstNameValidation').innerHTML = "";
        return true;
    }
}

function validateLastName() {
    if (!validateNotEmpty('lastName')) {
        return false;
    } else if (!validateName('lastName')) {
        document.getElementById('lastNameValidation').innerHTML = "Format invalide";
        return false;
    } else {
        document.getElementById('lastNameValidation').innerHTML = "";
        return true;
    }
}

function validatePassword() {
    if (!validateNotEmpty('passwordConfirm') && !validateNotEmpty('password')) {
        return false;
    } else if (!validateIdentical('password', 'passwordConfirm')) {
        document.getElementById('passwordConfirmValidation').innerHTML = "Le mot de passe et sa confirmation doivent correspondre.";
        return false;
    } else {
        document.getElementById('passwordConfirmValidation').innerHTML = "";
        return true;
    }
}

function validateIdentical(passwordId, confirmId) {
    const password = document.getElementById(passwordId);
    const confirm = document.getElementById(confirmId);

    const passwordValid = updateValidation(password, password.value.length > 0 && password.value === confirm.value);
    const confirmValid = updateValidation(confirm, confirm.value.length > 0 && password.value === confirm.value);

    return passwordValid && confirmValid;
}

function validateRegisterForm() {

    let allValid = true;

    if (!validateAlias()) allValid = false;
    if (!validateFirstName()) allValid = false;
    if (!validateLastName()) allValid = false;
    if (!validatePassword()) allValid = false;

    return allValid;
}

function validateLoginForm() {

    let allValid = true;

    if (!validateAlias()) allValid = false;
    if (!validateNotEmpty('password')) allValid = false;

    return allValid;
}

function validateModifyProfileForm() {

    let allValid = true;

    if (!validateFirstName()) allValid = false;
    if (!validateLastName()) allValid = false;
    if (!validatePassword()) allValid = false;

    return allValid;
}

function RegEx(regex, value) {
    return regex.test(value);
}