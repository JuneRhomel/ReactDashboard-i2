import style from './RequestCard.module.css'
function RequestCard() {
    return (
        <div className={style.card}>
            <div className={style.head}>
                <span className={`${style.status} ${style.pending}`}>Pending</span>
                <p className={style.date}>Feb 01, 2023 12:30</p>
            </div>
            <div className={style.desciption}>
                <p><b>GATE PASS</b></p>
                <p><b>Category Type:</b> Delivery</p>
                <p><b>Personel:</b> Jay Jay</p>
            </div>
        </div>
    )
}

export default RequestCard