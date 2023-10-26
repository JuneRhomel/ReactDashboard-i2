/** 
* This Component returns an html form based on the type of form needed.
* @param {'login'} type - The type of form you need. More types to be added
* @return {JsxElement} Returns a JsxElement of an HTML form
*/

import { Dispatch, SetStateAction } from "react";
import CreateServiceRequestForm from "./forms/createServiceRequestForm/CreateServiceRequestForm";
import LoginForm from "./forms/loginForm/LoginForm";

const Form = ({type, handleInput, formData, setFormData, onSubmit} : {
    type : string,
    handleInput?: Function,
    formData?: any,
    setFormData?: Dispatch<SetStateAction<any>>,
    onSubmit?: Function,
}) => {
    const formTypeMap: {[key: string]: JSX.Element} = {
        login: <LoginForm/>,
        gatepass: <CreateServiceRequestForm
            type={type}
            handleInput={handleInput as Function}
            formData={formData}
            setFormData={setFormData as Dispatch<SetStateAction<any>>}
            onSubmit={onSubmit as Function}
            />,
    };
    const formToRender = formTypeMap[type] ? formTypeMap[type] : <h1>Form does not exist yet</h1>;
    return formToRender;
}

export default Form