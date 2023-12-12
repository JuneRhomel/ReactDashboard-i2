import { fetch , setGlobalDispatcher, Agent, RequestInfo, RequestInit } from 'undici';

// Set the global dispatcher
setGlobalDispatcher(new Agent({ connect: { timeout: 90_000 } }));

// Define a custom fetch function
const customFetch = async (url: RequestInfo, options: RequestInit | undefined) => {
  try {
    const response = await fetch(url, options);

    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.statusCode}`);
    }

    return response;
  } catch (error) {
    console.error('Error during fetch:', error);
    throw error;
  }
};

export default customFetch;
