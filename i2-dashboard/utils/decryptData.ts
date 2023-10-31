import CryptoJS from 'crypto-js';
const SECRET = process.env.SECRET_KEY as string;
export default function decryptData(data: any) {
    // // Decrypt the encrypted data
    const decodedUrlSafeData = decodeURIComponent(data);
    const bytes = CryptoJS.AES.decrypt(decodedUrlSafeData, SECRET);
    const decryptedData = bytes.toString(CryptoJS.enc.Utf8);
    return decryptedData;
}

