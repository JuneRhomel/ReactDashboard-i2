import Link from 'next/link';
import { MdAddCircle, MdOutlineNotifications } from 'react-icons/md';
import styles from './Header.module.css';

export default function Header() {
  return (
    <header className={styles.header}>
      <div className={styles.container}>
        <div>
          <img className={styles.logo} src="/logo.png" alt="" />
        </div>
        <div className={styles.icon_container} >
          <Link href={'/'}>
            {<MdAddCircle className={styles.icon} />}
          </Link>
          <Link href={'/'}>
            {<MdOutlineNotifications className={styles.icon} />}
          </Link>
        </div>

      </div>

    </header>
  )
}
