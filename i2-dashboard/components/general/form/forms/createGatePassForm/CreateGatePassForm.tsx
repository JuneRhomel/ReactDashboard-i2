import { InputProps } from "@/types/models";
import InputGroup from "../../inputGroup/InputGroup";
import styles from './CreateGatePassForm.module.css';
import { useEffect, useState } from "react";

export default function CreateGatePassForm() {
    const [formData, setFormData] = useState({
        requestorName: "Kevin",
        gatepassType: '',
        forDate: '2023-05-15',
        time: '13:01',
        unit: '305',
        contactNumber: '1234567890'
    })

    const handleInput = (event: any) => {
        const name = event?.target?.name;
        const value = event?.target?.value;
        const newFormData = {...formData, [name]: value};
        setFormData(newFormData);
    }

    useEffect(()=> {
        console.log(formData)
    },[formData])

    const props: InputProps[] = [
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
    return (
        <form action="" className={styles.form}>
            {props.map((prop, index) => (<InputGroup key={index} props={prop}/>))}
        </form>
    )
}