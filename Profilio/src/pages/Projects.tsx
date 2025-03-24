import { motion } from "framer-motion";

const projects = [
  {
    title: "2D Break Out Game",
    description:
      "A classic arcade-style game developed using JavaScript and CSS. Features dynamic ball movement, paddle control, and block-breaking mechanics.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/2D%20Break%20Out%20Game",
  },
  {
    title: "Amazon Clone",
    description:
      "A fully responsive e-commerce platform built using JavaScript and CSS, replicating key features of Amazon, including product listing and cart functionality.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/Amazon%20Clone",
  },
  {
    title: "CatchTheBall",
    description:
      "A fun and interactive game built using JavaScript and CSS, challenging users to catch the ball as it moves across the screen.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/CatchTheBall",
  },
  {
    title: "Clock",
    description:
      "A clean and functional clock application created with JavaScript and CSS, displaying real-time updates and supporting multiple time zones.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/Clock",
  },
  {
    title: "Color Flipper",
    description:
      "A simple and interactive tool built with JavaScript and CSS that allows users to change background colors by clicking a button.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/Color%20Flipper",
  },
  {
    title: "Count Down Timer",
    description:
      "A responsive countdown timer application created with JavaScript and CSS, perfect for tracking events or deadlines.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/Count%20Down%20Timer",
  },
  {
    title: "Counter",
    description:
      "A basic counter application built with JavaScript and CSS, enabling users to increment, decrement, and reset values.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/Counter",
  },
  {
    title: "DragonStatus",
    description:
      "An interactive and visually engaging project built with JavaScript and CSS, showcasing dragon statuses with animations.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/DragonStatus",
  },
  {
    title: "Home Page",
    description:
      "A visually appealing and responsive homepage design built using JavaScript and CSS, perfect for personal or business websites.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/Home%20Page",
  },
  {
    title: "Modal",
    description:
      "A customizable modal window built with JavaScript and CSS, suitable for displaying alerts, forms, or additional information.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/Modal",
  },
  {
    title: "ProgrammingInstrument",
    description:
      "An interactive programming instrument project developed with JavaScript and CSS, allowing users to experiment with basic programming concepts.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/ProgrammingInstrument",
  },
  {
    title: "Reviews",
    description:
      "A review carousel application built with JavaScript and CSS, showcasing user reviews with smooth transitions.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/Reviews",
  },
  {
    title: "Shoe Website",
    description:
      "A responsive shoe website built with JavaScript and CSS, featuring product displays and a modern design.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/Shoe%20Website",
  },
  {
    title: "Sneaker Shop",
    description:
      "A dynamic sneaker shop website created using JavaScript and CSS, showcasing trendy footwear with a sleek design.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/Sneaker%20Shop",
  },
  {
    title: "SpeakRecogniseNoter",
    description:
      "A voice recognition and note-taking application built with JavaScript and CSS, enabling users to dictate and save notes.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/SpeakRecogniseNoter",
  },
  {
    title: "TodoList",
    description:
      "A functional and responsive to-do list application developed using JavaScript and CSS, designed for task management.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/TodoList",
  },
  {
    title: "Video",
    description:
      "A video player application built using JavaScript and CSS, supporting play, pause, and volume control functionality.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/Video",
  },
  {
    title: "Youtube",
    description:
      "A YouTube-like application built using JavaScript and CSS, showcasing video search and play functionalities.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/Youtube",
  },
  {
    title: "geolocation",
    description:
      "A geolocation-based application created with JavaScript and CSS, fetching and displaying user location data dynamically.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/geolocation",
  },
  {
    title: "imageSlider",
    description:
      "A smooth and responsive image slider built with JavaScript and CSS, supporting auto-slide and manual navigation.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/imageSlider",
  },
  {
    title: "magicQuotes",
    description:
      "A random quote generator built using JavaScript and CSS, fetching quotes dynamically and displaying them with animations.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/magicQuotes",
  },
  {
    title: "movieApp",
    description:
      "A movie database application created with JavaScript and CSS, allowing users to search for and view movie details.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/movieApp",
  },
  {
    title: "musicPlaylist",
    description:
      "A music playlist application built with JavaScript and CSS, supporting playlist creation and basic controls.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/musicPlaylist",
  },
  {
    title: "navigationBar",
    description:
      "A responsive navigation bar component built using JavaScript and CSS, perfect for modern websites.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/navigationBar",
  },
  {
    title: "rpg game",
    description:
      "A simple RPG game built using JavaScript and CSS, featuring character controls and basic enemy interactions.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/rpg%20game",
  },
  {
    title: "weatherApp",
    description:
      "A weather application developed with JavaScript and CSS, fetching and displaying real-time weather data.",
    link: "https://github.com/Aryan-Pourtaheri/resume/tree/main/resume/projects/Js/weatherApp",
  },
];

const Projects = () => {
  return (
    <motion.div
      className="bg-gradient-to-b from-gray-900 via-gray-800 to-gray-700 text-white min-h-screen p-8"
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      exit={{ opacity: 0 }}
      transition={{ duration: 1 }}
    >
      <div className="container mx-auto">
        <motion.h1
          className="text-4xl font-extrabold text-center mb-8"
          initial={{ y: -50, opacity: 0 }}
          animate={{ y: 0, opacity: 1 }}
          transition={{ duration: 1 }}
        >
          My Projects
        </motion.h1>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {projects.map((project, index) => (
            <motion.div
              key={index}
              className="bg-gray-800 rounded-lg shadow-lg p-6 hover:shadow-2xl transform transition-transform duration-300 hover:scale-105 cursor-pointer"
              initial={{ opacity: 0, y: 50 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5, delay: index * 0.2 }}
            >
              <h2 className="text-2xl font-semibold mb-4">{project.title}</h2>
              <p className="text-gray-400 mb-4">{project.description}</p>
              <a
                href={project.link}
                target="_blank"
                rel="noopener noreferrer"
                className="text-indigo-500 hover:text-indigo-400"
              >
                View Project &rarr;
              </a>
            </motion.div>
          ))}
        </div>
      </div>
    </motion.div>
  );
};

export default Projects;
