import Head from "next/head";

interface LayoutProps {
    title?: string,
    children: React.ReactNode;
}

const Layout = ({children, title = "Inventi I2 Dashboard"}: LayoutProps) => {
  return (
    <>
        <Head>
            <title>{title}</title>
            <link rel="shortcut icon" href="/Inventi_Icon-Blue.png" type="image/x-icon" />
        </Head>
        <div>
            {children}
        </div>
    </>
  )
}

export default Layout