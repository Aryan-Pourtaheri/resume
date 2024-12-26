import { useAuth } from '@/lib/appwrite/AuthContext';
import { useState } from 'react';
import { Link, useMatch, useResolvedPath, useNavigate } from 'react-router-dom';
import { useCart } from '@/lib/cart/CartContext';

const Navigation = () => {
  const [isOpen, setIsOpen] = useState(false);
  const navigate = useNavigate();
  const { user, logoutUser } = useAuth(); 
  const { cartCount } = useCart();


  const toggleMenu = () => {
    setIsOpen(!isOpen);
  };

  function CustomLink({ to, children, ...props }) {
    const resolvedPath = useResolvedPath(to);
    const isActive = useMatch({ path: resolvedPath.pathname, end: true });
    return (
      <Link className={isActive ? 'nav-item active' : 'nav-item'} to={to} {...props}>
        {children}
      </Link>
    );
  }

  const handleLogout = async () => {
    await logoutUser();
    navigate('/log-in');
  };

  return (
    <>
      <nav className="bg-black/50 backdrop-blur-lg fixed w-full z-50">
        <div className="container mx-auto px-4 py-3">
          <div className="flex justify-between items-center">
            <a href="/" className="text-white font-bold text-xl">
              <img src="assets/logo.svg" alt="logo" className="h-8" />
            </a>

            <div className="hidden md:flex items-center space-x-5">
              <CustomLink to="/">Home</CustomLink>
              <CustomLink to="/products">Products</CustomLink>
              <CustomLink to="/services">Services</CustomLink>
              <CustomLink to="/contact">Contact</CustomLink>
              <CustomLink to="/about">About</CustomLink>
            </div>

            <div className="hidden md:flex items-center space-x-6">
              {user ? (
                <>
                  <Link to="/shopping">
                    <button
                      aria-label="Shopping Cart"
                      className="relative bg-transparent bg-gray-200 px-4 py-2 rounded-md w-full text-center"
                    >
                      <span className="absolute left-10 bottom-8 text-black bg-orange-300 px-2 rounded-full">
                        {cartCount}
                      </span>
                      <img src="assets/shopping-cart.png" width={40} alt="shopping cart icon" />
                    </button>
                  </Link>
                  <button
                    onClick={handleLogout}
                    className="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 duration-300"
                  >
                    Log Out
                  </button>
                </>
              ) : (
                <>
                  <Link to="/log-in">
                    <button className="bg-transparent text-white hover:bg-gray-700 px-4 py-2 rounded-md duration-300">
                      Log in
                    </button>
                  </Link>
                  <Link to="/sign-up">
                    <button className="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 duration-300">
                      Sign Up
                    </button>
                  </Link>
                </>
              )}
            </div>

            <div className="md:hidden flex items-center">
              <button
                onClick={toggleMenu}
                className="text-white hover:text-gray-300 focus:outline-none"
                aria-label="Toggle Menu"
              >
                {isOpen ? (
                  <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                  </svg>
                ) : (
                  <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                  </svg>
                )}
              </button>
            </div>
          </div>
        </div>

        {isOpen && (
          <div className="md:hidden bg-black/70 backdrop-blur-lg">
            <div className="container mx-auto px-4 py-3 space-y-4">
              <CustomLink to="/">Home</CustomLink>
              <CustomLink to="/products">Products</CustomLink>
              <CustomLink to="/services">Services</CustomLink>
              <CustomLink to="/about">About</CustomLink>
              <CustomLink to="/contact">Contact</CustomLink>

              {user ? (
                <>
                  <Link to="/shopping">
                    <button
                      aria-label="Shopping Cart"
                      className="relative m-3 p-2 bg-white w-10 rounded-full"
                    >
                      <span className="absolute left-8 bottom-5 text-black bg-orange-300 px-2 rounded-full">
                        {cartCount}
                      </span>
                      <img src="assets/shopping-cart.png" width={30} alt="shopping cart icon" />
                    </button>
                  </Link>
                  <button
                    onClick={handleLogout}
                    className="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 duration-300 w-full"
                  >
                    Log Out
                  </button>
                </>
              ) : (
                <>
                  <Link to="/log-in">
                    <button className="bg-transparent text-white hover:bg-gray-700 px-4 py-2 rounded-md duration-300 w-full">
                      Log in
                    </button>
                  </Link>
                  <Link to="/sign-up">
                    <button className="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 duration-300 w-full">
                      Sign Up
                    </button>
                  </Link>
                </>
              )}
            </div>
          </div>
        )}
      </nav>
    </>
  );
};

export default Navigation;
