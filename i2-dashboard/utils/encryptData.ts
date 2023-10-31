import CryptoJS from 'crypto-js';
const SECRET = process.env.SECRET_KEY as string;
export default function encryptData(data: any) {
    // Encrypt the data
    const encryptedData = CryptoJS.AES.encrypt(data, SECRET).toString();
    const urlSafeEcryptedData = encodeURIComponent(encryptedData);
    return urlSafeEcryptedData;
}
