import styles from './Navigation.module.css';
import { MdDashboard, MdBallot, MdReceipt, MdInsertChart, MdMenu } from 'react-icons/md';
import { useState } from 'react';
import Link from 'next/link';
import { useRouter } from 'next/router';

export default function Navigation() {
  const router = useRouter();
  const [selectedTab, setSelectedTab] = useState('/Dashboard');
  const [windowLoc, setWindowLoc] = useState(router.pathname || '/');

  const navigationItems = [
    { id: 1, link: '/dashboard', text: 'Dashboard', icon: <MdDashboard /> },
    { id: 2, link: '/soa', text: 'SOA', icon: <MdBallot /> },
    { id: 3, link: '/myrequest', text: 'My Request', icon: <MdReceipt /> },
    { id: 4, link: '/newsannouncement', text: 'News & Announcement', icon: <MdInsertChart /> },
    { id: 5, link: '/', text: 'Menu', icon: <MdMenu /> },
  ];

  const navigate = (link: string) => {
    setSelectedTab(link);
  };

  return (
    <nav className={styles.navigation}>
      <ul>
        {navigationItems.map((item) => (
          <li
            onClick={() => navigate(item.link)} // Pass item.link here
            key={item.id}
            className={`${windowLoc === item.link ? styles.active : ''}`}
          >
            <Link href={item.link} className={styles.link} passHref>
              <div className={`${styles.tab}`}>
                <div className={styles.icons}>{item.icon}</div>
                {item.text}
              </div>
            </Link>
          </li>
        ))}
      </ul>
    </nav>
  );
}
