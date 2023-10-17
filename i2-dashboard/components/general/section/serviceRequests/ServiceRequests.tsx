import { RequestType, ServiceRequestType } from '@/types/models';
import ServiceRequestCard from '../../cards/serviceRequestCard/ServiceRequestCard';
import style from './ServiceRequests.module.css'

const ServiceRequests = ({ serviceRequests }: { serviceRequests: ServiceRequestType[] }) => {
    if (serviceRequests == undefined) {
        return (<div>Undefined</div>)
    }
    // const serviceRequest: ServiceRequestType = serviceRequests.shift() as ServiceRequestType;
    return (
        <div className={style.displayArea}>
            {serviceRequests.map((request, index) => {
                // const componentToRender = request.type === 'Report Issue' ? <ServiceIssueCard key={index} serviceIssue={request.data}/> :
                //                             request.type === 'Gate Pass' ? <GatePassCard key={index} gatePass={request.data}/> :
                //                             request.type === 'Work Permit' ? <WorkPermitCard key={index} workPermit={request.data}/> :
                //                             request.type === 'Visitor Pass' ? <VisitorPassCard key={index} visitorPass={request.data}/> :
                //                             <h1>Not Found</h1>
                // return componentToRender;
                return <ServiceRequestCard key={index} request={request}/>
            })}
            {/* <ServiceRequestCard request={serviceRequest}></ServiceRequestCard> */}
        </div>
    )
}

export default ServiceRequests