import '@/components/globals.css'
import UserContextProvider from '@/context/userContext'
import type { AppProps } from 'next/app'

export default function App({ Component, pageProps }: AppProps) {
  return (
    <UserContextProvider>
      <Component {...pageProps} />
    </UserContextProvider>
  )
  
}
