import { InputProps, SelectDataType, ReportIssueFormDataType } from "@/types/models";
import InputGroup from "../../inputGroup/InputGroup";
import styles from './CreateReportIssueForm.module.css';
import { useEffect, useState } from "react";
import Button from "@/components/general/button/Button";
import api from "@/utils/api";
import FileInput from "../../inputGroup/FileInput";
import checkFileIsValid from "@/utils/checkFileIsValid";

const emptyFormData = {
    requestorName: '',
    unit: '',
    contactNumber: '',
    issueCategory: '0',
    description: '',
    file: undefined,
}

const testFormData: ReportIssueFormDataType = {
    requestorName: 'Kevin',
    unit: '5',
    contactNumber: '1231231234',
    issueCategory: '1',
    description: 'Fee',
    file: undefined,
}

export default function CreateGatepassForm({closeDropdown, addServiceIssue}: {closeDropdown?: any, addServiceIssue: Function}) {
    
    const [status, setStatus] = useState<string>('');
    const [issueCategories, setIssueCategories] = useState<SelectDataType[]>([]);
    const [fileErrorMessage, setFileErrorMessage] = useState('');
    const [formData, setFormData] = useState<ReportIssueFormDataType>(testFormData);
    

    useEffect(() => {
        const fetchCategories = async () => {
            const response = await api.requests.getIssueCategories();
            if (response.success) {
                const categories = response.data;
                setIssueCategories(categories as SelectDataType[]);
            }
        }
        fetchCategories();
    }, [])

    const baseFields: InputProps[] = [
        {
            name: 'issueCategory',
            label: 'Issue Category',
            type: 'select',
            options: issueCategories,
            value: null,
            required: true,
        },
        {
            name: 'requestorName',
            label: 'Requestor Name',
            type: 'text',
            value: formData.requestorName,
            disabled: true,
            required: true,
        },
        {
            name: 'contactNumber',
            label: 'Contact Number',
            type: 'text',
            value: formData.contactNumber,
            required: true,
        },
        {
            name: 'unit',
            label: 'Unit #',
            type: 'text',
            value: formData.unit,
            required: true,
            disabled: true,
        },
        {
            name: 'description',
            label: 'Description',
            type: 'textArea',
            value: formData.description,
            required: true,
        }
    ]

    const handleFileSelection = (file: File) => {
        const newFormData = {...formData, file: file}
        setFormData(newFormData);
        setFileErrorMessage('');
    }

    const handleInput = (event: any) => {
        const name = event.target?.name;
        const value = event.target?.value;
        const newFormData = {...formData, [name]: value};
        setFormData(newFormData);
    }

    const clearForm = () => {
        setFormData({...emptyFormData})
        setStatus('');
    }

    const handleCancel = (event: any) => {
        event.preventDefault();
        window.scrollTo(0,0);
        closeDropdown();
        clearForm();
    }

    const handleSubmit = async (event: any) => {
        event.preventDefault();
        window.scrollTo(0,0);
        setStatus('submitting');
        const file = formData.file;
        const fileError = checkFileIsValid(file as File);
        setFileErrorMessage(fileError);
        if (!fileError) {
            // submit the form
            const response = await api.requests.saveReportIssue(formData);
            setFormData(emptyFormData);
            if (response.success) {
                setStatus('success');
                const newIssue = response.data;
                addServiceIssue(newIssue);
            } else {
                setStatus('error');
            }
        }
    }

    return status === 'submitting' ? 
        (
            <div>Submitting your request...</div>
        ) : status === 'success' ?
        (
            <div>
                <div>Your request has successfully been submitted</div>
                <button onClick={clearForm}>Submit another request</button>
            </div>
        ) : status === 'error' ?
        (
            <div>
                <div>There was an error submitting your request. Please try again</div>
                <button onClick={clearForm}>Try again</button>
            </div>
        ) :
        (
            <form action="" onSubmit={handleSubmit} className={styles.form} id="createGatepassForm">
                {baseFields.map((field, index) => (<InputGroup key={index} props={field} onChange={handleInput}/>))}

                <div className={styles.fileInputContainer}>
                    <FileInput onChange={handleFileSelection}/>
                    <p className={styles.fileErrorMessage}>{fileErrorMessage}</p>
                </div>

                <div className={styles.footer}>
                    <Button type='submit' onClick={null}/>
                    <Button type='cancel' onClick={handleCancel}/>
                </div>
            </form>
        )
}