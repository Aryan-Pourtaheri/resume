import { motion } from 'framer-motion';

const Contact = () => {
  return (
    <div className="min-h-screen mt-14 min-w-full flex items-center justify-center bg-gray-50 p-8 ">
      <motion.div
        className="w-full max-w-3xl bg-white rounded-lg shadow-lg p-8 border"
        initial={{ opacity: 0, y: -50 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 1 }}
      >
        {/* Header Section */}
        <div className="text-center mb-8">
          <h1 className="text-4xl font-bold text-teal-700">Contact</h1>
          <p className="text-gray-600 mt-4 text-lg">
            We'd love to hear from you! Reach out with any questions or feedback.
          </p>
        </div>

        {/* Contact Form */}
        <form className="space-y-6">
          <div>
            <label
              htmlFor="name"
              className="block text-sm font-medium text-gray-700"
            >
              Name
            </label>
            <motion.input
              type="text"
              id="name"
              className="mt-1 w-full border-gray-300 outline-none rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500"
              initial={{ opacity: 0, x: -50 }}
              animate={{ opacity: 1, x: 0 }}
              transition={{ duration: 0.6 }}
            />
          </div>

          <div>
            <label
              htmlFor="email"
              className="block text-sm font-medium text-gray-700"
            >
              Email
            </label>
            <motion.input
              type="email"
              id="email"
              className="mt-1 w-full border-gray-300 outline-none rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500"
              initial={{ opacity: 0, x: 50 }}
              animate={{ opacity: 1, x: 0 }}
              transition={{ duration: 0.6 }}
            />
          </div>

          <div>
            <label
              htmlFor="message"
              className="block text-sm font-medium text-gray-700"
            >
              Message
            </label>
            <motion.textarea
              id="message"
              rows={4}
              className="mt-1 w-full border-gray-300 outline-none rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500"
              initial={{ opacity: 0, y: 50 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.8 }}
            ></motion.textarea>
          </div>

          <motion.button
            type="submit"
            className="w-full bg-teal-700 text-white py-3 rounded-lg font-semibold hover:bg-teal-800 transition"
            whileHover={{ scale: 1.05 }}
            whileTap={{ scale: 0.95 }}
          >
            Send Message
          </motion.button>
        </form>

        {/* Contact Info */}
        <motion.div
          className="mt-8 text-center text-gray-700"
          initial={{ opacity: 0 }}
          whileInView={{ opacity: 1 }}
          transition={{ duration: 1 }}
          viewport={{ once: true }}
        >
          <h2 className="text-2xl font-bold text-teal-700">
            Prefer to reach us directly?
          </h2>
          <p className="mt-4">
            Email us at{' '}
            <a
              href="mailto:support@likeshop.com"
              className="text-teal-600 underline"
            >
              support@likeshop.com
            </a>{' '}
            or call us at{' '}
            <a href="tel:+1234567890" className="text-teal-600 underline">
              +1 (234) 567-890
            </a>
            .
          </p>
        </motion.div>
      </motion.div>
    </div>
  );
};

export default Contact;
