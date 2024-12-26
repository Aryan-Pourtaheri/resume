import { Navigate, Route, Routes } from 'react-router-dom';
import './App.css';
import AuthLayout from './pages/_auth/AuthLayout';
import Signup from './pages/_auth/forms/signup';
import Login from './pages/_auth/forms/login';
import RootLayout from './pages/_root/RootLayout';
import { Home } from './pages/_root/pages';
import About from './pages/_root/pages/About';
import Services from './pages/_root/pages/Services';
import Contact from './pages/_root/pages/Contact';
import Products from './pages/_root/pages/Products';
import { AuthProvider} from './lib/appwrite/AuthContext';
import { Toaster } from './components/ui/toaster';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { CartProvider } from './lib/cart/CartContext';
import Shopping from './pages/_root/pages/Shopping';
import ProductDetail from './pages/_root/pages/ProductDetail';
const queryClient = new QueryClient()

function App() {
  
  return (
    <main className='flex min-h-screen'>
      <Toaster
        position="top-right"
        reverseOrder={false}
        toastOptions={{
          style: {
            padding: '16px',
            fontSize: '16px',
            borderRadius: '8px',
          },
          error: {
            style: {
              background: '#f44336',  
              color: '#fff',          
              border: '1px solid #d32f2f',
              boxShadow: '0px 4px 10px rgba(0, 0, 0, 0.15)',
            },
            iconTheme: {
              primary: '#fff',
              secondary: '#f44336',
            },
          },
        }}
      />
      <AuthProvider>
        <CartProvider>
          <Routes>
            <Route element={<RootLayout />}>
              <Route index element={<Home />} />
              <Route path="/about" element={<About />} />
              <Route path="/services" element={<Services />} />
              <Route path="/contact" element={<Contact />} />
              <Route path="/products" element={
                <QueryClientProvider client={queryClient}>
                    <CartProvider>
                      <Products />
                    </CartProvider>
                </QueryClientProvider>
              } />
              <Route path='/shopping' element={<Shopping />}/>
              <Route path="/products/:productId" element={<ProductDetail />} />
              <Route path="*" element={<Navigate to="/" />} />
            </Route>

            <Route element={<AuthLayout />}>
              <Route path='/log-in' element={<Login />} />
              <Route path='/sign-up' element={<Signup />} />

              <Route path="*" element={<Navigate to="/log-in" />} />
            </Route>
          </Routes>
        </CartProvider>
      </AuthProvider>

    </main>
  );
}

export default App;