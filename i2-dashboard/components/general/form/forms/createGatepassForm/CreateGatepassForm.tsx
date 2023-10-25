import { CreateGatepassFormType, GatepassTypeType, InputProps, PersonnelDetailsType } from "@/types/models";
import InputGroup from "../../inputGroup/InputGroup";
import styles from './CreateGatepassForm.module.css';
import { useEffect, useState } from "react";
import ItemizedDetailsSection from "../../section/ItemizedDetailsSection";
import Button from "@/components/general/button/Button";
import parseFormErrors from "@/utils/parseFormErrors";
import api from "@/utils/api";

const testFormData = {
    requestorName: 'Kevin',
    gatepassType: '1',
    forDate: '2023-12-12',
    time: '12:31',
    unit: '121',
    contactNumber: '9569784569',
    items: [
        {
            itemName: 'Item 1',
            itemQuantity: 2,
            itemDescription: 'Decsription 1'
        },
    ],
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

export default function CreateGatepassForm({closeDropdown}: {closeDropdown: any}) {
    // const [formData, setFormData] = useState<CreateGatepassFormType>(emptyFormData);
    const [formData, setFormData] = useState<CreateGatepassFormType>(testFormData);
    const [gatepassTypes, setGatepassTypes] = useState<GatepassTypeType[]>([]);

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

    const handleInput = (event: any) => {
        const name = event?.target?.name;
        const value = event?.target?.value;
        const newFormData: CreateGatepassFormType = {...formData};
        if (name.substring(0,7) === 'courier') {
            const newPersonnelData = formData.personnel || {...newPersonnel};
            newPersonnelData[name as keyof PersonnelDetailsType] = value;
            newFormData.personnel = newPersonnelData;
        } else {
            newFormData[name as keyof CreateGatepassFormType] = value;
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
    }

    const handleCancel = (event: any) => {
        event.preventDefault();
        window.scrollTo(0,0);
        closeDropdown();
        clearForm();
    }

    // TODO
    const handleSubmit = async (event: any) => {
        event.preventDefault();
        const form = document.getElementById('createGatepassForm') as HTMLFormElement;
        if (!form?.checkValidity()) {
            const errors = parseFormErrors(form);
        } else {
            // const form = new FormData(event.target);
            // const body = {};
            // for (const [key, value] of form.entries()){
            //     body[key] = value;
            // }
            // console.log({body})
            const response = await api.requests.saveGatepass(formData);
        }

    }

    return (
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