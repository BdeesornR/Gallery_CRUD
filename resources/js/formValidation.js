export const inputValidation = (original, type, str) => {
    switch (type) {
        case 'name':
            if (str.length === 0) {
                return {...original, 'errName': 'Please enter a name', 'errInputName': 'err-msg', 'divName': 'msg err-msg'}
            } else if (str.length < 8) {
                return {...original, 'errName': 'Name must be at least 8 characters', 'errInputName': 'err-msg', 'divName': 'msg err-msg'}
            } else {
                return {...original, 'errName': null, 'errInputName': '', 'divName': 'msg'};
            }
            break;
        case 'email':
            const rules = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (str.length === 0) {
                return {...original, 'errEmail': 'Please enter an email', 'errInputEmail': 'err-msg', 'divEmail': 'msg err-msg'};
            } else if (rules.test(str)) {
                return {...original, 'errEmail': null, 'errInputEmail': '', 'divEmail': 'msg'};
            } else {
                return {...original, 'errEmail': 'Please enter a valid email address', 'errInputEmail': 'err-msg', 'divEmail': 'msg err-msg'};
            }
            break;
        case 'password':
            if (str.length === 0) {
                return {...original, 'errPassword': 'Please enter a password', 'errInputPassword': 'err-msg', 'divPassword': 'msg err-msg'}
            } else if (str.length < 6) {
                return {...original, 'errPassword': 'Password must be at least 6 characters', 'errInputPassword': 'err-msg', 'divPassword': 'msg err-msg'}
            } else {
                return {...original, 'errPassword': null, 'errInputPassword': '', 'divPassword': 'msg'};
            }
            break;
        default:
            return original;
    }
}

export const responseErrorsHandler = (state, err) => {
    const errors = err.response.data.errors;
    let original = state;

    // check name
    if (errors.name) {
        original.errName = errors.name[0];
        original.errInputName = 'err-msg';
        original.divName = 'msg err-msg';
    } else {
        original.errName = null;
        original.errInputName = '';
        original.divName = 'msg';
    }
    // check email
    if (errors.email) {
        original.errEmail = errors.email[0];
        original.errInputEmail = 'err-msg';
        original.divEmail = 'msg err-msg';
    } else {
        original.errEmail = null;
        original.errInputEmail = '';
        original.divEmail = 'msg';
    }
    // check password
    if (errors.password) {
        if (errors.password.includes("Passwords are not matched")) {
            // if confirm password field is not validate
            original.errConfirmPassword = "Passwords are not matched";
            original.errInputConfirmPassword = 'err-msg';
            original.divConfirm = 'msg err-msg';
            const tempArray = errors.password.filter(elm => elm !== "Passwords are not matched");
            if (tempArray.length !== 0){
                // if password field is not validate
                original.errPassword = tempArray[0];
                original.errInputPassword = 'err-msg';
                original.divPassword = 'msg err-msg';
            } else {
                // if password field is validate
                original.errPassword = null;
                original.errInputPassword = '';
                original.divPassword = 'msg';
            }
        } else {
            // if confirm password field is validate, but password field is not validate
            original.errPassword = errors.password[0];
            original.errConfirmPassword = null;
            original.errInputPassword = 'err-msg';
            original.errInputConfirmPassword = '';
            original.divPassword = 'msg err-msg';
            original.divConfirm = 'msg';
        }
    } else {
        // confirm password field and password field are validated
        original.errPassword = null;
        original.errConfirmPassword = null;
        original.errInputPassword = '';
        original.errInputConfirmPassword = '';
        original.divPassword = 'msg';
        original.divConfirm = 'msg';
    }
    // check confirmation password if null
    if (errors.password_confirmation) {
        original.errConfirmPassword = errors.password_confirmation[0];
        original.errInputConfirmPassword = 'err-msg';
        original.divConfirm = 'msg err-msg';
    }

    return original
}