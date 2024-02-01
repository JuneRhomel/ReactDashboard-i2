import { ParamGetSoaDetailsType, ParamGetSoaType } from "@/types/apiRequestParams";
import { SoaDetailsType } from "@/types/models";
import { ApiResponse } from "@/types/responseWrapper";
import parseObject from "@/utils/parseObject";
import axios, { AxiosResponse } from 'axios';
const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"

/**
 * Fetches the payment details of a specific SOA or all the SOAs.
 * @param {ParamGetSoaType} params - The parameters containing account code, database table, query condition, and result limit.
 * @param {string} token - The token used for authorization. Default value is "c8c69a475a9715c2f2c6194bc1974fae:tenant".
 * @return {Promise<ApiResponse<SoaDetailsType[]>>} - Returns a promise of a response object.
 */
export async function getSoaDetails(
    params: ParamGetSoaType,
    token = "c8c69a475a9715c2f2c6194bc1974fae:tenant"
): Promise<ApiResponse<SoaDetailsType[]>> {
    const url = `${process.env.API_URL}/tenant/get-list`;
    const headers = {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${token}`,
    };

    const data = {
        accountcode: params.accountcode,
        table: 'soa_detail',
        condition: params.soaId ? `soa_id=${params.soaId}` : undefined,
        limit: params.limit,
    };

    const response: ApiResponse<SoaDetailsType[]> = {
        success: false,
        data: undefined,
        error: undefined,
    };

    try {
        const axiosResponse: AxiosResponse = await axios.post(url, data, {
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
        response.data = parseObject(responseBody) as SoaDetailsType[];

        return response;
    } catch (error: any) {
        response.success = false;
        response.error = error.message;

        return {
            ...response
        };
    }
}