import { GatePassType, ServiceIssueType, ServiceRequestDataType, ServiceRequestType, VisitorsPassType, WorkPermitType } from '@/types/models';
import StatusBubble from '../../statusBubble/StatusBubble';
import style from './ServiceRequestCard.module.css'
import getDateString from '@/utils/getDateString';
import GatePass from './GatePass';
import ServiceIssue from './ServiceIssue';
import WorkPermit from './WorkPermit';
import VisitorPass from './VisitorPass';
import { useRouter } from 'next/router';

function ServiceRequestCard({ request, variant = undefined }: { request: ServiceRequestType | ServiceRequestDataType, variant?: 'Report Issue' |'Gate Pass' |'Work Permit' | 'Visitor Pass' | undefined}) {
    const router = useRouter();
    const page = router.pathname;
    const type = request && 'data' in request ?
                    request.type : variant;
    const data = request && 'data' in request ?
                    request.data : request;
    const status= request && 'data' in request ?
                    request.data?.status as string : data?.status as string;

    const cardDetailsComponent = new Map<string, JSX.Element>(
        [
            ['Report Issue', <ServiceIssue serviceIssue={data as ServiceIssueType} key={data?.id}/>],
            ['Gate Pass', <GatePass gatePass={data as GatePassType} key={data?.id}/>],
            ['Work Permit', <WorkPermit workPermit={data as WorkPermitType} key={data?.id}/>],
            ['Visitor Pass', <VisitorPass visitorPass={data as VisitorsPassType} key={data?.id}/>],
        ]
    )

    const componentToRender = type && cardDetailsComponent.get(type) || <p>No Component to Render</p>;
    return (
        <div className={style.card}>
            <div className={style.head}>
                <div className={style.headStatus}>
                    {page !== '/myrequests' ? <div className={style.id}>#{request?.id}</div> : <></>}
                    <StatusBubble status={status}/>
                </div>
                <p className={style.date}>{data?.dateUpload}</p>
            </div>
            <div className={style.desciption}>
                {componentToRender}
            </div>
        </div>
    )
}

export default ServiceRequestCard