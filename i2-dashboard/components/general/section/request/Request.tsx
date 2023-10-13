import { RequestType } from '@/types/models';
import RequestCard from '../../cards/requestCard/RequestCard';
import style from './Request.module.css'

const Request = ({myRequest} : {myRequest: RequestType[]}) => {
    if (myRequest == undefined) {
        return (<div>Undefined</div>)
    }
    const array: number[] = [1, 2, 3];
    return (
        <div className={style.displayArea}>
            {myRequest.map((request, index) => (<RequestCard key={index} request={request} />))}
        </div>
    )
}

export default Request