import { ListRequest } from '@/types/models';
import ServiceRequestCard from '../../cards/myrequestCard/ServiceRequestCard';

const Servicerequest = ({props} : {props: ListRequest[]}) => {
    console.log(props)
    if (props == undefined) {
        return (<div>Undefined</div>)
    }
    const array: number[] = [1, 2, 3];
    return (
        <>
            {props.map((request, index) => (<ServiceRequestCard key={index} request={request} />))}
        </>
    )
}

export default Servicerequest