import { useState } from "react";
import { motion } from "framer-motion";
import emailjs from "@emailjs/browser";

const Contact = () => {
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    subject: "",
    message: "",
  });
  const [successMessage, setSuccessMessage] = useState("");
  const [errorMessage, setErrorMessage] = useState("");

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    const { name, email, subject, message } = formData;

    if (!name || !email || !subject || !message) {
      setErrorMessage("Please fill in all fields.");
      return;
    }

    setErrorMessage(""); // Clear error messages

    // Use EmailJS to send the email
    emailjs
      .send(
        "service_8krddkj", // Replace with your EmailJS Service ID
        "template_43ohzk8", // Replace with your EmailJS Template ID
        {
          name,
          email,
          subject,
          message,
        },
        "Jo4-oNXKoDfd0yWcJ" // Replace with your EmailJS Public Key
      )
      .then(
        (result) => {
          setSuccessMessage("Message sent successfully!");
          setFormData({ name: "", email: "", subject: "", message: "" }); // Reset form
        },
        (error) => {
          setErrorMessage("Failed to send message. Please try again later.");
        }
      );
  };

  return (
    <motion.div
      className="bg-gradient-to-b from-gray-900 via-gray-800 to-gray-700 text-white min-h-screen p-6 flex items-center justify-center"
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      exit={{ opacity: 0 }}
      transition={{ duration: 1 }}
    >
      <div className="max-w-4xl mx-auto w-full space-y-8">
        <motion.h1
          className="text-4xl sm:text-5xl font-extrabold text-center"
          initial={{ y: -50, opacity: 0 }}
          animate={{ y: 0, opacity: 1 }}
          transition={{ duration: 1 }}
        >
          Contact Me
        </motion.h1>

        <motion.form
          onSubmit={handleSubmit}
          className="space-y-6 bg-gray-800 p-6 rounded-lg shadow-lg"
          initial={{ scale: 0.9, opacity: 0 }}
          animate={{ scale: 1, opacity: 1 }}
          transition={{ duration: 0.7, delay: 0.5 }}
        >
          <div>
            <label htmlFor="name" className="block text-sm font-medium">
              Name
            </label>
            <input
              type="text"
              id="name"
              name="name"
              value={formData.name}
              onChange={handleChange}
              className="w-full mt-1 p-3 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              placeholder="Enter your name"
            />
          </div>

          <div>
            <label htmlFor="email" className="block text-sm font-medium">
              Email
            </label>
            <input
              type="email"
              id="email"
              name="email"
              value={formData.email}
              onChange={handleChange}
              className="w-full mt-1 p-3 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              placeholder="Enter your email"
            />
          </div>

          <div>
            <label htmlFor="subject" className="block text-sm font-medium">
              Subject
            </label>
            <input
              type="text"
              id="subject"
              name="subject"
              value={formData.subject}
              onChange={handleChange}
              className="w-full mt-1 p-3 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              placeholder="Enter the subject"
            />
          </div>

          <div>
            <label htmlFor="message" className="block text-sm font-medium">
              Message
            </label>
            <textarea
              id="message"
              name="message"
              rows={4}
              value={formData.message}
              onChange={handleChange}
              className="w-full mt-1 p-3 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              placeholder="Enter your message"
            ></textarea>
          </div>

          <div className="text-center">
            <motion.button
              type="submit"
              className="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-3 rounded-md shadow-lg transform transition-transform duration-300 hover:scale-105"
              whileHover={{ scale: 1.05 }}
            >
              Send Message
            </motion.button>
          </div>

          {/* Success/Error Messages */}
          {successMessage && (
            <p className="text-green-500 text-center mt-4">{successMessage}</p>
          )}
          {errorMessage && (
            <p className="text-red-500 text-center mt-4">{errorMessage}</p>
          )}
        </motion.form>
      </div>
    </motion.div>
  );
};

export default Contact;
