import { ServiceIssueType } from "@/types/models";
import style from './ServiceIssue.module.css';

const ServiceIssue = ({serviceIssue} : {serviceIssue: ServiceIssueType}) => {
  const type = "Report Issue";

  return (
    <div className={style.descriptionBox}>
        <div>
            <p><b>{type}</b></p>
            <p><b>Issue :</b> {serviceIssue.issueName}</p>
            <p><b>Description :</b> {serviceIssue.description}</p>
        </div>
        {serviceIssue.attachments ? (
            <div>
                <img className={style.image} src={serviceIssue.attachments} alt="" />
            </div>
        ) : <></> }
    </div >
  )
}

export default ServiceIssue;