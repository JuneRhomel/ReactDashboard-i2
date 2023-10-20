import { useEffect, useState } from 'react';
import styles from './ItemizedDetailsSection.module.css';
import { InputProps } from '@/types/models';
import InputGroup from '../inputGroup/InputGroup';
import Button from '../../button/Button';
import ItemDetails from '../itemDetails/ItemDetails';

const emptyItemDetails = {
    itemName: 'sa',
    itemQuantity: 2,
    itemDescription: 'sd',
}

export default function ItemizedDetailsSection({type, formData, setFormData}: {type: string, formData: any, setFormData: any}) {
    const [items, setItems] = useState<any[]>([emptyItemDetails]);
    const [itemDetails, setItemDetails] = useState<any>({...emptyItemDetails});
    const [error, setError] = useState('');

    useEffect(()=> {
        setFormData({...formData, items: items});
    }, [items])

    const handleChange = (event: any) => {
        const newValue = event?.target?.value;
        const key = event?.target?.name;
        setItemDetails({...itemDetails, [key]: newValue})
        setError('');
    }
    
    const handleAddItem = (event: any) => {
        event.preventDefault();
        const itemName = document.getElementById('itemName') as HTMLInputElement;
        const itemQuantity = document.getElementById('itemQuantity') as HTMLInputElement;
        const description = document.getElementById('itemDescription') as HTMLInputElement;
        if (itemName.value && description.value && parseInt(itemQuantity.value) > 0) {
            const newItem = {
                itemName: itemName.value,
                itemQuantity: itemQuantity.value,
                itemDescription: description.value,
            }
            setItems((previousItems) => [...previousItems, newItem]);
            setItemDetails({...emptyItemDetails})
        } else {
            setError('*Please fill out item details completely to add an item');
        }
    }

    const inputFields: InputProps[] = [
        {
            name: 'itemName',
            label: 'Item Name',
            type: 'text',
            onChange: handleChange,
            value: itemDetails.itemName,
        },
        {
            name: 'itemQuantity',
            label: 'Item Quantity',
            type: 'number',
            onChange: handleChange,
            value: itemDetails.itemQuantity,
        },
        {
            name: 'itemDescription',
            label: 'Description',
            type: 'textArea',
            onChange: handleChange,
            value: itemDetails.itemDescription
        }
    ]

    const labels = inputFields.map((field) => field.label);
    return (
        <div className={styles.container}>
            <h3 className={styles.title}>{type}</h3>
            <div className={styles.itemsContainer}>
                {items.map((item, index) => <ItemDetails key={index} labels={labels} item={item}/>)}
            </div>
            <div className={styles.fieldsContainer}>
                {inputFields.map((field, index) => <InputGroup props={field} key={index}/>)}
            </div>
            <div className={styles.footer}>
                <Button onClick={handleAddItem} type='addItem'/>
                {error ? <p className={styles.error}>{error}</p> : <></>}
            </div>
        </div>
    )
}