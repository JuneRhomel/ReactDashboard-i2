import style from './Sidebar.module.css'
import Link from 'next/link';
import Button from '@/components/general/button/Button';
import { useState } from 'react';
import api from '@/utils/api';
import router from 'next/router';
function Sidebar({ showSidebar }: { showSidebar: boolean }) {
    const handleLogout = async () => {
        const response = await api.user.logout();
        if (response.ok) {
          router.push('/logout')
        }
      }
    return (
        <div className={style.sidebar}>
            <div className={style.sidebarImageContainer}>
                <div className={style.filter}></div>
                <img className={style.sidebarImage} src="https://apii2-sandbox.inventiproptech.com/uploads/adminmailinatorcom/branding/sidebar_img/2359016a-c48e-89dd." alt="" />
                <img className={style.logo} src="./logo.png" alt="" />
            </div>
            <nav>
                <ul className={style.sidebarList}>
                    <li>
                        <Link href="/dashboard" className={style.link} passHref>My Profile</Link>
                    </li>
                </ul>
                <div className={style.sidebarButton}>
                    <Button type='logout' onClick={handleLogout} />
                </div>
            </nav>
            <div className={style.powerdBy}>
                <img src="./poweredBy.png" alt="" />
            </div>
        </div>

    )
}

export default Sidebar