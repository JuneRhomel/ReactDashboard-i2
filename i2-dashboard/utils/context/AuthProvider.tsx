// TODO: Fix the typescript error for Auth being not meeting the type AuthenticatedUser

import { ReactNode, createContext, useState } from 'react';
import { AuthenticatedUser } from '@/types/models';

const AuthContext = createContext<AuthenticatedUser | null>(null);

export const AuthProvider = ({ children }: {children : ReactNode}) => {
    const [auth, setAuth] = useState({});

    return (
        <AuthContext.Provider value={{auth, setAuth}}> 
            {children}
        </AuthContext.Provider>
    )
}

export default AuthContext;