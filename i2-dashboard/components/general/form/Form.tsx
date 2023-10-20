/** 
* This Component returns an html form based on the type of form needed.
* @param {'login'} type - The type of form you need. More types to be added
* @return {JsxElement} Returns a JsxElement of an HTML form
*/

import CreateServiceRequestForm from "./forms/createServiceRequestForm/CreateServiceRequestForm";
import LoginForm from "./forms/loginForm/LoginForm";

const Form = ({type} : {type : string}) => {
    const formTypeMap: {[key: string]: JSX.Element} = {
        login: <LoginForm/>,
        gatepass: <CreateServiceRequestForm type='gatepass'/>,
    };
    const formToRender = formTypeMap[type] ? formTypeMap[type] : <h1>Form does not exist yet</h1>;
    return formToRender;
}

export default Form