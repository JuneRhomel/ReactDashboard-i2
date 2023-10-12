import style from './RequestCard.module.css'
import getDateString from '@/utils/getDateString';
import classNames from 'classnames';
function RequestCard({ request }: { request: any }) {
    const status = request?.data.status;

    let componentToRender = (props: {
        data: any; type: string;
    }) => {
        if (props.type === "Gate Pass") {
            return (
                <>
                    <p><b>{props.type}</b></p>
                    <p><b>Type:</b> {props.data.type}</p>
                    <p><b>Personel:</b> Jaysad Jay</p>
                </>
            )
        } else if (props.type === "Visitor Pass") {
            return (
                <>
                    <p><b>{props.type}</b></p>
                    <p><b>Arrival Date</b> {getDateString(props.data.arrival_date)}</p>
                    <p><b>Arrival Time</b> {props.data.arrival_time}</p>
                    <p><b>Guests:</b> {props.data.guest.map((e: { guest_name: string; }, index: number) => (
                        index === props.data.guest.length - 1 ? e.guest_name : `${e.guest_name}, `
                    ))}</p>

                </>
            )
        } else if (props.type === "Report Issue") {
            return (
                <div className={style.description_box}
                >
                    <div>
                        <p><b>{props.type}</b></p>
                        <p><b>Issue :</b> {props.data.issue_name}</p>
                        <p><b>Description :</b> {props.data.description}</p>
                    </div>
                    <div>
                        <img className={style.image} src={props.data.attachments} alt="" />
                    </div>
                </div >
            )
        } else if (props.type === "Work Permit") {
            return (
                <>
                    <p><b>{props.type}</b></p>
                    <p><b>Category :</b> {props.data.category_name}</p>
                    <p><b>Start Date :</b> {getDateString(props.data.start_date)}</p>
                    <p><b>Scope of work:</b> {props.data.work_details.map((e: { scope_work: string; }, index: number) => (
                        index === props.data.work_details.length - 1 ? e.scope_work : `${e.scope_work}, `
                    ))}</p>
                    <p><b>Contractor:</b> {props.data.work_details.map((e: { name_contractor: string; }, index: number) => (
                        index === props.data.work_details.length - 1 ? e.name_contractor : `${e.name_contractor}, `
                    ))}</p>
                </>
            )
        }
    };

    return (
        <div className={style.card}>
            <div className={style.head}>
                <span className={
                    `${style.status} ${status === "Open" ? style.open : status === "Approved" ? style.open : status === "Pending" ? style.pending : style.closed}`
                }>
                    {status}
                </span>
                <p className={style.date}>{request.date_upload}</p>
            </div>
            <div className={style.desciption}>
                {componentToRender(request)}
            </div>
        </div>
    )
}

export default RequestCard