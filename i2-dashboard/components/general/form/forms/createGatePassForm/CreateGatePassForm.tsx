import { InputProps } from "@/types/models";
import InputGroup from "../../inputGroup/InputGroup";
import styles from './CreateGatePassForm.module.css';
import { useEffect, useState } from "react";
import ItemizedDetailsSection from "../../section/ItemizedDetailsSection";
import Button from "@/components/general/button/Button";

export default function CreateGatePassForm({closeDropdown}: {closeDropdown: any}) {
    const [formData, setFormData] = useState({
        requestorName: "Kevin",
        gatepassType: '',
        forDate: '2023-05-15',
        time: '13:01',
        unit: '305',
        contactNumber: '1234567890',
        items: null,
        personnel: {
            courier: 'Some Courier',
            courierName: 'Person 1',
            contactInfo: 'Some contact info'
        },
    })

    const handleInput = (event: any) => {
        const name = event?.target?.name;
        const value = event?.target?.value;
        const newFormData = {...formData, [name]: value};
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
            value: formData.personnel?.courier,
            required: true
        },
        {
            name: 'courierName',
            label: 'Name',
            type: 'text',
            onChange: handleInput,
            value: formData.personnel?.courierName,
            required: true,
        },
        {
            name: 'contactInfo',
            label: 'Contact Details',
            type: 'text',
            onChange: handleInput,
            value: formData.personnel?.contactInfo,
            required: true,
        }
    ]

    // TODO
    const clearForm = () => {
        console.log('clearForm() has not yet been implemented')
    }

    const handleCancel = (event: any) => {
        event.preventDefault();
        closeDropdown();
        clearForm();
    }

    const handleSubmit = (event: any) => {
        event.preventDefault();
        console.log('submitting form')
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