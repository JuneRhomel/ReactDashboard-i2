import { useEffect, useState } from 'react';
import styles from './ItemizedDetailsSection.module.css';
import { InputProps, ItemizedListItemType } from '@/types/models';
import InputGroup from '../inputGroup/InputGroup';
import Button from '../../button/Button';
import ItemDetails from '../itemDetails/ItemDetails';

// This is to initialize the inputs to have empty values. Perhaps not needed but leaving it in for now
const detailsInitializer = new Map<string, any>([
    ['Item Details', {
        itemName: '',
        itemQuantity: 0,
        itemDecription: '',
    }],
    ['Guest List', {
        guestName: '',
        guestContact: '',
        guestPurpose: '',
    }],
])

export default function ItemizedDetailsSection({type, formData, setFormData}: {type: string, formData: any, setFormData: any}) {
    const emptyDetails = detailsInitializer.get(type);
    // const [items, setItems] = useState<GatepassItemType[]>([]);
    const [items, setItems] = useState<ItemizedListItemType[]>(formData.items || []);
    const [itemDetails, setItemDetails] = useState<any>({...emptyDetails});
    const [error, setError] = useState('');

    // This is the map of the fields needed based on the type of ItemizedDetailsSection is being rendered. If you have a new ItemizedDetailsSection
    // that you want to implement, you should add the fields to this map.
    const fieldList = new Map<string, InputProps[]>([
        ['Item Details', [{
            name: 'itemName',
            label: 'Item Name',
            type: 'text',
            value: itemDetails['itemName'],
        },
        {
            name: 'itemQuantity',
            label: 'Item Quantity',
            type: 'number',
            value: itemDetails['itemQuantity'],
        },
        {
            name: 'itemDescription',
            label: 'Description',
            type: 'textArea',
            value: itemDetails['itemDescription']
        }]],
        ['Guest List', [{
            name: 'guestName',
            label: 'Name',
            type: 'text',
            value: itemDetails['guestName']
        },
        {
            name: 'guestContact',
            label: 'Contact #',
            type: 'text',
            value: itemDetails['guestContact']
        },
        {
            name: 'guestPurpose',
            label: 'Visit Purpose',
            type: 'textArea',
            value: itemDetails['guestPurpose']
        }
        ]],
    ])
    // This map determines which key of formData needs to be updated based on the type of this section
    const keysInFormData = new Map<string, string>([
        ['Item Details', 'items'],
        ['Guest List', 'guests'],
    ])
    const keyToBeUpdated = keysInFormData.get(type) as string;
    const inputFields = fieldList.get(type) as InputProps[];
    const labels = inputFields.map((field) => field.label);

    useEffect(()=> {
        setFormData({...formData, [keyToBeUpdated]: items});
    }, [items])
    
    const handleChange = (event: any) => {
        const newValue = event?.target?.value;
        const key = event?.target?.name;
        setItemDetails({...itemDetails, [key]: newValue})
        setError('');
    }
    
    const handleAddItem = (event: any) => {
        event.preventDefault();
        const newItem: {[key: string]: string | number}= {};

        // Get the value of each input
        for (const index in inputFields) {
            const field = inputFields[index];
            const inputElement = document.getElementById(field.name) as HTMLInputElement;
            const value = inputElement.value;
            const type = inputElement.type;
            const name = inputElement.name;
            // Validate if the input is not blank. If input is number, make sure it is > 0
            if (value && (type !== 'number' || parseInt(value) > 0)) {
                newItem[name] = value;
            }
        }
        // Validate if the newItem has all its fields filled before adding the item to the list
        if (Object.keys(newItem).length == inputFields.length) {
            // net to set the type to unknown first before typing it to ItemizedListItemType
            setItems((previousItems) => [...previousItems, newItem as unknown as ItemizedListItemType]);
            setItemDetails({...emptyDetails})
        } else {
            setError('*Please fill out item details completely to add an item');
        }
    }

    return (
        <div className={styles.container}>
            <h3 className={styles.title}>{type}</h3>
            <div className={styles.itemsContainer}>
            {/* I want to change this to a table */}
                {items.map((item, index) => <ItemDetails key={index} labels={labels} item={item}/>)}
            </div>
            <div className={styles.fieldsContainer}>
                {inputFields.map((field, index) => <InputGroup props={field} key={index} onChange={handleChange}/>)}
            </div>
            <div className={styles.footer}>
                <Button onClick={handleAddItem} type='addGuest'/>
                {error ? <p className={styles.error}>{error}</p> : <></>}
            </div>
        </div>
    )
}