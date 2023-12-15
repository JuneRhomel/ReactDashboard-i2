import { ParamGetSoaDetailsType } from "@/types/apiRequestParams";
import { SoaPaymentsType } from "@/types/models";
import { ApiResponse } from "@/types/responseWrapper";
import parseObject from "@/utils/parseObject";
import axios, { AxiosResponse } from 'axios';
const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"

/** 
 * Fetches the payment details of a specific SOA or all the SOAs.
 * @param {ParamGetSoaDetailsType} params - This is a JSON object that has accountCode, dbTable, queryCondition, and resultLimit.
 * @param {string} token - The token used for authorization. Default value is "c8c69a475a9715c2f2c6194bc1974fae:tenant".
 * @return {Promise<ApiResponse<SoaPaymentsType[]>>} Returns a promise of a ApiResponse object.
 */
export async function getSoaPayments(params: ParamGetSoaDetailsType, token: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"): Promise<ApiResponse<SoaPaymentsType[]>> {
  const url = `${process.env.API_URL}/tenant/get-list`;
  const headers = {
    'Content-Type': 'application/json',
    'Authorization': `Bearer ${token}`,
  };

  const body = {
    accountcode: params.accountcode,
    table: 'vw_payment',
    condition: params.soaId ? `soa_id=${params.soaId}` : undefined,
    limit: params.limit,
  };

  const response: ApiResponse<SoaPaymentsType[]> = {
    success: false,
    data: undefined,
    error: undefined,
  };

  try {
    const axiosResponse: AxiosResponse = await axios.post(url, body, {
      headers,
    });
   
    if (!axiosResponse) {
      throw new Error(`HTTP error! Status: ${axiosResponse}, Response: ${JSON.stringify(axiosResponse.data)}`);
    }

    if (axiosResponse.data) {
      if (axiosResponse.data.success === 0) {
        throw new Error(`400 Bad Request! ${axiosResponse.data.description}`);
      }
      response.data = parseObject(axiosResponse.data) as SoaPaymentsType[];
    } else {
      response.data = null;
    }

    response.success = true;
    return response;
  } catch (error: any) {
    response.success = false;
    response.error = error.message;
    return response;
  }
}