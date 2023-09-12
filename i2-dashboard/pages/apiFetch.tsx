async function apiSend(params = {}) {
    const url = `http://apii2-sandbox.inventiproptech.com/tenant/authenticate`;
    const encodedKey = btoa(`UdAgg7J2Htbp5WECsm42LnUnXxLG5NwM:8vYW4XyXEsTUsxg8LvKzWcyB54BSFDa2`)
  
    const headers = {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${encodedKey}`,
    };
  
    try {
      const response = await fetch(url, {
        method: 'POST', // Change the HTTP method if needed
        headers,
        body: JSON.stringify(params),
      });
  
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
  
      const responseData = await response.text();
      return responseData;
    } catch (error) {
      return
      // return error.message;
    }
}

export default apiSend;
  