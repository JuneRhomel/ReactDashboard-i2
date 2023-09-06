import Head from 'next/head'
import Image from 'next/image'
import { Inter } from 'next/font/google'
import styles from '@/styles/Home.module.css'

const inter = Inter({ subsets: ['latin'] })

export default function Home() {
  return (
    <h1 className={styles.main}>This will be the Inventi portal dashboard in React using next.js</h1>
  )
}
