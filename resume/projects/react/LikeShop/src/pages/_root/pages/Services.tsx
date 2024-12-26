import { motion } from 'framer-motion';
import { useNavigate } from 'react-router-dom';

const services = [
  {
    title: 'Fast Delivery',
    description:
      'Get your products delivered within hours with our lightning-fast delivery services.',
    icon: '🚚',
  },
  {
    title: 'Quality Assurance',
    description:
      'Shop with confidence knowing that all our products are verified for top quality.',
    icon: '✅',
  },
  {
    title: 'Exclusive Discounts',
    description:
      'Save more with exciting deals and exclusive discounts available daily.',
    icon: '💸',
  },
  {
    title: '24/7 Support',
    description:
      'Our dedicated support team is available around the clock to assist you.',
    icon: '📞',
  },
  {
    title: 'Secure Payments',
    description:
      'Enjoy safe and secure transactions with multiple payment options.',
    icon: '🔒',
  },
  {
    title: 'Easy Returns',
    description:
      'Hassle-free returns to ensure a smooth and convenient shopping experience.',
    icon: '🔄',
  },
];

const Services = () => {
  const navigate = useNavigate();
  return (
    <div className="min-h-screen bg-gray-50 p-10 mt-20">
      <motion.div
        className="text-center mb-10"
        initial={{ opacity: 0, y: -50 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 1 }}
      >
        <h1 className="text-4xl font-bold text-teal-700">Why Shop With Us?</h1>
        <p className="text-gray-600 mt-4 text-lg">
          Discover what makes our shopping experience stand out.
        </p>
      </motion.div>

      <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        {services.map((service, index) => (
          <motion.div
            key={index}
            className="bg-white rounded-lg shadow-md p-6 text-center"
            initial={{ opacity: 0, y: 50 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.5, delay: index * 0.2 }}
            viewport={{ once: true }}
          >
            <div className="text-5xl text-teal-700">{service.icon}</div>
            <h2 className="text-xl font-semibold text-teal-800 mt-4">
              {service.title}
            </h2>
            <p className="text-gray-600 mt-2">{service.description}</p>
          </motion.div>
        ))}
      </div>

      <motion.div
        className="mt-16 text-center"
        initial={{ opacity: 0 }}
        whileInView={{ opacity: 1 }}
        transition={{ duration: 1 }}
        viewport={{ once: true }}
      >
        <h2 className="text-2xl font-bold text-teal-700">
          Ready to shop your favorites?
        </h2>
        <button
          className="mt-6 m-2 px-8 py-3 bg-teal-700 text-white rounded-lg hover:bg-teal-800 transition"
          onClick={() => navigate('/products')}
        >
          Shop Now
        </button>
        <button
          className="mt-6 m-2 px-8 py-3 bg-teal-700 text-white rounded-lg hover:bg-teal-800 transition"
          onClick={() => navigate('/contact')}
        >
          contact us
        </button>
      </motion.div>
    </div>
  );
};

export default Services;
