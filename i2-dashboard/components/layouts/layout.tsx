import Navigation from "./navigation/Navigation";
import Header from "./header/Header";
import { NextRouter, useRouter } from "next/router";
import Head from "next/head";

function Layout({ children, title } :
                {children: React.ReactNode; title: string}) {

  const router: NextRouter = useRouter();
  const route = router.route;
  return (
    <>
      <Head>
        <title>{title}</title>
        <link rel="shortcut icon" href="/Inventi_Icon-Blue.png" type="image/x-icon" />
      </Head>
      <main className={route === '/' ? 'login' : ''}>
        {route === '/' ? children : (
          <>
            <Header />
              <div className="container">
                {children}
              </div>
            <Navigation/>
          </>
        )}
      </main>
    </>
  )
}

export default Layout;