import { ServiceRequestsThumbnailData } from '@/types/models';
import Thumbnail from '../../thumbnail/Thumbnail';

const ServiceRequestThumbnails = ({data} : {data: ServiceRequestsThumbnailData[]}) => {
    if (data == undefined) {
        return (<div>Undefined</div>)
    }
    return (
        <>
            {data.map((thumbnail, index) => (<Thumbnail key={index} data={thumbnail}/>))}
        </>
    )
}

export default ServiceRequestThumbnails