import { motion } from 'framer-motion';
import Footer from './Footer';

const About = () => {
  return (
    <div className="min-h-screen min-w-full flex items-center justify-center bg-gray-50 p-8">
      <motion.div
        className="w-full max-w-4xl bg-white rounded-lg shadow-lg p-8"
        initial={{ opacity: 0, y: -50 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 1 }}
      >
        {/* Header Section */}
        <div className="text-center mb-8">
          <h1 className="text-4xl font-bold text-teal-700">About Us</h1>
          <p className="text-gray-600 mt-4 text-lg">
            Discover more about our mission, values, and the journey of our shopping platform.
          </p>
        </div>

        {/* Content Section */}
        <div className="space-y-6 text-gray-700 leading-relaxed">
          <motion.p
            initial={{ opacity: 0, x: -50 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.6 }}
          >
            At <span className="font-bold text-teal-700">LikeShop</span>, we believe shopping should be easy, enjoyable, and personalized for every customer. Our platform is designed to connect you with products you love, all in one place.
          </motion.p>
          <motion.p
            initial={{ opacity: 0, x: 50 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.8 }}
          >
            Since our inception, we have been committed to offering a seamless and secure shopping experience, combining innovative technology with a human touch. From curated collections to customer-first support, your satisfaction is our priority.
          </motion.p>
          <motion.p
            initial={{ opacity: 0, y: 50 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 1 }}
          >
            Thank you for being part of our story. Together, we aim to redefine how people shop, one product at a time.
          </motion.p>
        </div>

        {/* Call to Action */}
        <motion.div
          className="text-center mt-8"
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ duration: 1.2 }}
        >
          <button
            className="bg-teal-700 text-white py-3 px-8 rounded-lg font-semibold hover:bg-teal-800 transition"
            onClick={() => window.scrollTo({ top: 0, behavior: 'smooth' })}
          >
            Learn More
          </button>
        </motion.div>
      </motion.div>
    </div>
    
  );
};

export default About;
