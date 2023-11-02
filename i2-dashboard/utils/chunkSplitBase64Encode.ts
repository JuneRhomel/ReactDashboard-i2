
/**
 * Splits a base64-encoded string into smaller chunks for formatting. The chunk size is 76
 *
 * @param {string} data - The base64-encoded data to split.
 * @returns {string} The base64-encoded data split into chunks.
 */
export default function chunkSplitBase64Encode(data: string): string {
    const chunkSize = 76;
    let result = '';
    for (let i = 0; i < data.length; i += chunkSize) {
      result += data.slice(i, i + chunkSize) + '\r\n';
    }
    return result;
}