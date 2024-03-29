

export default function parseObject(obj: Record<string, any> | Record<string, any>[]): Record<string, any> | Record<string, any>[]{
  if (Array.isArray(obj))  {
    return obj.map((obj) => parseObject(obj));
  }
  
  const result: Record<string, any> = {};

  for (const key in obj) {
    if (obj.hasOwnProperty(key)) {
      const camelKey = key.replace(/_([a-z])/g, (_, letter) => letter.toUpperCase());
      // camelKey === 'id' ? result[camelKey] = parseInt(obj[key]) : result[camelKey] = obj[key];  //converting the id prop to a number type
      result[camelKey] = obj[key];
    }
  }
  delete result.iat;
  delete result.exp;
  return result;
  }