import Link from 'next/link';
import { MdAddCircle, MdOutlineNotifications } from 'react-icons/md';
import styles from './Header.module.css';
import api from '@/utils/api';
import { NextRouter, useRouter } from 'next/router';

export default function Header() {
  const router: NextRouter = useRouter();
  const handleLogout = async () => {
    const response = await api.user.logout();
    if (response.ok) {
      router.push('/logout')
    }
  }
  return (
    <header className={styles.header}>
      <div className={styles.container}>
        <div>
          <img className={styles.logo} src="/logo.png" alt="" />
        </div>
        <button onClick={handleLogout}>Logout</button>
        <div className={styles.icon_container} >
          <Link href={'/servicerequest'}>
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
