
export default function checkFileIsValid(file: File): string {
    if (!file) {
        return 'Please select a file to upload';
    }
    if (file) {
        const fileSizeInMB = file.size / (1024 * 1024);
        if (fileSizeInMB > 1) {
            return 'File size is too large. The maximum file size is 1 MB';
        }
    }
    return '';
}