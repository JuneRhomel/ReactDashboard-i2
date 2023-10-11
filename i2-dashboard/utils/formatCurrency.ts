const formatCurrency = (amount: string) : string => {
    const parsedAmount = parseFloat(amount);
    // Ensure 'amount' is a number and not NaN
    if (typeof parsedAmount !== 'number' || isNaN(parsedAmount)) {
      return 'Invalid Amount';
    }
  
    // Format the currency with a comma separator and two decimal places
    const formattedAmount = parsedAmount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    return formattedAmount;
  };

  export default formatCurrency;