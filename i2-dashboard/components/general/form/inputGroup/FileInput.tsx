import styles from './InputGroup.module.css';
import { useState } from 'react';

export default function FileInput({onChange}: {onChange: any}) {
    const [fileToUpload, setFileToUpload] = useState<File | null>(null);

    const handleFileSelect = (event: any)=> {
        const file = event.target.files[0];
        setFileToUpload(file);
        onChange(file);
    }
    return (
        <>
            <div className={styles.selectedFile}>
                <h4>Selected File</h4>
                <p>{fileToUpload ? (fileToUpload as File).name : 'No file selected'}</p>
            </div>
            <input className={styles.fileInput} type="file" name="file" id="file" onChange={handleFileSelect}/>
            <label className={styles.attachFileButton} htmlFor="file">
                Attach File/Photo
            </label>
        </>
    )
}