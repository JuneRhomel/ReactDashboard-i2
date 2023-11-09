import { CreateGatepassFormType, InputProps, SelectDataType } from "@/types/models";
import InputGroup from "../../inputGroup/InputGroup";
import styles from './CreateGatepassForm.module.css';
import { ChangeEventHandler, Dispatch, SetStateAction, useEffect, useState } from "react";
import ItemizedDetailsSection from "../../section/ItemizedDetailsSection";
import Button from "@/components/general/button/Button";
import api from "@/utils/api";

const emptyFormData = {
    requestorName: '',
    gatepassType: null,
    forDate: '',
    time: '',
    unit: '',
    contactNumber: '',
    items: null,
    personnel: null,
}

export default function CreateGatepassForm({closeDropdown, handleInput, formData, setFormData, onSubmit}: {
    closeDropdown?: any,
    handleInput: ChangeEventHandler,
    formData: CreateGatepassFormType,
    setFormData: Dispatch<SetStateAction<CreateGatepassFormType>>,
    onSubmit: Function,
    }) {
    const [gatepassTypes, setGatepassTypes] = useState<SelectDataType[]>([]);
    const [status, setStatus] = useState<string>('');

    useEffect(() => {
        const getGatepassTypes = async ()=> {
            const response = await api.requests.getGatepassTypes();
            if (typeof response !== 'string') {
                const newGatepassTypes = [...gatepassTypes];
                response.forEach((type: SelectDataType)=> {
                    newGatepassTypes.push(type);
                })
                gatepassTypes.length == 0 && setGatepassTypes(newGatepassTypes);
            }
        }
        getGatepassTypes();
    }, [])

    const baseFields: InputProps[] = [
        {
            name: 'requestorName',
            label: 'Requestor Name',
            type: 'text',
            value: formData.requestorName,
            disabled: true,
            required: true,
        },
        {
            name: 'gatepassType',
            label: 'Gatepass Type',
            type: 'select',
            value: formData.gatepassType,
            required: true,
            options: gatepassTypes,
        },
        {
            name: 'forDate',
            label: 'Date',
            type: 'date',
            value: formData.forDate,
            required: true,
        },
        {
            name: 'time',
            label: 'Time',
            type: 'time',
            value: formData.time,
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
            name: 'contactNumber',
            label: 'Contact Number',
            type: 'text',
            value: formData.contactNumber,
            required: true,
        }
    ]
    
    const personnelDetailsFields: InputProps[] = [
        {
            name: 'courier',
            label: 'Courier / Company',
            type: 'text',
            value: formData.personnel?.courier || '',
            required: true
        },
        {
            name: 'courierName',
            label: 'Name',
            type: 'text',
            value: formData.personnel?.courierName || '',
            required: true,
        },
        {
            name: 'courierContact',
            label: 'Contact Details',
            type: 'text',
            value: formData.personnel?.courierContact || '',
            required: true,
        }
    ]

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

    // 
    const handleSubmit = async (event: any) => {
        event.preventDefault();
        setStatus('submitting');
        const response = await onSubmit(event);
        setFormData(emptyFormData);
        response?.success ? setStatus('success') : setStatus('error');
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
                
                <ItemizedDetailsSection type='Item Details' formData={formData} setFormData={setFormData}/>

                <div className={styles.personnelContainer}>
                    <h3>Personnel Details</h3>
                    {personnelDetailsFields.map((field, index) => (<InputGroup key={index} props={field} onChange={handleInput}/>))}
                </div>

                <div className={styles.footer}>
                    <Button type='submit' onClick={null}/>
                    <Button type='cancel' onClick={handleCancel}/>
                </div>
            </form>
        )
}