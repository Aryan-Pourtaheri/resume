// Home Page
import { useNavigate } from "react-router-dom";
import { useEffect, useState } from "react";
import { motion } from "framer-motion";

const Home = () => {
  const navigate = useNavigate();
  const [fadeIn, setFadeIn] = useState(false);

  useEffect(() => {
    setFadeIn(true);
  }, []);

  const navigateToAbout = () => {
    navigate("/about");
  };

  return (
    <motion.div
      className="bg-gradient-to-b from-gray-900 via-gray-800 to-gray-700 text-white min-h-screen flex items-center justify-center"
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      exit={{ opacity: 0 }}
      transition={{ duration: 1 }}
    >
      <div className="text-center space-y-8">
        {/* Main Greeting */}
        <motion.h1
          className="text-4xl sm:text-5xl font-extrabold"
          initial={{ y: -50, opacity: 0 }}
          animate={{ y: 0, opacity: 1 }}
          transition={{ duration: 1 }}
        >
          Welcome to My Portfolio
        </motion.h1>

        <motion.p
          className="text-lg sm:text-xl"
          initial={{ y: 10, opacity: 0 }}
          animate={{ y: 0, opacity: 1 }}
          transition={{ duration: 1, delay: 0.3 }}
        >
          Building modern, responsive, and dynamic web apps with React.
        </motion.p>

        {/* Call-to-Action Button */}
        <motion.button
          onClick={navigateToAbout}
          className="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-3 text-lg rounded-md shadow-lg transform transition-transform duration-300 hover:scale-105"
          whileHover={{ scale: 1.05 }}
          initial={{ scale: 0.9 }}
          animate={{ scale: 1 }}
          transition={{ duration: 0.5 }}
        >
          Learn More About Me
        </motion.button>

        {/* Quote Section */}
        <motion.div
          className="mt-10 text-lg font-medium italic"
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ duration: 1, delay: 0.7 }}
        >
          <p>"Turning ideas into reality with clean and efficient code."</p>
        </motion.div>
      </div>
    </motion.div>
  );
};

export default Home;