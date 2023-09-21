import styles from "./Header.module.css"

export default function Header() {
  return (
    <header className={styles.header}>
      <img className={styles.headerBackground} src="/background.png" alt="header background"/>
      <img className={styles.headerLogo} src="/logo.svg" alt="Inventi Logo White" />
    </header>
  )
}
