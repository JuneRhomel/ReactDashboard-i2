import { WorkDetailType, WorkPermitType } from "@/types/models";
import getDateString from "@/utils/getDateString";

const WorkPermit = ({workPermit} : {workPermit: WorkPermitType}) => {
    const type = "Work Permit";
    const categoryName = workPermit.categoryName;
    const startDate = getDateString(workPermit.startDate);
    const workDetails: WorkDetailType = workPermit.workDetail as WorkDetailType;

  return (
    <>
        <p><b>{type}</b></p>
        <p><b>Category: </b>{categoryName}</p>
        <p><b>Start Date: </b>{startDate}</p>
        <p><b>Scope of work: </b>{workDetails.scopeWork}</p>
        <p><b>Contractor:</b> {workDetails.nameContractor}</p>
    </>
  )
}

export default WorkPermit;