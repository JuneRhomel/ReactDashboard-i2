import { ParamGetSoaType } from "@/types/apiRequestParams";
import { SoaType } from "@/types/models";
import { ApiResponse } from "@/types/responseWrapper";
import encryptData from "@/utils/encryptData";
import parseObject from "@/utils/parseObject";
import axios, { AxiosResponse } from "axios";
const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"

/**
 * Fetches the user's SOAs.
 * @param {ParamGetSoaType} params - This is a json object that has accountCode, dbTable,
 * queryCondition, and resultLimit
 * @return {Promise<ApiResponse<SoaType[]>>} Returns a promise of an ApiResponse object.
 */
export async function getSoa(
    params: ParamGetSoaType,
    token = "c8c69a475a9715c2f2c6194bc1974fae:tenant"
  ): Promise<ApiResponse<SoaType[]>> {
    const url = `${process.env.API_URL}/tenant/get-list`;
    const condition = params.userId
      ? `resident_id=${params.userId}`
      : `id=${params.soaId}`;
    const body = JSON.stringify({
      accountcode: params.accountcode,
      table: "vw_soa",
      condition: condition,
      limit: params.limit,
    });
    const headers = {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token}`,
    };
    const response: ApiResponse<SoaType[]> = {
      success: false,
      data: undefined,
      error: undefined,
    };
  
    try {
      const axiosResponse: AxiosResponse = await axios.post(url, body, {
        headers,
      });
      
      if (axiosResponse.status !== 200) {
        throw new Error(
          `HTTP error! Status: ${axiosResponse.status}, Response: ${JSON.stringify(
            axiosResponse.data
          )}`
        );
      }
  
      const responseBody = axiosResponse.data;
  
      if (responseBody.success === 0) {
        throw new Error(`400 Bad Request! ${responseBody.description}`);
      }
  
      response.success = true;
      const soas = parseObject(responseBody) as SoaType[];
      soas.forEach((soa) => {
        soa.encId = encryptData(soa.id);
      });
      response.data = soas;
      return response;
    } catch (error: any) {
      response.success = false;
      response.error = error.message;
      return {
        ...response,
      };
    }
  }