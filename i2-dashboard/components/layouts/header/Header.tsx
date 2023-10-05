import Link from 'next/link';
import { MdAddCircle,MdOutlineNotifications } from 'react-icons/md';
import React from 'react'
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
            <div className={styles.icon}>
              {<MdAddCircle/>}
            </div>
          </Link>
          <Link href={'/'}>
            <div className={styles.icon}>
              {<MdOutlineNotifications/>}
            </div>
          </Link>
        </div>

      </div>

    </header>
  )
}
