import { CreateGatepassFormType, GatepassTypeType, InputProps, PersonnelDetailsType } from "@/types/models";
import InputGroup from "../../inputGroup/InputGroup";
import styles from './CreateGatepassForm.module.css';
import { Dispatch, SetStateAction, useEffect, useState } from "react";
import ItemizedDetailsSection from "../../section/ItemizedDetailsSection";
import Button from "@/components/general/button/Button";
import parseFormErrors from "@/utils/parseFormErrors";
import api from "@/utils/api";
import { clear } from "console";

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
    closeDropdown: any,
    handleInput: Function,
    formData: CreateGatepassFormType,
    setFormData: Dispatch<SetStateAction<CreateGatepassFormType>>,
    onSubmit: Function,
    }) {
    const [gatepassTypes, setGatepassTypes] = useState<GatepassTypeType[]>([]);
    const [status, setStatus] = useState<string>('');

    useEffect(() => {
        const getGatepassTypes = async ()=> {
            const response = await api.requests.getGatepassTypes();
            if (typeof response !== 'string') {
                const newGatepassTypes = [...gatepassTypes];
                response.forEach((type: GatepassTypeType)=> {
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
            onChange: handleInput,
            value: formData.requestorName,
            disabled: true,
            required: true,
        },
        {
            name: 'gatepassType',
            label: 'Gatepass Type',
            type: 'select',
            onChange: handleInput,
            value: formData.gatepassType,
            required: true,
            options: gatepassTypes,
        },
        {
            name: 'forDate',
            label: 'Date',
            type: 'date',
            onChange: handleInput,
            value: formData.forDate,
            required: true,
        },
        {
            name: 'time',
            label: 'Time',
            type: 'time',
            onChange: handleInput,
            value: formData.time,
            required: true,
        },
        {
            name: 'unit',
            label: 'Unit #',
            type: 'text',
            onChange: handleInput,
            value: formData.unit,
            required: true,
            disabled: true,
        },
        {
            name: 'contactNumber',
            label: 'Contact Number',
            type: 'text',
            onChange: handleInput,
            value: formData.contactNumber,
            required: true,
        }
    ]
    
    const personnelDetailsFields: InputProps[] = [
        {
            name: 'courier',
            label: 'Courier / Company',
            type: 'text',
            onChange: handleInput,
            value: formData.personnel?.courier || '',
            required: true
        },
        {
            name: 'courierName',
            label: 'Name',
            type: 'text',
            onChange: handleInput,
            value: formData.personnel?.courierName || '',
            required: true,
        },
        {
            name: 'courierContact',
            label: 'Contact Details',
            type: 'text',
            onChange: handleInput,
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
                {baseFields.map((field, index) => (<InputGroup key={index} props={field}/>))}
                <ItemizedDetailsSection type='Item Details' formData={formData} setFormData={setFormData}/>

                <div className={styles.personnelContainer}>
                    <h3>Personnel Details</h3>
                    {personnelDetailsFields.map((field, index) => (<InputGroup key={index} props={field}/>))}
                </div>

                <div className={styles.footer}>
                    <Button type='submit' onClick={null}/>
                    <Button type='cancel' onClick={handleCancel}/>
                </div>
            </form>
        )
}