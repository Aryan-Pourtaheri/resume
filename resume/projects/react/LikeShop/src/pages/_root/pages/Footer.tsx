import { Link } from "react-router-dom";

const Footer = () => {
  return (
    <footer className="bg-teal-800 text-white py-8 w-full">
      <div className="container mx-auto px-6 md:px-12">
        <div className="flex flex-col md:flex-row justify-between items-center gap-6">
          <div className="text-center md:text-left">
            <h1 className="text-2xl font-bold">
              Like<span className="text-red-500">Shop</span>
            </h1>
            <p className="text-gray-300 mt-2">
              Your favorite place to shop smarter and better!
            </p>
          </div>

          <div className="space-y-2 md:space-y-0 md:space-x-6">
            <Link
              to="/"
              className="hover:text-gray-300 transition duration-300"
            >
              Home
            </Link>
            <Link
              to="/products"
              className="hover:text-gray-300 transition duration-300"
            >
              Products
            </Link>
            <Link
              to="/services"
              className="hover:text-gray-300 transition duration-300"
            >
              Services
            </Link>
            <Link
              to="/contact"
              className="hover:text-gray-300 transition duration-300"
            >
              Contact
            </Link>
            <Link
              to="/about"
              className="hover:text-gray-300 transition duration-300"
            >
              About
            </Link>
          </div>
        </div>

        <div className="mt-8 flex flex-col md:flex-row justify-between items-center border-t border-gray-700 pt-6">
          <div className="flex space-x-4">
            <a
              href="#"
              aria-label="Facebook"
              className="hover:text-gray-300 transition duration-300"
            >
              Facebook
            </a>
            <a
              href="#"
              aria-label="Twitter"
              className="hover:text-gray-300 transition duration-300"
            >
              Twitter
            </a>
            <a
              href="#"
              aria-label="Instagram"
              className="hover:text-gray-300 transition duration-300"
            >
              Instagram
            </a>
          </div>

          <p className="text-gray-400 text-sm mt-4 md:mt-0">
            © {new Date().getFullYear()} LikeShop. All rights reserved.
          </p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
