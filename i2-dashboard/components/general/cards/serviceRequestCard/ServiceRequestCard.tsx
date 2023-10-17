import { GatePassType, ServiceIssueType, ServiceRequestType, VisitorsPassType, WorkPermitType } from '@/types/models';
import StatusBubble from '../../statusBubble/StatusBubble';
import style from './ServiceRequestCard.module.css'
import getDateString from '@/utils/getDateString';
import GatePass from './GatePass';
import ServiceIssue from './ServiceIssue';
import WorkPermit from './WorkPermit';
import VisitorPass from './VisitorPass';
import { useRouter } from 'next/router';

function ServiceRequestCard({ request }: { request: ServiceRequestType}) {
    const router = useRouter();
    const page = router.pathname;
    const status: string = request?.data?.status as string;

    const componentToRender = request.type === 'Report Issue' ? <ServiceIssue serviceIssue={request.data as ServiceIssueType}/> :
                                request.type === 'Gate Pass' ? <GatePass gatePass={request.data as GatePassType}/> :
                                request.type === 'Work Permit' ? <WorkPermit workPermit={request.data as WorkPermitType}/> :
                                request.type === 'Visitor Pass' ? <VisitorPass visitorPass={request.data as VisitorsPassType}/> :
                                <h1>Service request details not found</h1>

    return (
        <div className={style.card}>
            <div className={style.head}>
                <div className={style.headStatus}>
                    {page !== '/myrequests' ? <div className={style.id}>#100</div> : <></>}
                    <StatusBubble status={status}/>
                </div>
                <p className={style.date}>{request.dateUpload}</p>
            </div>
            <div className={style.desciption}>
                {componentToRender}
            </div>
        </div>
    )
}

export default ServiceRequestCard