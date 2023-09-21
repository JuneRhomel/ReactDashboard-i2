import Head from "next/head";
import Navigation from "./navigation/Navigation";

function Layout({
  children,
  title = "Inventi I2 Dashboard",
}: {
  title?: string;
  children: React.ReactNode;
}) {
  return (
    <>
      <Head>
        <title>{title}</title>
        <link rel="shortcut icon" href="/Inventi_Icon-Blue.png" type="image/x-icon" />
      </Head>
      <main>
        <Navigation  />
        {children}
      </main>
    </>
  )
}

export default Layout;