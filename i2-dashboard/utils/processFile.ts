import chunkSplitBase64Encode from "./chunkSplitBase64Encode";

export default async function processFile(file: File) : Promise<string>{
    let chunkedFileData = '';
    const reader = new FileReader();

    // Create a promise that resolves when the file is read
    const fileReadPromise = new Promise<void>((resolve, reject) => {
        reader.onload = (e) => {
            const base64Data = (e.target?.result as string | undefined)?.split(',')[1]; // Extract the base64-encoded part
            chunkedFileData = chunkSplitBase64Encode(base64Data || ''); // Split into chunks
            resolve();
        };
        reader.onerror = (e) => {
            reject(e);
        };
    });

    reader.readAsDataURL(file); // Read the file as a data URL (base64-encoded)

    try {
        await fileReadPromise; // Wait for the file to be read
    } catch (error) {
        console.error("Error reading the file:", error);
    }

    return chunkedFileData;
}