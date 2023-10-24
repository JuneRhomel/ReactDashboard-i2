import { CreateGatePassFormType, InputProps, PersonnelDetailsType } from "@/types/models";
import InputGroup from "../../inputGroup/InputGroup";
import styles from './CreateGatePassForm.module.css';
import { useEffect, useState } from "react";
import ItemizedDetailsSection from "../../section/ItemizedDetailsSection";
import Button from "@/components/general/button/Button";

const testFormData = {
    requestorName: 'Kevin',
    gatepassType: null,
    forDate: '2023-12-12',
    time: '12:31',
    unit: '121',
    contactNumber: '1231231234',
    items: null,
    personnel: {
        courier: 'Some Courier',
        courierName: 'Person 1',
        courierContact: 'Some contact info'
    },
}

const newPersonnel = {
    courier: '',
    courierName: '',
    courierContact: '',
}

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

export default function CreateGatePassForm({closeDropdown}: {closeDropdown: any}) {
    const [formData, setFormData] = useState<CreateGatePassFormType>(emptyFormData)

    const handleInput = (event: any) => {
        const name = event?.target?.name;
        const value = event?.target?.value;
        const newFormData: CreateGatePassFormType = {...formData};
        if (name.substring(0,7) === 'courier') {
            const newPersonnelData = formData.personnel || {...newPersonnel};
            newPersonnelData[name as keyof PersonnelDetailsType] = value;
            newFormData.personnel = newPersonnelData;
            console.log(formData.personnel)
        } else {
            newFormData[name as keyof CreateGatePassFormType] = value;
        }
        setFormData(newFormData);
    }

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
            options: ['Delivery', 'Move In', 'Move Out', 'Pull Out']
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
            type: 'number',
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
    }

    const handleCancel = (event: any) => {
        event.preventDefault();
        window.scrollTo(0,0);
        closeDropdown();
        clearForm();
    }

    // TODO
    const handleSubmit = (event: any) => {
        event.preventDefault();
        console.log(formData)
    }

    return (
        <form action="" className={styles.form}>
            {baseFields.map((field, index) => (<InputGroup key={index} props={field}/>))}
            
            <ItemizedDetailsSection type='Item Details' formData={formData} setFormData={setFormData}/>

            <div className={styles.personnelContainer}>
                <h3>Personnel Details</h3>
                {personnelDetailsFields.map((field, index) => (<InputGroup key={index} props={field}/>))}
            </div>

            <div className={styles.footer}>
                <Button type='submit' onClick={handleSubmit}/>
                <Button type='cancel' onClick={handleCancel}/>
            </div>
        </form>
    )
}