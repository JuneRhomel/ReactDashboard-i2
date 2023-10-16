import styles from "./StatusBubble.module.css";

const StatusBubble = ({status}: {status: string}) => {
    interface statusStyleType {
        open: string,
        approved: string,
        pending: string,
        closed: string,
        disapproved: string,
        ongoing: string,
    }
    const styleMap: statusStyleType = {
        open: styles.open,
        approved: styles.open,
        pending: styles.pending,
        closed: styles.closed,
        disapproved: styles.closed,
        ongoing: styles.pending,
    }
    const statusStyle = styleMap[status.toLowerCase() as keyof statusStyleType];
  return (
    <span className={`${styles.status} ${statusStyle}`}>
        {status}
    </span>
  )
}

export default StatusBubble;