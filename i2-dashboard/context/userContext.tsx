import { UserType } from "@/types/models";
import { Dispatch, ReactNode, SetStateAction, createContext, useContext, useState } from "react";

type UserContext = {
    user: UserType | null,
    setUser: Dispatch<SetStateAction<UserType | null>>,
}

export const UserContext = createContext<UserContext | null>(null);

export default function UserContextProvider({children}: {children: ReactNode}) {
    const [user, setUser] = useState<UserType | null>(null);

    return (
        <UserContext.Provider value={{user, setUser}}>
            {children}
        </UserContext.Provider>
    )
}

export function useUserContext() {
    const context = useContext(UserContext);
    if (!context) {
        throw new Error("useUserContext must be used within a UserContextProvider");
    }
    return context;
}