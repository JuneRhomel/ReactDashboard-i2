/** 
* This Component returns an html form based on the type of form needed.
* @param {'login'} type - The type of form you need. More types to be added
* @return {JsxElement} Returns a JsxElement of an HTML form
*/

import LoginForm from "./forms/loginForm/LoginForm";

const Form = ({type} : {type : 'login'}) => {
    if (type === 'login') {
        return <LoginForm/>;
    }
    return <div>Default Form</div>

}

export default Form