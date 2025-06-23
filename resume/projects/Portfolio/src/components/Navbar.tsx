import { useState } from "react";
import { Link, useLocation } from "react-router-dom";
import "../styles/Navbar.css";

const Navbar = () => {
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const location = useLocation(); // To get the current path

  const toggleMobileMenu = () => {
    setIsMobileMenuOpen(!isMobileMenuOpen);
  };

  // Function to determine if the link is active
  const isActive = (path) => location.pathname === path;

  return (
    <nav className="bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 text-white p-4 shadow-lg">
      <div className="container mx-auto flex justify-between items-center">
        {/* Title */}
        <h1 className="text-xl font-bold font-sans cursor-pointer">
          My Portfolio
        </h1>

        {/* Desktop Navigation */}
        <div className="hidden sm:flex space-x-4">
          <Link
            to="/"
            className={`px-3 py-2 rounded-md text-sm font-medium ${
              isActive("/")
                ? "bg-white text-gray-800"
                : "text-gray-200 hover:bg-pink-600 hover:text-white"
            }`}
          >
            Home
          </Link>
          <Link
            to="/about"
            className={`px-3 py-2 rounded-md text-sm font-medium ${
              isActive("/about")
                ? "bg-white text-gray-800"
                : "text-gray-200 hover:bg-pink-600 hover:text-white"
            }`}
          >
            About
          </Link>
          <Link
            to="/projects"
            className={`px-3 py-2 rounded-md text-sm font-medium ${
              isActive("/projects")
                ? "bg-white text-gray-800"
                : "text-gray-200 hover:bg-pink-600 hover:text-white"
            }`}
          >
            Projects
          </Link>
          <Link
            to="/contact"
            className={`px-3 py-2 rounded-md text-sm font-medium ${
              isActive("/contact")
                ? "bg-white text-gray-800"
                : "text-gray-200 hover:bg-pink-600 hover:text-white"
            }`}
          >
            Contact
          </Link>
        </div>

        {/* Mobile Menu Button */}
        <div className="sm:hidden">
          <button
            type="button"
            className="inline-flex items-center justify-center rounded-md p-2 text-gray-200 hover:bg-pink-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
            aria-controls="mobile-menu"
            aria-expanded={isMobileMenuOpen}
            onClick={toggleMobileMenu}
          >
            <span className="sr-only">Open main menu</span>
            {isMobileMenuOpen ? (
              <svg
                className="block h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                strokeWidth="1.5"
                stroke="currentColor"
                aria-hidden="true"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            ) : (
              <svg
                className="block h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                strokeWidth="1.5"
                stroke="currentColor"
                aria-hidden="true"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                />
              </svg>
            )}
          </button>
        </div>
      </div>

      {/* Mobile Menu */}
      {isMobileMenuOpen && (
        <div className="sm:hidden" id="mobile-menu">
          <div className="space-y-1 px-2 pb-3 pt-2">
            <Link
              to="/"
              className={`block px-3 py-2 rounded-md text-base font-medium ${
                isActive("/")
                  ? "bg-white text-gray-800"
                  : "text-gray-200 hover:bg-pink-600 hover:text-white"
              }`}
              onClick={() => setIsMobileMenuOpen(false)}
            >
              Home
            </Link>
            <Link
              to="/about"
              className={`block px-3 py-2 rounded-md text-base font-medium ${
                isActive("/about")
                  ? "bg-white text-gray-800"
                  : "text-gray-200 hover:bg-pink-600 hover:text-white"
              }`}
              onClick={() => setIsMobileMenuOpen(false)}
            >
              About
            </Link>
            <Link
              to="/projects"
              className={`block px-3 py-2 rounded-md text-base font-medium ${
                isActive("/projects")
                  ? "bg-white text-gray-800"
                  : "text-gray-200 hover:bg-pink-600 hover:text-white"
              }`}
              onClick={() => setIsMobileMenuOpen(false)}
            >
              Projects
            </Link>
            <Link
              to="/contact"
              className={`block px-3 py-2 rounded-md text-base font-medium ${
                isActive("/contact")
                  ? "bg-white text-gray-800"
                  : "text-gray-200 hover:bg-pink-600 hover:text-white"
              }`}
              onClick={() => setIsMobileMenuOpen(false)}
            >
              Contact
            </Link>
          </div>
        </div>
      )}
    </nav>
  );
};

export default Navbar;
