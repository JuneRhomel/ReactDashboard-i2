import styles from './Navigation.module.css';
import { MdDashboard, MdBallot, MdReceipt, MdInsertChart, MdMenu } from "react-icons/md";
import React, { useState } from 'react'
import { useRouter } from 'next/router';


export default function Navigation() {
    const [selectedTab, setSelectedTab] = useState('dashboard'); 
    const router = useRouter();

    const navigationItems = [
        { id: 1, link: 'dashboard', text: 'Dashboard', icon: <MdDashboard /> },
        { id: 2, link: 'soa', text: 'SOA', icon: <MdBallot /> },
        { id: 3, link: 'my-request', text: 'My Request', icon: <MdReceipt /> },
        { id: 4, link: 'news-announcement', text: 'News & Announcement', icon: <MdInsertChart /> },
        { id: 5, link: 'menu', text: 'Menu', icon: <MdMenu /> },
    ];

    const navigate = (id: string) => {
        setSelectedTab(id); 
        // router.push(`/${id}`);
    };

    return (
        <nav className={styles.navigation}>
            <ul>
                {navigationItems.map((item) => (
                    <li key={item.id}>
                        <a
                            onClick={() => navigate(item.link)}
                            className={`${styles.tab} ${selectedTab === item.link ? styles.active : ''}`}
                        >
                            <div className={styles.icons}>{item.icon}</div>
                            {item.text}
                        </a>
                    </li>
                ))}
            </ul>
        </nav>
    )
}
