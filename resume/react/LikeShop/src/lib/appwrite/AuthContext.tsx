import { createContext, useState, useEffect, useContext } from "react";
import { account, configs, databases } from "./appwriteConfig";
import { ID, Permission, Role } from "appwrite";
import Loader  from "@/components/shared/Loader";
import { useToast } from "@/hooks/use-toast";
import { useNavigate } from "react-router-dom";
import { UserInfo } from "src/types/user";
import { Product } from "@/types/products";


const AuthContext = createContext('');

export const AuthProvider = ({ children }) => {
  const { toast } = useToast();
  const [loading, setLoading] = useState(true); 
  const [user, setUser] = useState(false);
  const navigate = useNavigate();

  const loginUser = async (userInfo: UserInfo) => {
    try {
      const currentUser = await account.get();
      if (currentUser) {
        console.log("User already logged in.");
        return currentUser; 
      }
    } catch (error) {

      try {
        const session = await account.createEmailPasswordSession(userInfo.email, userInfo.password);
        return session;
      } catch (createError) {
        console.log("Error creating new session:", createError);
        return null;
      }
    }
  };

  const logoutUser = async () => {
    try {
      await account.deleteSessions();
      setUser(false); 
    } catch (error) {
      setUser(null);
      console.log("Logout error:", error);
    }
  };


  const registerUser = async (user) => {
    try {
      const newAccount = await account.create(ID.unique(), user.email, user.password);
      console.log("New account created:", newAccount);

      await account.createEmailPasswordSession(user.email, user.password);

      const currentUser = await account.get();
      setUser(currentUser); 

      const response = await databases.createDocument(
        configs.databases,
        configs.collections,
        ID.unique(),
        {
          email: user.email,
          name: user.name,
          username: user.username,
        },
        [Permission.read(Role.users()), Permission.write(Role.users())]
      );
      console.log("Document creation response:", response);

      return { newAccount, response };
    } catch (error) {
      console.log("Registration error:", error);
    }
  };

  
  const checkUserStatus = async () => {
    try {
      const accountDetails = await account.get();
      setUser(accountDetails); 
      return true; 
    } catch (error) {
      setUser(false); 
      console.log("No active session:", error);
      return false; 
    } finally {
      setLoading(false); 
    }
  };


  useEffect(() => {
    checkUserStatus();
  }, []);

  const contextData = {
    user,
    loginUser,
    logoutUser,
    registerUser,
    loading, 
    checkUserStatus,
  };

  return (
    <AuthContext.Provider value={contextData}>
      {loading ? <Loader /> : children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => useContext(AuthContext);

export default AuthContext;
