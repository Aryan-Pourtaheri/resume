import { useEffect, useState } from "react";
import { Link } from "react-router-dom";

const About = () => {
  const [fadeIn, setFadeIn] = useState(false);

  // Usage percentage state
  const [progress, setProgress] = useState({
    React: 30,
    "JavaScript ES6+": 25,
    "HTML & CSS": 20,
    Tailwind: 15,
    "Responsive Website": 5,
    "React Router": 3,
    Appwrite: 2,
  });

  useEffect(() => {
    setFadeIn(true);
  }, []);

  const skillsTheme = [
    { name: "React", percentage: progress.React, color: "text-indigo-500" },
    {
      name: "JavaScript ES6+",
      percentage: progress["JavaScript ES6+"],
      color: "text-yellow-500",
    },
    {
      name: "HTML & CSS",
      percentage: progress["HTML & CSS"],
      color: "text-blue-500",
    },
    { name: "Tailwind", percentage: progress.Tailwind, color: "text-green-500" },
    {
      name: "Responsive Website",
      percentage: progress["Responsive Website"],
      color: "text-purple-500",
    },
    {
      name: "React Router",
      percentage: progress["React Router"],
      color: "text-red-500",
    },
    { name: "Appwrite", percentage: progress.Appwrite, color: "text-pink-500" },
  ];

  return (
    <div
      className={`bg-gradient-to-b from-gray-900 via-gray-800 to-gray-700 text-white min-h-screen p-6 flex items-center justify-center transition-opacity duration-1000 ${
        fadeIn ? "opacity-100" : "opacity-0"
      }`}
    >
      <div className="max-w-4xl mx-auto text-center space-y-8">
        {/* Page Title */}
        <h1 className="text-4xl sm:text-5xl font-extrabold mb-4">About Me</h1>
        <p className="text-lg sm:text-xl leading-relaxed">
          Hi there! I'm a passionate{" "}
          <span className="text-indigo-400 font-semibold">React Developer</span>{" "}
          with a knack for creating modern, responsive, and dynamic web
          applications. I thrive on solving complex problems and crafting
          elegant user experiences.
        </p>

        {/* Journey Section */}
        <div className="space-y-6">
          <h2 className="text-2xl font-semibold">My Journey</h2>
          <p className="text-base sm:text-lg">
            My journey into web development began with curiosity and an appetite
            for creativity. Over the years, I have honed my skills in{" "}
            <span className="text-blue-400 font-semibold">HTML & CSS</span>,{" "}
            <span className="text-yellow-400 font-semibold">
              JavaScript ES6+
            </span>
            , <span className="text-indigo-400 font-semibold">React</span>, and{" "}
            <span className="text-green-400 font-semibold">Tailwind CSS</span>,
            building a solid foundation for crafting responsive and scalable
            web applications.
          </p>
        </div>

        {/* Static Skills Section */}
        <div className="space-y-6">
          <h2 className="text-2xl font-semibold">My Skills</h2>
          <div className="flex flex-wrap justify-center gap-4">
            <span className="bg-indigo-500 px-4 py-2 rounded-full text-sm">
              React
            </span>
            <span className="bg-yellow-500 px-4 py-2 rounded-full text-sm">
              JavaScript (ES6+)
            </span>
            <span className="bg-blue-500 px-4 py-2 rounded-full text-sm">
              HTML & CSS
            </span>
            <span className="bg-green-500 px-4 py-2 rounded-full text-sm">
              Tailwind CSS
            </span>
            <span className="bg-purple-500 px-4 py-2 rounded-full text-sm">
              Responsive Design
            </span>
            <span className="bg-red-500 px-4 py-2 rounded-full text-sm">
              React Router
            </span>
            <span className="bg-pink-500 px-4 py-2 rounded-full text-sm">
              Appwrite
            </span>
          </div>
        </div>

        {/* Dynamic Skills with Circular Progress Bars */}
        <div className="space-y-6 mt-10">
          <h2 className="text-2xl font-semibold">Usage Base On Percent</h2>
          <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
            {skillsTheme.map((skill) => (
              <div key={skill.name} className="flex flex-col items-center">
                <div className="relative w-24 h-24">
                  <svg className="w-full h-full">
                    <circle
                      className="text-gray-700"
                      strokeWidth="4"
                      stroke="currentColor"
                      fill="transparent"
                      r="40"
                      cx="50%"
                      cy="50%"
                    />
                    <circle
                      className={`${skill.color} transition-all duration-1000 ease-out`}
                      strokeWidth="4"
                      strokeDasharray="251.2" // Circumference of the circle
                      strokeDashoffset={`${
                        251.2 - (251.2 * skill.percentage) / 100
                      }`} // Adjust the stroke dashoffset to represent the percentage
                      strokeLinecap="round"
                      stroke="currentColor"
                      fill="transparent"
                      r="40"
                      cx="50%"
                      cy="50%"
                    />
                  </svg>
                  <span className="absolute inset-0 flex items-center justify-center text-lg font-bold">
                    {skill.percentage}%
                  </span>
                </div>
                <p className="mt-2 text-base">{skill.name}</p>
              </div>
            ))}
          </div>
        </div>

        {/* Call-to-Action Section */}
        <div className="mt-10">
          <Link
            to="/projects"
            className="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-3 text-lg rounded-md shadow-lg transform transition-transform duration-300 hover:scale-105"
          >
            Check Out My Projects
          </Link>
        </div>
      </div>
    </div>
  );
};

export default About;
