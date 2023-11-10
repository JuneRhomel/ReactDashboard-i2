import { CreateWorkPermitFormType, InputProps, SelectDataType, UserType, WorkDetailsType } from "@/types/models";
import InputGroup from "../../inputGroup/InputGroup";
import styles from './CreateWorkPermitForm.module.css';
import { ChangeEventHandler, Dispatch, SetStateAction, useEffect, useState } from "react";
import ItemizedDetailsSection from "../../section/ItemizedDetailsSection";
import Button from "@/components/general/button/Button";
import api from "@/utils/api";
import { useUserContext } from "@/context/userContext";

const newWorkDetails: WorkDetailsType = {
    contractorName: '',
    scopeOfWork: '',
    personInCharge: '',
    contractorContact: '',
}

export default function CreateWorkPermitForm({closeDropdown, addWorkPermit}: {
closeDropdown?: any,
addWorkPermit: Function,
}) {
    const {user, setUser} = useUserContext();
    const [workPermitTypes, setWorkPermitTypes] = useState<SelectDataType[]>([]);
    const [status, setStatus] = useState<string>('');
    const emptyFormData: CreateWorkPermitFormType = {
        requestorName: `${user?.firstName} ${user?.lastName}` as string,
        unit: user?.unitName as string,
        contactNumber: user?.contactNumber as string,
        workPermitCategory: '',
        startDate: '',
        endDate: '',
        workDetails: null,
        workPersonnel: [],
        workMaterials: [],
        workTools: [],
        isCreateGatepass: false
    }
    const [formData, setFormData] = useState<CreateWorkPermitFormType>(emptyFormData);

    useEffect(() => {
        const getWorkPermitTypes = async ()=> {
            const response = await api.requests.getWorkPermitTypes();
            if (response.success) {
                const newWorkPermitTypes = [...workPermitTypes];
                const permitTypes = response.data as SelectDataType[];
                permitTypes.forEach((type: SelectDataType)=> {
                    newWorkPermitTypes.push(type);
                })
                workPermitTypes.length == 0 && setWorkPermitTypes(newWorkPermitTypes);
            }
        }
        getWorkPermitTypes();
        setFormData(emptyFormData);
    }, [])

    const baseFields: InputProps[] = [
        {
            name: 'name',
            label: 'Requestor Name',
            type: 'text',
            value: formData?.requestorName,
            disabled: true,
            required: true,
        },
        {
            name: 'unit',
            label: 'Unit #',
            type: 'text',
            value: formData?.unit,
            required: true,
            disabled: true,
        },
        {
            name: 'contactNumber',
            label: 'Contact Number',
            type: 'text',
            value: formData?.contactNumber,
            required: true,
        },
        {
            name: 'workPermitCategory',
            label: 'Nature of Work',
            type: 'select',
            value: formData?.workPermitCategory,
            required: true,
            options: workPermitTypes,
        },
        {
            name: 'startDate',
            label: 'Start Date',
            type: 'date',
            value: formData?.startDate,
            required: true,
        },
        {
            name: 'endDate',
            label: 'End Date',
            type: 'date',
            value: formData?.endDate,
            required: true,
        },
    ]

    const workDetailsFields: InputProps[] = [
        {
            name: 'contractorName',
            label: 'Name of Contractor',
            type: 'text',
            value: formData?.workDetails?.contractorName || '',
            required: true
        },
        {
            name: 'scopeOfWork',
            label: 'Scope of Work',
            type: 'text',
            value: formData?.workDetails?.scopeOfWork || '',
            required: true,
        },
        {
            name: 'personInCharge',
            label: 'Name of Person-in-Charge',
            type: 'text',
            value: formData?.workDetails?.personInCharge || '',
            required: true,
        },
        {
            name: 'contractorContact',
            label: 'Contact Number',
            type: 'text',
            value: formData?.workDetails?.contractorContact || '',
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

    const handleSubmit = async (event: any) => {
        event.preventDefault();
        console.log(formData);
        setStatus('submitting');
        const response = await api.requests.saveWorkPermit(formData, user as UserType);
        if (response.success) {
            setStatus('success');
            const newWorkPermit = response.data?.workPermit;
            addWorkPermit(newWorkPermit);
        } else {
            setStatus('error')
            console.log(response.error);
        }
        clearForm();
    }

    const handleInput = (event: any) => {
        const name = event.target?.name;
        const value = event.target?.value;
        const newFormData: CreateWorkPermitFormType = {...formData};
        if (newWorkDetails.hasOwnProperty(name)) {
            const newWorkDetailsData = formData.workDetails || {...newWorkDetails};
            newWorkDetailsData[name as keyof WorkDetailsType] = value;
            newFormData.workDetails = newWorkDetailsData;
        } else {
            newFormData[name as keyof CreateWorkPermitFormType] = value;
        }
        setFormData(newFormData);
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
            <form action="" onSubmit={handleSubmit} className={styles.form} id="createWorkPermitForm">
                {baseFields.map((field, index) => (<InputGroup key={index} props={field} onChange={handleInput}/>))}
                
                <div className={styles.personnelContainer}>
                    <h3>Work Details</h3>
                    {workDetailsFields.map((field, index) => (<InputGroup key={index} props={field} onChange={handleInput}/>))}
                </div>

                <ItemizedDetailsSection type='List of Workers/Personnel' formData={formData} setFormData={setFormData}/>

                <ItemizedDetailsSection type='List of Materials' formData={formData} setFormData={setFormData}/>

                <ItemizedDetailsSection type='List of Tools' formData={formData} setFormData={setFormData}/>

                <div className={styles.footer}>
                    <Button type='submit' onClick={null}/>
                    <Button type='cancel' onClick={handleCancel}/>
                </div>
            </form>
        )
}