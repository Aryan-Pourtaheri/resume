import { Navigate, Outlet } from 'react-router-dom';
import './AuthLayout.css';
import { useAuth } from '@/lib/appwrite/AuthContext';

const AuthLayout = () => {

  const {user} = useAuth();

  return user ? <Navigate to="/" /> : (
    <section className='auth-container flex justify-center items-center w-full'>
      <Outlet />
    </section>
  );
};

export default AuthLayout;
